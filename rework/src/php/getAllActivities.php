<?php
require '../config/connectDB.php';

$resultArray = array();

$sql = "SELECT img_path, img_ID
FROM compclub_img
WHERE compclub_img.activity_ID > 0
ORDER BY RAND()  
LIMIT 1";

$result = $db->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($resultArray, $row);
    }
}

$db->close();
echo json_encode($resultArray);
