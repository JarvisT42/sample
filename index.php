<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="" />
  <meta name="author" content="webthemez" />
  <title>GFI-Library</title>
  <!-- core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <link href="css/animate.min.css" rel="stylesheet" />
  <link href="css/prettyPhoto.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
  <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <link rel="shortcut icon" href="images/ico/favicon.ico" />
</head>

<body id="home">


  <header id="header">
    <nav id="main-nav" class="navbar navbar-default navbar-fixed-top" role="banner">
      <div class="container-fluid">
        <div class="navbar-header">
          <button
            type="button"
            class="navbar-toggle collapsed"
            data-toggle="collapse"
            data-target="#navbar-content"
            aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <!-- Logo and Title -->
          <a class="navbar-brand" href="index.html" style="display: flex; align-items: center">
            <img src="./src/assets/images/library.png" alt="logo" />
            <span class="navbar-title">Gensantos Foundation College, Inc. Library</span>
          </a>
        </div>

        <div class="collapse navbar-collapse" id="navbar-content">
          <ul class="nav navbar-nav navbar-right">
            <li class="scroll active"><a href="#home">Home</a></li>
            <li class="scroll"><a href="#services">Features</a></li>
            <li class="scroll"><a href="#about">About</a></li>
            <li class="scroll"><a href="#contact-us">Contact</a></li>

            <!-- Centered Login Button -->
            <li class="scroll center-login">
              <a href="login.php" class="btn btn-login">Login</a>
            </li>
          </ul>

        </div>
      </div>
    </nav>
  </header>



  background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../src/assets/images/img5.png') no-repeat center center;



  <section id="hero-banner">
    <!-- Slide 1 -->
    <div
      class="slide active"
      style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('./src/assets/images/background.png');">
      <div class="slide-content">
        <h2>Stronger than <b>EVER</b></h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <a href="#">Start Now</a>
      </div>
    </div>

    <!-- Slide 2 -->
    <div
      class="slide"
      style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),  url('./src/assets/images/Screenshot 2024-08-30 203504.png');
        ">
      <div class="slide-content">
        <h2>Join Our Journey</h2>
        <p>
          Praesent eget risus vitae massa semper aliquam quis mattis quam.
        </p>
        <a href="#">Join Us</a>
      </div>
    </div>

    <!-- Slide 3 -->
    <div
      class="slide"
      style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),  url('./src/assets/images/gfi-library.png')">
      <div class="slide-content">
        <h2>Become Stronger</h2>
        <p>Morbi vitae tortor tempus, placerat leo et, suscipit lectus.</p>
        <a href="#">Learn More</a>
      </div>
    </div>

    <div
      class="slide"
      style="background-image: url('./src/assets/images/mainlib2.upd.png')"></div>

    <div
      class="slide"
      style="background-image: url('./src/assets/images/mainlib3.upd.png')"></div>

    <!-- style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),  url('./src/assets/images/mainlib.upd.png')"> -->

    <div
      class="slide"
      style="background-image: url('./src/assets/images/mainlib.upd.png')"></div>


    <!-- Add more slides as needed -->
  </section>

  <script>
    // JavaScript for Slideshow
    let currentSlide = 0;
    const slides = document.querySelectorAll(".slide");
    const totalSlides = slides.length;
    const slideInterval = 3000; // 3 seconds

    function showSlide(index) {
      slides.forEach((slide, i) => {
        slide.classList.remove("active");
        if (i === index) {
          slide.classList.add("active");
        }
      });
    }

    function nextSlide() {
      currentSlide = (currentSlide + 1) % totalSlides;
      showSlide(currentSlide);
    }

    setInterval(nextSlide, slideInterval);
  </script>

  <section id="search-engine">
    <div class="container text-center d-flex justify-content-center">
      <div class="section-header">
      <h2 class="section-title wow fadeInDown" style="color: #9C1414;">

          Search Our Library
        </h2>
        <p class="wow fadeInDown">
          Find books, journals, articles, and resources in our extensive
          online library collection.
        </p>
      </div>

      <form class="search-form d-flex mx-auto">
        <!-- Dropdown for category selection -->
        <select class="form-select" aria-label="Category">
          <option selected>All Fields</option>
          <option value="title">Title</option>
          <option value="author">Author</option>
          <option value="keyword">Keyword</option>
          <option value="isbn">ISBN</option>
        </select>

        <!-- Search input field -->
        <input
          type="text"
          class="form-control"
          placeholder="Search by Title, Author, Keyword or ISBN"
          aria-label="Search" />

        <!-- Search button -->
        <button class="btn btn-primary" type="submit">
          <i class="fa fa-search"></i>
        </button>
      </form>
    </div>
  </section>

  <section id="services">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title wow fadeInDown">Library Features</h2>
        <p class="wow fadeInDown">
          Discover our comprehensive online borrowing system designed to make
          your library experience seamless and efficient.
        </p>
      </div>

      <div class="row">
        <!-- Online Borrowing -->
        <div
          class="col-lg-4 col-md-6 col-sm-12 wow fadeInUp"
          data-wow-duration="300ms"
          data-wow-delay="0ms">
          <div class="media service-box">
            <div class="pull-left">
              <i class="fa fa-book"></i>
            </div>
            <div class="media-body">
              <h4 class="media-heading">Online Borrowing</h4>
              <p>
                Easily borrow books online from the comfort of your home. No
                need to visit the library; simply reserve your book online and
                pick it up when it’s ready.
              </p>
            </div>
          </div>
        </div>

        <!-- View Available Books -->
        <div
          class="col-lg-4 col-md-6 col-sm-12 wow fadeInUp"
          data-wow-duration="300ms"
          data-wow-delay="100ms">
          <div class="media service-box">
            <div class="pull-left">
              <i class="fa fa-eye"></i>
            </div>
            <div class="media-body">
              <h4 class="media-heading">View Available Books</h4>
              <p>
                Browse our extensive catalog to see which books are currently
                available. Filter by genre, author, or publication date to
                find what you're looking for quickly.
              </p>
            </div>
          </div>
        </div>

        <!-- Account Management -->
        <div
          class="col-lg-4 col-md-6 col-sm-12 wow fadeInUp"
          data-wow-duration="300ms"
          data-wow-delay="200ms">
          <div class="media service-box">
            <div class="pull-left">
              <i class="fa fa-user"></i>
            </div>
            <div class="media-body">
              <h4 class="media-heading">Account Management</h4>
              <p>
                Manage your borrowing history, track due dates, and view fines
                or fees all from your personal library account dashboard.
              </p>
            </div>
          </div>
        </div>

        <!-- Book Recommendations -->
        <div
          class="col-lg-4 col-md-6 col-sm-12 wow fadeInUp"
          data-wow-duration="300ms"
          data-wow-delay="300ms">
          <div class="media service-box">
            <div class="pull-left">
              <i class="fa fa-thumbs-up"></i>
            </div>
            <div class="media-body">
              <h4 class="media-heading">Discover New Books
              </h4>
              <p>
                Explore our curated selection of popular titles and genres. Browse through new arrivals, bestsellers, and trending books to find your next great read.
              </p>
            </div>
          </div>
        </div>

        <!-- Digital Library Access -->
        <div
          class="col-lg-4 col-md-6 col-sm-12 wow fadeInUp"
          data-wow-duration="300ms"
          data-wow-delay="400ms">
          <div class="media service-box">
            <div class="pull-left">
              <i class="fa fa-laptop"></i>
            </div>
            <div class="media-body">
              <h4 class="media-heading">Digital Library Access</h4>
              <p>
                Access a wide range of e-books and digital resources directly
                from your account. Ideal for remote learning and research.
              </p>
            </div>
          </div>
        </div>

        <!-- Notifications and Alerts -->
        <div
          class="col-lg-4 col-md-6 col-sm-12 wow fadeInUp"
          data-wow-duration="300ms"
          data-wow-delay="500ms">
          <div class="media service-box">
            <div class="pull-left">
              <i class="fa fa-bell"></i>
            </div>
            <div class="media-body">
              <h4 class="media-heading">Notifications & Alerts</h4>
              <p>
                Stay updated with in-platform notifications for due dates, new arrivals, and special library events. Easily check reminders and updates right within your library account.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>



  <section id="about" style="font-family: Arial, sans-serif; line-height: 1.8;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; ">
        <div class="section-header" style="text-align: center; margin-bottom: 20px;">
            <h2 class="section-title wow fadeInDown" style="font-size: 2.5em; font-weight: bold; margin-bottom: 10px;">About Us</h2>
            <p class="wow fadeInDown" style="font-size: 1.3em;">
                Welcome to the Gensantos Foundation College, Inc. Library – a center of knowledge, learning, and innovation designed to support the academic and personal growth of our students and faculty.
            </p>
        </div>

        <div class="row" style="display: flex; flex-wrap: wrap; gap: 20px;">
            <!-- Left Column -->
            <div class="col-sm-6 wow fadeInLeft" style="flex: 1; min-width: 300px;">
                <h3 class="column-title" style="font-size: 2em; font-weight: bold;">Our Mission & Vision</h3>
                <p style="font-size: 1.3em;">
                    <strong>VISION</strong><br>
                    GFI Library envisions becoming a leading College Learning Resource Center in all types of information sources in the fields of Accountancy, Business and Management, Education, and Information and Communication Technology. It aims for reliable, rapid access, easy retrieval, and transfer of relevant information to its users, establishing linkages with other academic libraries globally.<br><br>
                    <strong>MISSION</strong><br>
                    The College Library exists to support the vision and mission of Gensantos Foundation College Inc. and the goals and objectives of its various curricular programs, providing excellent library services in support of instruction, research, and other scholarly activities.
                </p>
            </div>

            <!-- Right Column -->
            <div class="col-sm-6 wow fadeInRight" style="flex: 1; min-width: 300px;">
                <h3 class="column-title" style="font-size: 2em; font-weight: bold;">What We Offer</h3>
                <ul class="listarrow" style="list-style: none; padding: 0; font-size: 1.3em; color: #555;">
                    <li style="margin-bottom: 10px;"><i class="fa fa-angle-double-right" style="margin-right: 8px; color: #007bff;"></i>Extensive Collection: Books, journals, and digital resources across multiple disciplines.</li>
                    <li style="margin-bottom: 10px;"><i class="fa fa-angle-double-right" style="margin-right: 8px; color: #007bff;"></i>Modern Borrowing System: Reserve and borrow books online for added convenience.</li>
                    <li style="margin-bottom: 10px;"><i class="fa fa-angle-double-right" style="margin-right: 8px; color: #007bff;"></i>Personalized Services: Manage borrowing history, track due dates, and receive tailored services.</li>
                    <li style="margin-bottom: 10px;"><i class="fa fa-angle-double-right" style="margin-right: 8px; color: #007bff;"></i>Digital Library Access: 24/7 access to e-books, research articles, and other digital materials.</li>
                    <li style="margin-bottom: 10px;"><i class="fa fa-angle-double-right" style="margin-right: 8px; color: #007bff;"></i>Community Engagement: Events, book clubs, and more to promote knowledge-sharing.</li>
                </ul>
            </div>
        </div>
    </div>
