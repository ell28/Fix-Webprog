<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $devname = mysqli_real_escape_string($conn, $_POST['developer_name']);
    $price = mysqli_real_escape_string($conn, ($_POST['price']));
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'assets/gameicons/' . $image;

    if ($image_size > 2000000) { // 2 MB
            $message[] = 'Image size is too large';
        } else {
            $insert = mysqli_query($conn, "INSERT INTO game_form (name, developer_name, price, image) VALUES('$name', '$devname', '$price', '$image')");
            if ($insert) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Registered successfully.';
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
    <title>GameNexus 2.0 - Add Game</title>
    <link rel="stylesheet" href="css/register.css">
    <link rel="icon" href="assets/logo-title.png" type="image/png">
</head>

<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Add Game</h3>
            <?php
            if (isset($message)) {
                foreach ($message as $msg) {
                    echo '<div class="message">' . $msg . '</div>';
                }
            }
            ?>
            <input type="text" name="name" placeholder="Enter game name" class="box" autocomplete="off" required>
            <input type="text" name="developer_name" placeholder="Enter developer name" class="box" autocomplete="off" required>
            <input type="text" name="price" placeholder="Enter game price" autocomplete="off" class="box" required>
            <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/gif">
            <input type="submit" name="submit" value="ADD GAME" class="btn">
            <a href="adminpagegame.php" class="delete-btn">BACK TO ADMIN GAME PAGE</a>
        </form>
    </div>
</body>

</html>