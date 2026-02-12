<?php
require_once 'config/database.php';

$id = $_GET['id'] ?? 0;
$sql = "SELECT * FROM movies WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$movie = $stmt->fetch();

if (!$movie) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $movie['title']; ?> - شياء أفلام</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="movie-details-container">
        <div class="movie-backdrop">
            <div class="container">
                <div class="movie-header">
                    <div class="movie-poster-large">
                        <img src="<?php echo $movie['poster_image'] ?: 'https://via.placeholder.com/300x450?text=No+Poster'; ?>" 
                             alt="<?php echo $movie['title']; ?>">
                    </div>
                    <div class="movie-info-large">
                        <h1><?php echo $movie['title']; ?></h1>
                        <div class="movie-meta">
                            <span><i class="fas fa-calendar"></i> <?php echo $movie['release_year']; ?></span>
                            <span><i class="fas fa-tag"></i> <?php echo $movie['genre']; ?></span>
                            <?php if ($movie['rating']): ?>
                                <span><i class="fas fa-star"></i> <?php echo $movie['rating']; ?>/10</span>
                            <?php endif; ?>
                        </div>
                        
                        <h3>القصة</h3>
                        <p class="movie-description"><?php echo $movie['description']; ?></p>
                        
                        <?php if ($movie['director']): ?>
                            <p><strong>المخرج:</strong> <?php echo $movie['director']; ?></p>
                        <?php endif; ?>
                        
                        <?php if ($movie['cast']): ?>
                            <p><strong>طاقم التمثيل:</strong> <?php echo $movie['cast']; ?></p>
                        <?php endif; ?>
                        
                        <?php if (isLoggedIn() && $movie['video_url']): ?>
                            <a href="<?php echo $movie['video_url']; ?>" class="btn btn-primary" target="_blank">
                                <i class="fas fa-play"></i> مشاهدة الفيلم
                            </a>
                        <?php elseif (!isLoggedIn()): ?>
                            <p class="login-prompt">
                                <a href="login.php">سجل دخول</a> للمشاهدة
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>