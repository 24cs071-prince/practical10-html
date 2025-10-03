<?php
session_start();

// Session timeout: 5 minutes
$timeout = 300;

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// Check timeout
if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)){
    session_unset();
    session_destroy();
    header("Location: login.php?message=Session expired. Login again.");
    exit();
}
$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<style>
body { font-family: Arial, sans-serif; background:#f0f4f7; margin:0; padding:0; }
.container { max-width:800px; margin:50px auto; background:#fff; padding:25px; border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.2); }
h2 { color:#2c3e50; }
.logout { text-align:right; margin-bottom:15px; }
.logout a { text-decoration:none; background:#e74c3c; color:#fff; padding:6px 12px; border-radius:5px; }
.logout a:hover { background:#c0392b; }
.role { font-weight:bold; color:#2980b9; }
</style>
</head>
<body>
<div class="container">
<div class="logout">
<a href="logout.php">Logout</a>
</div>
<h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
<p>Your role: <span class="role"><?php echo htmlspecialchars($_SESSION['role']); ?></span></p>

<?php if($_SESSION['role'] == 'admin'): ?>
<p>You have admin privileges. You can manage users here.</p>
<?php else: ?>
<p>You are a standard user. Limited access.</p>
<?php endif; ?>
</div>
</body>
</html>
