<?php
$database_path = 'dbconfig.php';

$key = $_POST['key'];
$input = $_POST['input'];

switch ($key) {
    case "DELETE_ACTIVITY_IMG":
        deleteActivityImg($input);
        break;
        case "DELETE_ACTIVITY_DOCUMENT":
        deleteActivityDocument($input);
        break;
}

function deleteActivityImg($input)
{
    global $database_path;
    require $database_path;

    $sql = "DELETE FROM compclub_img WHERE img_ID = '$input'";

    if ($db->query($sql)) {
        echo 1;
    } else {
        echo 0;
    }

    $db->close();
}

function deleteActivityDocument($input)
{
    global $database_path;
    require $database_path;

    $sql = "DELETE FROM compclub_document WHERE document_ID = '$input'";

    if ($db->query($sql)) {
        echo 1;
    } else {
        echo 0;
    }

    $db->close();
}

