<?php
$pageTitle = "Blog - " . (defined('COMPANY_NAME') ? COMPANY_NAME : 'Pixel Laser Prints');
include_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/PortalApiClient.php';

$response = PortalApiClient::getBlogPosts();
$posts = [];
$errorMessage = null;

if ($response['success'] && isset($response['data'])) {
    $data = $response['data'];
    if (isset($data['data']) && is_array($data['data'])) {
        $posts = $data['data'];
    } elseif (is_array($data)) {
        $posts = $data;
    }
} else {
    $errorMessage = $response['error'] ?? 'Could not retrieve blog posts at this time.';
}
?>

<div class="bg-dark text-white py-5 mb-5" style="margin-top: 80px;">
    <div class="container text-center py-4">
        <h1 class="display-4 fw-bold">Our Blog</h1>
        <p class="lead">Latest news, guides, and updates from Pixel Laser Prints</p>
    </div>
</div>

<main class="container my-5">
    <?php if ($errorMessage): ?>
        <div class="alert alert-warning text-center" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?php echo htmlspecialchars($errorMessage); ?>
        </div>
    <?php elseif (empty($posts)): ?>
        <div class="text-center py-5">
            <i class="bi bi-journal-x display-1 text-muted"></i>
            <h3 class="mt-3 text-muted">No blog posts found.</h3>
            <p>Check back soon for new content!</p>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($posts as $post): ?>
                <?php 
                    $title = $post['title'] ?? 'Untitled Post';
                    $slug = $post['slug'] ?? '';
                    $excerpt = $post['excerpt'] ?? $post['summary'] ?? (isset($post['content']) ? substr(strip_tags($post['content']), 0, 150) . '...' : '');
                    $coverImage = $post['image'] ?? $post['cover_image'] ?? $post['thumbnail'] ?? (BASE_URL . '/images/general/index/modernDesigns.jpg');
                    $createdAt = isset($post['created_at']) ? date('M d, Y', strtotime($post['created_at'])) : '';
                ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                        <?php if ($coverImage): ?>
                            <img src="<?php echo htmlspecialchars($coverImage); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($title); ?>" style="height: 220px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column p-4">
                            <?php if ($createdAt): ?>
                                <div class="text-muted small mb-2"><i class="bi bi-calendar3 me-1"></i><?php echo htmlspecialchars($createdAt); ?></div>
                            <?php endif; ?>
                            <h5 class="card-title fw-bold text-dark mb-3"><?php echo htmlspecialchars($title); ?></h5>
                            <p class="card-text text-secondary flex-grow-1"><?php echo htmlspecialchars($excerpt); ?></p>
                            <div class="mt-3">
                                <a href="<?php echo BASE_URL; ?>/views/blog-detail.php?slug=<?php echo urlencode($slug); ?>" class="btn btn-outline-dark rounded-pill px-4">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
