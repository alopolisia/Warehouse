<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<link rel="stylesheet" href="libs/css/main.css" />
<link rel="stylesheet" href="/css/master.css">
<div class="page1">
    <div class="container-fluid">
        <div class="login-page">
            <div class="text-center">
               <h1>Bienvenido</h1>
               <p>Iniciar sesión </p>
             </div>
             <?php echo display_msg($msg); ?>
              <form method="post" action="auth.php" class="clearfix">
                <div class="form-group">
                      <label for="username" class="control-label">Usario</label>
                      <input type="name" class="form-control" name="username" placeholder="Usario">
                </div>
                <div class="form-group">
                    <label for="Password" class="control-label">Contraseña</label>
                    <input type="password" name= "password" class="form-control" placeholder="Contraseña">
                </div>
                <div class="form-group">
                        <button type="submit" class="btn btn-info  pull-right">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
