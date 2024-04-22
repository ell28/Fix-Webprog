<?php
include 'config.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GamesNexus 2.0</title>
    <link rel="icon" href="assets/logo-title.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="css/aboutus.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <script>
        $(window).blur(function() {
            $('#background-video').get(0).pause();
        });
        $(window).focus(function() {
            $('#background-video').get(0).play();
        });
    </script>
</head>

<body>
    <div class="container">
        <!-- HEADER -->
        <header>
            <div class="logo">
                <a href="index.php">
                    <img src="assets/logo-transparent.png">
                </a>
            </div>
            <!-- PROFILE PICTURE -->
            <div class="profile">
                <a href="profile.php" class="profile-picture">
                    <?php
                    if (isset($user_id)) {
                        $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'");
                        if (mysqli_num_rows($select) > 0) {
                            $fetch = mysqli_fetch_assoc($select);
                            if (array_key_exists('image', $fetch) && $fetch['image'] != '') {
                                echo '<img src="uploaded_img/' . $fetch['image'] . '">';
                            } else {
                                echo '<img src="assets/account/default-avatar.png">';
                            }
                        } else {
                            echo '<img src="assets/account/default-avatar.png">';
                        }
                    } else {
                        echo '<img src="assets/account/default-avatar.png">';
                    }
                    ?>
                </a>
            </div>

            <!-- NAV BUTTON -->
            <nav>
                <ul>
                <?php if (isset($user_id)) {
                            $role_type = mysqli_query($conn, "SELECT role_type FROM user_form WHERE id = '$user_id'");
                        if (mysqli_num_rows($role_type) > 0) {
                            $role = mysqli_fetch_assoc($role_type);
                            if ($role['role_type'] == 'admin') {
                                    echo '<li><a href="adminpage.php">ADMIN</a></li>';
                                }
                            }
                        }

                    ?>
                    <li><a href="explore.php" class="active">EXPLORE</a></li>
                    <li><a href="forum.php">FORUM</a></li>
                    <li><a href="aboutus.php">ABOUT US</a></li>
                </ul>
            </nav>
        </header>

        <div class="container2">
            <div class="text">
                <h1>Darren Setiawan</h1>
                <table class="description">
                    <tr>
                        <td>NIM</td>
                        <td> : 1122011</td>
                    </tr>
                    <tr>
                        <td>Job Description</td>
                        <td> : (FrontEnd & BackEnd)</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="container2">
            <div class="text">
                <h1>Gregory Jason Andrew Matthew</h1>
                <table class="description">
                    <tr>
                        <td>NIM</td>
                        <td> : 1122033</td>
                    </tr>
                    <tr>
                        <td>Job Description</td>
                        <td> : Homepage, Forum (FrontEnd & BackEnd)</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="container2">
            <div class="text">
                <h1>Aqbil Dzaky Nauval</h1>
                <table class="description">
                    <tr>
                        <td>NIM</td>
                        <td> : 1122036</td>
                    </tr>
                    <tr>
                        <td>Job Description</td>
                        <td> : Register, Login, LogOut, Edit Profile (FrontEnd & BackEnd)</td>
                    </tr>
                </table>

            </div>
        </div>
        <div class="container2">
            <div class="text">
                <h1>Eliezer Christian</h1>
                <table class="description">
                    <tr>
                        <td>NIM</td>
                        <td> : 1122043</td>
                    </tr>   
                    <tr>
                        <td>Job Description</td>
                        <td> : Homepage, Register, Login, LogOut, Edit Profile, Forum, Aboutus, AdminPage, Explore, Addgame (FrontEnd & BackEnd)</td>
                    </tr>
                </table>
            </div>
        </div>
</body>

</html>
</body>

</html>