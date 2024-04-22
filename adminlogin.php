<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, ($_POST['password']));

    $select = mysqli_query($conn, "SELECT * FROM `admin_form` WHERE name ='$username' AND password = '$pass'");

    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        $_SESSION['user_id'] = $row['id'];
        header('location:adminpage.php');
    } else {
        $message[] = 'Username or Password is incorrect';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameNexus 2.0 - Admin Login</title>
    <link rel="stylesheet" href="css/adminlogin.css">
    <link rel="icon" href="assets/logo-title.png" type="image/png">
</head>

<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>ADMIN LOGIN</h3>
            <?php
            if (isset($message)) {
                if (!is_array($message)) {
                    $message = array($message);
                }
                foreach ($message as $msg) {
                    echo '<div class="message">' . $msg . '</div>';
                }
            }
            ?>
            <input type="text" name="username" placeholder="Enter your username" class="box" autocomplete="off" required>
            <input type="password" name="password" placeholder="Enter your password" class="box" autocomplete="off" required>
            <input type="submit" name="submit" value="LOGIN" class="btn">
            <a href="index.php" class="delete-btn">BACK TO HOME</a>
            <p>Go back to the user <a href="login.php">login page</a></p>
        </form>
    </div>
</body>

</html>