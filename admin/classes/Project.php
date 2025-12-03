<?php
class Project {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // -------------------
    // Add new project
    // -------------------
    public function addProject($data) {
        $project_name    = $data['project_name'];
        $teaser          = $data['teaser'];
        $project_url     = $data['project_url'];
        $project_details = $data['project_details'];
        $status          = intval($data['status']);
        $project_images  = $data['project_images']; // JSON string of images
        $project_map     = $data['project_map'];    // string path

        $stmt = $this->conn->prepare("
            INSERT INTO projects 
            (project_name, teaser, project_url, project_details, status, project_images, project_map, create_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        if(!$stmt) return ['success'=>false,'message'=>$this->conn->error];

        $stmt->bind_param('ssssiss', $project_name, $teaser, $project_url, $project_details, $status, $project_images, $project_map);

        if($stmt->execute()) {
            $stmt->close();
            return ['success'=>true,'message'=>'Project added successfully.'];
        } else {
            $stmt->close();
            return ['success'=>false,'message'=>'Add failed: '.$this->conn->error];
        }
    }

    // -------------------
    // Update existing project
    // -------------------
    public function updateProject($id, $data) {
        $id              = intval($id);
        $project_name    = $data['project_name'];
        $teaser          = $data['teaser'];
        $project_url     = $data['project_url'];
        $project_details = $data['project_details'];
        $status          = intval($data['status']);
        $project_images  = $data['project_images']; // can be same as old JSON or new
        $project_map     = $data['project_map'];    // new path or old

        $stmt = $this->conn->prepare("
            UPDATE projects 
            SET project_name=?, teaser=?, project_url=?, project_details=?, status=?, project_images=?, project_map=?
            WHERE id=?
        ");

        if(!$stmt) return ['success'=>false,'message'=>$this->conn->error];

        $stmt->bind_param('ssssissi', $project_name, $teaser, $project_url, $project_details, $status, $project_images, $project_map, $id);

        if($stmt->execute()) {
            $stmt->close();
            return ['success'=>true,'message'=>'Project updated successfully.'];
        } else {
            $stmt->close();
            return ['success'=>false,'message'=>'Update failed: '.$this->conn->error];
        }
    }

    // -------------------
    // Delete project
    // -------------------
    public function deleteProject($id) {
        $id = intval($id);

        // First get current images and map to delete files if needed
        $stmt = $this->conn->prepare("SELECT project_images, project_map FROM projects WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if($result) {
            // Delete images
            $images = json_decode($result['project_images'], true);
            if($images && is_array($images)) {
                foreach($images as $img) {
                    $path = __DIR__ . '/../' . $img;
                    if(file_exists($path)) unlink($path);
                }
            }
            // Delete map
            if(!empty($result['project_map'])) {
                $mapPath = __DIR__ . '/../' . $result['project_map'];
                if(file_exists($mapPath)) unlink($mapPath);
            }
        }

        // Delete project record
        $stmt = $this->conn->prepare("DELETE FROM projects WHERE id=?");
        $stmt->bind_param('i', $id);

        if($stmt->execute()) {
            $stmt->close();
            return ['success'=>true,'message'=>'Project deleted successfully.'];
        } else {
            $stmt->close();
            return ['success'=>false,'message'=>'Delete failed: '.$this->conn->error];
        }
    }

    // -------------------
    // Fetch all projects
    // -------------------
    public function getAllProjects() {
        $result = $this->conn->query("SELECT * FROM projects ORDER BY id DESC");
        if(!$result) return ['success'=>false,'message'=>$this->conn->error,'data'=>[]];
        $projects = [];
        while($row = $result->fetch_assoc()) $projects[] = $row;
        return ['success'=>true,'data'=>$projects];
    }

    // -------------------
    // Fetch single project
    // -------------------
    public function getProject($id) {
        $stmt = $this->conn->prepare("SELECT * FROM projects WHERE id=?");
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        if($res && $res->num_rows>0) return ['success'=>true,'data'=>$res->fetch_assoc()];
        return ['success'=>false,'message'=>'Project not found'];
    }
}
