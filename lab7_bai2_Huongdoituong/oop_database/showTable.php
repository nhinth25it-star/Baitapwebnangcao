<?php
$op = isset($_GET["chon"]) ? $_GET["chon"] : "";

if ($op != "") {
    include("database.class.php");
    
    // Khởi tạo đối tượng Dao với user="root", pass="", db="udn"
    $dao = new Dao("root", "", "udn");
    
    $sql = "SELECT * FROM {$op}";
    $header = "DANH SÁCH " . strtoupper($op);
    
    $dao->table($sql, $header);
}
?>