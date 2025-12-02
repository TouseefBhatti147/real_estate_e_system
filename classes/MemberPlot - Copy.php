<?php
class MemberPlot
{
    /** @var mysqli */
    private $conn;
    private $table = "memberplot";

    public function __construct(mysqli $db)
    {
        $this->conn = $db;
    }

    /**
     * Get list with joins (projects, sectors, streets, plots, member, user)
     * $filters = ['search' => '...']
     */
    public function getAll(array $filters, int $limit, int $offset)
    {
        $sql = "
            SELECT 
                mp.*,
                p.plot_size,
                pr.project_name,
                sec.sector_name,
                st.street AS street_name,
                m.name AS member_name,
                u.username AS assigned_user
            FROM {$this->table} mp
            LEFT JOIN plots    p   ON p.id = mp.plot_id
            LEFT JOIN projects pr  ON pr.id = p.project_id
            LEFT JOIN sectors  sec ON sec.sector_id = p.sector_id
            LEFT JOIN streets  st  ON st.id = p.street_id
            LEFT JOIN member   m   ON m.id = mp.member_id
            LEFT JOIN user     u   ON u.id = mp.uid
            WHERE 1
        ";

        $params = [];
        $types  = '';

        if (!empty($filters['search'])) {
            $sql .= "
                AND (
                    mp.plotno      LIKE ? OR
                    mp.msno        LIKE ? OR
                    mp.status      LIKE ? OR
                    m.name         LIKE ? OR
                    pr.project_name LIKE ? OR
                    sec.sector_name LIKE ? OR
                    st.street       LIKE ?
                )
            ";
            $search = '%' . $filters['search'] . '%';
            // 7 placeholders
            for ($i = 0; $i < 7; $i++) {
                $params[] = $search;
            }
            $types .= str_repeat('s', 7);
        }

        $sql .= " ORDER BY mp.id DESC LIMIT ? OFFSET ?";

        $params[] = $limit;
        $params[] = $offset;
        $types    .= "ii";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * Total rows for pagination
     */
    public function getTotal(array $filters): int
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM {$this->table} mp
            LEFT JOIN plots    p   ON p.id = mp.plot_id
            LEFT JOIN projects pr  ON pr.id = p.project_id
            LEFT JOIN sectors  sec ON sec.sector_id = p.sector_id
            LEFT JOIN streets  st  ON st.id = p.street_id
            LEFT JOIN member   m   ON m.id = mp.member_id
            WHERE 1
        ";

        $params = [];
        $types  = '';

        if (!empty($filters['search'])) {
            $sql .= "
                AND (
                    mp.plotno      LIKE ? OR
                    mp.msno        LIKE ? OR
                    mp.status      LIKE ? OR
                    m.name         LIKE ? OR
                    pr.project_name LIKE ? OR
                    sec.sector_name LIKE ? OR
                    st.street       LIKE ?
                )
            ";
            $search = '%' . $filters['search'] . '%';
            for ($i = 0; $i < 7; $i++) {
                $params[] = $search;
            }
            $types .= str_repeat('s', 7);
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

    /**
     * Same as getAll but without LIMIT/OFFSET – used for export (CSV/Excel/PDF)
     */
    public function getAllForExport(array $filters)
    {
        $sql = "
            SELECT 
                mp.*,
                p.plot_size,
                pr.project_name,
                sec.sector_name,
                st.street AS street_name,
                m.name AS member_name,
                u.username AS assigned_user
            FROM {$this->table} mp
            LEFT JOIN plots    p   ON p.id = mp.plot_id
            LEFT JOIN projects pr  ON pr.id = p.project_id
            LEFT JOIN sectors  sec ON sec.sector_id = p.sector_id
            LEFT JOIN streets  st  ON st.id = p.street_id
            LEFT JOIN member   m   ON m.id = mp.member_id
            LEFT JOIN user     u   ON u.id = mp.uid
            WHERE 1
        ";

        $params = [];
        $types  = '';

        if (!empty($filters['search'])) {
            $sql .= "
                AND (
                    mp.plotno      LIKE ? OR
                    mp.msno        LIKE ? OR
                    mp.status      LIKE ? OR
                    m.name         LIKE ? OR
                    pr.project_name LIKE ? OR
                    sec.sector_name LIKE ? OR
                    st.street       LIKE ?
                )
            ";
            $search = '%' . $filters['search'] . '%';
            for ($i = 0; $i < 7; $i++) {
                $params[] = $search;
            }
            $types .= str_repeat('s', 7);
        }

        $sql .= " ORDER BY mp.id DESC";

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

    /**
     * Get single record – joined with plots to get project/sector/street/size etc
     */
    public function getById(int $id): ?array
    {
        $sql = "
            SELECT 
                mp.*,
                p.project_id,
                p.sector_id,
                p.street_id,
                p.size_cat_id,
                p.category_id
            FROM {$this->table} mp
            LEFT JOIN plots p ON p.id = mp.plot_id
            WHERE mp.id = ?
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return null;
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ?: null;
    }

    /**
     * Create new record
     */
    public function create(array $data): bool
    {
        $sql = "
            INSERT INTO {$this->table}
            (plot_id, member_id, create_date, noi, insplan, status, plotno, msno, uid)
            VALUES (?,?,?,?,?,?,?,?,?)
        ";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $create_date = $data['create_date'] ?? date('Y-m-d H:i:s');

        $stmt->bind_param(
            "iississsi",
            $data['plot_id'],
            $data['member_id'],
            $create_date,
            $data['noi'],
            $data['insplan'],
            $data['status'],
            $data['plotno'],
            $data['msno'],
            $data['uid']
        );

        return $stmt->execute();
    }

    /**
     * Update record
     */
    public function update(array $data): bool
    {
        $sql = "
            UPDATE {$this->table}
            SET 
                plot_id     = ?,
                member_id   = ?,
                create_date = ?,
                noi         = ?,
                insplan     = ?,
                status      = ?,
                plotno      = ?,
                msno        = ?
            WHERE id = ?
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $create_date = $data['create_date'] ?? date('Y-m-d H:i:s');

        $stmt->bind_param(
            "iississsi",
            $data['plot_id'],
            $data['member_id'],
            $create_date,
            $data['noi'],
            $data['insplan'],
            $data['status'],
            $data['plotno'],
            $data['msno'],
            $data['id']
        );

        return $stmt->execute();
    }

    /**
     * Delete record
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
