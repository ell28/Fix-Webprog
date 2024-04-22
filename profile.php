<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location: login.php');
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameNexus 2.0 - Account settings</title>
    <link rel="stylesheet" href="css/profile.css">
    <link rel="icon" href="assets/logo-title.png" type="image/png">
</head>

<body>
    <div class="container">
        <div class="profile">
            <?php
            $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'");
            if (mysqli_num_rows($select) > 0) {
                $fetch = mysqli_fetch_assoc($select);
            }
            if ($fetch['image'] == '') {
                echo '<img src="assets/account/default-avatar.png">';
            } else {
                echo '<img src="uploaded_img/' . $fetch['image'] . '">';
            }
            ?>
            <h3>Welcome, <?php echo $fetch['name'] ?></h3>
            <a href="update_profile.php" class="btn">EDIT PROFILE</a>
            <a href="logout.php" class="delete-btn">LOGOUT</a>
            <p>Back to <a href="index.php">home</a></p>
        </div>
    </div>
</body>

</html>