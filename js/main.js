// initialize
console.log("CSMJU Computer Club");

// html tag as variable
var tableTag = "<table>";
var theadTag = "<thead>";
var theadTagEnd = "</thead>";
var tdTag = "<td>";
var tdTagEnd = "</td>";
var divTagEnd = "</div>";
var trTag = "<tr>";
var trTagEnd = "</tr>";

// activity.php initialize
if ((window.location.href).includes("activity.php")) {
    $("input[name='year']#activity").val("2561");
    getActivityList();
}

// index.php initialize
if ((window.location.href).includes("index.php")) {
    $.ajax({
        type: "POST",
        url: "src/php/getjson.php",
        dataType: 'json',
        data: {
            "key": "GET_ACTIVITY_IMG",
            "input": "NO_INPUT"
        },
        success: function (result) {
            loopIndexImgByRandom(result);
        }
    });

    function loopIndexImgByRandom(result) {
        var targetElement = $("#index-img"),
            randomNumber;

        setInterval(function () {
            randomNumber = Math.floor((Math.random() * parseInt(result.length)));
            (new Image).src = 'img/' + result[randomNumber].img_path;
        }, 4000);

        setInterval(function () {
            targetElement.css("background-image", "url(img/" + result[randomNumber].img_path + ")");
        }, 5000);
    }
}

// get parameter function
function getParameter(param) {
    var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < url.length; i++) {
        var urlparam = url[i].split('=');
        if (urlparam[0] == param) {
            return urlparam[1];
        }
    }
}

// get student name from input student id
$("input[name='studentid']").on("input", function () {
    var input = $(this).val();

    if (input.length != 10) {
        $("input[type='submit']").attr("disabled", "disabled");
        $(".output-name").val("ไม่พบชื่อนักศึกษา");
    } else {
        $.ajax({
            type: "POST",
            url: "src/php/getjson.php",
            dataType: 'json',
            data: {
                "key": "student_name",
                "input": input
            },
            success: function (result) {
                if (result != "") {
                    $("input[type='submit']").removeAttr("disabled");
                    $(".output-name").val(result[0].Name);
                } else {
                    $("input[type='submit']").attr("disabled", "disabled");
                    $(".output-name").val("ไม่พบชื่อนักศึกษา");
                }
            }
        });
    }
});

// if input year length < 4 --> disable input submit
$("input[name='year']").on("input", function () {
    var input = $(this).val();
    if (input.length >= 4) {
        input = input.slice(0, 4);
        $(this).val(input);
    }
});

// search for admin member / advisor / activity
$("input#admin-search").keypress(function (key) {
    if (key.which == 13) {
        var input = $(this).val();
        var selector = ".admin-table tbody tr:not(:contains(" + input + "))";
        $(selector).hide(500);
        selector = ".admin-table tbody tr:contains(" + input + ")";
        $(selector).show(500);
    }
});

$("input.search-btn").click(function () {
    var input = $("input#admin-search").val();
    var selector = ".admin-table tbody tr:not(:contains(" + input + "))";
    $(selector).hide(500);
    selector = ".admin-table tbody tr:contains(" + input + ")";
    $(selector).show(500);
});

// add admin activity input
$("input[value='เพิ่มกิจกรรม +']").click(function () {
    var html = '<input type="text" placeholder="ชื่อกิจกรรม" name="activity[]" list="activity-list">';
    html += '<select name="month[]">';
    html += '<option value="">เลือกเดือนที่จัดกิจกรรม</option>';
    html += '<option value="1">มกราคม</option>';
    html += '<option value="2">กุมภาพันธ์</option>';
    html += '<option value="3">มีนาคม</option>';
    html += '<option value="4">เมษายน</option>';
    html += '<option value="5">พฤษภาคม</option>';
    html += '<option value="6">มิถุนายน</option>';
    html += '<option value="7">กรกฎาคม</option>';
    html += '<option value="8">สิงหาคม</option>';
    html += '<option value="9">กันยายน</option>';
    html += '<option value="10">ตุลาคม</option>';
    html += '<option value="11">พฤศจิกายน</option>';
    html += '<option value="12">ธันวาคม</option>';
    html += '</select>';
    $(".input-activity").append(html);
});

