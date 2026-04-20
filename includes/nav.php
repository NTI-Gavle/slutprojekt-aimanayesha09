<?php
/**
 * Navigationsmeny
 */

// Se till att functions.php är laddad
require_once dirname(__DIR__) . '/includes/functions.php';

$currentUser = getCurrentUser();
?>
<nav class="navbar">
    <div class="container nav-container">
        <a href="index.php" class="logo">
            <span class="logo-icon">💬</span>
            <span>Mini Forum</span>
        </a>
        
        <div class="nav-links">
            <a href="index.php" class="nav-link">Flöde</a>
            <a href="about.php" class="nav-link">Om oss</a>
            <a href="contact.php" class="nav-link">Kontakt</a>
        </div>
        
        <div class="nav-auth">
            <?php if ($currentUser): ?>
                <span class="user-info">
                    Inloggad som: <strong><?php echo sanitize($currentUser['username']); ?></strong>
                    <?php if ($currentUser['is_admin']): ?>
                        <span class="admin-badge">(Admin)</span>
                    <?php endif; ?>
                </span>
                <a href="logout.php" class="btn btn-secondary">Logga ut</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-secondary">Logga in</a>
                <a href="registering.php" class="btn btn-primary">Registrera</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
