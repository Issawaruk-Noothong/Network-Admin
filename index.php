<?php
$db_host = "localhost";
$db_username = "programmer";
$db_pass = "P@ssw0rd!";
$db_name = "lab5";
$conn = new mysqli($db_host, $db_username, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $memo = $_POST['memo'];
    $date = $_POST['date'];
    $sql = "INSERT INTO phonebook (name, email, phone, memo, date) VALUES ('$name', '$email', '$phone', '$memo', '$date')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM phonebook WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $memo = $_POST['memo'];
    $date = $_POST['date'];
    $sql = "UPDATE phonebook SET name='$name', email='$email', phone='$phone', memo='$memo', date='$date' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$result = $conn->query("SELECT * FROM phonebook");
if (!$result) {
    echo("<p>Error performing query: " . $conn->error . "</p>");
    exit();
}

echo '<h2>Phonebook</h2>';
echo '<table width=100% cellpadding=10 cellspacing=0 border=1>';
echo '<tr><td><b>ID</b></td><td><b>Name</b></td><td><b>Email</b></td>';
echo '<td><b>Phone</b></td><td><b>Memo</b></td><td><b>Date</b></td><td><b>Actions</b></td></tr>';
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>'.$row['id'].'</td>';
    echo '<td>'.$row['name'].'</td>';
    echo '<td>'.$row['email'].'</td>';
    echo '<td>'.$row['phone'].'</td>';
    echo '<td>'.$row['memo'].'</td>';
    echo '<td>'.$row['date'].'</td>';
    echo '<td><a href="?delete='.$row['id'].'">Delete</a> | <a href="?edit='.$row['id'].'">Edit</a></td>';
    echo '</tr>';
}
echo '</table>';
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM phonebook WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Record not found");
    }
?>

<h2>Edit Record</h2>
<form method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
    <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>" required>
    <input type="text" name="memo" value="<?php echo htmlspecialchars($row['memo']); ?>">
    <input type="date" name="date" value="<?php echo htmlspecialchars($row['date']); ?>" required>
    <input type="submit" name="update" value="Update Record">
</form>

<?php
}

?>
<h2>Add New Record</h2>
<form method="POST">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Phone" required>
    <input type="text" name="memo" placeholder="Memo">
    <input type="date" name="date" required>
    <input type="submit" name="add" value="Add Record">
</form>

<?php
$conn->close();
?>