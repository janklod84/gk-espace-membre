<?php 
require_once 'inc/bootstrap.php';
App::getAuth()->logout();
Session::getInstance()->setFlash('success', 'Vous etes maintenant deconnecte');
App::redirect('login.php');
