<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

// * UPDATE NAMA DAN EMAIL USER
if (isset($_POST['update_profile'])) {
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

    $select = mysqli_query($conn, "SELECT id FROM `user_form` WHERE (name = '$update_name' OR email = '$update_email') AND id != '$user_id'");
    if (mysqli_num_rows($select) > 0) {
        $message[] = 'Username or email already exist on our system';
    } else {
        $current_data = mysqli_query($conn, "SELECT name, email FROM `user_form` WHERE id = '$user_id'");
        $row = mysqli_fetch_assoc($current_data);
        if ($row['name'] !== $update_name && $row['email'] !== $update_email) {
            mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name', email = '$update_email' WHERE id = '$user_id'");
            $message[] = 'Username and email updated successfully';
        } else if ($row['name'] !== $update_name) {
            mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name' WHERE id = '$user_id'");
            $message[] = 'Username updated successfully';
        } else if ($row['email'] !== $update_email) {
            mysqli_query($conn, "UPDATE `user_form` SET email = '$update_email' WHERE id = '$user_id'");
            $message[] = 'Email updated successfully';
        } else {
            $message[] = 'No changes were made to your profile';
        }
    }

    // * UPDATE PASSWORD USER    
    $old_pass = $_POST['old_pass'];
    $update_pass = mysqli_real_escape_string($conn, ($_POST['update_pass']));
    $new_pass = mysqli_real_escape_string($conn, ($_POST['new_pass']));
    $confirm_pass = mysqli_real_escape_string($conn, ($_POST['confirm_pass']));

    if (!empty($update_pass) && !empty($new_pass) && !empty($confirm_pass)) {
        if ($update_pass != $old_pass || $update_pass == null) {
            $message[] = 'Old password is wrong';
        } else if ($new_pass == null || $confirm_pass == null) {
            $message[] = 'Please enter the new password';
        } else if ($new_pass != $confirm_pass) {
            $message[] = 'Confirm password does not match';
        } else if ($new_pass == $confirm_pass) {
            mysqli_query($conn, "UPDATE `user_form` SET password = '$confirm_pass' WHERE id = '$user_id'");
            $message[] = 'Password updated successfully';
        }
    }

    // * UPDATE PROFILE PICTURE USER
    $update_image = $_FILES['update_image']['name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = 'uploaded_img/' . $update_image;

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            $image_update_query = mysqli_query($conn, "UPDATE `user_form` SET image = '$update_image' WHERE id = '$user_id'");
            if ($image_update_query) {
                move_uploaded_file($update_image_tmp_name, $update_image_folder);
            }
            $message[] = 'Image updated successfully';
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
    <title>GameNexus 2.0 - Profile update</title>
    <link rel="stylesheet" href="css/profile.css">
    <link rel="icon" href="assets/logo-title.png" type="image/png">
</head>

<body>
    <div class="update-profile">
        <?php
        $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'");
        if (mysqli_num_rows($select) > 0) {
            $fetch = mysqli_fetch_assoc($select);
        }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <?php
            if (isset($message)) {
                foreach ($message as $msg) {
                    echo '<div class="message">' . $msg . '</div>';
                }
            }
            if ($fetch['image'] == '') {
                echo '<img src="assets/account/default-avatar.png">';
            } else {
                echo '<img src="uploaded_img/' . $fetch['image'] . '">';
            }
            ?>

            <div class="flex">
                <div class="inputBox">
                    <span>Username : </span>
                    <input type="text" name="update_name" value="<?php echo $fetch['name'] ?>" class="box">
                    <span>Email : </span>
                    <input type="email" name="update_email" value="<?php echo $fetch['email'] ?>" class="box">
                    <span>Upload Profile Picture : </span>
                    <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
                </div>
                <div class="inputBox">
                    <input type="hidden" name="old_pass" value="<?php echo $fetch['password'] ?>">
                    <span>Old Password : </span>
                    <input type="password" name="update_pass" placeholder="Enter previous password" class="box">
                    <span>New Password : </span>
                    <input type="password" name="new_pass" placeholder="Enter new password" class="box">
                    <span>Confirm Password : </span>
                    <input type="password" name="confirm_pass" placeholder="Confirm new password" class="box">
                </div>
            </div>
            <input type="submit" value="UPDATE PROFILE" name="update_profile" class="btn">
            <a href="profile.php" class="delete-btn">BACK</a>
        </form>
    </div>
</body>

</html>