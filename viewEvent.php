<?php
require 'classes/db1.php';

// Query to get all events along with their additional details
$result = mysqli_query($conn, "SELECT e.event_id, e.event_title, e.event_price, e.img_link, ei.Date, ei.time, ei.location, ei.duration
                                FROM events e
                                JOIN event_info ei ON e.event_id = ei.event_id");
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>College Club Management System</title>
    <?php require 'utils/styles.php'; ?><!-- CSS links, file found in utils folder -->
    <style>
        .event {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
        }
        .event img {
            max-width: 300px;
            margin-right: 20px;
        }
        .event-details {
            flex: 1;
        }
    </style>
</head>
<body>

    <?php require 'utils/header.php'; ?><!-- Header content, file found in utils folder -->

    <?php require 'graph.php'; ?>

    <div class="content"><!-- Body content holder -->
        <div class="container">
            <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $event_id = $row['event_id']; 
                        $event_title = $row['event_title'];
                        $event_price = $row['event_price'];
                        $img_link = $row['img_link'];
                        $event_date = $row['Date'];
                        $event_time = $row['time'];
                        $event_location = $row['location'];
                        $event_duration = $row['duration'];
            ?>
                        <div class="event">
                            <img src="<?php echo htmlspecialchars($img_link); ?>" alt="<?php echo htmlspecialchars($event_title); ?>"/>
                            <div class="event-details">
                                <h2><?php echo htmlspecialchars($event_title); ?></h2>
                                <p>Date: <?php echo htmlspecialchars($event_date); ?></p>
                                <p>Time: <?php echo htmlspecialchars($event_time); ?></p>
                                <p>Location: <?php echo htmlspecialchars($event_location); ?></p>
                                <p>Duration: <?php echo htmlspecialchars($event_duration); ?></p>
                                <p>Price: Rs. <?php echo htmlspecialchars($event_price); ?></p>

                                <!-- Register button with event_id -->
                                <a href="register.php?event_id=<?php echo htmlspecialchars($event_id); ?>" class="btn btn-primary">
                                    Register
                                </a>
                            </div>
                        </div>
                        <div class="container">
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>
            <?php
                    }
                } else {
                    echo "<p>No events found.</p>";
                }
            ?>
            <a class="btn btn-default" href="index.php">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
            </a>
        </div><!-- Body content div -->
    </div>

    
    <?php require 'utils/footer.php'; ?><!-- Footer content, file found in utils folder -->

</body>
</html>
