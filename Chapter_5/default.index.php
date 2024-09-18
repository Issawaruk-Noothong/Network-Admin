<?php
$db_host = "localhost";
$db_username = "blackrose";
$db_pass = "@pril8TH";
$db_name = "lab5";
$conn = new mysqli($db_host, $db_username, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query("SELECT * FROM phonebook");
if (!$result) {
    echo("<p>Error performing query: " . $conn->error . "</p>");
    exit();
}
echo '<h2>Phonebook</h2>';
echo '<table width=100% cellpadding=10 cellspacing=0 border=1>';
echo '<tr><td><b>ID</b></td><td><b>Name</b></td><td><b>Email</b></td>';
echo '<td><b>Phone</b></td><td><b>Memo</b></td><td><b>Date</b></td></tr>';
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>'.$row['id'].'</td>';
    echo '<td>'.$row['name'].'</td>';
    echo '<td>'.$row['email'].'</td>';
    echo '<td>'.$row['phone'].'</td>';
    echo '<td>'.$row['memo'].'</td>';
    echo '<td>'.$row['date'].'</td>';
    echo '</tr>';
}
echo '</table>';
?>