<?php
$database_path = 'src/php/dbconfig.php';
$navbar_path = 'src/html/navbar.html';
$head_path = 'src/html/head.html';
$menu_path = 'src/html/menu.html';
$footer_path = 'src/html/footer.html';
$img_path = 'img/';
$document_path = 'doc/';

class member
{
    public function getMember($member_position)
    {
        global $database_path, $img_path, $year;
        require $database_path;

        $sql = "SELECT compclub_member.Student_Id, compclub_img.img_path, compclub_member.member_position, student.Name
        FROM compclub_member,student,compclub_img
        WHERE compclub_member.Student_Id = student.Student_Id
        AND compclub_member.member_position = '$member_position'
        AND compclub_member.year = '$year'
        AND compclub_member.img_ID = compclub_img.img_ID
        ORDER BY compclub_member.Student_Id ASC";

        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $student_id = $row['Student_Id'];
                $member_name = str_replace(' ', "<br>", $row["Name"]);
                $member_position = $row['member_position'];
                $path = $img_path . $row['img_path'];

                $html = "<div class='content-member'>";
                $html .= "<img src='$path' >";
                $html .= "<div class='name'>$member_name</div>";
                $html .= "<div class='id'>$student_id</div>";
                $html .= "<div class='position'>$member_position</div>";
                $html .= "</div>";

                echo $html;
            }
        }
        $db->close();
    }
}

class advisor
{
    public function getAdvisor()
    {
        global $database_path, $img_path, $year;
        require $database_path;

        $sql = "SELECT cv_personal.Name, cv_personal.picturePersonal, compclub_advisor.advisor_ID, compclub_advisor.year
        FROM compclub_advisor,cv_personal
        WHERE cv_personal.Personal_Id = compclub_advisor.Personal_Id
        AND compclub_advisor.year = '$year'";

        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $advisor_img = "http://csmju.jowave.com/applications/CSMJU1/images_personal/" . $row['picturePersonal'];
                $advisor_name = str_replace(' ', "<br>", $row["Name"]);
                $year = $row["year"];
                $advisor_id = $row["advisor_ID"];

                $html = "<div class='content-member'>";
                $html .= "<img src='$advisor_img' >";
                $html .= "<div class='name'>$advisor_name</div>";
                $html .= "<div class='position'> อาจารย์ที่ปรึกษา </div>";
                $html .= "</div>";

                echo $html;
            }
        }

        $db->close();
    }
}

class document
{
    static $doc_path = 'doc/';
    static $document_year;

    public static function getDocumentList()
    {
        global $database_path;
        require $database_path;

        $sql = "SELECT document_ID , document_name, date FROM document ORDER BY date DESC";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $document_id = $row["document_ID"];
                $document_name = $row["document_name"];
                $document_timestamp = strtotime($row['date']);
                $document_year = date('Y', $document_timestamp);

                //condition logic : prevent year duplicate
                if (strtotime(self::$document_year) != strtotime($document_year)) {
                    self::$document_year = date('Y', $document_timestamp);
                    echo "<div class='document-list'>$document_year</div>";
                }

                echo "<a class='document-list' href='" . self::$doc_path . $document_name . "'>$document_name</a>";
            }
        }
        $db->close();
    }
}

class admin
{
    public function GetContent($param)
    {
        if (isset($_REQUEST[$param])) {
            $admin_menu = $_REQUEST[$param];
            switch ($admin_menu) {
                case 'member':require 'admin_member.php';
                    break;
                case 'advisor':require 'admin_advisor.php';
                    break;
                case 'activity':require 'admin_activity.php';
                    break;
            }
        }
    }
}

function getFileExtension($fileName, $fileExtension)
{
    return $fileName . "." . $fileExtension;
}

function getPathOfFile($fileName, $filePath)
{
    return $filePath . $fileName;
}

class adminMember
{
    private $student_id;
    private $student_position;
    private $img_name;
    private $img_tmp;
    private $year;

    private $inserted_id;

    public function __construct($student_id, $student_position, $img_name, $img_tmp, $year)
    {
        $this->student_id = $student_id;
        $this->student_position = $student_position;
        $this->img_name = $img_name;
        $this->img_tmp = $img_tmp;
        $this->year = $year;
    }