// get activity table
$("input[name='year']#activity").on("input", function () {
    getActivityList();
});


function getActivityList() {
    var input = $("input[name='year']#activity").val();
    var html, academicYearMonthStart;


    if (input.length == 4) {
        $.ajax({
            type: "POST",
            url: "src/php/getjson.php",
            dataType: 'json',
            data: {
                "key": "activity",
                "input": input
            },
            success: function (result) {
                if (result == "") {
                    html = getNotFoundMessageHTML(input);
                    $(".content-activity").html(html);
                } else {
                    academicYearMonthStart = parseInt(result[0].activity_year);

                    html = getActivityHeaderHTML(input);

                    html += tableTag;
                    html += theadTag + getActivityTheadHTML(input, academicYearMonthStart) + theadTagEnd;

                    html += "<tbody>"
                    for (let i = 0; i < result.length; i++) {
                        html += "<tr>";
                        html += "<td>";
                        html += "<span class='activity-link' data-activity='" + result[i].activity_ID + "'>";
                        html += result[i].activity_name;
                        html += "</span>"
                        html += "</td>"
                        for (let i = 0; i < 11; i++) {
                            html += "<td> </td>";
                        }
                        html += "</tr>";
                    }
                    html += "</tbody>"
                    html += "</table>"

                    $(".content-activity").html(html);
                    applyColor(result);
                }
            }
        });
    }

    function getNotFoundMessageHTML(input) {
        let html = "<div class='content-header'>"
        html += "ไม่พบแผนโครงการ ปี " + input;
        html += "</div>";
        return html;
        // return <div class='content-header'> ไม่พบแผนโครงการ ปี xxxx </div>
    }

    function getActivityHeaderHTML(input) {
        let thisYear = parseInt(input);
        let nextYear = thisYear + 1;
        let divTagContentHeader = "<div class='content-header'>";
        let divTagEnd = "</div>";
        let text = "โครงการและกิจกรรมปี " + thisYear + " - " + nextYear;
        let html = divTagContentHeader + text + divTagEnd;
        return html;
        // return <div class='content-header'> โครงการและกิจกรรมปี xxxx - xxxx </div>
    }

    function getActivityTheadHTML(input, month) {
        var html;
        var thisYear = parseInt(input);
        var nextYear = thisYear + 1;
        var yearSpan = countMonthUntilEndYear(month);

        var thTagTableHeader = "<th rowspan='2'> โครงการ / กิจกรรม </th>";
        var thTagThisYearHeader = "<th colspan='" + yearSpan + "'>" + thisYear + "</th>";
        var thTagNextYearHeader = "<th colspan='12'>" + nextYear + "</th>";

        html = trTag + thTagTableHeader + thTagThisYearHeader + thTagNextYearHeader + trTagEnd;
        html += trTag + loopMonthFromStart(month) + trTagEnd;

        return html;
    }

    function loopMonthFromStart(month) {
        var html = "";
        for (let i = 0; i < 11; i++) {
            if (month > 12) {
                month = 1;
            }
            var divMonth = "<div data-month='" + month + "'>";
            var shortMonth = getShortMonth(month);
            html += tdTag + divMonth + shortMonth + divTagEnd + tdTagEnd;
            month++;
        }
        return html;
    }

    function countMonthUntilEndYear(month) {
        var count = 0;
        while (true) {
            if (month > 12) {
                break;
            } else {
                count++;
                month++;
            }
        }
        return count;
    }

    function getShortMonth(month) {
        switch (month) {
            case 1:
                return "ม.ค.";
            case 2:
                return "ก.พ.";
            case 3:
                return "มี.ค.";
            case 4:
                return "เม.ย";
            case 5:
                return "พ.ค.";
            case 6:
                return "มิ.ย";
            case 7:
                return "ก.ค.";
            case 8:
                return "ส.ค.";
            case 9:
                return "ก.ย.";
            case 10:
                return "ต.ค.";
            case 11:
                return "พ.ย.";
            case 12:
                return "ธ.ค.";
        }
    }

    function applyColor(result) {
        var academicYearMonthStart = parseInt(result[0].activity_year);
        var activityMonth, target;
        for (let i = 0; i < result.length; i++) {
            activityMonth = parseInt(result[i].activity_month);
            target = activityMonth - academicYearMonthStart + 1;
            $("tr:eq(" + (i + 2) + ")").find("td:eq(" + target + ")").addClass("activity-active");;
        }
    }
}

