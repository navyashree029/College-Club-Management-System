<?php
include_once 'classes/db1.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>College Club Management System</title>
    <?php require 'utils/styles.php'; ?><!--css links. file found in utils folder-->
    
    <!-- Include jQuery and Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
</head>
<body>
    <?php require 'utils/header.php'; ?><!--header content. file found in utils folder-->

    <div class="content"><!--body content holder-->
        <div class="container">
            <div class="col-md-6 col-md-offset-3">
                <form action="" class="form-group" method="POST">
                    <div class="form-group">
                        <label for="usn">Student USN:</label>
                        <input type="text" id="usn" name="usn" class="form-control" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-default">Login</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST["login"])) {
        $usn = $_POST['usn'];

        // Check if the USN exists in the registered table
        $query = "SELECT * FROM registered WHERE usn = '$usn'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>
                $(document).ready(function() {
                    toastr.success('Login Successful with USN: $usn');
                    setTimeout(function() {
                        window.location.href='RegisteredEvents.php?usn=' + encodeURIComponent('$usn');
                    }, 1500); // Short delay to allow the user to see the Toastr message
                });
            </script>";
        } else {
            echo "<script>
                $(document).ready(function() {
                    toastr.error('Invalid USN or no events registered for this USN.');
                    setTimeout(function() {
                        window.location.href='usn.php'; // Redirect to the same page if USN is invalid
                    }, 1500); // Short delay to allow the user to see the Toastr message
                });
            </script>";
        }
    }
    ?>

</body>
</html>