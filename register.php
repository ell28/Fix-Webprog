<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, ($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, ($_POST['cpassword']));
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    $checkuser = mysqli_query($conn, "SELECT * FROM user_form WHERE name='$name'");
    $checkemail = mysqli_query($conn, "SELECT * FROM user_form WHERE email='$email'");

    if (mysqli_num_rows($checkuser) > 0 && mysqli_num_rows($checkemail) > 0) {
        $message[] = 'Username and email already exist on our system';
    } else if (mysqli_num_rows($checkuser) > 0) {
        $message[] = 'Username already exist on our system';
    } else if (mysqli_num_rows($checkemail) > 0) {
        $message[] = 'Email already registered on our system';
    } else {
        if ($pass != $cpass) {
            $message[] = 'Password does not match';
        } else if ($image_size > 2000000) { // 2 MB
            $message[] = 'Image size is too large';
        } else {
            $insert = mysqli_query($conn, "INSERT INTO user_form (name, email, password, image) VALUES('$name', '$email', '$pass', '$image')");
            if ($insert) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Registered successfully.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameNexus 2.0 - Register</title>
    <link rel="stylesheet" href="css/register.css">
    <link rel="icon" href="assets/logo-title.png" type="image/png">
</head>

<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>REGISTER</h3>
            <?php
            if (isset($message)) {
                foreach ($message as $msg) {
                    echo '<div class="message">' . $msg . '</div>';
                }
            }
            ?>
            <input type="text" name="name" placeholder="Enter your username" class="box" autocomplete="off" required>
            <input type="email" name="email" placeholder="Enter your email" class="box" autocomplete="off" required>
            <input type="password" name="password" placeholder="Enter your password" autocomplete="off" class="box" required>
            <input type="password" name="cpassword" placeholder="Confirm your password" autocomplete="off" class="box" required>
            <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/gif">
            <input type="submit" name="submit" value="REGISTER" class="btn">
            <a href="index.php" class="delete-btn">BACK TO HOME</a>
            <p>Already have an account? <a href="login.php">Login now!</a></p>
        </form>
    </div>
</body>

</html>