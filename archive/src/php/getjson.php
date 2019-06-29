<?php
header('Content-Type: application/json');
$database_path = 'dbconfig.php';

$key = $_POST['key'];

switch ($key) {
    case "student_name":
        getStudentName();
        break;
    case "activity":
        getActivityList();
        break;
    case "ACTIVITY_DETAIL":
        getActivityDetail();
        break;
    case "EDIT_ACTIVITY":
        getActivityDetail();
        break;
    case "CHECK_YEAR_DUPLICATE":
        getActivityYearForCheckDuplicate();
        break;
    case "ACTIVITY_DOCUMENT":
        getActivityDocument();
        break;
    case "ACTIVITY_IMG_FOR_SLIDESHOW":
        getActivityImgForSlideshow();
        break;
    case "ACTIVITY_IMG_FOR_EDIT":
        getActivityImgForEdit();
}

function getStudentName()
{
    global $database_path;
    require $database_path;

    $student_id = $_POST['input'];
    $result_array = array();

    $sql = "SELECT Student_Id, Name FROM student WHERE Student_Id = '$student_id'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($result_array, $row);
        }
    }
    $db->close();

    echo json_encode($result_array);
}

function getActivityList()
{
    global $database_path;
    require $database_path;

    $year = $_POST['input'] - 543;
    $result_array = array();

    $sql = "SELECT activity_ID, activity_year, activity_name, activity_month
    FROM compclub_activity
    WHERE activity_year LIKE '%$year%'";

    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($result_array, $row);
        }
    }
    $db->close();

    foreach ($result_array as $key => $value) {
        $result_array[$key]['activity_year'] = date('n', strtotime($value['activity_year']));
    }

    echo json_encode($result_array);
}

function getActivityDetail()
{
    global $database_path;
    require $database_path;

    $activityID = $_POST['input'];
    $result_array = array();

    $sql = "SELECT activity_ID, year(activity_year) AS activity_year, activity_name, activity_detail, activity_month
    FROM compclub_activity
    WHERE activity_ID = '$activityID'";

    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($result_array, $row);
        }
    }

    $sql = "SELECT img_path,img_ID
    FROM compclub_img
    WHERE compclub_img.activity_ID = '$activityID'";

    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($result_array, $row);
        }
    }

    $db->close();

    echo json_encode($result_array);
}

function getActivityYearForCheckDuplicate()
{
    global $database_path;
    require $database_path;

    $year = $_POST['input'];
    $resultArray = array();

    $sql = "SELECT activity_year
    FROM compclub_activity
    WHERE activity_year LIKE '%$year%'
    LIMIT 1";

    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($resultArray, $row);
        }
    }

    $db->close();
    echo json_encode($resultArray);
}

function getActivityDocument()
{
    global $database_path;
    require $database_path;

    $input = $_POST['input'];
    $resultArray = array();

    $sql = "SELECT document_ID, document_name
    FROM compclub_document
    WHERE activity_ID = '$input'";

    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($resultArray, $row);
        }
    }

    $db->close();
    echo json_encode($resultArray);
}

function getActivityImgForSlideshow()
{
    global $database_path;
    require $database_path;

    $resultArray = array();

    $sql = "SELECT img_path
    FROM compclub_img, compclub_activity
    WHERE compclub_img.activity_ID > 0
    AND compclub_img.activity_ID = compclub_activity.activity_ID";

    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($resultArray, $row);
        }
    }

    $db->close();
    echo json_encode($resultArray);
}

function getActivityImgForEdit()
{
    global $database_path;
    require $database_path;

    $activityID = $_POST['input'];
    $resultArray = array();

    $sql = "SELECT img_path,img_ID
    FROM compclub_img
    WHERE compclub_img.activity_ID = '$activityID'";

    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($resultArray, $row);
        }
    }

    $db->close();

    echo json_encode($resultArray);
}
