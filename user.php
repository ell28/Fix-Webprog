<?php
include 'config.php';
$keyword = $_GET["keyword"];
$query = "SELECT * FROM user_form WHERE name LIKE '%$keyword%' or email LIKE '%$keyword%'";
$hasil = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="css/adminpage.css">
</head>

<body>
    <div class="container">
        <table class="table">
            <tr class="table-head-row">
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            <tbody class="table-body">
                <?php
                $sql = "SELECT * FROM user_form WHERE name LIKE '%$keyword%' or email LIKE '%$keyword%'";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr class='table-body-row'>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['password'] . "</td>";
                    echo "<td>" . $row['image'] . "</td>";
                    echo "<td><div class='link-wrapper'><a class='btn btn-delete' href='?id=" . $row['id'] . "'>Delete</a>";
                    echo "<a class='btn btn-edit' href='edit.php?id=" . $row['id'] . "'>Edit Name</a></div></td>";
                    echo "</tr>";
                }
                ?>
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $sql = "DELETE FROM user_form WHERE id=$id";

                    if (mysqli_query($conn, $sql)) {
                        $check = true;
                    }
                }
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>