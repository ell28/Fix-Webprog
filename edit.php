<?php
include "config.php";
?>

<html>
<head>
</head>
<body>
    <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
        <table>
            <tr>
                <td><label for="oldName">Old Name :</label></td>
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM `user_form` WHERE id=$id";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                            echo "<td>" . $row['name'] . "</td>";
                        }
                    }
                }

                ?>
            </tr>
            <tr>
                <td><label for="name">New Name :</label></td>
                <td><input type="text" name="newName"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="Submit"></td>
            </tr>
        </table>
    </form>
    <?php
    if (isset($_POST["submit"])) {
        $name = $_POST['newName'];

        $sql = "UPDATE user_form SET name = '$name' WHERE id=$id";

        if (mysqli_query($conn, $sql)) {
            echo "Nama berhasil diganti menjadi : " . $name . " <br>";
            echo "<a href = 'adminpage.php'>Back</a>";
        }
    }
    ?>
</body>

</html>