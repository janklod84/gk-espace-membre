<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Espace membre</title>

    <link href="css/app.css" rel="stylesheet">

  </head>

  <body>

    <nav class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Espace membre</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">

            <?php if(isset($_SESSION['auth'])): ?>

              <li><a href="logout.php">Se deconnecter</a></li>

            <?php else: ?>

              <li><a href="register.php">S'inscrire</a></li>
              <li><a href="login.php">Se connecter</a></li>

            <?php endif; ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

       <?php if(Session::getInstance()->hasFlashes()): ?>
          <?php foreach(Session::getInstance()->getFlashes() as $type => $message): ?>
             <div class="alert alert-<?= $type; ?>">
                 <?= $message; ?>
             </div>
          <?php endforeach; ?>
       <?php endif; ?>
