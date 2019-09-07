/**
 * information logger
 */
console.log('CSMJU Computer Club');
console.log('</> by CS #22 : 352 353 354');
console.log('Visit Repository https://github.com/phumoonlight/csmju-compclub');

if (window.location.href == "http://csmju.jowave.com/applications/compclub/beta/") {
    window.location.replace("http://csmju.jowave.com/applications/compclub/beta/index.php");
}

// html tag as variable
var tableTag = "<table>";
var theadTag = "<thead>";
var theadTagEnd = "</thead>";
var tdTag = "<td>";
var tdTagEnd = "</td>";
var divTagEnd = "</div>";
var trTag = "<tr>";
var trTagEnd = "</tr>";

// index.php initialize
if ((window.location.href).includes("index.php")) {

    var loopIndexImgByRandom = function (result) {
        var randomNumber;
        var targetElement = $("#index-img");

        setInterval(function () {
            randomNumber = Math.floor((Math.random() * parseInt(result.length)));
            (new Image).src = '../database/images/' + result[randomNumber].img_path;
        }, 3500);

        setInterval(function () {
            targetElement.css("background-image", "url(../database/images/" + result[randomNumber].img_path + ")");
        }, 5000);
    };

    callAjax("NO_INPUT", "ACTIVITY_IMG_FOR_SLIDESHOW", loopIndexImgByRandom);
}

