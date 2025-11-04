<?php
/**
 * User Class
 *
 * This class handles all user-related logic, such as logging in,
 * registering, and managing sessions.
 */
class User {

    /**
     * @var PDO The database connection object
     */
    private $pdo;

    /**
     * Constructor
     *
     * @param PDO $pdo The database connection object
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Login User
     *
     * Verifies user credentials, logs the login, fetches permissions,
     * and starts a session if successful.
     *
     * @param string $username The username to log in
     * @param string $password The password to verify
     * @return bool True on successful login, False on failure
     */
    public function login($username, $password) {
        
        try {
            // Start a transaction
            $this->pdo->beginTransaction();

            // 1. Prepare SQL statement to find active user
            $sql = "SELECT * FROM user WHERE username = :username AND status = 1";
            
            // REMOVED DEBUG LINE: 'echo $sql = "SELECT * FROM users WHERE username = :username AND status = 1";exit;'

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->execute();
            // 2. Check if username exists
            if ($stmt->rowCount() == 1) {
                
                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    
                    // 3. Verify password
                    if (password_verify($password, $row["password1"])) {
                        
                        $user_id = $row["id"];
                        // 4. Log the successful login (as per your logic)
                        $sql_log = "INSERT INTO users_log (user_id, date_time) VALUES (:user_id, CURRENT_TIMESTAMP())";
                        $stmt_log = $this->pdo->prepare($sql_log);
                        $stmt_log->bindParam(":user_id", $user_id, PDO::PARAM_INT);
                        $stmt_log->execute();

                        // 5. Get project permissions (as per your logic)
                        $sql_projects = "SELECT p.*, pp.* FROM project_permissions pp 
                                         LEFT JOIN projects p ON p.id = pp.project_id 
                                         WHERE pp.user_id = :user_id AND p.status = 1";
                        $stmt_projects = $this->pdo->prepare($sql_projects);
                        $stmt_projects->bindParam(":user_id", $user_id, PDO::PARAM_INT);
                        $stmt_projects->execute();
                        $projects_data = $stmt_projects->fetchAll(PDO::FETCH_ASSOC);

                        // 6. Get centers permissions (as per your logic)
                        $sql_centers = "SELECT * FROM centers_permissions WHERE user_id = :user_id";
                        $stmt_centers = $this->pdo->prepare($sql_centers);
                        $stmt_centers->bindParam(":user_id", $user_id, PDO::PARAM_INT);
                        $stmt_centers->execute();
                        $centers_data = $stmt_centers->fetchAll(PDO::FETCH_ASSOC);

                        // 7. Start session and store all data
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        
                        $_SESSION["loggedin"] = true;
                        $_SESSION["user_array"] = $row; // Stores all user data
                        $_SESSION["projects_array"] = $projects_data;
                        $_SESSION["centers_array"] = $centers_data;
                        
                        // Commit the transaction
                        $this->pdo->commit();
                        
                        // Login successful
                        return true;
                    }
                }
            }
            
            // If username not found or password mismatch, roll back
            $this->pdo->rollBack();
            return false;

        } catch (PDOException $e) {
            // An error occurred, roll back the transaction
            $this->pdo->rollBack();
            // In a real app, log this error $e->getMessage()
            return false;
        } finally {
            // Close statements if they were created
            unset($stmt);
            unset($stmt_log);
            unset($stmt_projects);
            unset($stmt_centers);
        }
    }

    /**
     * Check if user is logged in
     *
     * @return bool
     */
    public static function isLoggedIn() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            return true;
        }
        return false;
    }

    /**
     * Log out user
     *
     * Destroys all session data.
     */
    public static function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = array();
        session_destroy();
        // 🛑 PROBLEM LINE IS HERE
        header("location: login.php"); // <--- This needs to be 'login.php'
        exit;
    }
}
?>