<?php
class Street {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Fetch all streets
    public function getAll() {
        $stmt = $this->db->prepare("SELECT s.*, p.project_name FROM streets s 
                                   JOIN projects p ON s.project_id = p.id 
                                   ORDER BY s.streets_sorting ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Fetch street by ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM streets WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Add new street
    public function add($data) {
        $stmt = $this->db->prepare("INSERT INTO streets (project_id, sector_id, street, create_date, modify_date, streets_sorting)
                                   VALUES (?, ?, ?, NOW(), NOW(), ?)");
        $stmt->bind_param("issi", $data['project_id'], $data['sector_id'], $data['street'], $data['streets_sorting']);
        return $stmt->execute();
    }

    // Update street
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE streets SET project_id=?, sector_id=?, street=?, modify_date=NOW(), streets_sorting=? WHERE id=?");
        $stmt->bind_param("issii", $data['project_id'], $data['sector_id'], $data['street'], $data['streets_sorting'], $id);
        return $stmt->execute();
    }

    // Delete street
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM streets WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Fetch all projects for dropdown
    public function getProjects() {
        $stmt = $this->db->prepare("SELECT id, project_name FROM projects WHERE status=1 ORDER BY project_name ASC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
