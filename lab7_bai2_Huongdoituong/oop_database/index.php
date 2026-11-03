<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>OOP with PHP</title>
<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th { background-color: #004080; color: white; text-transform: uppercase; }
    td, th { padding: 8px; border: 1px solid #ddd; text-align: left; }
    tr:nth-child(even) { background-color: #f2f2f2; }
    h3 { color: #333; margin-top: 15px; }
</style>
<script>
function ajax() {
    var value = document.getElementById("chon").value;
    var obj = document.getElementById("info");
    
    if (value === "") {
        obj.style.display = "none";
        obj.innerHTML = "";
        return;
    }
    
    obj.style.display = "block";
    var xml = new XMLHttpRequest();
    
    xml.onreadystatechange = function() {
        if (xml.readyState == 4 && xml.status == 200) {
            obj.innerHTML = xml.responseText;
        }
    };
    
    var url = "showTable.php?chon=" + encodeURIComponent(value);
    xml.open("GET", url, true);
    xml.send();
}
</script>
</head>
<body>

<h1>OOP with PHP</h1>

Chọn bảng dữ liệu: 
<select id="chon" onChange="ajax();">
    <option value="">-->--Chọn--<--</option>
    <option value="giaovien">Giáo viên</option>
    <option value="sinhvien">Sinh viên</option>
    <option value="hocphan">Học phần</option>
</select>

<hr>
<div id="info" style="display:none;"></div>

</body>
</html>