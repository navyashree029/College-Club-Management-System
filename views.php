<html>
    <head>
        <title>Multiple Resgistrations</title>
    </head>
</html>

<?php
include_once 'classes/db1.php';

// Assuming you already have a connection to the database stored in $conn

// Define the query to select data from the view
$query = "SELECT usn, name, branch FROM ParticipantsWithMultipleRegistrations";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die("Error retrieving data: " . mysqli_error($conn));
}

// Process the result set
while ($row = mysqli_fetch_assoc($result)) {
    // Output or process each row of data
    echo "USN: " . $row['usn'] . "<br>";
    echo "Name: " . $row['name'] . "<br>";
    echo "Branch: " . $row['branch'] . "<br>";
    echo "<hr>";
}

// Free the result set
mysqli_free_result($result);

// Close the connection
mysqli_close($conn);
?>
