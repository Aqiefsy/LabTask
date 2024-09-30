<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Edit Record</title>
</head>
<body>

<?php include("header.php"); ?>

<?php
// Include header
include("header.php");

echo '<h2>Edit a Record</h2>';

// Establish database connection
$connect = mysqli_connect("localhost", "root", "", "hospital");

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}


// Look for a valid user id
if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
    $id = $_GET['id'];
} elseif ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
    $id = $_POST['id'];
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();

    // Validate First Name
    if (empty($_POST['FirstName_P'])) {
        $errors[] = 'You forgot to enter the First Name.';
    } else {
        $n = mysqli_real_escape_string($connect, trim($_POST['FirstName_P']));
    }

    // Validate Last Name
    if (empty($_POST['LastName_P'])) {
        $errors[] = 'You forgot to enter the Last Name.';
    } else {
        $l = mysqli_real_escape_string($connect, trim($_POST['LastName_P']));
    }

    // Validate Insurance Number
    if (empty($_POST['InsuranceNumber'])) {
        $errors[] = 'You forgot to enter the Insurance Number.';
    } else {
        $in = mysqli_real_escape_string($connect, trim($_POST['InsuranceNumber']));
    }

    // Validate Diagnose
    if (empty($_POST['Diagnose'])) {
        $errors[] = 'You forgot to enter the Diagnose.';
    } else {
        $d = mysqli_real_escape_string($connect, trim($_POST['Diagnose']));
    }

    // If no errors, proceed to update the record
    if (empty($errors)) {
        // Check for duplicate Insurance Number
        $q = "SELECT ID_P FROM pesakit WHERE insurance_number = '$in' AND ID_P != $id";
        $result = mysqli_query($connect, $q);

        if ($result === false) {
            echo 'Error executing query: ' . mysqli_error($connect);
            exit;
        }

        if (mysqli_num_rows($result) == 0) {
            $q = "UPDATE pesakit SET FirstName_P='$n', LastName_P='$l', insurance_number='$in', Diagnose='$d' WHERE ID_P='$id' LIMIT 1";
            $result = mysqli_query($connect, $q);

            if ($result === false) {
                echo 'Error executing query: ' . mysqli_error($connect);
            } elseif (mysqli_affected_rows($connect) == 1) {
                echo '<h3>The user has been edited.</h3>';
            } else {
                echo '<p class="error">The user could not be edited due to a system error. We apologize for the inconvenience.</p>';
            }
        } else {
            echo '<p class="error">The Insurance Number has already been registered.</p>';
        }
    } else {
        echo '<p class="error">The following errors occurred:<br />';
        foreach ($errors as $msg) {
            echo " - $msg<br />\n";
        }
        echo '</p><p>Please try again.</p>';
    }
}

// Fetch the user’s data
$q = "SELECT FirstName_P, LastName_P, insurance_number, Diagnose FROM pesakit WHERE ID_P=$id";
$result = mysqli_query($connect, $q);

if ($result === false) {
    echo 'Error executing query: ' . mysqli_error($connect);
    exit;
}

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    echo '<form action="edit_pesakit.php" method="post">
    <p><label class="label" for="FirstName_P">First Name: </label>
    <input id="FirstName_P" type="text" name="FirstName_P" size="30" maxlength="30" value="' . $row[0] . '" /></p>

    <p><label class="label" for="LastName_P">Last Name: </label>
    <input id="LastName_P" type="text" name="LastName_P" size="30" maxlength="30" value="' . $row[1] . '" /></p>

    <p><label class="label" for="InsuranceNumber">Insurance Number: </label>
    <input id="InsuranceNumber" type="text" name="InsuranceNumber" size="30" maxlength="30" value="' . $row[2] . '" /></p>

    <p><label class="label" for="Diagnose">Diagnose: </label>
    <input id="Diagnose" type="text" name="Diagnose" size="30" maxlength="30" value="' . $row[3] . '" /></p>

    <p><input id="submit" type="submit" name="submit" value="Edit" /></p>
    <input type="hidden" name="id" value="' . $id . '" />
    </form>';
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
}

mysqli_close($connect);
?>


</body>
</html>