    public function insertImg()
    {
        global $database_path, $img_path;
        require $database_path;

        $img_name = getRandomString(10);
        $imgNameWithExt = getFileExtension($img_name, "jpg");
        $imgNameWithPath = getPathOfFile($imgNameWithExt, $img_path);

        while (file_exists($imgPathFull)) {
            $img_name = getRandomString(10);
            $imgNameWithExt = getFileExtension($img_name, "jpg");
            $imgNameWithPath = getPathOfFile($imgNameWithExt, $img_path);
        }

        if (move_uploaded_file($this->img_tmp, $imgNameWithPath)) {
            $sql = "INSERT INTO compclub_img (img_path) VALUES ('$imgNameWithExt')";
            if ($db->query($sql) === true) {
                $this->inserted_id = $db->insert_id;
            }
                
        }

        return $this;
    }

    public function insertSQL()
    {
        global $database_path;
        require $database_path;

        $student_id = $this->student_id;
        $student_position = $this->student_position;
        $img_inserted_id = $this->inserted_id;
        $year = $this->year;

        $sql = "INSERT INTO compclub_member (Student_Id, member_position, img_ID, year)
        VALUES ('$student_id','$student_position','$img_inserted_id','$year')";

        $db->query($sql);
        $db->close();
    }

    public function getMember()
    {
        global $database_path, $img_path;
        require $database_path;

        $sql = "SELECT compclub_member.Student_Id, student.Name, compclub_member.member_ID, compclub_member.member_position, compclub_member.year, compclub_img.img_path
        FROM compclub_member,compclub_img,student
        WHERE compclub_member.img_ID = compclub_img.img_ID
        AND compclub_member.Student_Id = student.Student_Id
        ORDER BY compclub_member.year DESC , compclub_member.Student_Id ASC";

        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $member_id = $row["member_ID"];
                $student_id = $row["Student_Id"];
                $student_name = $row["Name"];
                $member_position = $row['member_position'];
                $student_img = $img_path . $row["img_path"];
                $year = $row["year"];

                $html = '<tr>';
                $html .= '<td class="member-profile"><img src="' . $student_img . '"></td>';
                $html .= '<td>' . $student_id . '</td>';
                $html .= '<td>' . $student_name . '</td>';
                $html .= '<td>' . $member_position . '</td>';
                $html .= '<td>' . $year . '</td>';
                $html .= '<td> <a href="admin.php?admin_menu=member&deleteid=' . $member_id . '" onclick="return confirm("ยืนยันการลบ")"><img class="manage-icon" src="img/bin.png"></a> </td>';
                $html .= '</tr>';

                echo $html;
            }
        }
        $db->close();
    }

    public function getStudentId()
    {
        global $database_path;
        require $database_path;

        $sql = "SELECT Student_Id, Name
        FROM student
        WHERE LENGTH(Student_Id) = 10
        AND StudentStatus_Id = 1
        AND CAST(SUBSTRING(Student_Id, 1, 2) AS int) > 58";

        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $student_id = $row["Student_Id"];
                $student_name = $row["Name"];

                $html = "<option value='$student_id'></option>";
                echo $html;
            }
        }
    }

    public function deleteMember($delete_id)
    {
        global $database_path, $img_path;
        require $database_path;

        $sql = "SELECT img_path FROM compclub_img WHERE img_ID = $delete_id";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $img = $img_path . $row["img_path"];
                unlink($img);
            }
        }

        $sql = "DELETE FROM compclub_img WHERE img_ID = $delete_id";
        $db->query($sql);
        $sql = "DELETE FROM compclub_member WHERE member_ID = $delete_id";
        $db->query($sql);
        $db->close();
    }
}

//----------------------------------------------------------------------------------------------//

class adminAdvisor
{
    private $personal_id;
    private $advisor_year;

    public function __construct($personal_id, $advisor_year)
    {
        $this->personal_id = $personal_id;
        $this->advisor_year = $advisor_year;
    }

