<?php 


function debug($variable, $die = false)
{
	echo '<pre>'. print_r($variable, true) . '</pre>';
	if($die) die;
}

/**
 * Chiffres de 0 - 9
 * Toutes les chaines de caracteres du clavier minuscule et majuscule
 * str_repeat() pour repeter $length = 60 fois la chaine $alphabet
 * str_shuffle() pour melanger le resultat
 * substr() pour limiter la taille de 0 a la taille $length demander 60
**/

function str_random($length)
{
	// return sha1(uniqid());
	$alphabet = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
	return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}



function logged_only()
{
	if(session_status() == PHP_SESSION_NONE)
    {
          session_start();
    }
    
	if(!isset($_SESSION['auth']))
    {
		$_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'acceder a cette page";
	    header('Location: login.php');
	    exit();
   }
}


/**
 * Permet de reconnecte l'utilisateur automatiquement
 * 
**/
function reconnect_from_cookie()
{
    
    if(session_status() == PHP_SESSION_NONE)
    {
          session_start();
    }


    // on verifie s'il est definit cookie 'remember' 
    // et que si l'utilisateur est deja connecte
	if(isset($_COOKIE['remember']) && !isset($_SESSION['auth']))
	{

		require_once 'db.php';
        
        // la variable n'etant pas accessible depuis le require_once
        // donc charge $pdo depuis le namespace global 
	    if(!isset($pdo))
	    {
	    	global $pdo;
	    }

		// var_dump($_COOKIE['remember']);
		$remember_token = $_COOKIE['remember'];
		$parts = explode('==', $remember_token);
		$user_id = $parts[0];
		$req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
		$req->execute([$user_id]);
	    $user = $req->fetch();

		if($user)
		{
			 $expected = $user_id .'=='. $user->remember_token . sha1($user_id . 'unmotarbitraire');

			 if($expected === $remember_token)
			 {
			 	  // reconnection automatique
			 	  // die('reco automatique');
	               session_start();
			 	   $_SESSION['auth'] = $user;
                   
                   // pour annule le message flash 
                   // il suffit de faire $_SESSION['flash'] = [] cad dire vider
			 	   // reste connecte sur les 7 jours
			 	   setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);

	               // on ne le redirige pas , mais on le laisse sur la page ou il etait
	               // header('Location: account.php');

			 }else{

			 	setcookie('remember', null, -1);

			 }

		} else {

			setcookie('remember', null, -1);
		}

	}
}