<?php
include 'config.php';
$data = array();
$sql = "SELECT *  FROM `discussion` ORDER BY id desc";
$result = $conn->query($sql);
while($row = mysqli_fetch_array($result)){
        array_push($data, $row);
        array_push($data);
}
echo json_encode($data);
$conn = null;
exit();



