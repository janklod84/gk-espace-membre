<?php 
session_start();

require_once 'inc/functions.php';

/**
 * Laragon:
 * Email: D:\laragon\bin\sendmail\output
**/


if(!empty($_POST))
{

	  require_once 'inc/db.php';

	  // VALIDATION
	  $errors = [];


      if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username']))
      {
      	  $errors['username'] = "Votre pseudo n'est pas valide (alphanumerique)";

      }else{

      	 // On verifie si ce email existe deja [UNIQUE]
      	 $req = $pdo->prepare("SELECT id FROM users WHERE username = ?");
      	 $req->execute([
      	 	$_POST['username']
      	 ]);

      	 $user = $req->fetch();

      	 if($user)
      	 {
      	 	  $errors['username'] = 'Ce pseudo est deja pris';
      	 }

      }


      if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
      {
      	    $errors['email'] = "Votre email n'est pas valide";

      }else{

      	 // On verifie si ce email existe deja [UNIQUE]
      	 $req = $pdo->prepare("SELECT id FROM users WHERE email = ?");
      	 $req->execute([
      	 	$_POST['email']
      	 ]);

      	 $user = $req->fetch();

      	 if($user)
      	 {
      	 	  $errors['email'] = 'Ce email est deja utilise pour un autre compte';
      	 }

      }


      if(empty($_POST['password']) || ($_POST['password'] != $_POST['password_confirm']))
      {
      	   $errors['password'] = "Vous devez rentrer un mot de passe valide";
      }


      // INSERER UTILISATEUR S'IL n'y a pas d'erreurs
      if(empty($errors))
      {
           $req = $pdo->prepare("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?");
           $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

           $token = str_random(60); // la fonction str_random() se trouve dans functions.php
           
           // debug($token, true);

           $req->execute([
               $_POST['username'],
               $password,
               $_POST['email'],
               $token
           ]);
           
           // renvoit le dernier id genere par PDO
           $user_id = $pdo->lastInsertId();
           
           // a changer par un vrai lien quand on est en production
           $lien_confirmation = "http://web.loc/confirm.php?id=$user_id&token=$token";

           mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\n$lien_confirmation");
           
           $_SESSION['flash']['success'] = 'Un email de confirmation vous a ete envoye pour valider votre compte';

           header('Location: login.php');
           exit();
           // die("Notre compte a bien ete cree");
      }
      
      // debug($errors);
}

require __DIR__.'/inc/header.php';

?>

<h1>S'inscrire</h1>

<?php if(!empty($errors)): ?>
 <div class="alert alert-danger">
	<p>Vous n'avez pas rempli le formulaire correctement</p>
	<ul>
		<?php foreach($errors as $error): ?>
           <li><?= $error; ?></li>
	    <?php endforeach; ?>
	</ul>
 </div>
<?php endif; ?>

<form action="" method="POST">
	
	<div class="form-group">
		<label for="">Pseudo</label>
		<input type="text" name="username" class="form-control">
	</div>

    <div class="form-group">
		<label for="">Email</label>
		<input type="text" name="email" class="form-control">
	</div>

	<div class="form-group">
		<label for="">Mot de passe</label>
		<input type="password" name="password" class="form-control">
	</div>

	<div class="form-group">
		<label for="">Confirmez votre mot de passe</label>
		<input type="password" name="password_confirm" class="form-control">
	</div>
     
    <button type="submit" class="btn btn-primary">M'inscrire</button>
</form>

<?php 
require __DIR__.'/inc/footer.php';
?>