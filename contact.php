<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require 'libs/PHPMailer/src/Exception.php';
require 'libs/PHPMailer/src/PHPMailer.php';
require 'libs/PHPMailer/src/SMTP.php';
require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Now you can access the variables


$mailUsername = $_ENV['MAIL_USERNAME'];
$mailPassword = $_ENV['MAIL_PASSWORD'];
$mailName = $_ENV['MAIL_NAME'];

// Include your header and styles
require 'utils/styles.php';
require 'utils/header.php';

// Form processing code
$success = false;
$error = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email']; // User's email address
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    // Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = $mailUsername; // Your SMTP username
        $mail->Password = $mailPassword; // Your SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom($email, $name); // User's email and name as the sender
        $mail->addAddress($mailUsername, $mailName); // Your email address as the recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "<strong>Name:</strong> $name<br><strong>Email:</strong> $email<br><strong>Phone:</strong> $phone<br><strong>Message:</strong><br>$message";

        // Send email
        $mail->send();
        $success = true;
    } catch (Exception $e) {
        $error = true;
        $errorMessage = $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>College Club Management System</title>

    <!-- Include jQuery (necessary for Toastr) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Include Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">

    <!-- Include Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .content {
            padding: 20px;
        }

        .contact {
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            color: #004d99;
            font-size: 36px;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #018cb5;
            outline: none;
            box-shadow: 0 0 5px rgba(1, 140, 181, 0.3);
        }

        .btn-primary {
            background: linear-gradient(45deg, #0056b3, #00aaff); /* Gradient from dark blue to bright cyan */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            display: block;
            width: 100%;
            text-align: center;
            transition: background 0.3s ease; /* Smooth transition on hover */
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #00aaff, #0056b3); /* Invert gradient on hover */
        }
    </style>

    <script>
        // Toastr configuration
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        $(document).ready(function() {
            <?php if ($success): ?>
                toastr.success('Message has been sent successfully!', 'Success');
            <?php elseif ($error): ?>
                toastr.error('Message could not be sent. Error: <?php echo $errorMessage; ?>', 'Error');
            <?php endif; ?>
        });
    </script>
</head>
<body>

<div class="content">
    <div class="contact">
        <h1><strong>Contact Us</strong></h1>
        <form method="POST" action="contact.php">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn-primary">Send Message</button>
        </form>
    </div>
</div>

<?php require 'utils/footer.php'; ?>

</body>
</html>
