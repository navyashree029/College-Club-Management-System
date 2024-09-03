<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>College Club Management System</title>
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Navbar Color */
        .navbar {
            background-color: rgba(244, 244, 244, 0.8);
            position: fixed;
            top: 0;
            z-index: 1000;
            width: 100%;
        }

        .nav > li > a {
            color: black;
        }

        /* Carousel styling */
        .carousel {
            position: relative;
            width: 100%;
            max-height: 600px;
            overflow: hidden;
            padding-top: 90px;
        }

        .carousel video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .carousel-container {
            position: absolute;
            top: 50%;
            width: 100%;
            text-align: center;
            transform: translateY(-50%);
        }

        .carousel h1 {
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            font-size: 48px;
            font-weight: bold;
        }

        /* Carousel navigation */
        .carousel-controls {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .carousel-controls button {
            background-color: rgba(0, 0, 0, 0.5);
            border: none;
            color: white;
            padding: 10px;
            cursor: pointer;
            font-size: 18px;
        }

        .carousel-controls button:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }
    </style>
</head>
<body>
    <header> 
        <nav class="navbar">
            <div class="container">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php"><strong>Home</strong></a></li>
                    <li><a href="viewEvent.php"><strong>Events</strong></a></li>
                    <li><a href="contact.php"><strong>Contact Us</strong></a></li>
                    <li><a href="aboutus.php"><strong>About us</strong></a></li>
                    <li class="btnlogout">
                        <a class="btn btn-default navbar-btn" href="login_form.php">
                            Login <span class="glyphicon glyphicon-log-in"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="carousel">
            <div class="carousel-container">
                <h1><strong>Welcome to<br>MIND Spark Official Page</strong></h1>
            </div>
            <video src="videos/vid5.mp4" alt="Slide 1" autoplay muted></video>
            <video src="videos/vid2.mp4" alt="Slide 2" style="display:none;" autoplay muted></video>
            <video src="videos/vid3.mp4" alt="Slide 3" style="display:none;" autoplay muted></video>
            <div class="carousel-controls">
                <button onclick="prevSlide()">&#10094;</button>
                <button onclick="nextSlide()">&#10095;</button>
            </div>
        </div>
    </header>

    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel video');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.display = i === index ? 'block' : 'none';
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        // Auto-play feature (optional)
        setInterval(nextSlide, 5000); // Change slide every 5 seconds

        // Initialize carousel
        showSlide(currentSlide);
    </script>
</body>
</html>
