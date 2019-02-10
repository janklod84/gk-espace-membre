<?php 
session_start();

require 'inc/db.php';

$user_id = $_GET['id'];
$token   = $_GET['token'];


$req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$req->execute([$user_id]);
$user = $req->fetch();

if($user && $user->confirmation_token == $token)
{
    // die('OK');

    // On connecte directement l'utilisateur

    $req = $pdo->prepare("UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?");
    $req->execute([$user_id]);
    $_SESSION['auth'] = $user;
    $_SESSION['flash']['success'] = 'Votre compte a bien ete valide!';
    header('Location: account.php');
    exit();

}else{

	// die('Pas OK');

	// Message flash
	$_SESSION['flash']['danger'] =  "Ce token n'est plus valide";

	header('Location: login.php');
	exit();
}