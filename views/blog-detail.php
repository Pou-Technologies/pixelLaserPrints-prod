<?php
require_once __DIR__ . '/../includes/PortalApiClient.php';

$slug = $_GET['slug'] ?? '';
$post = null;
$errorMessage = null;

if (empty($slug)) {
    $errorMessage = 'No blog post specified.';
} else {
    $response = PortalApiClient::getBlogPostBySlug($slug);
    if ($response['success'] && isset($response['data'])) {
        $data = $response['data'];
        $post = isset($data['data']) && is_array($data['data']) ? $data['data'] : $data;
    } else {
        $errorMessage = $response['error'] ?? 'Post not found or could not be loaded.';
    }
}

$pageTitle = ($post && !empty($post['title'])) ? htmlspecialchars($post['title']) . " - Pixel Laser Prints" : "Blog Post - Pixel Laser Prints";
include_once __DIR__ . '/../includes/header.php';
?>

<div class="bg-dark text-white py-5 mb-5" style="margin-top: 80px;">
    <div class="container py-4">
        <a href="<?php echo BASE_URL; ?>/views/blog.php" class="btn btn-outline-light rounded-pill mb-3">
            <i class="bi bi-arrow-left me-1"></i> Back to Blog
        </a>
        <h1 class="display-5 fw-bold"><?php echo htmlspecialchars($post['title'] ?? 'Blog Post'); ?></h1>
        <?php if ($post && !empty($post['created_at'])): ?>
            <p class="text-white-50"><i class="bi bi-calendar3 me-1"></i> <?php echo date('F d, Y', strtotime($post['created_at'])); ?></p>
        <?php endif; ?>
    </div>
</div>

<main class="container my-5" style="max-width: 900px;">
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger text-center p-5 rounded-4 shadow-sm" role="alert">
            <i class="bi bi-exclamation-octagon display-4 text-danger mb-3 d-block"></i>
            <h4>Post Not Available</h4>
            <p><?php echo htmlspecialchars($errorMessage); ?></p>
            <a href="<?php echo BASE_URL; ?>/views/blog.php" class="btn btn-dark rounded-pill px-4 mt-3">Return to Blog</a>
        </div>
    <?php else: ?>
        <article class="bg-white p-4 p-md-5 rounded-4 shadow-sm">
            <?php 
                $coverImage = $post['image'] ?? $post['cover_image'] ?? $post['banner'] ?? null;
            ?>
            <?php if ($coverImage): ?>
                <img src="<?php echo htmlspecialchars($coverImage); ?>" class="img-fluid rounded-4 mb-4 w-100" style="max-height: 450px; object-fit: cover;" alt="<?php echo htmlspecialchars($post['title']); ?>">
            <?php endif; ?>

            <div class="blog-content leading-relaxed text-secondary fs-5">
                <?php 
                    $content = $post['content'] ?? $post['body'] ?? '';
                    // Allow safe HTML formatting or fallback to nl2br
                    if ($content === strip_tags($content)) {
                        echo nl2br(htmlspecialchars($content));
                    } else {
                        echo $content;
                    }
                ?>
            </div>

            <hr class="my-5">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <a href="<?php echo BASE_URL; ?>/views/blog.php" class="btn btn-outline-dark rounded-pill px-4">
                    <i class="bi bi-arrow-left me-1"></i> Back to Blog
                </a>
                <a href="<?php echo BASE_URL; ?>/views/contact.php" class="btn btn-gold rounded-pill px-4">
                    <i class="bi bi-envelope me-1"></i> Have a Question? Contact Us
                </a>
            </div>
        </article>
    <?php endif; ?>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
