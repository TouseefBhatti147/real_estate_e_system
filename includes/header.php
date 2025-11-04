<nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"><i class="bi bi-list"></i></a>
            </li>
          </ul>
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" data-widget="navbar-search" href="#" role="button"><i class="bi bi-search"></i></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#"><i class="bi bi-chat-text"></i><span class="navbar-badge badge text-bg-danger">3</span></a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!-- Messages go here -->
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#"><i class="bi bi-bell-fill"></i><span class="navbar-badge badge text-bg-warning">15</span></a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <a href="#" class="dropdown-item"><i class="bi bi-envelope me-2"></i> 4 new messages</a>
                <a href="#" class="dropdown-item"><i class="bi bi-people-fill me-2"></i> 8 friend requests</a>
                <a href="#" class="dropdown-item"><i class="bi bi-file-earmark-fill me-2"></i> 3 new reports</a>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
              </a>
            </li>

            <!-- --- USER MENU (UPDATED) --- -->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img src="assets/img/user2-160x160.jpg" class="user-image rounded-circle shadow" alt="User Image" />
                
                <!-- Display Logged-in User's Full Name -->
                <span class="d-none d-md-inline">
                    <?php 
                        // **FIX: Ensure session is started for this include file to read $_SESSION**
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        
                        // Assuming $_SESSION['user_array'] is set and contains user details
                        if (isset($_SESSION['user_array'])) {
                            $user = $_SESSION['user_array'];
                            echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']);
                        } else {
                            echo "Guest User";
                        }
                    ?>
                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <li class="user-header text-bg-primary">
                  <img src="assets/img/user2-160x160.jpg" class="rounded-circle shadow" alt="User Image" />
                  <p>
                    <!-- Display Logged-in User's Full Name and Role/Info -->
                    <?php 
                        // **FIX: Ensure session is started for this include file to read $_SESSION**
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        
                        if (isset($_SESSION['user_array'])) {
                            $user = $_SESSION['user_array'];
                            echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']);
                            echo "<small>" . htmlspecialchars($user['role_type'] ?? 'Member') . "</small>";
                        } else {
                            echo "Guest User";
                        }
                    ?>
                  </p>
                </li>
                <li class="user-footer">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                  
                  <!-- FUNCTIONAL SIGN OUT LINK -->
                  <a href="logout-handler.php" class="btn btn-default btn-flat float-end">Sign out</a>
                </li>
              </ul>
            </li>
            <!-- --- END USER MENU --- -->
          </ul>
        </div>
      </nav>