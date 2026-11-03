<?php
class Dao {
    private $con;

    // Hàm khởi tạo kết nối CSDL
    function __construct($user, $pass, $db) {
        $host = $_SERVER['SERVER_NAME'];
        $this->con = mysqli_connect($host, $user, $pass, $db);
        mysqli_query($this->con, "set names 'utf8'");
    }

    // Hàm thực thi truy vấn SQL
    public function query($sql) {
        $rs = mysqli_query($this->con, $sql);
        return $rs;
    }

    // Hàm tạo và hiển thị bảng dữ liệu động
    function table($sql, $header) {
        $rs = $this->query($sql);
        if (!$rs) return;

        $fieldinfo = mysqli_fetch_fields($rs);
        $str = "<table border='1' cellspacing='0' cellpadding='5'><tr>";

        // Tạo hàng tiêu đề (header) của bảng
        foreach ($fieldinfo as $val) {
            $name = $val->name;
            $str .= "<th>" . $name . "</th>";
        }
        $str .= "</tr>";

        // Đưa dữ liệu các dòng (records) vào bảng
        while ($r = mysqli_fetch_array($rs)) {
            $str .= "<tr>";
            foreach ($fieldinfo as $val) {
                $name = $val->name;
                $str .= "<td>" . $r[$name] . "</td>";
            }
            $str .= "</tr>";
        }
        $str .= "</table>";

        // In ra tiêu đề và bảng
        echo "<h3>{$header}</h3>";
        echo $str;
    }
}
?>