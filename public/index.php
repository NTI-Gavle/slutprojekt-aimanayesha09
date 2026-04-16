<?php
$pageTitle = 'Flöde';
require_once '../includes/header.php';
require_once '../database/user_queries.php';

$currentUser = getCurrentUser();
$posts = getAllPosts();
$flash = getFlashMessage();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_post'])) {
    if (!isLoggedIn()) {
        redirect('login.php');
    }
    
    $content = sanitize($_POST['content'] ?? '');
    
    if (empty($content)) {
        setFlashMessage('error', 'Inlägget kan inte vara tomt.');
    } else {
        if (createPost($currentUser['id'], $content)) {
            setFlashMessage('success', 'Inlägget har skapats!');
        } else {
            setFlashMessage('error', 'Kunde inte skapa inlägget.');
        }
    }
    redirect('index.php');
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_post'])) {
    if (!isLoggedIn()) {
        redirect('login.php');
    }
    
    $postId = (int)($_POST['post_id'] ?? 0);
    
    if (deletePost($postId, $currentUser['id'], $currentUser['is_admin'])) {
        setFlashMessage('success', 'Inlägget har raderats!');
    } else {
        setFlashMessage('error', 'Kunde inte radera inlägget.');
    }
    redirect('index.php');
}
?>

<?php include '../includes/nav.php'; ?>

<main>
    <div class="container">
       
        <div class="clock-container">
            <canvas id="clockCanvas" width="300" height="90"></canvas>
        </div>
        
        <h1 class="page-title">Flöde</h1>
        
        <div class="posts-container">
            <?php if ($flash): ?>
                <div class="alert alert-<?php echo $flash['type']; ?>">
                    <?php echo $flash['message']; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($currentUser): ?>
                <div class="create-post-form">
                    <h3>Skapa nytt inlägg</h3>
                    <form method="POST" action="">
                        <div class="form-group">
                            <textarea 
                                name="content" 
                                class="form-control" 
                                placeholder="Vad vill du dela med dig av?"
                                rows="3"
                                required
                            ></textarea>
                        </div>
                        <button type="submit" name="create_post" class="btn btn-primary">
                            Skapa inlägg
                        </button>
                    </form>
                </div>
            <?php endif; ?>
            
            <?php if (empty($posts)): ?>
                <div class="empty-state">
                    <p>Inga inlägg ännu.</p>
                    <?php if (!$currentUser): ?>
                        <p><a href="login.php">Logga in</a> för att skapa det första inlägget!</p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post-card">
                        <div class="post-header">
                            <div class="post-author">
                                <div class="author-avatar">
                                    <?php echo strtoupper(substr($post['username'], 0, 1)); ?>
                                </div>
                                <span class="author-name"><?php echo sanitize($post['username']); ?></span>
                            </div>
                            <span class="post-date"><?php echo formatDate($post['created_at']); ?></span>
                        </div>
                        <div class="post-content">
                            <?php echo sanitize($post['content']); ?>
                        </div>
                        <?php if ($currentUser && ($currentUser['id'] == $post['user_id'] || $currentUser['is_admin'])): ?>
                            <div class="post-footer">
                                <form method="POST" action="" style="display: inline;">
                                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                    <button type="submit" name="delete_post" class="btn btn-danger btn-small delete-post-btn">
                                        Radera
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>