<?php

$pageTitle = 'Registrera';
require_once '../includes/header.php';
require_once '../database/user_queries.php';

if (isLoggedIn()) {
    redirect('index.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($username) || empty($password) || empty($confirmPassword)) {
        $error = 'Fyll i alla fält.';
    } elseif (strlen($username) < 3) {
        $error = 'Användarnamnet måste vara minst 3 tecken.';
    } elseif (strlen($password) < 4) {
        $error = 'Lösenordet måste vara minst 4 tecken.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Lösenorden matchar inte.';
    } else {
        if (createUser($username, $password)) {
            $user = verifyLogin($username, $password);
            if ($user) {
                loginUser($user);
                setFlashMessage('success', 'Välkommen till Mini Forum!');
                redirect('index.php');
            }
        } else {
            $error = 'Användarnamnet är redan taget.';
        }
    }
}
?>

<?php include '../includes/nav.php'; ?>

<main>
    <div class="container">
        <div class="form-container">
            <div class="card">
                <h1 class="card-title" style="text-align: center; margin-bottom: 10px;">Registrera konto</h1>
                <p style="text-align: center; color: var(--text-light); margin-bottom: 25px;">
                    Skapa ett konto för att delta i forumet
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
                            placeholder="Välj ett användarnamn"
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
                            placeholder="Välj ett lösenord"
                            required
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Bekräfta lösenord</label>
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            class="form-control"
                            placeholder="Upprepa lösenordet"
                            required
                        >
                    </div>
                    
                    <button type="submit" class="btn btn-primary form-submit">
                        Registrera
                    </button>
                </form>
                
                <div class="form-footer">
                    Har du redan ett konto? <a href="login.php">Logga in</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>