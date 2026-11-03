<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Ajax - Danh sách lớp</title>
<style>
    body { font-size: 11pt; }
    div { padding: 3px 5px; font: normal 13pt Arial; }
    table { background-color: #eaeaea; width: 100%; border-collapse: collapse; }
    td, th { font: normal 11pt Arial; padding: 5px; border: 1px solid #ccc; }
    .hd { background-color: navy; color: white; font-weight: bold; }
</style>
<script>
function sendajax() {
    var lop = document.getElementById("lop").value;
    var objds = document.getElementById("ds");
    var xml = new XMLHttpRequest();
    
    xml.onreadystatechange = function() {
        if (xml.readyState == 4 && xml.status == 200) {
            objds.innerHTML = xml.responseText;
        }
    }
    
    var url = "ds.php?lop=" + encodeURIComponent(lop);
    xml.open("GET", url, true);
    xml.send();
}
</script>
</head>
<body>
<h3>In danh sách theo từng lớp</h3>

<?php
include("inc/connect.inc");
global $con; /** @var mysqli $con */

function initClass($conn) {
    if (!$conn) return;
    
    $sql = "SELECT DISTINCT lop FROM sinhvien";
    $rs = mysqli_query($conn, $sql);
    
    $str = "Chọn lớp: <select id='lop' onChange='sendajax();'>";
    $str .= "<option value=''>-- Chọn lớp --</option>";
    
    if ($rs) {
        while ($row = mysqli_fetch_array($rs)) {
            $str .= "<option value='{$row['lop']}'>{$row['lop']}</option>";
        }
    }
    
    $str .= "</select>";
    echo $str;
}

initClass($con);
?>

<hr>
<div id="ds">Danh sách sinh viên sẽ hiển thị tại đây</div>

</body>
</html>