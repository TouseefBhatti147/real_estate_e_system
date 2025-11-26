<?php
include __DIR__ . '../../includes/config.php';
?>

<div class="sidebar-wrapper">
  <nav class="mt-2">
    <!--begin::Sidebar Menu-->
    <!-- client sidebar menu -->
    <ul
      class="d-none  nav sidebar-menu flex-column"
      data-lte-toggle="treeview"
      role="navigation"
      aria-label="Main navigation"
      data-accordion="false"
      id="navigation">
      <li class="nav-item">
        <a href="<?= $base ?>index.php" class="nav-link active">
          <i class="nav-icon bi bi-speedometer"></i>
          <p>Client Dashboard</p>
        </a>
      </li>


      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon bi bi-building"></i>
          <p>
            Property
            <i class="nav-arrow bi bi-chevron-right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= $base ?>client/property/booking.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Booking</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= $base ?>client/property/transfer.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Allotments/Transfer</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= $base ?>client/property/membership.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Joint Memberships</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= $base ?>client/property/transferProcess.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Transfer in Process</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= $base ?>client/property/cancellation.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Cancellation in Process</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon bi bi-building"></i>
          <p>
            Accounts
            <i class="nav-arrow bi bi-chevron-right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= $base ?>client/accounts/paymentSummery.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Payment Summary</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= $base ?>client/accounts/transactionHistory.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Transaction History</p>
            </a>
          </li>
        </ul>
      </li>


      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon bi bi-building"></i>
          <p>
            Profile
            <i class="nav-arrow bi bi-chevron-right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= $base ?>client/profile/myProfile.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>My Profile</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= $base ?>client/profile/changePassword.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Change Password</p>
            </a>
          </li>


        </ul>
      </li>
    </ul>






    <!-- // Admin sidebar menu -->
    <ul
      class="  nav sidebar-menu flex-column"
      data-lte-toggle="treeview"
      role="navigation"
      aria-label="Main navigation"
      data-accordion="false"
      id="navigation">
      <li class="nav-item">
        <a href="../index.php" class="nav-link active">
          <i class="nav-icon bi bi-speedometer"></i>
          <p>Dashboard</p>
        </a>
      </li>

      <!-- Property Management -->
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon bi bi-building"></i>
          <p>
            Property Management
            <i class="nav-arrow bi bi-chevron-right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="projects.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Projects</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="sectors.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Sectors</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="streets.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Streets</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="plot_sizes.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Plot Size Categories</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="property_types.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Property Types</p>
            </a>
          </li>
        </ul>
      </li>



      <!-- Finance & Sales -->
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon bi bi-cash-coin"></i>
          <p>
            Finance & Sales
            <i class="nav-arrow bi bi-chevron-right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="recovery_system.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Recovery System</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="installment_plan.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Installment Plan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="charges_list.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Charges List</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="banks.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Banks</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="sales_center.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Sales Center</p>
            </a>
          </li>
        </ul>
      </li>

      <!-- Users & Members -->
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon bi bi-people-fill"></i>
          <p>
            Users / Members
            <i class="nav-arrow bi bi-chevron-right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="members_directory.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Member's Directory</p>
              <span class="nav-badge badge text-bg-success me-3"></span>
            </a>
          </li>

          <li class="nav-item">
            <a href="users.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>User</p>
              <span class="nav-badge badge text-bg-danger me-3"></span>
            </a>
          </li>
        </ul>
      </li>

      <!-- Reports -->
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon bi bi-clipboard-data-fill"></i>
          <p>
            Reports
            <i class="nav-arrow bi bi-chevron-right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="plots_report.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Plots Report</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="receipt_reports.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Receipt Reports</p>
            </a>
          </li>

        </ul>
      </li>



      <!-- Media & Website -->
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon bi bi-display-fill"></i>
          <p>
            Media & Website
            <i class="nav-arrow bi bi-chevron-right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="slider.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Slider</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="gallery.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Image Gallery</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="news.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>News</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="downloads.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Downloads</p>
            </a>
          </li>

        </ul>
      </li>

      <li class="nav-header">SYSTEM</li>

      <!-- Operations -->
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon bi bi-tools"></i>
          <p>
            Operations
            <i class="nav-arrow bi bi-chevron-right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="security.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Security</p>
            </a>
          </li>

        </ul>
      </li>

      <!-- Settings -->
      <li class="nav-item">

        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="pages.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Pages</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="country.php" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Manage Country</p>
            </a>
          </li>

        </ul>
      </li>

    </ul>
    <!--end::Sidebar Menu-->
  </nav>
</div>