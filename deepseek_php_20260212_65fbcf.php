<?php
require_once 'config/database.php';

// جلب الأفلام
$sql = "SELECT * FROM movies ORDER BY created_at DESC LIMIT 12";
$stmt = $pdo->query($sql);
$movies = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شياء أفلام - الصفحة الرئيسية</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="hero-section">
        <div class="hero-content">
            <h1>شياء أفلام</h1>
            <p>أحدث الأفلام والمسلسلات حصرياً</p>
            <?php if (!isLoggedIn()): ?>
                <a href="register.php" class="btn btn-primary">ابدأ المشاهدة الآن</a>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="container">
        <div class="section-header">
            <h2><i class="fas fa-fire"></i> أحدث الأفلام</h2>
            <div class="filter-buttons">
                <button class="filter-btn active">الكل</button>
                <button class="filter-btn">أكشن</button>
                <button class="filter-btn">دراما</button>
                <button class="filter-btn">كوميديا</button>
            </div>
        </div>
        
        <div class="movies-grid">
            <?php foreach ($movies as $movie): ?>
            <div class="movie-card">
                <div class="movie-poster">
                    <img src="<?php echo $movie['poster_image'] ?: 'https://via.placeholder.com/300x450?text=No+Poster'; ?>" 
                         alt="<?php echo $movie['title']; ?>">
                    <div class="movie-overlay">
                        <a href="movie-details.php?id=<?php echo $movie['id']; ?>" class="btn-play">
                            <i class="fas fa-play"></i>
                        </a>
                    </div>
                    <?php if ($movie['rating']): ?>
                    <span class="rating"><i class="fas fa-star"></i> <?php echo $movie['rating']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="movie-info">
                    <h3><?php echo $movie['title']; ?></h3>
                    <span class="year"><?php echo $movie['release_year']; ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>