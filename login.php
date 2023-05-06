
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="deco.css">
</head>
<body>
    <form action= "welcome.php" method="post">
        <h2> Login form </h2>
            <?php if(isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php  } ?>

            <label>Username</label>
            <input type="text" name="user" placeholder="Username">
            <label>Password</label>
            <input type="password" name="passcode" placeholder="Password">
            <button class="submit" name="submit">Login</button>
            <a href="signup.php">Create account</a>
    </form>
</body>
</html>
