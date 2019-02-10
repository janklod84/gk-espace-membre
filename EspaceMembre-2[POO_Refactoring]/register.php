<?php 
require_once 'inc/bootstrap.php';


// Je veux recuperer le premier utilisateur


if(!empty($_POST))
{

	    $errors = [];

      $db = App::getDatabase();
      $validator = new Validator($_POST);
      $validator->isAlpha('username', "Votre pseudo n'est pas valide (alphanumerique)");

      if($validator->isValid())
      {
          $validator->isUniq('username', $db, 'users', 'Ce pseudo est deja pris');
      }
      
      $validator->isEmail('email', "Votre email n'est pas valide");
      
      if($validator->isValid())
      {
          $validator->isUniq('email', $db, 'users', 'Ce email est deja utilise pour un autre compte');
      }

      $validator->isConfirmed('password', 'Vous devez rentrer un mot de passe valide');
      

      if($validator->isValid())
      {

           App::getAuth()->register($db, $_POST['username'], $_POST['password'], $_POST['email']);
           
           Session::getInstance()->setFlash('success', 'Un email de confirmation vous a ete envoye pour valider votre compte');

           App::redirect('login.php');
         
      } else {

           $errors = $validator->getErrors();
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