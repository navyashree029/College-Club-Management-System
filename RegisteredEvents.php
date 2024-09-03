<?php

require_once 'utils/styles.php';
require_once 'utils/header.php';

include_once 'classes/db1.php';

// Get the USN from GET data
$usn = isset($_GET['usn']) ? $_GET['usn'] : '';

// Query to fetch registered events
$result = mysqli_query($conn, "SELECT * FROM registered r
    JOIN staff_coordinator s ON r.event_id = s.event_id
    JOIN event_info ef ON r.event_id = ef.event_id
    JOIN student_coordinator st ON r.event_id = st.event_id
    JOIN events e ON r.event_id = e.event_id
    WHERE r.usn = '$usn'");

?>

<div class="content">
    <div class="container">
        <h1>Registered Events</h1>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table id="eventsTable" class="table table-hover">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Student Co-ordinator</th>
                        <th>Staff Co-ordinator</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['event_title']); ?></td>
                            <td><?php echo htmlspecialchars($row['st_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['Date']); ?></td>
                            <td><?php echo htmlspecialchars($row['time']); ?></td>
                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Not Yet Registered for any events.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'utils/footer.php'; ?>

<!-- JavaScript to scroll to the table -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tableElement = document.getElementById('eventsTable');
        if (tableElement) {
            tableElement.scrollIntoView({ behavior: 'smooth' });
        }
    });
</script>