<?php
session_start();
include("connect.php");
global $con;

$us = isset($_GET["user"]) ? $_GET["user"] : '';
$pw = isset($_GET["pass"]) ? $_GET["pass"] : '';

$sql = "SELECT * FROM sinhvien WHERE masv='{$us}' AND matkhau='{$pw}'";
$rs = mysqli_query($con, $sql);

if (mysqli_num_rows($rs) > 0) {
    $row = mysqli_fetch_array($rs);
    $_SESSION["code"] = $row['masv'];
    $_SESSION["info"] = $row["hoten"] . " - " . $row["lop"];
    
    echo "Chào " . $row['hoten'] . "&nbsp;&nbsp;<a href='QLSV.php'>Next</a>";
} else {
    echo "Bạn nhập thông tin sai!";
}

mysqli_free_result($rs);
mysqli_close($con);
?>