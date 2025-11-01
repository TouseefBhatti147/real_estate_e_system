<?php
class Project {
    private $pdo;
    private $targetDir = "images/projects/";

    /**
     * Constructor. Requires a PDO database connection.
     * @param PDO $pdo The database connection.
     */
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;

        // Ensure the upload directory exists
        if (!file_exists($this->targetDir)) {
            // 0777 is permissive, use 0755 in production
            mkdir($this->targetDir, 0777, true); 
        }
    }

    /**
     * Validates, uploads files, and creates a new project.
     * @param array $post The $_POST data from the form.
     * @param array $files The $_FILES data from the form.
     * @return array A response array ['success' => bool, 'message' => string].
     */
    public function createProject($post, $files) {
        try {
            // 1. Validate Input (Now checks for 'projectUrl')
            $this->validateInput($post, $files);
            
            // 2. Process Project Map (Single File)
            $mapDbPath = $this->uploadProjectMap($files['projectMap']);

            // 3. Process Project Images (Multiple Files)
            $uploadedImagePaths = $this->uploadProjectImages($files['projectImages']);
            $imagePathsString = json_encode($uploadedImagePaths); // Convert array to JSON string

            // 4. Get remaining POST data (Using 'projectUrl')
            $projectName = trim($post['projectName']);
            $projectUrl = trim($post['projectUrl']); // <-- This is correct, from the form
            $teaser = trim($post['teaser']);
            $projectDetail = trim($post['projectDetail']);
            $status = trim($post['status']);

            // 5. Database Insertion
            // <-- FIXED: Changed 'project_url' back to 'url'
            $sql = "INSERT INTO projects (project_name, url, teaser, project_detail, status, project_map, project_images) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $projectName, 
                $projectUrl, // <-- This is correct, it holds the value from 'projectUrl'
                $teaser, 
                $projectDetail, 
                $status, 
                $mapDbPath, 
                $imagePathsString
            ]);

            // If we get here, everything was successful
            return ['success' => true, 'message' => 'Project added successfully! All files uploaded.'];

        } catch (Exception $e) {
            // Catch any errors from validation or file uploads
            return ['success' => false, 'message' => $e->getMessage()];
        } catch (PDOException $e) {
            // Catch database-specific errors
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Fetches all projects from the database.
     * @return array A response array ['success' => bool, 'data' => array] or ['success' => false, 'message' => string]
     */
    public function getAllProjects() {
        try {
            // Define the SQL query to select all projects
            // Added ORDER BY id DESC to show newest first
            $sql = "SELECT * FROM projects ORDER BY id DESC";
            
            // Prepare and execute the query
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            // Fetch all results as an associative array
            $projects = $stmt->fetchAll();
            
            // Return a successful response with the data
            return ['success' => true, 'data' => $projects];

        } catch (PDOException $e) {
            // Catch any database errors
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    // --- NEW FUNCTION for Update ---

    /**
     * Validates, uploads new files, and updates an existing project.
     * @param array $post The $_POST data from the form. Must include 'id'.
     * @param array $files The $_FILES data from the form.
     * @return array A response array ['success' => bool, 'message' => string].
     */
    public function updateProject($post, $files) {
        try {
            // 1. Validate Input (using a new validator for update)
            $this->validateUpdateInput($post);
            $projectId = trim($post['id']); // Use 'id'

            // 2. Fetch old project data to get old file paths
            $oldProject = $this->getProjectById($projectId);
            if (!$oldProject) {
                throw new Exception('Project not found.');
            }

            // 3. Initialize paths with old data. 
            //
            // --- FIX for JSON ERROR ---
            // Use null coalescing (??) to prevent "Undefined index" notices
            $mapDbPath = $oldProject['project_map'] ?? null;
            $imagePathsString = $oldProject['project_images'] ?? null; // <-- FIXED: 'project_images' (plural)
            
            $filesToDelete = []; // To store old file paths for deletion

            // 4. Process Project Map (if a new one is uploaded)
            if (isset($files['projectMap']) && $files['projectMap']['error'] == 0) {
                // A new map was uploaded. Upload it.
                $mapDbPath = $this->uploadProjectMap($files['projectMap']);
                
                // --- FIX for JSON ERROR ---
                // Mark the old map for deletion (only if it's not empty)
                if (!empty($oldProject['project_map'])) {
                    $filesToDelete[] = $oldProject['project_map'];
                }
            }

            // 5. Process Project Images (if new ones are uploaded)
            if (isset($files['projectImages']) && !empty($files['projectImages']['name'][0])) {
                // New images were uploaded. Upload them.
                $uploadedImagePaths = $this->uploadProjectImages($files['projectImages']);
                $imagePathsString = json_encode($uploadedImagePaths); // Convert to JSON string

                // --- FIX for JSON ERROR & Inconsistency ---
                // Mark the old images for deletion (only if not empty)
                if (!empty($oldProject['project_images'])) { // <-- FIXED: 'project_images' (plural)
                    $oldImagePaths = json_decode($oldProject['project_images'], true); // <-- FIXED: 'project_images' (plural)
                    if (is_array($oldImagePaths)) {
                        $filesToDelete = array_merge($filesToDelete, $oldImagePaths);
                    }
                }
            }

            // 6. Get remaining POST data
            $projectName = trim($post['projectName']);
            $projectUrl = trim($post['projectUrl']); // <-- This is correct, from the form
            $teaser = trim($post['teaser']);
            $projectDetail = trim($post['projectDetail']);
            $status = trim($post['status']);

            // 7. Database Update
            // <-- FIXED: Changed 'project_url' back to 'url'
            $sql = "UPDATE projects SET 
                        project_name = ?, 
                        url = ?, 
                        teaser = ?, 
                        project_detail = ?, 
                        status = ?, 
                        project_map = ?, 
                        project_images = ? 
                    WHERE id = ?";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $projectName, 
                $projectUrl, // <-- This is correct, it holds the value from 'projectUrl'
                $teaser, 
                $projectDetail, 
                $status, 
                $mapDbPath, 
                $imagePathsString,
                $projectId // The WHERE clause parameter
            ]);

            // 8. Delete old files (only after DB update is successful)
            $this->deleteFiles($filesToDelete);

            return ['success' => true, 'message' => 'Project updated successfully!'];

        } catch (Exception $e) {
            // Catch any errors from validation or file uploads
            return ['success' => false, 'message' => $e->getMessage()];
        } catch (PDOException $e) {
            // Catch database-specific errors
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }


    // --- Private Helper Functions ---

    /**
     * Validates all required POST and FILE data for create.
     * @throws Exception if validation fails.
     */
    private function validateInput($post, $files) {
        // <-- FIXED: Changed 'url' to 'projectUrl'
        if (empty($post['projectName']) || empty($post['projectUrl']) || empty($post['status'])) {
            throw new Exception('Project Name, Project URL, and Status are required.');
        }
        if (!isset($files['projectMap']) || $files['projectMap']['error'] != 0) {
            throw new Exception('Project Map is required and must be uploaded successfully.');
        }
        if (!isset($files['projectImages']) || empty($files['projectImages']['name'][0])) {
            throw new Exception('At least one Project Image is required.');
        }
    }

    /**
     * Handles the single project map upload.
     * @return string The database path of the uploaded file.
     * @throws Exception if upload fails.
     */
    private function uploadProjectMap($mapFile) {
        $mapExtension = pathinfo($mapFile['name'], PATHINFO_EXTENSION);
        $mapName = 'map_' . time() . '_' . uniqid() . '.' . $mapExtension;
        $mapTarget = $this->targetDir . $mapName;

        if (!move_uploaded_file($mapFile['tmp_name'], $mapTarget)) {
            throw new Exception('Failed to upload Project Map.');
        }
        return $mapTarget; // Return the path to be stored in DB
    }

    /**
     * Handles the multiple project image uploads.
     * @return array An array of database paths for all uploaded images.
     * @throws Exception if any upload fails.
     */
    private function uploadProjectImages($images) {
        $uploadedImagePaths = [];

        foreach ($images['name'] as $key => $name) {
            if ($images['error'][$key] == 0) {
                $tmp_name = $images['tmp_name'][$key];
                $imageExtension = pathinfo($name, PATHINFO_EXTENSION);
                $imageName = 'img_' . time() . '_' . uniqid() . '_' . $key . '.' . $imageExtension;
                $imageTarget = $this->targetDir . $imageName;
                
                if (move_uploaded_file($tmp_name, $imageTarget)) {
                    $uploadedImagePaths[] = $imageTarget;
                } else {
                    // Fail the whole request if one image fails
                    throw new Exception("Failed to upload one or more images ($name).");
                }
            }
        }

        if (empty($uploadedImagePaths)) {
            throw new Exception('No project images were successfully uploaded.');
        }

        return $uploadedImagePaths;
    }

    // --- NEW Private Helper Functions for Update ---

    /**
     * Fetches a single project by its ID.
     * @param int $id The project ID.
     * @return array|false The project data or false if not found.
     * @throws PDOException if the query fails.
     */
    public function getProjectById($id) { // This is public, which is correct
        $sql = "SELECT * FROM projects WHERE id = ?"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(); // Returns false if no row is found
    }

    /**
     * Validates all required POST data for an update.
     * Files are optional for update, so they are not checked here.
     * @throws Exception if validation fails.
     */
    private function validateUpdateInput($post) {
        if (empty($post['id'])) { // Check for 'id'
            throw new Exception('Project ID is required for update.');
        }
         // <-- FIXED: Changed 'url' to 'projectUrl'
        if (empty($post['projectName']) || empty($post['projectUrl']) || empty($post['status'])) {
            throw new Exception('Project Name, Project URL, and Status are required.');
        }
    }

    /**
     * Deletes an array of files from the server.
     * @param array $filePaths Array of paths to delete.
     */
    private function deleteFiles(array $filePaths) {
        foreach ($filePaths as $path) {
            if ($path && file_exists($path)) {
                // Suppress errors if file doesn't exist or permissions fail
                @unlink($path); 
            }
        }
    }
}
?>

