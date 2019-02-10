<?php 
require_once 'inc/bootstrap.php';

// $auth = new Auth(['restriction_msg' => 'Lol tu es bloque']);

App::getAuth()->restrict();

if(!empty($_POST))
{
     
      if(empty($_POST['password']) || ($_POST['password'] != $_POST['password_confirm']))
      {
      	   $_SESSION['flash']['danger'] = "Les mots de passes ne correspondent pas";

      }else{

      	  $user_id = $_SESSION['auth']->id;
      	  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

      	  require_once 'inc/db.php';
      	  $req = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
      	  $req->execute([$password, $user_id]);
      	  $_SESSION['flash']['success'] = "Votre mot de passe a bien ete mise a jour";
      }
}

require __DIR__.'/inc/header.php';
?>

<h1>Bonjour, <?= $_SESSION['auth']->username; ?></h1>

<form action="" method="post">
	
	<div class="form-group">
		<input type="password" name="password" placeholder="Changer de mot de passe" class="form-control">
	</div>
	<div class="form-group">
		<input type="password" name="password_confirm" placeholder="Confirmation du mot de passe" class="form-control">
	</div>
    
    <button class="btn btn-primary">Changer mon mot de passe</button>
</form>

<?php 
require __DIR__.'/inc/footer.php';
?>