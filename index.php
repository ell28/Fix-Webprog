<?php
include 'config.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    if (isset($_SESSION['role_type'])) {
        $role_type = $_SESSION['role_type'];
    }
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
    <link rel="stylesheet" type="text/css" href="css/index.css">
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
                <a href=#>
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
                    <?php if (isset($role_type) && $role_type == 'admin') {
                        echo'<li><a href="adminpage.php">ADMIN</a></li>'; }
                    ?>
                    <li><a href="explore.php" class="active">EXPLORE</a></li>
                    <li><a href="forum.php">FORUM</a></li>
                    <li><a href="aboutus.php">ABOUT US</a></li>
                </ul>
            </nav>
        </header>

        <section>
            <h2>GAMES<span class="logo-color">NEXUS</span>2.0</h2>
            <p>YOUR FAVOURITE GAME THAT YOU HAVEN'T FOUND YET AGAIN</p>
            <a href="register.php" class="active">GET STARTED</a>
        </section>


        <footer>
            <h2>STAY CONNECTED</h2>
            <p>
                &copy; 2023 GAMESNEXUS, INC. ALL RIGHTS RESERVED.<br>
                All <b>trademarks</b> referenced herein are the properties of their respective owners.
            </p>
            <a href="aboutus.php">
                <h3>We made this website!</h3>
            </a><br>
            <a href="#top"><img src="assets/logo-transparent.png"></a>
        </footer>

        <video src="assets/homepage/homepageVideoCover.mp4" id="background-video" autoplay muted loop></video>
    </div>
    <script type="text/javascript" src="javascript/index.js"></script>
</body>

</html>