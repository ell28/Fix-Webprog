<?php
include 'config.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GamesNexus 2.0 - Explore</title>
    <link rel="icon" href="assets/logo-title.png" type="image/png">
    <link rel="stylesheet" href="css/explore.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container" style="max-width: 50%;">
        <div class="text-center mt-5 mb-4">
            <h2>EXPLORE</h2>
        </div>
        <input type="text" class="form-control" id="live-search" autocomplete="off" placeholder="Looking for a specific game...?">
    </div>
    <div id="searchresult">
    </div>
    <div class="text-center mt-3 pt-2 pb-4">
        <a href="index.php" class="btn btn-primary">Back to Home</a>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajax({
                url: "livesearch.php",
                method: "POST",
                data: {
                    input: ''
                },
                success: function(data) {
                    $("#searchresult").html(data);
                    $("#searchresult").css("display", "block");
                }
            });

            $("#live-search").keyup(function() {
                var input = $(this).val();
                if (input != "") {
                    $.ajax({
                        url: "livesearch.php",
                        method: "POST",
                        data: {
                            input: input
                        },
                        success: function(data) {
                            $("#searchresult").html(data);
                            $("#searchresult").css("display", "block");
                        }
                    });
                } else {
                    $.ajax({
                        url: "livesearch.php",
                        method: "POST",
                        success: function(data) {
                            $("#searchresult").html(data);
                            $("#searchresult").css("display", "block");
                        }
                    });
                }
            });
        });
    </script>
</body>
<script>
</script>

</html>