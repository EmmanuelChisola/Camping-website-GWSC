<?php
session_start();
include "db_conn.php";

// Set max login attempts and block time
$max_attempts = 3;
$block_time = 600; // 10 minutes in seconds

// Check if user is already logged in, redirect to home page
if (isset($_SESSION['user_id'])) {
    header("Location: home.html");
    exit();
}

$msg = "";

if (isset($_POST['submit'])) {
    $user = $_POST['user'];
    $passcode = $_POST['passcode'];

    // Check if user entered valid credentials
    if (empty($user) || empty($passcode)) {
        $msg = "Please enter valid login details";
    } else {

        // Check if user exists in the database
        $sql = "SELECT * FROM users WHERE user_name = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // Verify the password
            if (password_verify($passcode, $row['password'])) {
                // Valid credentials, start session and redirect to home page
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['firstname'] = $row['firstname'];
                unset($_SESSION['login_attempts'][$user]);
                unset($_SESSION['blocked_time'][$user]);
                header("Location: home.html");
                exit();
            } else {
                // Invalid password, increment login attempts
                if (!isset($_SESSION['login_attempts'][$user])) {
                    $_SESSION['login_attempts'][$user] += 1;
                } else {
                    $_SESSION['login_attempts'][$user] = 1;
                }

                $remaining_attempts = $max_attempts - $_SESSION['login_attempts'][$user];

                if ($remaining_attempts == 0) {
                    $_SESSION['blocked_time'][$user] = time() + $block_time;
                }

                $msg = "Please enter valid login details. ".$remaining_attempts. " attempts remain";
                header("Location: login.php?error=" . urlencode($msg));
                exit();
            }
        } else {
            // User does not exist
            $msg = "Please enter valid login details";
            header("Location: login.php?error=" . urlencode($msg));
            exit();
        }

        $stmt->close();
        $conn->close();
    }
}
?>

//code to change the button to logout when a user logs in
if (isset($_SESSION['id'])) {
    // User is logged in, so display a logout button
    echo '<form method="post" action="logout.php">';
    echo '<input type="submit" value="Logout">';
    echo '</form>';
} else {
    // User is not logged in, so display a login button
    echo '<a href="login.php">Login</a>';
}
?>