<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];
        
        if ($user['role'] == 'admin') {
            header('Location: admin/dashboard.php');
        } else {
            header('Location: index.php');
        }
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - شياء أفلام</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <h2><i class="fas fa-film"></i> شياء أفلام</h2>
            <h3>تسجيل الدخول</h3>
            
            <?php if (isset($_GET['registered'])): ?>
                <div class="alert alert-success">تم التسجيل بنجاح! يمكنك تسجيل الدخول الآن</div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> كلمة المرور</label>
                    <input type="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary">دخول</button>
            </form>
            
            <p>ليس لديك حساب؟ <a href="register.php">سجل الآن</a></p>
        </div>
    </div>
</body>
</html>