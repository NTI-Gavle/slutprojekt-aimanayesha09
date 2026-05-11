<?php
function startSession(){
    if (session_status() === PHP_SESSION_NONE){
        session_start();
    }
}
function isLoggedIn(){
startSession();
return isset($_SESSION['user_id']);
}
function getCurrentUser() {
    startSession();
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'is_admin' => $_SESSION['is_admin'] ?? false
        ];
    }
    return null;
}

function loginUser($user) {
    startSession();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['is_admin'] = $user['is_admin'];
}

function logoutUser() {
    startSession();
    session_unset();
    session_destroy();
}

function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function formatDate($dateString) {
    $date = new DateTime($dateString);
    return $date->format('j M Y, H:i');
}

function setFlashMessage($type, $message) {
    startSession();
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function getFlashMessage() {
    startSession();
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function redirect($url) {
    header("Location: $url");
    exit;
}