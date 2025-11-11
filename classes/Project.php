<?php
class Project {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // --- Add Project ---
    public function addProject($data){
        // ... (existing code for addProject) ...
        $required = ['project_name','project_url','teaser','project_details','status'];
        foreach($required as $field){
            if(!isset($data[$field]) || $data[$field]===''){
                return ['success'=>false, 'message'=>"Missing field: $field"];
            }
        }

        // Prepare variables for bind_param
        $project_name    = $data['project_name'];
        $project_url     = $data['project_url'];
        $teaser          = $data['teaser'];
        $project_details = $data['project_details'];
        $status          = $data['status'];
        $project_images  = $data['project_images'] ?? null; // JSON of multiple images
        $project_map     = $data['project_map'] ?? null;    // single map

        $sql = "INSERT INTO projects 
            (project_name, project_url, teaser, project_details, status, project_images, project_map) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if(!$stmt){
            return ['success'=>false, 'message'=>"Prepare failed: ".$this->conn->error];
        }

        $stmt->bind_param(
            "sssssss",
            $project_name,
            $project_url,
            $teaser,
            $project_details,
            $status,
            $project_images,
            $project_map
        );

        if($stmt->execute()){
            return ['success'=>true, 'message'=>'Project added successfully'];
        } else {
            return ['success'=>false, 'message'=>'Execute failed: '.$stmt->error];
        }
    }

    // --- Update Project ---
    public function updateProject($data){
        // ... (existing code for updateProject) ...
        if(empty($data['id'])){
            return ['success'=>false, 'message'=>"Project ID missing"];
        }

        $id = $data['id'];

        // --- Fetch existing project to merge images ---
        $existingImages = [];
        $existingMap = null;
        $res = $this->conn->query("SELECT project_images, project_map FROM projects WHERE id=".$id);
        if($res && $res->num_rows){
            $row = $res->fetch_assoc();
            $existingImages = json_decode($row['project_images'], true) ?: [];
            $existingMap = $row['project_map'];
        }

        // --- Merge images if new ones uploaded ---
        if(isset($data['project_images'])){
            $newImages = json_decode($data['project_images'], true) ?: [];
            $allImages = array_merge($existingImages, $newImages);
            $data['project_images'] = json_encode($allImages);
        } else {
            // NOTE: The previous logic assumed if 'project_images' was NOT set in $data,
            // it means no new images were uploaded, so it uses the existing.
            // If the user *removed* all images, $data['project_images'] would be set to an empty JSON array '[]'.
            $data['project_images'] = json_encode($existingImages);
        }

        // --- Use new map if uploaded, else keep old ---
        if(!isset($data['project_map'])){
            $data['project_map'] = $existingMap;
        }

        // Prepare variables for bind_param
        $project_name    = $data['project_name'];
        $project_url     = $data['project_url'];
        $teaser          = $data['teaser'];
        $project_details = $data['project_details'];
        $status          = $data['status'];
        $project_images  = $data['project_images'];
        $project_map     = $data['project_map'];

        $sql = "UPDATE projects SET 
                    project_name=?,
                    project_url=?,
                    teaser=?,
                    project_details=?,
                    status=?,
                    project_images=?,
                    project_map=?
                WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        if(!$stmt){
            return ['success'=>false, 'message'=>"Prepare failed: ".$this->conn->error];
        }

        $stmt->bind_param(
            "sssssssi",
            $project_name,
            $project_url,
            $teaser,
            $project_details,
            $status,
            $project_images,
            $project_map,
            $id
        );

        if($stmt->execute()){
            return ['success'=>true, 'message'=>'Project updated successfully'];
        } else {
            return ['success'=>false, 'message'=>'Execute failed: '.$stmt->error];
        }
    }

    // --- List All Projects ---
    public function listProjects(){
        // ... (existing code for listProjects) ...
        $sql = "SELECT id, project_name, teaser, project_url, create_date FROM projects ORDER BY create_date DESC";
        $result = $this->conn->query($sql);
        
        if(!$result){
            return ['success'=>false, 'message'=>"Query failed: ".$this->conn->error];
        }

        $projects = [];
        while($row = $result->fetch_assoc()){
            $row['url'] = $row['project_url']; 
            $projects[] = $row;
        }

        return ['success'=>true, 'data'=>$projects];
    }
    
    // --- Delete Project ---
    public function deleteProject($id){
        // ... (existing code for deleteProject) ...
        if(empty($id) || !is_numeric($id)){
            return ['success'=>false, 'message'=>"Invalid Project ID"];
        }

        $sql = "DELETE FROM projects WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        
        if(!$stmt){
            return ['success'=>false, 'message'=>"Prepare failed: ".$this->conn->error];
        }

        $stmt->bind_param("i", $id);
        
        if($stmt->execute()){
            if($stmt->affected_rows > 0){
                return ['success'=>true, 'message'=>'Project deleted successfully'];
            } else {
                return ['success'=>false, 'message'=>'Project not found or already deleted'];
            }
        } else {
            return ['success'=>false, 'message'=>'Execute failed: '.$stmt->error];
        }
    }
    
    // --- Get Single Project By ID (NEW METHOD) ---
    public function getProjectById($id){
        if(empty($id) || !is_numeric($id)){
            return ['success'=>false, 'message'=>"Invalid Project ID"];
        }

        // Select ALL fields for the edit form
        $sql = "SELECT * FROM projects WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);

        if(!$stmt){
            return ['success'=>false, 'message'=>"Prepare failed: ".$this->conn->error];
        }

        $stmt->bind_param("i", $id);
        
        if($stmt->execute()){
            $result = $stmt->get_result();
            if($result->num_rows === 1){
                return ['success'=>true, 'data'=>$result->fetch_assoc()];
            } else {
                return ['success'=>false, 'message'=>'Project not found.'];
            }
        } else {
            return ['success'=>false, 'message'=>'Execute failed: '.$stmt->error];
        }
    }
}
?>