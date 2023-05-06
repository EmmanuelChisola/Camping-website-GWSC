<?php
include "db_conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['fname'])) {
        $errors[] = 'First name is required';
    } else {
        $fname = trim($_POST['fname']);
    }
    
    if (empty($_POST['lname'])) {
        $error[] = 'Last name is required';
    } else {
        $lname = trim($_POST['lname']);
    }
    
    if (empty($_POST['email'])) {
        $errors[] = 'Email is required';
    } else {
        $email = trim($_POST['email']);
    }
    
    if (empty($_POST['username'])) {
        $errors[] = 'Username is required';
    } else {
        $username = trim($_POST['username']);
    }
    if (empty($_POST['gender'])) {
        $errors[] = 'Gender is required';
    } else {
        $gender = trim($_POST['gender']);
    }
    if (empty($_POST['password'])) {
        $errors[] = 'Password is required';
    } else {
        $password = trim($_POST['password']);
    }
    
    if ($_POST['confirmpassword'] !== $_POST['password']) {
        $errors[] = 'Confirm Password is required';
    } else {
        $confirmpassword = trim($_POST['confirmpassword']);
    }
    $stmt = $conn->prepare("INSERT INTO users (user_name, email, firstname, lastname, Gender, password) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $username, $email, $fname, $lname, $gender, $password);

// set parameters and execute
$username = $_POST['username'];
$email = $_POST['email'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$gender = $_POST['gender'];
$password = $_POST['password'];
$stmt->execute();

// check for errors
if ($stmt->error) {
  die("Error Occured: " . $stmt->error);
}

// close statement and connection
$stmt->close();
$conn->close();   
  }
/*
if (isset($_POST['username']));
if (isset($_POST['password']));
if (isset($_POST['Fname']));
if (isset($_POST['gender']));
if (isset($_POST['Lname']));
if (isset($_POST['email']));
if (isset($_POST['confrimpassword']));

$username = $_POST['username'];
$confirmpassword =$_POST['confirmpassword'];
$email = $_POST['email'];
$confirmpassword =$_POST['confirmpassword'];
$email = $_POST['email'];
$confirmpassword =$_POST['confirmpassword'];
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" type="text/css" href="deco.css">
</head>
<body>
    <form action= "" method="POST" class="suf">
        <h2> Sign up form </h2>
            <label for="Fname">Firstname</label>
            <input type="text" name="fname" id="Fn" placeholder="Firstname" autocomplete="off" required>
            <label for="Lname">Lastname</label>
            <input type="text" name="lname" id="L" placeholder="Lastname" autocomplete="off" required>
            <label for="Gender">Gender</label>
            <select name="gender" id=" gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            </select><br>
            <label for="email">Email</label>
            <input type="text" name="email" id="email" placeholder="Email" autocomplete="off" required>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Username" autocomplete="off" required>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" autocomplete="off" required>
            <label for="confirmpassword">Confirm Password</label>
            <input type="password" name="confirmpassword" id="confrimpassword" placeholder="Confirm Password" autocomplete="off" required>
            <a href="login.php"> Already have an account?</a>
            <button>Sign up</button>
    </form>
</body>
</html>