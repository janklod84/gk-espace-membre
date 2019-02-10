<?php 
/**
 * password_verify() retourne boolean
 * On verifie le password qui est entree et celui qui a ete stocke en base de donnee
**/

require_once('inc/functions.php');

reconnect_from_cookie(); // inc/functions.php

if(isset($_SESSION['auth']))
{
	 header('Location: account.php');
     exit();
}

if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password']))
{
	  require_once 'inc/db.php';

	  $req = $pdo->prepare('SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL');
	  $req->execute(['username' => $_POST['username']]);
	  $user = $req->fetch();
      
      // debug($user, true);

  	  if($user && password_verify($_POST['password'], $user->password))
      {
            $_SESSION['auth'] = $user;
            $_SESSION['flash']['success'] = "Vous etes maintenant connecte";
            
            if($_POST['remember'])
            {
            	$remember_token = str_random(250);
                $pdo->prepare('UPDATE users SET remember_token = ? WHERE id = ?')
                    ->execute([$remember_token, $user->id]);

                setcookie('remember', $user->id .'=='. $remember_token . sha1($user->id . 'unmotarbitraire'), time() + 60 * 60 * 24 * 7);
            }


            header('Location: account.php');
            exit();

      }else{

      	  $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrecte';
      }

}

require __DIR__.'/inc/header.php';
?>



<h1>Se connecter</h1>

<form action="" method="POST">
	
	<div class="form-group">
		<label for="">Pseudo ou email</label>
		<input type="text" name="username" class="form-control">
	</div>

	<div class="form-group">
		<label for="">
			Mot de passe 
			<a href="forget.php">(J'ai oublie mon mot de passe)</a>
		</label>
		<input type="password" name="password" class="form-control">
	</div>

	<div class="form-group">
		<label>
			<input type="checkbox" name="remember" value="1" /> Se souvenir de moi
		</label>
	</div>
     
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>
<!-- le fichier forget.php peut etre appele remember.php -->

<?php 
require __DIR__.'/inc/footer.php';
?>