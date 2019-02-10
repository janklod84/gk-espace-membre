<?php 
require_once 'inc/bootstrap.php';


//  Piste d'amelioration en faisant if($request->has(['id', 'token'])){}
if(isset($_GET['id']) && isset($_GET['token']))
{
     $auth = App::getAuth();
     $db = App::getDatabase();
     $user = $auth->checkResetToken($db, $_GET['id'], $_GET['token']);


     if($user)
     {  
           
          // Piste d'amelioration en faisant if($request->isPost()){}
          if(!empty($_POST))
          {

              $validator = new Validator($_POST);
              $validator->isConfirmed('password');

              if($validator->isValid())
              {
                  $password = $auth->hashPassword($_POST['password']);

          	    	$db->query('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL WHERE id = ?', [$password, $_GET['id']]);

                    Session::getInstance()->setFlash('success', 'Votre mot de passe a bien ete modifie');
                    $auth->connect($user);
                    App::redirect('account.php');

          	    }
          }


     }else{
         
         Session::getInstance()->setFlash('danger', "Ce token n'est pas valide");
         App::redirect('login.php');
     }


}else{

  App::redirect('login.php');

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