// activity modal function
$(document).on("click", "span.activity-link", function () {
    var html = "",
        activityID = $(this).attr('data-activity');

    $("body").css("overflow-y", "hidden");
    $(".activity-modal").show(250);
    $(".modal-container").show(250);

    $.ajax({
        type: "POST",
        url: "src/php/getjson.php",
        dataType: 'json',
        data: {
            "key": "activityDetail",
            "input": activityID
        },
        success: function (result) {
            if (result != "") {
                var activity_name = result[0].activity_name;
                var activity_year = "ประจำปีการศีกษา " + (parseInt(result[0].activity_year) + 543);
                var activity_detail = (result[0].activity_detail != "" ? result[0].activity_detail : "ยังไม่มีรายละเอียดกิจกรรม");

                for (let i = 1; i < result.length; i++) {
                    let activity_img = "img/" + result[i].img_path;
                    html += "<div class='modal-activity-img'><img src='" + activity_img + "'></div>";
                    //href='" + activity_img + "' target='_blank'
                }

                $(".activity-modal-header").html(activity_name);
                $(".activity-modal-year").html(activity_year);
                $(".activity-modal-content").html(activity_detail);
                $(".activity-modal-img").html(html);

                activeListenerOpenActivityImgModal();
            }
        }
    });

    $.ajax({
        type: "POST",
        url: "src/php/getjson.php",
        dataType: 'json',
        data: {
            "key": "ACTIVITY_DOCUMENT",
            "input": activityID
        },
        success: function (result) {
            var html = "";
            if (result != "") {
                for (let i = 0; i < result.length; i++) {
                    let documentNameWithPath = "doc/" + result[i].document_name;
                    html += "<a class='modal-activity-doc' href='" + documentNameWithPath + "'>" + result[i].document_name + "</a>";
                }

                $(".activity-modal-document").html(html);
            } else {
                $(".activity-modal-document").html("ไม่มีเอกสาร");
            }
        }
    });

    activeListenerCloseActivityModal();
});

function activeListenerCloseActivityModal() {
    $(".activity-modal").on("click", function () {
        var thisElement = $(this);
        $("body").css("overflow-y", "scroll");
        $(".modal-container").hide(250);
        thisElement.off("click");
        thisElement.hide(250);
    });
}

// admin activity modal function
$("img[data-edit]").on("click", function () {
    var htmlImg = "",
        htmlDoc = "",
        activityID = $(this).attr('data-edit');

    $("body").css("overflow-y", "hidden");
    $(".activity-admin-modal").show(250);
    $(".modal-container").show(250);

    $.ajax({
        type: "POST",
        url: "src/php/getjson.php",
        dataType: 'json',
        data: {
            "key": "activityDetail",
            "input": activityID
        },
        success: function (result) {
            if (result != "") {
                var activity_name = result[0].activity_name;
                var activity_year = "ประจำปีการศีกษา " + (parseInt(result[0].activity_year) + 543);
                var activity_detail = (result[0].activity_detail != "" ? result[0].activity_detail : "ยังไม่มีรายละเอียดกิจกรรม");

                for (let i = 1; i < result.length; i++) {
                    let activity_img = "img/" + result[i].img_path;
                    htmlImg += "<div class='modal-activity-admin-img-container' data-deleteid='" + result[i].img_ID + "'>"
                    htmlImg += "<div class='hover-delete'>ลบ</div>";
                    htmlImg += "<img src='" + activity_img + "' >";
                    htmlImg += divTagEnd;
                }

                $(".admin-activity-modal-header").html(activity_name);
                $(".admin-activity-modal-year").html(activity_year);
                $(".admin-activity-modal-content").html(activity_detail);
                $(".admin-activity-modal-img").html(htmlImg);

                // active listener
                activeListenerDeleteActivityImg();
            }
        }
    });

    $.ajax({
        type: "POST",
        url: "src/php/getjson.php",
        dataType: 'json',
        data: {
            "key": "ACTIVITY_DOCUMENT",
            "input": activityID
        },
        success: function (result) {
            var html = "";
            if (result != "") {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr>";
                    html += "<td>";
                    html += "<div class='modal-admin-activity-doc'>" + result[i].document_name + "</div>";
                    html += "</td>";
                    html += "<td>";
                    html += "<span data-doc-deleteid='" + result[i].document_ID + "'>ลบ</span>";
                    html += "</td>";
                    html += "</tr>";
                }

                $(".admin-activity-modal-document table tbody").html(html);
                activeListenerDeleteActivityDocument();
            } else {
                $(".admin-activity-modal-document table tbody").html("ไม่มีเอกสาร");
            }
        }
    });

    // active listener
    activeListenerCloseAdminActivityModal();
});

