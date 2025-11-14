<?php
class User
{
    private $conn;
    private $table = "user";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get users with pagination
    public function getAllUsers($search = "", $limit = 20, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1";

        if (!empty($search)) {
            $sql .= " AND (firstname LIKE ? OR middelname LIKE ? OR lastname LIKE ? OR username LIKE ?)";
            $stmt = $this->conn->prepare($sql . " LIMIT ? OFFSET ?");
            $searchTerm = "%$search%";
            $stmt->bind_param("ssssii", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $limit, $offset);
        } else {
            $sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $limit, $offset);
        }

        $stmt->execute();
        return $stmt->get_result();
    }

    // Total count for pagination
    public function getTotalUsers($search = "")
    {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table} WHERE 1";

        if (!empty($search)) {
            $sql .= " AND (firstname LIKE ? OR middelname LIKE ? OR lastname LIKE ? OR username LIKE ?)";
            $stmt = $this->conn->prepare($sql);
            $searchTerm = "%$search%";
            $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
        } else {
            $stmt = $this->conn->prepare($sql);
        }

        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }

    // Get single user
    public function getUserById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Create user
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (firstname, middelname, lastname, sodowo, email, mobile, username, password, status, pic, create_date)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "ssssssssss",
            $data['firstname'], $data['middelname'], $data['lastname'], $data['sodowo'],
            $data['email'], $data['mobile'], $data['username'], $data['password'],
            $data['status'], $data['pic']
        );
        return $stmt->execute();
    }

    // Update user
    public function update($data)
    {
        $sql = "UPDATE {$this->table} SET 
                firstname=?, middelname=?, lastname=?, sodowo=?, email=?, mobile=?, 
                username=?, status=?, pic=? WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "sssssssssi",
            $data['firstname'], $data['middelname'], $data['lastname'], $data['sodowo'],
            $data['email'], $data['mobile'], $data['username'],
            $data['status'], $data['pic'], $data['id']
        );
        return $stmt->execute();
    }

    // Delete user
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
