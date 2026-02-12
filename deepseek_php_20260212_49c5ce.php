<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$username, $email, $password]);
        header('Location: login.php?registered=1');
        exit();
    } catch(PDOException $e) {
        $error = "Username or email already exists!";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل حساب جديد - شياء أفلام</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <h2><i class="fas fa-film"></i> شياء أفلام</h2>
            <h3>إنشاء حساب جديد</h3>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> اسم المستخدم</label>
                    <input type="text" name="username" required>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> كلمة المرور</label>
                    <input type="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary">تسجيل</button>
            </form>
            
            <p>لديك حساب بالفعل؟ <a href="login.php">تسجيل الدخول</a></p>
        </div>
    </div>
</body>
</html>