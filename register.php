<?php
// register.php
session_start();
require 'classes/db1.php';

// Include Razorpay PHP SDK
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$razorpayKey = $_ENV['RAZORPAY_KEY'];
$razorpaySecret = $_ENV['RAZORPAY_SECRET'];

// Set your Razorpay credentials
define('RAZORPAY_KEY_ID', $razorpayKey); // Replace with your Razorpay Key ID
define('RAZORPAY_KEY_SECRET', $razorpaySecret); // Replace with your Razorpay Key Secret

// Handle AJAX requests
if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    $action = $_GET['action'];
    $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

    if ($action == 'create_order') {
        $event_id = intval($_POST['event_id']);
        $amount = 0;

        // Fetch event price from the database
        $stmt = $conn->prepare("SELECT event_price FROM events WHERE event_id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $stmt->bind_result($event_price);
        if ($stmt->fetch()) {
            $amount = $event_price;
        }
        $stmt->close();

        if ($amount > 0) {
            try {
                $orderData = [
                    'receipt'         => 'receipt_' . time(),
                    'amount'          => $amount * 100, // Amount in paise
                    'currency'        => 'INR',
                    'payment_capture' => 1 // Auto capture
                ];
                $razorpayOrder = $api->order->create($orderData);
                $_SESSION['razorpay_order_id'] = $razorpayOrder['id'];
                echo json_encode(['success' => true, 'order_id' => $razorpayOrder['id'], 'amount' => $amount]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No payment required for this event.']);
        }
        exit;
    }

    if ($action == 'verify_payment') {
        $attributes = [
            'razorpay_order_id' => $_POST['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>College Club Management System - Register</title>
    <?php require 'utils/styles.php'; ?>
    <style>
        #registrationForm {
            margin: 50px 0px;
        }
        .regFull {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }
        .regFull > img {
            height: 600px;
            width: 500px;
            margin: 0px 100px 0px 0px;
        }
    </style>

    <!-- Include jQuery and Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

    <!-- Include Razorpay Checkout -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            window.toggleOtherBranchInput = function() {
                var branchSelect = $('#branchSelect').val();
                $('#otherBranchInput').toggle(branchSelect === 'Other');
            }

            window.initiatePayment = function(event_id) {
                $('#makePaymentBtn').prop('disabled', true);

                $.ajax({
                    url: 'register.php?action=create_order',
                    type: 'POST',
                    data: { event_id: event_id },
                    success: function(response) {
                        if (response.success) {
                            var options = {
                                "key": "<?php echo RAZORPAY_KEY_ID; ?>",
                                "amount": response.amount * 100,
                                "currency": "INR",
                                "name": "College Club Management",
                                "description": "Event Registration Payment",
                                "order_id": response.order_id,
                                "handler": function (response) {
                                    verifyPayment(response, event_id);
                                },
                                "prefill": {
                                    "name": "<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>",
                                    "email": "<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>",
                                    "contact": "<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>"
                                },
                                "theme": {
                                    "color": "#3399cc"
                                }
                            };

                            var rzp1 = new Razorpay(options);
                            rzp1.on('payment.failed', function (response){
                                toastr.error('Payment failed: ' + response.error.description, 'Error');
                                $('#makePaymentBtn').prop('disabled', false);
                            });

                            rzp1.open();
                        } else {
                            toastr.error(response.message, 'Error');
                            $('#makePaymentBtn').prop('disabled', false);
                        }
                    },
                    error: function() {
                        toastr.error('Failed to create order. Please try again.', 'Error');
                        $('#makePaymentBtn').prop('disabled', false);
                    }
                });
            }

            function verifyPayment(paymentResponse, event_id) {
                $.ajax({
                    url: 'register.php?action=verify_payment',
                    type: 'POST',
                    data: {
                        razorpay_payment_id: paymentResponse.razorpay_payment_id,
                        razorpay_order_id: paymentResponse.razorpay_order_id,
                        razorpay_signature: paymentResponse.razorpay_signature
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Payment Successful!', 'Success');
                            $('#submitBtn').prop('disabled', false);
                            $('#razorpay_payment_id').val(paymentResponse.razorpay_payment_id);
                            $('#razorpay_order_id').val(paymentResponse.razorpay_order_id);
                            $('#razorpay_signature').val(paymentResponse.razorpay_signature);
                        } else {
                            toastr.error('Payment Verification Failed: ' + response.message, 'Error');
                            $('#makePaymentBtn').prop('disabled', false);
                        }
                    },
                    error: function() {
                        toastr.error('Payment Verification Request Failed.', 'Error');
                        $('#makePaymentBtn').prop('disabled', false);
                    }
                });
            }
        });
    </script>
</head>
<body>
    <?php require 'utils/header.php'; ?>

    <div class="content">
        <div class="container">
            <div class="regFull col-md-12">
                <?php
                if (!isset($_GET['event_id'])) {
                    echo "<p>Invalid event.</p>";
                    exit;
                }

                $event_id = intval($_GET['event_id']);
                // Fetch event details
                $stmt = $conn->prepare("SELECT event_price FROM events WHERE event_id = ?");
                $stmt->bind_param("i", $event_id);
                $stmt->execute();
                $stmt->bind_result($event_price);
                if (!$stmt->fetch()) {
                    echo "<p>Event not found.</p>";
                    exit;
                }
                $stmt->close();

                $title = "";
                // Fetch event price from the database
                $stmt = $conn->prepare("SELECT event_title FROM events WHERE event_id = ?");
                $stmt->bind_param("i", $event_id);
                $stmt->execute();
                $stmt->bind_result($event_title);
                if ($stmt->fetch()) {
                    $title = $event_title;
                }
                $stmt->close();

                $img = "";
                // Fetch event price from the database
                $stmt = $conn->prepare("SELECT img_link FROM events WHERE event_id = ?");
                $stmt->bind_param("i", $event_id);
                $stmt->execute();
                $stmt->bind_result($img_link);
                if ($stmt->fetch()) {
                    $img = $img_link;
                }
                $stmt->close();
                ?>

                <img src="<?php echo htmlspecialchars($img_link); ?>" alt="<?php echo htmlspecialchars($event_title); ?>"/>
                <form method="POST" id="registrationForm">
                    <label>Student USN:</label><br>
                    <input type="text" name="usn" class="form-control" required pattern="\d[A-Z]{2}\d{2}[A-Z]{2}\d{3}" title="Format: 1XX21XX111"><br><br>

                    <label>Student Name:</label><br>
                    <input type="text" name="name" class="form-control" required><br><br>

                    <label>Branch:</label><br>
                    <select name="branch" id="branchSelect" class="form-control" onchange="toggleOtherBranchInput()" required>
                        <option value="" disabled selected>Select your branch</option>
                        <option value="CSE">CSE (Computer Science Engineering)</option>
                        <option value="CSE (AI & ML)">CSE (AI & ML)</option>
                        <option value="CSE (DS)">CSE (Data Science)</option>
                        <option value="ISE">ISE (Information Science Engineering)</option>
                        <option value="AIDS">AIDS (Artificial Intelligence & Data Science)</option>
                        <option value="AIML">AIML (Artificial Intelligence and Machine Learning)</option>
                        <option value="ECE">ECE (Electronics and Communication Engineering)</option>
                        <option value="EEE">EEE (Electrical and Electronics Engineering)</option>
                        <option value="CV">CV (Civil Engineering)</option>
                        <option value="ME">ME (Mechanical Engineering)</option>
                        <option value="Other">Other</option>
                    </select><br><br>

                    <div id="otherBranchInput" style="display:none;">
                        <label>If other, please specify:</label><br>
                        <input type="text" name="other_branch" class="form-control"><br><br>
                    </div>

                    <label>Semester:</label><br>
                    <select name="sem" class="form-control" required>
                        <option value="" disabled selected>Select your semester</option>
                        <option value="1">I</option>
                        <option value="2">II</option>
                        <option value="3">III</option>
                        <option value="4">IV</option>
                        <option value="5">V</option>
                        <option value="6">VI</option>
                        <option value="7">VII</option>
                        <option value="8">VIII</option>
                    </select><br><br>

                    <label>Email:</label><br>
                    <input type="email" name="email" class="form-control" required><br><br>

                    <label>Phone:</label><br>
                    <input type="text" name="phone" class="form-control" required pattern="\d{10}" title="Phone number must be exactly 10 digits"><br><br>

                    <label>College:</label><br>
                    <input type="text" name="college" class="form-control" required><br><br>

                    <label>Event ID:</label><br>
                    <input type="text" name="event_id" class="form-control" value="<?php echo htmlspecialchars($event_id); ?>" readonly><br><br>

                    <?php if ($event_price > 0): ?>
                        <button type="button" onclick="initiatePayment(<?php echo $event_id; ?>)" id="makePaymentBtn" class="btn btn-primary">Make Payment</button><br><br>
                        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                        <button type="submit" name="update" id="submitBtn" class="btn btn-success" disabled>Submit</button>
                    <?php else: ?>
                        <button type="submit" name="update" class="btn btn-success">Submit</button>
                    <?php endif; ?>
                </form>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
                    if ($event_price > 0) {
                        $razorpay_payment_id = $_POST['razorpay_payment_id'];
                        $razorpay_order_id = $_POST['razorpay_order_id'];
                        $razorpay_signature = $_POST['razorpay_signature'];

                        if (empty($razorpay_payment_id) || empty($razorpay_order_id) || empty($razorpay_signature)) {
                            echo "<script>toastr.error('Payment details missing. Please complete the payment.', 'Error');</script>";
                            exit;
                        }
                    }

                    $usn = $conn->real_escape_string($_POST['usn']);
                    $name = $conn->real_escape_string($_POST['name']);
                    $branch = $_POST['branch'] === 'Other' ? $conn->real_escape_string($_POST['other_branch']) : $conn->real_escape_string($_POST['branch']);
                    $sem = intval($_POST['sem']);
                    $email = $conn->real_escape_string($_POST['email']);
                    $phone = $conn->real_escape_string($_POST['phone']);
                    $college = $conn->real_escape_string($_POST['college']);
                    $event_id_post = intval($_POST['event_id']);

                    $stmt = $conn->prepare("INSERT INTO participent (usn, name, branch, sem, email, phone, college, event_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssisssi", $usn, $name, $branch, $sem, $email, $phone, $college, $event_id_post);

                    if ($stmt->execute()) {
                        echo "<script>
                                toastr.success('Registration Successful!', 'Success', {
                                    onHidden: function() {
                                        window.location.href = 'usn.php';
                                    }
                                });
                            </script>";
                    } else {
                        echo "<script>toastr.error('Error in Registration. Please try again.', 'Error');</script>";
                    }

                    $stmt->close();
                }
                ?>
            </div>
        </div>
    </div>

    <?php require 'utils/footer.php'; ?>
</body>
</html>