</section>


  <!--/#about-->



  <!--/#about-->




  <section id="contact-us">
    <div class="container">
      <div class="section-header text-center">
        <h2 class="section-title wow fadeInDown">Contact Us</h2>
        <p class="wow fadeInDown">
          Reach out to Gensantos Foundation College, Inc. for any assistance or inquiries.
        </p>
      </div>
    </div>
  </section>

  <section id="contact">
    <div class="container">
      <div class="contact-info">
        <div class="row">
          <div class="col-sm-6">
            <h3>Contact Information</h3>
            <address>
              <p><strong><i class="fa fa-university"></i> GENSANTOS FOUNDATION COLLEGE, INC.</strong></p>
              <p><i class="fa fa-map-marker"></i> Bulaong Extension, General Santos City, South Cotabato, Philippines, 9500</p>
              <p><i class="fa fa-envelope"></i> Email: <a href="mailto:gfistudentaffairs1994@gmail.com">gfistudentaffairs1994@gmail.com</a></p>
              <p><i class="fa fa-phone"></i> Phone: 553-1937 / 552-3594</p>
              <p><i class="fa fa-facebook"></i> Facebook: <a href="https://facebook.com/GFIOfficeOfTheStudentaffairs" target="_blank">/GFIOfficeOfTheStudentaffairs</a></p>
            </address>
          </div>

          <div class="col-sm-6">
            <h3>Quick Links</h3>
            <ul class="quick-links">
              <li><i class="fa fa-info-circle"></i> <a href="#about">About</a></li>
              <li><i class="fa fa-graduation-cap"></i> <a href="#admission">Admission</a></li>
              <li><i class="fa fa-phone"></i> <a href="#contact">Contact</a></li>
              <li><i class="fa fa-newspaper-o"></i> <a href="#news">News & Updates</a></li>
              <li><i class="fa fa-book"></i> <a href="#rules">Rules and Regulations</a></li>

            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--/#bottom-->

  <footer id="footer">
    <div class="container">
      <div class="row">
        <div class="col-sm-6">
          &copy; Copyright © 2024 GFI FOUNDATION COLLEGE, INC. All Rights Reserved.

        </div>
        <div class="col-sm-6">
          <ul class="social-icons">
            <li>
              <a href="#"><i class="fa fa-facebook"></i></a>
            </li>
            <li>
              <a href="#"><i class="fa fa-twitter"></i></a>
            </li>
            <li>
              <a href="#"><i class="fa fa-google-plus"></i></a>
            </li>
            <li>
              <a href="#"><i class="fa fa-linkedin"></i></a>
            </li>
            <li>
              <a href="#"><i class="fa fa-youtube"></i></a>
            </li>
            <li>
              <a href="#"><i class="fa fa-github"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  <!--/#footer-->

  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/mousescroll.js"></script>
  <script src="js/smoothscroll.js"></script>
  <script src="js/jquery.prettyPhoto.js"></script>
  <script src="js/jquery.isotope.min.js"></script>
  <script src="js/jquery.inview.min.js"></script>
  <script src="js/wow.min.js"></script>
  <script src="js/custom-scripts.js"></script>
</body>

</html>