<?php 

/**
 * password_verify() retourne boolean
 * On verifie le password qui est entree et celui qui a ete stocke en base de donnee
 * ici on peut verifier email avec filter_var()
**/

if(!empty($_POST) && !empty($_POST['email']))
{
	  require_once 'inc/db.php';
	  require_once('inc/functions.php');

	  session_start();

	  $req = $pdo->prepare('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL');
	  $req->execute([$_POST['email']]);
	  $user = $req->fetch();
      
      // debug($user, true);

  	  if($user)
      {
      	    // on genere un nouveau token
      	    $reset_token = str_random(60);
            $req = $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?');
            $req->execute([$reset_token, $user->id]);
            $_SESSION['flash']['success'] = "Les instructions du rappel de mot de passe vous ont ete envoyees par emails";

            $lien_reset = "http://web.loc/reset.php?id={$user->id}&token=$reset_token";

            mail($_POST['email'], 'Reinitialisation de votre mot de passe', "Afin de reinitialiser votre mot de passe cliquez sur ce lien\n\n$lien_reset");

            header('Location: login.php');
            exit();

      }else{

      	  $_SESSION['flash']['danger'] = 'Aucun compte ne correspond a cette addresse';
      }

}

require __DIR__.'/inc/header.php';
?>


<h1>Mot de passe oublie</h1>

<form action="" method="POST">
	
	<div class="form-group">
		<label for="">Email</label>
		<input type="email" name="email" class="form-control">
	</div>

    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>


<?php 
require __DIR__.'/inc/footer.php';
?>