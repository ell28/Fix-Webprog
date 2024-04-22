<?php
include "config.php";

if (isset($_POST['input'])) {
    $input = $_POST['input'];
    $query = "SELECT * FROM `game_form` WHERE name LIKE '{$input}%' OR developer_name LIKE '{$input}%' OR price LIKE '{$input}%'";
} else {
    $query = "SELECT * FROM `game_form`";
}

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
?>
    <table class="table table-bordered table-striped mt-4">
        <thead>
            <tr>
                <td class="text-center">IMAGE</td>
                <td class="text-center">NAME</td>
                <td class="text-center">DEVELOPER</td>
                <td class="text-center">PRICE</td>
            </tr>
        </thead>

        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $image = $row['image'];
                $name = $row['name'];
                $dev = $row['developer_name'];
                $price = $row['price'];
            ?>
                <tr>
                    <td class="text-center" style="width: 150px;"><?php echo '<img style="height: 150px; width: 150px;" src="assets/gameicons/' . $image . '">'; ?></td>
                    <td class="align-middle text-center "><?php echo $name; ?></td>
                    <td class="align-middle text-center"><?php echo $dev; ?></td>
                    <td class="align-middle text-center">
                        <?php
                        if ($price == 0) {
                            echo "Free to play";
                        } else {
                            echo "$" . $price;
                        }
                        ?>
                    </td>

                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
<?php
} else {
    echo "<h6 class='text-danger text-center mt-3'>No Data Found</h6>";
}
?>