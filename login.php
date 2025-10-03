<?php
session_start();
include 'db_connect.php';

$message = "";

if(isset($_POST['login'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        if($password === $user['password']){
            // Start session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['last_activity'] = time(); // For session timeout
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Incorrect password";
        }
    } else {
        $message = "User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<style>
body { font-family: Arial, sans-serif; background:#f0f4f7; display:flex; justify-content:center; align-items:center; height:100vh; }
.form-box { background:#fff; padding:30px 35px; border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,0.15); width:320px; }
h2 { text-align:center; color:#2c3e50; margin-bottom:25px; }
input[type=text], input[type=password] { width:100%; padding:10px; margin:8px 0; border-radius:6px; border:1px solid #ccc; }
button { width:100%; padding:10px; margin-top:10px; border:none; border-radius:6px; background:#3498db; color:#fff; font-weight:bold; cursor:pointer; }
button:hover { background:#2980b9; }
.message { text-align:center; color:red; font-weight:bold; margin-bottom:10px; }
</style>
</head>
<body>
<div class="form-box">
<h2>Login</h2>
<?php if($message) echo "<p class='message'>$message</p>"; ?>
<form method="POST">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit" name="login">Login</button>
</form>
</div>
</body>
</html>
