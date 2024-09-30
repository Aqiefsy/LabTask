<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Database Connection</title>
</head>
<body>
    <?php
    // extract($_POST);

    // Connect to the server
    $connect = mysqli_connect("localhost", "root", "", "hospital");

    // Check connection
    if (!$connect) {
        die('ERROR: Could not connect to the database. ' . mysqli_connect_error());
    } else {
        echo "Successfully connected to the database!";
    }

    ?>
</body>
</html>