    public function getAdvisor()
    {
        global $database_path;
        require $database_path;

        $sql = "SELECT cv_personal.Name, cv_personal.picturePersonal, compclub_advisor.advisor_ID, compclub_advisor.year
        FROM compclub_advisor,cv_personal
        WHERE cv_personal.Personal_Id = compclub_advisor.Personal_Id";

        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $advisor_img = "http://csmju.jowave.com/applications/CSMJU1/images_personal/" . $row['picturePersonal'];
                $advisor_name = $row['Name'];
                $year = $row["year"];
                $advisor_id = $row["advisor_ID"];

                $html = "<tr>";
                $html .= "<td class='member-profile'><img src='$advisor_img'></td>";
                $html .= "<td> $advisor_name </td>";
                $html .= "<td> $year </td>";
                $html .= "<td> <a href='admin.php?admin_menu=advisor&deleteid=$advisor_id'><img class='manage-icon' src='img/bin.png'></a> </td>";
                $html .= "</tr>";

                echo $html;
            }
        }
        $db->close();
    }

    public function getAdvisorList()
    {
        global $database_path;
        require $database_path;

        $sql = "SELECT Personal_Id, Name
        FROM cv_personal
        WHERE PersonalStatus_Id = 1
        AND PersonalType_Id = 1";

        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $personal_id = $row["Personal_Id"];
                $personal_name = $row["Name"];

                $html = "<option value='$personal_id'>$personal_name</option>";
                echo $html;
            }
        }
    }

    public function insertInput()
    {
        global $database_path;
        require $database_path;

        $personal_id = $this->personal_id;
        $year = $this->advisor_year;

        $sql = "INSERT INTO compclub_advisor (Personal_Id, year) VALUES ('$personal_id','$year')";
        $result = $db->query($sql);
        $db->close();
    }

    public function deleteAdvisor($delete_id)
    {
        global $database_path;
        require $database_path;

        $sql = "DELETE FROM compclub_advisor
        WHERE advisor_ID = $delete_id";

        $db->query($sql);
        $db->close();
    }
}

//----------------------------------------------------------------------------------------------//

class adminActivity
{
    private $activity_year;
    private $activity_name;
    private $activity_month;
    private $activity_count;

    private $admin_menu = 'activity';

    public function __construct($activity_year, $activity_name, $activity_month, $activity_count)
    {
        $this->activity_year = $activity_year;
        $this->activity_name = $activity_name;
        $this->activity_month = $activity_month;
        $this->activity_count = $activity_count;
    }

