<?php 

  require_once '../controllers/DbController.php';
  include_once '../controllers/UserController.php';

  $UserCookie = login($_COOKIE['login'], $_COOKIE['password']);
   if($UserCookie) 
    return header('Location: admin/');


 if(isset($_POST['login']) && isset($_POST['password'])) {
     $result = login($_POST['login'], $_POST['password']);
     
     if($result){
        setcookie('login', $_POST['login'], time() + 24 * 60 * 60, "/");
        setcookie('password', $_POST['password'], time() + 24 * 60 * 60, "/");
        return header('Location: admin/');
      }
     else{
        return header('Location: auth.php?error=Error auth');
      }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="https://divan-technologies.ru/favicon.ico"/>

    <title>Authorization | Divan Solution</title>

    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <link href="../css/main.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" action="auth.php" method="POST">
      <h1 class="h3 mb-4 font-weight-normal">Log in</h1>
      
      <label for="inputLogin" class="sr-only">Username</label>
      <input type="login" name="login" id="inputLogin" class="form-control" placeholder="Username" required autofocus>

      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" name="password" id="inputPassword" class="form-control mb-10" placeholder="Password" required>

      <h1 class="h3 mb-3 font-weight-normal"><?php echo $result; ?></h1>

      <button class="btn btn-lg btn-primary btn-block" type="submit" >Log in</button>
      <p class="mt-5 mb-3 text-muted">Divan Technologies &copy; 2022</p>
    </form>
  </body>
</html>
