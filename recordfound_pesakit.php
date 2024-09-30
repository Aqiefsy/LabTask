<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Search Result - Pesakit</title>
</head>

<body>
<?php include("header.php"); ?>

<h2>Search result</h2>

<?php
// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database connection
$connect = mysqli_connect('localhost', 'root', '', 'hospital'); 

if (!$connect) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Example of searching for a record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $insuranceNumber = mysqli_real_escape_string($connect, $_POST['InsuranceNumber']);
    
    // Update the query to select the required fields
    $query = "SELECT ID_P, Insurance_Number, Diagnose, FirstName_P, LastName_P FROM pesakit WHERE Insurance_Number = '$insuranceNumber'";
    $result = mysqli_query($connect, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch and display the records
        while ($row = mysqli_fetch_assoc($result)) {
            echo "ID: " . $row['ID_P'] . "<br>"; // Displaying ID_P
            echo "Insurance Number: " . $row['Insurance_Number'] . "<br>"; // Displaying Insurance Number
            echo "Diagnose: " . $row['Diagnose'] . "<br>"; // Displaying Diagnose
            echo "First Name: " . $row['FirstName_P'] . "<br>"; // Displaying First Name
            echo "Last Name: " . $row['LastName_P'] . "<br>"; // Displaying Last Name
            echo "<hr>"; // Adding a horizontal line for separation between records
        }
    } else {
        echo "No record found. Please make sure the Insurance Number is correct.";
    }
}

// Close the database connection
mysqli_close($connect);
?>

</body>
</html>