    public function selectActivityAutoListSQL()
    {
        global $database_path;
        require $database_path;

        $sql = "SELECT activity_list_name
        FROM compclub_activity_list
        ORDER BY activity_list_ID DESC";

        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $activity_name = $row['activity_list_name'];

                $html = "<option value='$activity_name'></option>";
                echo $html;
            }
        }
        $db->close();
    }

    public function insertInput($input)
    {
        global $database_path;
        require $database_path;

        $activity_year = $this->activity_year;
        $activity_name = $this->activity_name;
        $activity_month = $this->activity_month;
        $activity_count = $this->activity_count;

        for ($i = 0; $i < count($activity_name); $i++) {
            $sql = "INSERT INTO compclub_activity (activity_name, activity_month, activity_year)
            VALUES ('$activity_name[$i]','$activity_month[$i]','$activity_year')";
            $db->query($sql);
        }
        $db->close();
    }

    public function getActivityList()
    {
        global $database_path;
        require $database_path;
        $i = 1;

        $sql = "SELECT activity_ID , activity_name , activity_month , activity_year
        FROM compclub_activity
        ORDER BY activity_year DESC, activity_ID ASC";

        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $activity_id = $row["activity_ID"];
                $activity_name = $row['activity_name'];
                $activity_month = $row['activity_month'];
                $timestamp = strtotime($row['activity_year']);
                $activity_year = date('Y', $timestamp) + 543;

                switch ($activity_month) {
                    case 1:
                        $activity_month = "มกราคม";
                        break;
                    case 2:
                        $activity_month = "กุมภาพันธ์";
                        break;
                    case 3:
                        $activity_month = "มีนาคม";
                        break;
                    case 4:
                        $activity_month = "เมษายน";
                        break;
                    case 5:
                        $activity_month = "พฤษภาคม";
                        break;
                    case 6:
                        $activity_month = "มิถุนายน";
                        break;
                    case 7:
                        $activity_month = "กรกฎาคม";
                        break;
                    case 8:
                        $activity_month = "สิงหาคม";
                        break;
                    case 9:
                        $activity_month = "กันยายน";
                        break;
                    case 10:
                        $activity_month = "ตุลาคม";
                        break;
                    case 11:
                        $activity_month = "พฤศจิกายน";
                        break;
                    case 12:
                        $activity_month = "ธันวาคม";
                }

                $html = "<tr>";
                $html .= "<td>" . ($i++) . "</td>";
                $html .= "<td>$activity_name</td>";
                $html .= "<td>$activity_month</td>";
                $html .= "<td>$activity_year</td>";
                $html .= "<td>";
                $html .= "<img class='manage-icon' data-edit='$activity_id' src='img/edit.png'>";
                $html .= "</td>";
                $html .= "<td>";
                $html .= "<a href='admin.php?admin_menu=$this->admin_menu&deleteid=$activity_id'><img class='manage-icon' src='img/bin.png'></a>";
                $html .= "</td>";
                $html .= "</tr>";
                echo $html;
            }
        }

        $db->close();
    }

    public function updateSQL($array)
    {
        global $database_path, $img_path, $document_path;
        require $database_path;

        $activity_id = $array[0];
        $activity_name = $array[1];
        $activity_detail = $array[2];
        $activity_img = $array[3];
        $activity_doc = $array[4];

        $sql = "UPDATE compclub_activity
        SET activity_name = '$activity_name', activity_detail = '$activity_detail'
        WHERE activity_ID = '$activity_id'";
        $db->query($sql);

        // img upload
        foreach ($activity_img['tmp_name'] as $key) {
            $img_tmp = $key;
            $img_name = getRandomString(10);
            $imgNameWithExt = $img_name . ".jpg";
            $imgPathFull = $img_path . $imgNameWithExt;

            while (file_exists($imgPathFull)) {
                $img_name = getRandomString(10);
                $imgNameWithExt = $img_name . ".jpg";
                $imgPathFull = $img_path . $imgNameWithExt;
            }

            if (move_uploaded_file($img_tmp, $imgPathFull)) {
                $sql = "INSERT INTO compclub_img (img_path, activity_ID)
                VALUES ('$imgNameWithExt','$activity_id')";
                $db->query($sql);
            }
        }

        // doc upload
        foreach ($activity_doc['tmp_name'] as $key => $value) {
            $fileNameWithExt = $activity_doc['name'][$key];
            $fileOriginalName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileTmp = $activity_doc['tmp_name'][$key];
            $filePathFull = $document_path . $fileNameWithExt;

            $i = 0;
            while (file_exists($filePathFull)) {
                $FileExtension = pathinfo($fileNameWithExt, PATHINFO_EXTENSION);
                $FileNameNoExt = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $fileNameWithExt = $fileOriginalName."_$i.".$FileExtension;
                $filePathFull = $document_path . $fileNameWithExt;
                $i++;
            }

            if (move_uploaded_file($fileTmp, $filePathFull)) {
                $sql = "INSERT INTO compclub_document (document_name, activity_ID)
                VALUES ('$fileNameWithExt','$activity_id')";
                $db->query($sql);
            }
        }
        
        $db->close();
    }
}

class adminDocument
{

