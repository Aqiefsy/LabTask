<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php include("header.php"); ?>

<h2>Search result</h2>

<?php

// Check if ID is set in POST request
if (isset($_POST['ID'])) {
    $id = $_POST['ID'];
    
    // Secure the ID input
    $id = mysqli_real_escape_string($connect, $id);

    // Query to select records based on the ID
    $q = "SELECT ID, FirstName, LastName, Specialization, Password FROM doktor WHERE ID = '$id' ORDER BY ID";

    $result = @mysqli_query($connect, $q);

    if ($result && mysqli_num_rows($result) > 0) {
        // Display the table headers
        echo '<table border="2">
        <tr>
            <td><b>ID</b></td>
            <td><b>First Name</b></td>
            <td><b>Last Name</b></td>
            <td><b>Specialization</b></td>
            <td><b>Password</b></td>
        </tr>';

        // Fetch and display each row of results
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo '<tr>
            <td>' . $row['ID'] . '</td>
            <td>' . $row['FirstName'] . '</td>
            <td>' . $row['LastName'] . '</td>
            <td>' . $row['Specialization'] . '</td>
            <td>' . $row['Password'] . '</td>
            </tr>';
        }

        echo '</table>';

        // Free up the result set
        mysqli_free_result($result);
    } else {
        // Display an error if no results were found
        echo '<p class="error">No records found. Please ensure the ID is correct and try again.</p>';
        echo '<p>' . mysqli_error($connect) . '<br><br/>Query: ' . $q . '</p>';
    }

} else {
    // Display an error if ID is not set in the POST request
    echo '<p class="error">Please enter an ID to search.</p>';
}

// Close the database connection
mysqli_close($connect);
?>

</body>
</html>
