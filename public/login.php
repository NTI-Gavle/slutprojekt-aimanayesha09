<?php
$pageTitle = 'Logga in';
require_once '../includes/header.php';
require_once '../database/user_queries.php';

if (isLoggedIn()) {
    redirect('index.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Fyll i alla fält.';
    } else {
        $user = verifyLogin($username, $password);
        if ($user) {
            loginUser($user);
            setFlashMessage('success', 'Välkommen tillbaka, ' . $user['username'] . '!');
            redirect('index.php');
        } else {
            $error = 'Fel användarnamn eller lösenord.';
        }
    }
}
?>

<?php include '../includes/nav.php'; ?>

<main>
    <div class="container">
        <div class="form-container">
            <div class="card">
                <h1 class="card-title" style="text-align: center; margin-bottom: 10px;">Logga in</h1>
                <p style="text-align: center; color: var(--text-light); margin-bottom: 25px;">
                    Logga in för att skapa och hantera inlägg
                </p>
                
                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username">Användarnamn</label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            class="form-control"
                            placeholder="Ditt användarnamn"
                            required
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Lösenord</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-control"
                            placeholder="Ditt lösenord"
                            required
                        >
                    </div>
                    
                    <button type="submit" class="btn btn-primary form-submit">
                        Logga in
                    </button>
                </form>
                
                <div class="form-footer">
                    Har du inget konto? <a href="register.php">Registrera dig</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>