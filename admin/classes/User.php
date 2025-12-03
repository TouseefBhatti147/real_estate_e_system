<?php
class User
{
    private $conn;
    private $table = "user";

    public function __construct($pdo)
    {
        $this->conn = $pdo;
    }

    // ---------------- LOGIN ----------------
  public function login($username, $password)
    {
        $sql = "SELECT * FROM {$this->table} WHERE username = ? AND password = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username, $password]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return $user;
        }

        return false;
    }

    // ---------------- GET ALL USERS (PDO) ----------------
    public function getAllUsers($search = "", $limit = 20, $offset = 0)
    {
        $where = "";
        $params = [];

        if (!empty($search)) {
            $where = "WHERE firstname LIKE ? OR lastname LIKE ? OR username LIKE ?";
            $searchParam = "%$search%";
            $params = [$searchParam, $searchParam, $searchParam];
        }

        $sql = "
            SELECT * FROM {$this->table}
            $where
            ORDER BY id DESC
            LIMIT $limit OFFSET $offset
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ---------------- TOTAL COUNT ----------------
    public function getTotalUsers($search = "")
    {
        $where = "";
        $params = [];

        if (!empty($search)) {
            $where = "WHERE firstname LIKE ? OR lastname LIKE ? OR username LIKE ?";
            $searchParam = "%$search%";
            $params = [$searchParam, $searchParam, $searchParam];
        }

        $sql = "SELECT COUNT(*) AS total FROM {$this->table} $where";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn();
    }

    // ---------------- GET SINGLE USER ----------------
    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ---------------- ADD USER ----------------
    public function create($data)
    {
        $hash = password_hash($data['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO {$this->table}
            (firstname, middelname, lastname, pic, sodowo, cnic, address, 
             city_id, email, country_id, mobile, username, password, 
             password1, status, skey, login_status, create_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '', ?, '', '0', NOW())";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $data['firstname'], $data['middelname'], $data['lastname'], $data['pic'],
            $data['sodowo'], $data['cnic'], $data['address'], $data['city_id'], $data['email'],
            $data['country_id'], $data['mobile'], $data['username'], $hash, $data['status']
        ]);
    }

    // ---------------- UPDATE USER ----------------
    public function update($data)
    {
        if (!empty($data['password'])) {
            $hash = password_hash($data['password'], PASSWORD_BCRYPT);

            $sql = "UPDATE {$this->table}
                    SET firstname=?, middelname=?, lastname=?, pic=?, sodowo=?, cnic=?, 
                        address=?, city_id=?, email=?, country_id=?, mobile=?, 
                        username=?, password=?, status=?
                    WHERE id=?";
            
            $params = [
                $data['firstname'], $data['middelname'], $data['lastname'], $data['pic'],
                $data['sodowo'], $data['cnic'], $data['address'], $data['city_id'],
                $data['email'], $data['country_id'], $data['mobile'], $data['username'],
                $hash, $data['status'], $data['id']
            ];
        } else {
            $sql = "UPDATE {$this->table}
                    SET firstname=?, middelname=?, lastname=?, pic=?, sodowo=?, cnic=?, 
                        address=?, city_id=?, email=?, country_id=?, mobile=?, 
                        username=?, status=?
                    WHERE id=?";
            
            $params = [
                $data['firstname'], $data['middelname'], $data['lastname'], $data['pic'],
                $data['sodowo'], $data['cnic'], $data['address'], $data['city_id'],
                $data['email'], $data['country_id'], $data['mobile'], $data['username'],
                $data['status'], $data['id']
            ];
        }

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // ---------------- DELETE USER ----------------
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}
