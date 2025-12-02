<!-- ======== TOP NAVIGATION BAR (Elegant Menu) ======== -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm border-bottom" style="font-size: 15px;">
  <div class="container-fluid">

    <!-- LEFT SIDE -->
    <a class="navbar-brand fw-bold" href="/admin/index.php">
      🏠 Dashboard
    </a>

    <!-- Hamburger for Mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENU ITEMS -->
    <div class="collapse navbar-collapse" id="topNavbar">
      <ul class="navbar-nav">

        <!-- PROPERTY MANAGEMENT -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            Property Management
          </a>
   <ul class="dropdown-menu shadow">

    <li><a class="dropdown-item" href="/admin/plots/plots_list.php">All Plots</a></li>
    <li><a class="dropdown-item" href="/admin/plots/form_plot.php">Add Plot</a></li>
    <li><a class="dropdown-item" href="/admin/plots/plots_list.php">Allot Plots</a></li>
    <li><a class="dropdown-item" href="/admin/plots/plots_list.php">Transfer Plots</a></li>

</ul>

        </li>

        <!-- PROJECT MANAGEMENT -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            Projects
          </a>
         <ul class="dropdown-menu shadow">

   <li><a class="dropdown-item" href="/admin/plots/plots_list.php">All Plots</a></li>
<li><a class="dropdown-item" href="/admin/plots/form_plot.php">Add Plots</a></li>

<li><a class="dropdown-item" href="/admin/projects/projects.php">Projects</a></li>
<li><a class="dropdown-item" href="/admin/sectors/sectors.php">Sectors</a></li>
<li><a class="dropdown-item" href="/admin/streets/streets.php">Streets</a></li>

<li><a class="dropdown-item" href="/admin/plot_sizes/plot_size_list.php">Plot Size Categories</a></li>
<li><a class="dropdown-item" href="/admin/charges/charges.php">Charges</a></li>
<li><a class="dropdown-item" href="/admin/property_type/property_type.php">Property Types</a></li>


</ul>

        </li>

        <!-- MEMBERS -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            Members
          </a>
          <ul class="dropdown-menu shadow">
            <li><a class="dropdown-item" href="members/member_list.php">Members List</a></li>
            <li><a class="dropdown-item" href="members/form_member.php">Add Member</a></li>
          </ul>
        </li>

        <!-- USERS -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            Users
          </a>
          <ul class="dropdown-menu shadow">
            <li><a class="dropdown-item" href="users/user_list.php">Users List</a></li>
            <li><a class="dropdown-item" href="users/form_user.php">Add User</a></li>
          </ul>
        </li>

        <!-- MEDIA MANAGEMENT -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            Media
          </a>
          <ul class="dropdown-menu shadow">
            <li><a class="dropdown-item" href="sliders/slider_list.php">Slider</a></li>
            <li><a class="dropdown-item" href="news/news_list.php">News</a></li>
            <li><a class="dropdown-item" href="sales_centers/sale_center_list.php">Sales Center</a></li>
          </ul>
        </li>

        <!-- REPORTS -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            Reports
          </a>
          <ul class="dropdown-menu shadow">
            <li><a class="dropdown-item" href="reports/plots_report.php">Plots Report</a></li>
            <li><a class="dropdown-item" href="reports/receipt_report.php">Receipt Report</a></li>
          </ul>
        </li>

      </ul>
    </div>

  </div>
</nav>
<!-- ======== END TOP NAVIGATION BAR ======== -->