function activeListenerOpenActivityImgModal() {
    $(".modal-activity-img").on("click", function () {
        var thisElement = $(this);
        var targetElement = $(".image-modal");
        targetElement.show();
        var attr = thisElement.children().attr('src');
        targetElement.children().attr('src', attr);
    });

    $(".image-modal").on("click", function () {
        var thisElement = $(this);
        thisElement.hide();
    });
}

function activeListenerCloseAdminActivityModal() {
    $(".activity-admin-modal").on("click", function () {
        $("body").css("overflow-y", "scroll");
        $(".modal-container").hide(250);
        $(this).off("click");
        $(this).hide(250);
    });
}

function activeListenerDeleteActivityImg() {
    $(".modal-activity-admin-img-container").on("click", function () {
        var thisElement = $(this);
        var deleteID = thisElement.attr('data-deleteid');
        var confirmMessage = "ยืนยันการลบรูปนี้";

        if (confirm(confirmMessage)) {
            $.ajax({
                type: "POST",
                url: "src/php/delete.php",
                data: {
                    "key": "DELETE_ACTIVITY_IMG",
                    "input": deleteID
                },
                success: function (result) {
                    if (result) {
                        thisElement.remove();
                    }
                }
            });
        }
    });
}

function activeListenerDeleteActivityDocument() {
    $("[data-doc-deleteid]").on("click", function () {
        var thisElement = $(this);
        var deleteID = thisElement.attr('data-doc-deleteid');
        var confirmMessage = "ยืนยันการลบเอกสารนี้";

        if (confirm(confirmMessage)) {
            $.ajax({
                type: "POST",
                url: "src/php/delete.php",
                data: {
                    "key": "DELETE_ACTIVITY_DOCUMENT",
                    "input": deleteID
                },
                success: function (result) {
                    if (result) {
                        thisElement.parent().parent().remove();
                    }
                }
            });
        }
    });
}

$("img[data-edit]").on("click", function () {
    var input = $(this).attr('data-edit');

    $.ajax({
        type: "POST",
        url: "src/php/getjson.php",
        dataType: 'json',
        data: {
            "key": "edit_activity",
            "input": input
        },
        success: function (result) {

            $("[name='edit_activity_name']").val(result[0].activity_name);
            $("[name='edit_activity_detail']").val(result[0].activity_detail);
            $("[name='edit_activity_id']").val(result[0].activity_ID);
        }
    });
});

$("input[name='year_start']").on("input", function () {
    var input = $(this).val();
    input = input.slice(0, 4);

    $.ajax({
        type: "POST",
        url: "src/php/getjson.php",
        dataType: 'json',
        data: {
            "key": "CHECK_YEAR_DUPLICATE",
            "input": input
        },
        success: function (result) {

            if (result != "") {
                var date = new Date(result[0].activity_year);
                var month = date.getMonth() + 1;
                if (month < 10) {
                    month = "0" + month.toString();
                }
                $("input[name='year_start']").val(input + "-" + month)
            }
        }
    });
});