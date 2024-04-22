<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameNexus 2.0 - Admin Page</title>
    <link rel="stylesheet" href="css/adminpage.css">
    <link rel="icon" href="assets/logo-title.png" type="image/png">
</head>

<body>

    <h2>Admin Games Nexus 2</h2>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="search-form">
        <input type="text" name="name" placeholder="Game Name/Developer Name" id="keyword" autocomplete="off" class="name-input">
        <input type="reset" value="Reset" class="btn btn-reset">
    </form>
    <div id="container">
        <table class="table">
            <tr class="table-head-row">
                <th>Name</th>
                <th>Developer Name</th>
                <th>Price</th>
                <th>Image Path</th>
                <th>Action</th>
            </tr>
            <tbody class="table-body">
                <?php
                include 'config.php';
                $sql = "SELECT * FROM game_form";
                $result = mysqli_query($conn, $sql);
                if (isset($_POST["submit"])) {
                    $name = $_POST['name'];
                    if ($name != '') {
                        $sql = "SELECT * FROM game_form WHERE name LIKE '%$name%' or developer_name  LIKE '%$name%'";
                    }
                }
                if (isset($_POST["reset"])) {
                    header("location:adminpagegame.php");
                }
                $result = mysqli_query($conn, $sql);

                $game = "<XML>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr class='table-body-row'>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['developer_name'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>" . $row['image'] . "</td>";

                    echo "<td><div class='link-wrapper'><a class='btn btn-delete' href='?id=" . $row['id'] . "'>Delete</a>";
                    echo "<a class='btn btn-edit' href='edit.php?id=" . $row['id'] . "'>Edit Name</a></div></td>";
                    echo "</tr>";
                    $game .= "<game>";
                    $game .= "<name>" . $row['name'] . "</name>";
                    $game .= "<developer_name>" . $row['developer_name'] . "</developer_name>";
                    $game .= "<price>" . $row['price'] . "</price>";
                    $game .= "<image>" . $row['image'] . "</image>";
                    $game .= "</game>";
                }
                $game .= "</XML>";
                $x = new SimpleXMLElement($game);
                $x->asXML("game.xml");
                ?>
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $sql = "DELETE FROM game_form WHERE id=$id";

                    if (mysqli_query($conn, $sql)) {
                        $check = true;
                    }
                }
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
    <script>
        var keyword = document.getElementById('keyword');
        var container = document.getElementById('container');

        keyword.addEventListener('keyup', function () {

            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    container.innerHTML = xhr.responseText;
                }
            };
            xhr.open('GET', 'game.php?keyword=' + keyword.value, true);
            xhr.send();
        });
    </script>
    <a class='btn btn-back' href='adminpage.php'>Back to User Page</a>

</body>


</html>