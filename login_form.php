<?php
include_once 'classes/db1.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>College Club Management System</title>
        <style>
            span.error {
                color: red;
            }
            .hidden {
                display: none;
            }
        </style>
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
                    <h3>Select Login Type</h3>
                    <!-- Dropdown to select login type -->
                    <select id="loginType" class="form-control">
                        <option value="">Select Login Type</option>
                        <option value="user">User Login</option>
                        <option value="admin">Admin Login</option>
                    </select>

                    <!-- User Login Form -->
                    <form id="userLoginForm" class="form-group hidden" method="POST">
                        <div class="form-group">
                            <label for="usn"> Student USN: </label>
                            <input type="text" id="usn" name="usn" class="form-control" required>
                        </div>
                        <button type="submit" name="user_login" class="btn btn-default">Login</button>
                    </form>

                    <!-- Admin Login Form -->
                    <form id="adminLoginForm" class="form-group hidden" method="POST">
                        <!--username field-->
                        <label>UserName:</label><br>
                        <input type="text" name="name" class="form-control" required><br>
                        <label>Password:</label><br>
                        <input type="password" name="password" class="form-control" required><br>
                        <button type="submit" name="update" class="btn btn-default">Login</button>
                    </form>
                </div><!--col md 6 div-->
            </div><!--container div-->
        </div><!--content div-->
        <?php require 'utils/footer.php'; ?><!--footer content. file found in utils folder-->

        <!-- jQuery Script to Toggle Login Forms Based on Selection -->
        <script>
            $(document).ready(function() {
                $('#loginType').change(function() {
                    var selectedType = $(this).val();
                    if (selectedType == 'user') {
                        $('#userLoginForm').removeClass('hidden');
                        $('#adminLoginForm').addClass('hidden');
                    } else if (selectedType == 'admin') {
                        $('#adminLoginForm').removeClass('hidden');
                        $('#userLoginForm').addClass('hidden');
                    } else {
                        $('#userLoginForm').addClass('hidden');
                        $('#adminLoginForm').addClass('hidden');
                    }
                });
            });
        </script>

        <?php
        if (isset($_POST["update"])) {
            $myusername = $_POST['name'];
            $mypassword = $_POST['password'];

            if ($mypassword == 'admin' && $myusername == 'admin') {
                echo "<script>
                    $(document).ready(function() {
                        toastr.success('Login Successful');
                        setTimeout(function() {
                            window.location.href='adminPage.php';
                        }, 500); // Short delay to allow the user to see the Toastr message
                    });
                </script>";
            } else {
                echo "<script>
                    $(document).ready(function() {
                        toastr.error('Invalid credentials');
                        setTimeout(function() {
                            window.location.href='login_form.php';
                        }, 1500); // Slightly longer delay for error messages
                    });
                </script>";
            }
        }

        if (isset($_POST["user_login"])) {
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
                            window.location.href='RegisteredEvents.php?usn=' + encodeURIComponent('$usn');
                        }, 1500); // Short delay to allow the user to see the Toastr message
                    });
                </script>";
            }
        }
        ?>
    </body>
</html>