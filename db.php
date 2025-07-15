<?php
$conn = new mysqli("localhost", "root", "", "railway_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
//register.php
<?php include 'db.php'; ?>

<form method="POST">
  <input type="text" name="name" placeholder="Full Name" required />
  <input type="email" name="email" placeholder="Email" required />
  <input type="password" name="password" placeholder="Password" required />
  <button type="submit" name="register">Register</button>
</form>

<?php
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$pass')";
    if ($conn->query($sql)) {
        echo "Registered Successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
//login.php
<?php
include 'db.php';
session_start();
?>

<form method="POST">
  <input type="email" name="email" required />
  <input type="password" name="password" required />
  <button type="submit" name="login">Login</button>
</form>

<?php
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = $conn->query($sql);
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: dashboard.php");
        } else {
            echo "Wrong password!";
        }
    } else {
        echo "User not found!";
    }
}
?>
//dashboard.php
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
?>

<h2>Welcome to Railway Reservation</h2>
<a href="book.php">Book Ticket</a> | <a href="pnr_status.php">PNR Status</a> | <a href="logout.php">Logout</a>
//book.php
<?php include 'db.php'; session_start(); ?>

<form method="POST">
  <input type="text" name="train" placeholder="Train Name" required />
  <input type="text" name="source" placeholder="From" required />
  <input type="text" name="destination" placeholder="To" required />
  <input type="date" name="date" required />
  <button type="submit" name="book">Book Ticket</button>
</form>

<?php
if (isset($_POST['book'])) {
    $train = $_POST['train'];
    $src = $_POST['source'];
    $dest = $_POST['destination'];
    $date = $_POST['date'];
    $uid = $_SESSION['user_id'];
    $pnr = rand(1000000000, 9999999999);

    $sql = "INSERT INTO bookings (user_id, train, source, destination, date, pnr) VALUES 
           ('$uid', '$train', '$src', '$dest', '$date', '$pnr')";

    if ($conn->query($sql)) {
        echo "Ticket Booked! Your PNR is: <b>$pnr</b>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
//pnr_status.php
<?php include 'db.php'; ?>

<form method="POST">
  <input type="text" name="pnr" placeholder="Enter PNR" required />
  <button type="submit" name="check">Check Status</button>
</form>

<?php
if (isset($_POST['check'])) {
    $pnr = $_POST['pnr'];
    $sql = "SELECT * FROM bookings WHERE pnr = '$pnr'";
    $res = $conn->query($sql);
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        echo "<p>Train: {$row['train']} | From: {$row['source']} | To: {$row['destination']} | Date: {$row['date']}</p>";
    } else {
        echo "PNR not found.";
    }
}
?>
//logout.php
<?php
session_start();
session_destroy();
header("Location: login.php");
?>
//database.sql
CREATE DATABASE railway_db;
USE railway_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255)
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    train VARCHAR(100),
    source VARCHAR(100),
    destination VARCHAR(100),
    date DATE,
    pnr VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
//style.css
body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  padding: 30px;
}
form {
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  max-width: 400px;
}
input, button {
  display: block;
  margin: 10px 0;
  padding: 10px;
  width: 100%;
}
//
