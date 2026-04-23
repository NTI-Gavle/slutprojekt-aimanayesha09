<?php


require_once '../includes/functions.php';

logoutUser();
setFlashMessage('success', 'Du har loggats ut.');
redirect('index.php');