<?php
require_once '../config/database.php';

if (!isAdmin()) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $release_year = $_POST['release_year'];
    $genre = $_POST['genre'];
    $director = $_POST['director'];
    $cast = $_POST['cast'];
    $rating = $_POST['rating'];
    $video_url = $_POST['video_url'];
    
    // رفع الصورة
    $target_dir = "../uploads/movies/";
    $poster_image = "";
    
    if (isset($_FILES["poster"]) && $_FILES["poster"]["error"] == 0) {
        $extension = pathinfo($_FILES["poster"]["name"], PATHINFO_EXTENSION);
        $poster_image = time() . "." . $extension;
        move_uploaded_file($_FILES["poster"]["tmp_name"], $target_dir . $poster_image);
    }
    
    $sql = "INSERT INTO movies (title, description, poster_image, video_url, release_year, genre, director, cast, rating, created_by) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $description, $poster_image, $video_url, $release_year, $genre, $director, $cast, $rating, $_SESSION['user_id']]);
    
    header('Location: dashboard.php?success=1');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة فيلم جديد - لوحة التحكم</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            <!-- نفس قائمة التنقل -->
        </aside>
        
        <main class="admin-content">
            <div class="form-container">
                <h1><i class="fas fa-plus-circle"></i> إضافة فيلم جديد</h1>
                
                <form method="POST" action="" enctype="multipart/form-data" class="movie-form">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>عنوان الفيلم</label>
                            <input type="text" name="title" required>
                        </div>
                        
                        <div class="form-group col-6">
                            <label>سنة الإصدار</label>
                            <select name="release_year">
                                <?php for($year = date('Y'); $year >= 1900; $year--): ?>
                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>التصنيف</label>
                            <select name="genre">
                                <option value="أكشن">أكشن</option>
                                <option value="دراما">دراما</option>
                                <option value="كوميديا">كوميديا</option>
                                <option value="رعب">رعب</option>
                                <option value="خيال علمي">خيال علمي</option>
                                <option value="رومانسي">رومانسي</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-6">
                            <label>المخرج</label>
                            <input type="text" name="director">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>طاقم التمثيل</label>
                        <textarea name="cast" rows="3" placeholder="أسماء الممثلين"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>وصف الفيلم</label>
                        <textarea name="description" rows="5" required></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>صورة الملصق</label>
                            <input type="file" name="poster" accept="image/*">
                        </div>
                        
                        <div class="form-group col-6">
                            <label>التقييم (1-10)</label>
                            <input type="number" name="rating" step="0.1" min="1" max="10">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>رابط الفيديو</label>
                        <input type="url" name="video_url" placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> حفظ الفيلم
                        </button>
                        <a href="dashboard.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>