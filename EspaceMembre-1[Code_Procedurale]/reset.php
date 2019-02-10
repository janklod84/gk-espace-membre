<?php 


/**
 * DATE_SUB(NOW(), INTERVAL 30 MINUTES)
 * On retranche dans -30 minutes dans la date actuelle
 * 
**/

if(isset($_GET['id']) && isset($_GET['token']))
{
	 require_once 'inc/db.php';
	 require_once 'inc/functions.php';

     $req = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
     $req->execute([$_GET['id'], $_GET['token']]);
     $user = $req->fetch();

     if($user)
     {  
         // debug($user);

          if(!empty($_POST))
          {
          	    if(!empty($_POST['password']) 
          	    	&& ($_POST['password'] == $_POST['password_confirm']))
          	    {
                    
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
          	    	$pdo->prepare('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL WHERE id = ?')
          	    	     ->execute([$password, $_GET['id']]);

                    session_start();

          	    	// message de success
          	    	$_SESSION['flash']['success'] = 'Votre mot de passe a bien ete modifie';
                    
                    // connection de l'utilisateur
                    $_SESSION['auth'] = $user;

                    // redirection de l'utilisateur a son compte
          	    	header('Location: account.php');
                    exit();

          	    }
          }


     }else{
         
         session_start();

         $_SESSION['flash']['danger'] = "Ce token n'est pas valide";
         header('Location: login.php');
         exit();

     }


}else{

	header('Location: login.php');
	exit();
}



require __DIR__.'/inc/header.php';
?>



<h1>Reinitialiser mon mot de passe</h1>

<form action="" method="POST">

	<div class="form-group">
		<label for="">Mot de passe</label>
		<input type="password" name="password" class="form-control">
	</div>

	<div class="form-group">
		<label for="">Confirmation du mot de passe</label>
		<input type="password" name="password_confirm" class="form-control">
	</div>
     
    <button type="submit" class="btn btn-primary">
       Reinitialiser mon mot de passe
    </button>
</form>

<?php 
require __DIR__.'/inc/footer.php';
?>