// activity.php initialize
if ((window.location.href).includes("activity.php")) {
    $("input[name='year']#activity").val("2561");
    getActivityList();
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
        $(selector).hide();
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
    var html, academicYearMonthStart;
    var input = $("input[name='year']#activity").val();

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
    $(".activity-modal").fadeIn(250);
    $(".modal-container").fadeIn(250);

    $.ajax({
        type: "POST",
        url: "src/php/getjson.php",
        dataType: 'json',
        data: {
            "key": "ACTIVITY_DETAIL",
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
});
//------------------------------------------------------------//
// hide activity modal
$(document).on("click", ".activity-modal", function () {
    $("body").css("overflow-y", "scroll");
    $(".modal-container").fadeOut(250);
    $(this).fadeOut(250);
});
// show activity modal img
$(document).on("click", ".modal-activity-img", function () {
    var thisElement;
    var targetElement;
    var attr;

    $(".modal-activity-img.this-img").removeClass("this-img");

    thisElement = $(this);
    thisElement.addClass("this-img");
    targetElement = $(".image-modal");

    attr = thisElement.children().attr('src');
    targetElement.children().children().attr('src', attr);
    targetElement.fadeIn(250);
});

// hide activity modal img
$(document).on("click", ".image-modal", function (e) {
    var thisElement = $(this);

    if ($(e.target).is('.image-modal .container')) {
        thisElement.fadeOut(250);
    }
});

// activity img view previous 
$(".previous-img").on("click", function () {
    if ($(".modal-activity-img.this-img").is(":first-child")) {
        $(".modal-activity-img").last().trigger('click');
    } else {
        $(".modal-activity-img.this-img").prev().trigger('click');
    }
});

// activity img view next
$(".next-img").on("click", function () {
    if ($(".modal-activity-img.this-img").is(":last-child")) {
        $(".modal-activity-img").first().trigger('click');
    } else {
        $(".modal-activity-img.this-img").next().trigger('click');
    }
});

// show admin activity modal for edit
$("img[data-edit]").on("click", function () {
    var activityID;

    activityID = $(this).attr('data-edit');

    $("body").css("overflow-y", "hidden");
    $(".activity-admin-modal").fadeIn(250);
    $(".modal-container").fadeIn(250);

    getActivityDetailForEdit(activityID);
    getActivityImgForEdit(activityID);
    getActivityDocumentForEdit(activityID);
});
//------------------------------------------------------------//
// hide admin activity modal
$(document).on("click", ".activity-admin-modal", function () {
    $("body").css("overflow-y", "scroll");
    $(".modal-container").fadeOut(250);
    $(this).fadeOut(250);
});
//---------------------------------------------//
function getActivityDetailForEdit(activityID) {
    var input, key;

    input = activityID;;
    key = "EDIT_ACTIVITY";

    var getActivityDetail = function (result) {
        $("[name='edit_activity_id']").val(result[0].activity_ID);
        $("[name='edit_activity_name']").val(result[0].activity_name);
        $("[name='edit_activity_detail']").val(result[0].activity_detail);
    }

    callAjax(input, key, getActivityDetail);
}
//---------------------------------------------//
function getActivityImgForEdit(activityID) {
    var input, key, html;

    input = activityID;
    html = "";
    key = "ACTIVITY_IMG_FOR_EDIT";

    var getActivityImg = function (result) {
        for (let i = 0; i < result.length; i++) {
            let activity_img = "img/" + result[i].img_path;
            html += "<div class='modal-activity-admin-img-container' data-deleteid='" + result[i].img_ID + "'>"
            html += "<div class='hover-delete'>ลบ</div>";
            html += "<img src='" + activity_img + "' >";
            html += divTagEnd;
        }

        $(".admin-activity-modal-img").html(html);
    }

    callAjax(input, key, getActivityImg);
}
//---------------------------------------------//
function getActivityDocumentForEdit(activityID) {
    var input, key, html;

    input = activityID;
    html = "";
    key = "ACTIVITY_DOCUMENT";

    var getActivityDocument = function (result) {
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
        } else {
            $(".admin-activity-modal-document table tbody").html("ไม่มีเอกสาร");
        }
    }

    callAjax(input, key, getActivityDocument);
}
//------------------------------------------------------------//
// delete activity img
$(document).on("click", ".modal-activity-admin-img-container", function () {
    var thisElement, input, key, confirmMessage;

    thisElement = $(this);
    input = thisElement.attr('data-deleteid');
    confirmMessage = "ยืนยันการลบรูปนี้";
    key = "DELETE_ACTIVITY_IMG";

    var deleteActivityImg = function (result) {
        if (result) {
            thisElement.remove();
        }
    }

    if (confirm(confirmMessage)) {
        callAjaxForDelete(input, key, deleteActivityImg);
    }
});
//------------------------------------------------------------//
// delete activity document
$(document).on("click", "[data-doc-deleteid]", function () {
    var thisElement, input, key, confirmMessage;

    thisElement = $(this);
    input = thisElement.attr('data-doc-deleteid');
    confirmMessage = "ยืนยันการลบเอกสารนี้";
    key = "DELETE_ACTIVITY_DOCUMENT";

    var deleteActivityDocument = function (result) {
        if (result) {
            thisElement.parent().parent().remove();
        }
    }

    if (confirm(confirmMessage)) {
        callAjaxForDelete(input, key, deleteActivityDocument);
    }
});
//------------------------------------------------------------//
// check academic year input duplicate
$("input[name='year_start']").on("input", function () {
    var date, year, month, input, key;

    input = $(this).val();
    input = input.substring(0, 4);
    key = "CHECK_YEAR_DUPLICATE";

    var checkYearDuplicate = function (result) {
        if (result != "") {
            date = result[0].activity_year;
            year = date.substring(0, 4);
            month = date.substring(5, 7);
            $("input[name='year_start']").val(year + "-" + month);
        }
    }

    callAjax(input, key, checkYearDuplicate);
});

// ajax
function callAjax(input, key, func) {
    $.ajax({
        type: "POST",
        url: "src/php/getjson.php",
        dataType: 'json',
        data: {
            "key": key,
            "input": input
        },
        success: function (result) {
            func(result);
        }
    });
}

// ajax for delete
function callAjaxForDelete(input, key, func) {
    $.ajax({
        type: "POST",
        url: "src/php/delete.php",
        data: {
            "key": key,
            "input": input
        },
        success: function (result) {
            func(result);
        }
    });
}

// get url parameter
function getParameter(param) {
    var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < url.length; i++) {
        var urlparam = url[i].split('=');
        if (urlparam[0] == param) {
            return urlparam[1];
        }
    }
}