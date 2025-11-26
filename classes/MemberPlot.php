<?php
class MemberPlot
{
    private $conn;
    private $table = "memberplot";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get data with search + pagination
    public function getAll($search = '', $limit = 20, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1";
        $params = [];
        $types  = '';

        if ($search !== '') {
            $sql .= " AND (plotno LIKE ? OR msno LIKE ? OR status LIKE ?)";
            $like = "%{$search}%";
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
            $types   .= "sss";
        }

        $sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types   .= "ii";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result();
    }

    public function getTotal($search = '')
    {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table} WHERE 1";
        $params = [];
        $types  = '';

        if ($search !== '') {
            $sql .= " AND (plotno LIKE ? OR msno LIKE ? OR status LIKE ?)";
            $like = "%{$search}%";
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
            $types   .= "sss";
        }

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return 0;
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return (int)($res['total'] ?? 0);
    }

    // Get a single record + plot linkage (project/sector/street for edit prefill)
    public function getById($id)
    {
        $sql = "SELECT mp.*, p.project_id, p.sector_id, p.street_id
                FROM {$this->table} mp
                LEFT JOIN plots p ON p.id = mp.plot_id
                WHERE mp.id = ?
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return null;

        $id = (int)$id;
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO {$this->table}
            (plot_id, member_id, create_date, noi, insplan, status, plotno, msno, uid)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $plot_id     = (int)($data['plot_id'] ?? 0);
        $member_id   = (int)($data['member_id'] ?? 0);
        $create_date = $data['create_date'] ?? date('Y-m-d H:i:s');
        $noi         = (string)($data['noi'] ?? '');
        $insplan     = (int)($data['insplan'] ?? 0);
        $status      = (string)($data['status'] ?? 'Approved');
        $plotno      = (string)($data['plotno'] ?? '');
        $msno        = (string)($data['msno'] ?? '');
        $uid         = (int)($data['uid'] ?? 0);

        // i i s s i s s s i
        $stmt->bind_param(
            "iississsi",
            $plot_id,
            $member_id,
            $create_date,
            $noi,
            $insplan,
            $status,
            $plotno,
            $msno,
            $uid
        );

        return $stmt->execute();
    }

    public function update(array $data)
    {
        $sql = "UPDATE {$this->table}
                SET plot_id = ?, member_id = ?, create_date = ?, noi = ?, insplan = ?,
                    status = ?, plotno = ?, msno = ?, uid = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $id          = (int)($data['id'] ?? 0);
        $plot_id     = (int)($data['plot_id'] ?? 0);
        $member_id   = (int)($data['member_id'] ?? 0);
        $create_date = $data['create_date'] ?? date('Y-m-d H:i:s');
        $noi         = (string)($data['noi'] ?? '');
        $insplan     = (int)($data['insplan'] ?? 0);
        $status      = (string)($data['status'] ?? 'Approved');
        $plotno      = (string)($data['plotno'] ?? '');
        $msno        = (string)($data['msno'] ?? '');
        $uid         = (int)($data['uid'] ?? 0);

        // i i s s i s s s i i
        $stmt->bind_param(
            "iississsii",
            $plot_id,
            $member_id,
            $create_date,
            $noi,
            $insplan,
            $status,
            $plotno,
            $msno,
            $uid,
            $id
        );

        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        if (!$stmt) return false;

        $id = (int)$id;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
