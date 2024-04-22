<html>
    <head>

    </head>
    <body>
        <?php
            include "config.php";
            $id = $_GET['id']; 
            $sql = "DELETE FROM user_form WHERE id=$id";

            if (mysqli_query($conn, $sql)){
                echo "Delete Berhasil! <br>";
                echo "<a href = 'adminpage.php'>Back</a>";
            }
        ?>
    </body>
</html>