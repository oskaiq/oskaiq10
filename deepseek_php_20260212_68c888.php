<?php
require_once '../config/database.php';

if (!isAdmin()) {
    header('Location: ../login.php');
    exit();
}

// إحصائيات
$totalMovies = $pdo->query("SELECT COUNT(*) FROM movies")->fetchColumn();
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$recentMovies = $pdo->query("SELECT * FROM movies ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - شياء أفلام</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-film"></i> شياء أفلام</h2>
                <p>لوحة التحكم</p>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="active"><i class="fas fa-dashboard"></i> الرئيسية</a>
                <a href="add_movie.php"><i class="fas fa-plus-circle"></i> إضافة فيلم</a>
                <a href="manage_movies.php"><i class="fas fa-video"></i> إدارة الأفلام</a>
                <a href="manage_users.php"><i class="fas fa-users"></i> إدارة المستخدمين</a>
                <a href="../index.php"><i class="fas fa-home"></i> العودة للموقع</a>
                <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج</a>
            </nav>
        </aside>
        
        <main class="admin-content">
            <header class="admin-header">
                <h1>مرحباً، <?php echo $_SESSION['username']; ?></h1>
            </header>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fas fa-film"></i>
                    <div class="stat-info">
                        <h3>إجمالي الأفلام</h3>
                        <p><?php echo $totalMovies; ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <div class="stat-info">
                        <h3>إجمالي المستخدمين</h3>
                        <p><?php echo $totalUsers; ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <i class="fas fa-eye"></i>
                    <div class="stat-info">
                        <h3>المشاهدات</h3>
                        <p>1,234</p>
                    </div>
                </div>
            </div>
            
            <div class="recent-section">
                <h2>أحدث الأفلام المضافة</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان الفيلم</th>
                            <th>السنة</th>
                            <th>التصنيف</th>
                            <th>تاريخ الإضافة</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentMovies as $movie): ?>
                        <tr>
                            <td><?php echo $movie['id']; ?></td>
                            <td><?php echo $movie['title']; ?></td>
                            <td><?php echo $movie['release_year']; ?></td>
                            <td><?php echo $movie['genre']; ?></td>
                            <td><?php echo $movie['created_at']; ?></td>
                            <td>
                                <a href="edit_movie.php?id=<?php echo $movie['id']; ?>" class="btn-sm btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete_movie.php?id=<?php echo $movie['id']; ?>" class="btn-sm btn-delete" onclick="return confirm('هل أنت متأكد؟')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>