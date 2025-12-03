<?php 
session_start();

/* ------------------------------------
   DATABASE CONNECTION
------------------------------------- */
$conn = mysqli_connect("localhost", "root", "", "rdlpk_db1");

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

/* ------------------------------------
   FETCH SLIDER
------------------------------------- */
$sliderQuery = "SELECT * FROM slider ORDER BY id DESC";
$sliderResult = mysqli_query($conn, $sliderQuery);
if (!$sliderResult) {
    die("Slider Query Error: " . mysqli_error($conn));
}

/* ------------------------------------
   FETCH PROJECTS (Top 3 Active)
------------------------------------- */
$projectQuery = "SELECT * FROM projects WHERE status = 1 ORDER BY id DESC LIMIT 3";
$projectResult = mysqli_query($conn, $projectQuery);
if (!$projectResult) {
    die("Projects Query Error: " . mysqli_error($conn));
}

/* ------------------------------------
   FETCH NEWS (Latest 5 Active)
------------------------------------- */
$newsQuery = "SELECT * FROM latest_news WHERE status = 'active' ORDER BY id DESC LIMIT 5";
$newsResult = mysqli_query($conn, $newsQuery);
if (!$newsResult) {
    die("News Query Error: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Real Estate E-System - Explore Homes, Live Better</title>
    <?php require("header.php"); ?>
</head>

<body>

<!-- NAVBAR -->
<?php $navbarClass = "navbar-absolute"; include("navbar.php"); ?>


<!-- HERO SECTION -->
<section class="hero">
    <img class="img" src="./assets/img/Decore.svg" alt="">
    <div class="container">

        <div class="row align-items-center">

            <!-- LEFT TEXT -->
            <div class="col-md-6">
                <p class="text-uppercase text-danger fw-bold mb-2">Find your dream property</p>
                <h1>Buy, sell, <br> or rent your <br> perfect home</h1>
                <p>Explore premium residential and commercial properties with trusted agents.</p>
                <a href="#" class="btn btn-orange">Explore Properties</a>
            </div>

            <!-- RIGHT: DYNAMIC SLIDER -->
            <div class="col-md-6">
                <div id="heroCarousel" class="heroCarousel carousel slide" data-bs-ride="carousel">

                    <!-- Indicators -->
                    <div class="carousel-indicators">
                    <?php 
                    $i = 0;
                    mysqli_data_seek($sliderResult, 0);
                    while ($slide = mysqli_fetch_assoc($sliderResult)) { ?>
                        <button type="button" 
                                data-bs-target="#heroCarousel" 
                                data-bs-slide-to="<?php echo $i; ?>" 
                                class="<?php echo ($i == 0 ? 'active' : ''); ?>">
                        </button>
                    <?php $i++; } ?>
                    </div>

                    <!-- Slider Images -->
                    <div class="carousel-inner">
                    <?php 
                    mysqli_data_seek($sliderResult, 0);
                    $i = 0;
                    while ($slide = mysqli_fetch_assoc($sliderResult)) { ?>
                        <div class="carousel-item <?php echo ($i == 0 ? 'active' : ''); ?>">
                            <img src="/admin/assets/img/slider_images/<?php echo $slide['image']; ?>" 
     class="d-block w-100 rounded" 
     alt="<?php echo $slide['title']; ?>">

                        </div>
                    <?php $i++; } ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>



<!-- SERVICES SECTION -->
<section class="services text-center mt-5">
    <div class="container">
        <h6 class="text-muted">CATEGORY</h6>
        <h2 class="fw-bold mb-5">We Offer Best Property Services</h2>

        <div class="row g-4">
            <div class="col-md-3">
                <div class="service-box">
                    <i class="bi bi-house-door"></i>
                    <h5>Featured Properties</h5>
                    <p>Discover premium homes and commercial spaces.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="service-box">
                    <i class="bi bi-cash-stack"></i>
                    <h5>Best Deals</h5>
                    <p>Get exclusive property offers & investment opportunities.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="service-box">
                    <i class="bi bi-calendar-event"></i>
                    <h5>Open House Events</h5>
                    <p>Join property tours & view listings firsthand.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="service-box">
                    <i class="bi bi-person-check"></i>
                    <h5>Personalized Assistance</h5>
                    <p>Full support from property search to documentation.</p>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- TOP PROJECTS -->
<section class="destinations text-center mt-5">
    <div class="container">
        <h6 class="text-muted">Our Projects</h6>
        <h2 class="fw-bold mb-5">Our Top Projects</h2>

        <div class="row g-4">
        <?php while ($p = mysqli_fetch_assoc($projectResult)) { ?>

            <div class="col-md-4">
                <div class="card destination-card">
                    <img src="uploads/projects/<?php echo $p['project_images']; ?>" 
                         class="card-img-top" alt="">  

                    <div class="card-body">
                        <h5><?php echo $p['project_name']; ?></h5>
                        <p class="text-muted">
                            <?php echo substr($p['teaser'], 0, 100); ?>...
                            <br>
                            <a href="project-details.php?id=<?php echo $p['id']; ?>">
                                More Details
                            </a>
                        </p>
                    </div>
                </div>
            </div>

        <?php } ?>
        </div>

    </div>
</section>




<!-- LATEST NEWS -->
<section class="news-section mt-5">
    <div class="container">
        <h2 class="fw-bold mb-4">Latest News</h2>

        <div class="row g-4">
        <?php while ($n = mysqli_fetch_assoc($newsResult)) { ?>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">

                    <small class="text-muted">
                        <?php echo date("d M Y", strtotime($n['create_date'])); ?>
                    </small>

                    <h5 class="mt-2"><?php echo substr($n['teaser'], 0, 70); ?>...</h5>

                    <a href="news-details.php?id=<?php echo $n['id']; ?>" 
                       class="mt-3 d-block">
                       Read More →
                    </a>
                </div>
            </div>
        <?php } ?>
        </div>

    </div>
</section>



<!-- SUBSCRIBE -->
<section class="subscribe mt-5">
    <div class="container">
        <div class="subscribe-inner">
            <img class="img1" src="./assets/img/group-left.svg" alt="">
            <h3 class="fw-bold mb-5">Subscribe for Updates</h3>

            <form class="d-flex justify-content-center">
                <input type="email" placeholder="Your Email" required>
                <button class="ms-2">Subscribe</button>
            </form>

            <img class="img2" src="./assets/img/group-right.svg" alt="">
        </div>
    </div>
</section>


<!-- FOOTER -->
<?php require("footer.php"); ?>
<?php require("script.php"); ?>

</body>
</html>
