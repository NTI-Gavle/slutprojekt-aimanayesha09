<?php
require_once __DIR__ . '/db.php';
function getUserByUsername($username) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch();
}

function getUserById($id) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function createUser($username, $password) {
    $db = getDB();
    
    if (getUserByUsername($username)) {
        return false;
    }
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    return $stmt->execute([$username, $hashedPassword]);
}

function verifyLogin($username, $password) {
    $user = getUserByUsername($username);
    
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}

function getAllPosts() {
    $db = getDB();
    $stmt = $db->query("
        SELECT posts.*, users.username 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        ORDER BY posts.created_at DESC
    ");
    return $stmt->fetchAll();
}

function createPost($userId, $content) {
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
    return $stmt->execute([$userId, $content]);
}

function deletePost($postId, $userId, $isAdmin) {
    $db = getDB();
    
    $stmt = $db->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$postId]);
    $post = $stmt->fetch();
    
    if (!$post) {
        return false;
    }
    
    if ($post['user_id'] != $userId && !$isAdmin) {
        return false;
    }
    
    $stmt = $db->prepare("DELETE FROM posts WHERE id = ?");
    return $stmt->execute([$postId]);
}