    public static function getList()
    {
        global $database_path;
        require $database_path;

        $sql = "SELECT document_ID , document_name , date FROM document ORDER BY date DESC";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $document_id = $row["document_ID"];
                $document_name = $row["document_name"];
                $timestamp = strtotime($row['date']);
                $document_date = date('d/m/Y', $timestamp);

                echo '<tr>
                        <td>' . $document_name . '</td>
                        <td>' . $document_date . '</td>
                        <td> <a href="admin.php?admin_menu=document&deletetarget=' . $document_id . '">DELETE</a> </td>
                    </tr>';
            }
        }

        $db->close();
    }

    public static function setInput($input)
    {
        global $database_path, $document_path;
        if (isset($_POST[$input])) {
            require $database_path;

            $doc_date = date('Y-m-d');

            $doc_name = $_FILES["doc"]["name"];
            $doc_tmp = $_FILES['doc']['tmp_name'];
            $doc_path = $document_path . $doc_name;

            if (file_exists($doc_path)) {
                return "upload file ไม่สำเร็จ - ชื่อ file ซ้ำกัน";
            }

            move_uploaded_file($doc_tmp, $doc_path);

            $sql = "INSERT INTO document (document_name, date) VALUES ('$doc_name','$doc_date')";
            $db->query($sql);
            $db->close();

            header('Location: admin.php?admin_menu=document');
        }
    }

    public static function deleteList()
    {
        global $database_path, $document_path;
        if (isset($_GET['deletetarget'])) {
            require $database_path;

            $delete_id = $_GET['deletetarget'];

            $sql = "SELECT document_name FROM document WHERE document_ID = $delete_id";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $doc_path = $document_path . $row["document_name"];
                    unlink($doc_path);
                }
            }

            $sql = "DELETE FROM document WHERE document_ID = $delete_id";
            $db->query($sql);
            $db->close();

            header('Location: admin.php?admin_menu=document');
        }
    }
}

function getRandomString($n)
{
    $string = "";
    $domain = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    $length = strlen($domain);
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, $length - 1);
        $string = $string . $domain[$index];
    }
    return $string;
}

function deleteSQL($deleteID)
{
    global $database_path;
    require $database_path;

    $sql = "DELETE FROM compclub_activity WHERE activity_ID = '$deleteID'";
    $db->query($sql);
    $db->close();
}

// class adminIndex
// {
//     public function getContent()
//     {
//         require 'src/php/dbconfig.php';

//         $sql = "SELECT about_content FROM about WHERE 1";
//         $result = $db->query($sql);
//         if ($result->num_rows > 0) {
//             while ($row = $result->fetch_assoc()) {
//                 $about_detail = $row["about_content"];
//             }
//         }
//         $db->close();
//         return $about_detail;
//     }

//     public function setInput($input)
//     {
//         if (isset($_POST[$input])) {
//             require 'src/php/dbconfig.php';

//             $input = $_POST[$input];
//             $sql = "UPDATE about SET about_content = '$input' WHERE 1";
//             $this->result = $db->query($sql);
//             $db->close();
//             header('Location: index.php?admin_menu=index');
//         }
//     }
// }
// -----------------------------------------------------------------------------------
// class activity
// {
//     public static function getActivityContent()
//     {
//         global $database_path;
//         require $database_path;

//         if (isset($_GET['activityid'])) {
//             require $GLOBALS["database_path"];

//             $activity_id = $_GET['activityid'];

//             $sql = "SELECT activity_ID , activity_name , activity_detail , activity_date
//             FROM activity
//             WHERE activity_ID = $activity_id";

//             $result = $db->query($sql);
//             if ($result->num_rows > 0) {
//                 while ($row = $result->fetch_assoc()) {
//                     $activity_id = $row["activity_ID"];
//                     $activity_name = $row["activity_name"];
//                     $activity_detail = $row["activity_detail"];
//                     $activity_timestamp = strtotime($row['activity_date']);
//                     $activity_date = date('d/m/Y', $activity_timestamp);
//                     echo "<div class='activity-content-name'>$activity_name</div>";
//                     echo "<div class='activity-content-date'>$activity_date</div>";
//                     echo "<div class='activity-content-detail'>$activity_detail</div>";
//                 }
//             }
//             $db->close();
//         }
//     }

//     public static function getActivityImg()
//     {
//         if (isset($_GET['activityid'])) {
//             require $GLOBALS["database_path"];

//             $activity_id = $_GET['activityid'];

//             $sql = "SELECT activity_img FROM activity_img WHERE activity_ID = $activity_id";
//             $result = $db->query($sql);
//             if ($result->num_rows > 0) {
//                 while ($row = $result->fetch_assoc()) {
//                     $output = self::$img_path . $row["activity_img"];
//                     echo "<div class='activity-content-img'><img src='$output'></div>";
//                 }
//             }
//             $db->close();
//         }
//     }
// }
