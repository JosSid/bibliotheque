<?php
    session_start();
    if($_POST){
        if(($_POST['username']=='jossid')&&($_POST['password']=="1234"))
{
    $_SESSION['user']="ok";
    $_SESSION['username']="Jossid";
    header('Location:inicio.php');
} else {
    $message="ERROR: username or password not correct";
}
        
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      
   <div class="container">
    <div class="row mt-5">

    <div class="col-md-4">
        
    </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Login
                </div>
                <div class="card-body">
                    <?php if(isset($message)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $message; ?>
                    </div>
                    <?php } ?>
                    <form  method="POST">
                    <div class = "form-group">
                    <label for="username">User</label>
                    <input type="text" class="form-control" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                    
                    
                </div>

            </div>
        </div>
        
    </div>
   </div>
  </body>
</html>