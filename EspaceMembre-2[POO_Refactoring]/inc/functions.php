<?php 


function debug($variable, $die = false)
{
	echo '<pre>'. print_r($variable, true) . '</pre>';
	if($die) die;
}

function dump($variable, $die = false)
{
	echo '<pre>';
	var_dump($variable);
	echo '</pre>';
	if($die) die;
}



/**
 * Permet de reconnecte l'utilisateur automatiquement
 * 
**/
function reconnect_from_cookie()
{
    

	if(isset($_COOKIE['remember']) && !isset($_SESSION['auth']))
	{

		require_once 'db.php';
        
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