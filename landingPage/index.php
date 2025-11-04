<!DOCTYPE html>
<html lang="en">
<head>
  <title>Jadoo Travel - Explore the World</title>

    <?php require("header.php");?>

 
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand fw-bold fs-3" href="#">Real State</a>
      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item"><a class="nav-link" href="#">Destinations</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Hotels</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Flights</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Bookings</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <li class="nav-item ms-3"><a class="btn btn-sm" href="signup.php">Sign Up</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
      <img class="img" src="./assets/img/Decore.svg" alt="">
    <div class="container">
    
      <div class="row align-items-center">
       <div class="col-md-6">
  <p class="text-uppercase text-danger fw-bold mb-2">Find your dream property</p>
  <h1>Buy, sell, <br> or rent your <br> perfect home</h1>
  <p>Explore premium residential and commercial properties with trusted agents. We make your property journey smooth and stress-free.</p>
  <a href="#" class="btn btn-orange">Explore Properties</a>
</div>

   

<div class="col-md-6">
  <div id="heroCarousel" class="heroCarousel carousel slide" data-bs-ride="carousel">
    
    <!-- Carousel Indicators (bullets) -->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>

    <!-- Carousel Images -->
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="https://images.unsplash.com/photo-1560185127-6ed189bf02f4" 
             class="d-block w-100 rounded" 
             alt="Modern house front view">
      </div>
      <div class="carousel-item">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c" 
             class="d-block w-100 rounded" 
             alt="Luxury home exterior">
      </div>
      <div class="carousel-item">
        <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be" 
             class="d-block w-100 rounded" 
             alt="Living room interior">
      </div>
    </div>

  </div>
</div>



      </div>
    </div>
  </section>

<!-- Services -->
<section class="services text-center">
  <div class="container">
    <h6 class="text-muted">CATEGORY</h6>
    <h2 class="fw-bold mb-5">We Offer Best Property Services</h2>
    <div class="row g-4">
      <div class="col-md-3">
        <div class="service-box">
          <i class="bi bi-house-door"></i>
          <h5>Featured Properties</h5>
          <p>Discover premium homes, apartments, and commercial spaces that fit your lifestyle and budget.</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="service-box">
          <i class="bi bi-cash-stack"></i>
          <h5>Best Deals</h5>
          <p>Get exclusive property offers and investment opportunities at competitive market prices.</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="service-box">
          <i class="bi bi-calendar-event"></i>
          <h5>Open House Events</h5>
          <p>Join local property tours and real estate exhibitions to explore listings firsthand.</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="service-box">
          <i class="bi bi-person-check"></i>
          <h5>Personalized Assistance</h5>
          <p>We guide you through buying, selling, and renting — from property search to legal documentation.</p>
        </div>
      </div>
    </div>
  </div>
</section>



  <!-- Top Destinations -->
  <section class="destinations text-center">
    <div class="container">
      <h6 class="text-muted">Our Projects</h6>
      <h2 class="fw-bold mb-5">Our Top Projects</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card destination-card">
            <img src="https://images.unsplash.com/photo-1504196606672-aef5c9cefc92" class="card-img-top" alt="Rome">
            <div class="card-body">
              <h5>Royal Orchard MULTAN</h5>
              <p class="text-muted">Booking is open <br><a href="">More Details</a></p>
            </div>
          </div>
        </div>
             <div class="col-md-4">
          <div class="card destination-card">
            <img src="https://images.unsplash.com/photo-1504196606672-aef5c9cefc92" class="card-img-top" alt="Rome">
            <div class="card-body">
              <h5>Royal Orchard PESHAWAR</h5>
              <p class="text-muted">Booking is open <br><a href="">More Details</a></p>
            </div>
          </div>
        </div>
             <div class="col-md-4">
          <div class="card destination-card">
            <img src="https://images.unsplash.com/photo-1504196606672-aef5c9cefc92" class="card-img-top" alt="Rome">
            <div class="card-body">
              <h5>Royal Orchard LAHORE</h5>
              <p class="text-muted">Booking is open <br><a href="">More Details</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Subscribe -->
  <section class="subscribe">
    <div class="container">
      <div class="subscribe-inner">
        <img class="img1" src="./assets/img/group-left.svg" alt="">
      <h3 class="fw-bold mb-5">Subscribe to get information, latest news and other
      interesting offers about Jadoo</h3>
            <form class="d-flex justify-content-center">
        <input type="email" placeholder="Your Email" required>
        <button class="ms-2">Subscribe</button>
      </form>
              <img class="img2" src="./assets/img/group-right.svg" alt="">


      </div>
     
    </div>
  </section>

  <!-- Footer -->
<footer class="py-5 bg-light">
  <div class="container">
    <div class="row align-items-start text-center text-md-start">
      <!-- Brand -->
      <div class="col-md-3 mb-4">
        <h3 class="fw-bold text-dark">Real State<span class="text-danger">.</span></h3>
        <p class="text-muted">Find your dream property — homes, apartments, and investments made simple.</p>
      </div>

      <!-- Company -->
      <div class="col-md-2 mb-4">
        <h6 class="fw-bold mb-3">Company</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="text-muted text-decoration-none">About</a></li>
          <li><a href="#" class="text-muted text-decoration-none">Careers</a></li>
          <li><a href="#" class="text-muted text-decoration-none">Our Agents</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="col-md-2 mb-4">
        <h6 class="fw-bold mb-3">Contact</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="text-muted text-decoration-none">Help / FAQ</a></li>
          <li><a href="#" class="text-muted text-decoration-none">Press</a></li>
          <li><a href="#" class="text-muted text-decoration-none">Support</a></li>
        </ul>
      </div>

      <!-- More -->
      <div class="col-md-2 mb-4">
        <h6 class="fw-bold mb-3">More</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="text-muted text-decoration-none">Property Tips</a></li>
          <li><a href="#" class="text-muted text-decoration-none">Mortgage Guide</a></li>
          <li><a href="#" class="text-muted text-decoration-none">Investing</a></li>
        </ul>
      </div>

      <!-- Social & App Links -->
      <div class="col-md-3 mb-4 text-center text-md-start">
        <div class="mb-3">
          <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle me-2"><i class="bi bi-facebook"></i></a>
          <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle me-2"><i class="bi bi-instagram"></i></a>
          <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle"><i class="bi bi-twitter"></i></a>
        </div>
        <p class="fw-semibold mb-2">Download our app</p>
        <div class="d-flex justify-content-center justify-content-md-start">
          <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" height="40" class="me-2"></a>
          <a href="#"><img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="App Store" height="40"></a>
        </div>
      </div>
    </div>

    <div class="text-center mt-4">
      <p class="text-muted small mb-0">© 2025 Real State. All rights reserved.</p>
    </div>
  </div>
</footer>

   <?php require("script.php");?>
</body>
</html>
