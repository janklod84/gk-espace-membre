<?php 

require_once 'inc/bootstrap.php';


if(!empty($_POST) && !empty($_POST['email']))
{
	
       $db = App::getDatabase();
       $auth = App::getAuth();
       $session = Session::getInstance();
       
       
       if($auth->resetPassword($db, $_POST['email']))
       {
           $session->setFlash('success', "Les instructions du rappel de mot de passe vous ont ete envoyees par emails");

           App::redirect('login.php');

       }else{

           $session->setFlash('danger', 'Aucun compte ne correspond a cette addresse');
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