<?php


$db_server = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "db2";

$conn = mysqli_connect('localhost', 'root', '', 'db2');




if ($conn) {
    echo"<br> <br>Databáze připojena.";

}

else {
    echo"Připojení selhalo.";
}


$conn->close();

echo "<br>ses kokot";
echo "<br>ses kokot";
?>