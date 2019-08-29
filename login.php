<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <?php

    include("config.php");

    session_start();

    unset($_SESSION['ID']);
    unset($_SESSION['EMPRESA']);
    unset($_SESSION['ROL']);



    if(isset($_POST["txtUser"])){
      $strUser = $_POST["txtUser"];
      $strPass = $_POST["txtPass"];

      $sql = "SELECT USUARIOS.ID, EM.ID_EMPRESA, USUARIOS.TIPO 
              FROM USUARIOS 
              INNER JOIN EMPRESA_USUARIOS AS EM 
                ON EM.ID_USUARIO = USUARIOS.ID  
              WHERE USUARIOS.NOMBRE = '".$strUser."' 
              AND PASSWORD = '".$strPass."'";

      $resultado = $connection->query($sql);

      $loggin = $resultado->fetch_assoc();

      if(isset($loggin["ID"])){
        $_SESSION['ID'] = $loggin["ID"];
        $_SESSION['EMPRESA'] = $loggin["ID_EMPRESA"];
        $_SESSION['ROL'] = $loggin["TIPO"];
        ?>
        <script>
          location.href ="dashboard.php";
        </script>
        <?php
      }
    }


  ?>

<script>
    

  function fntLogin() {
    var strUser = document.getElementById("txtUser").value;
    var strPass = document.getElementById("txtPass").value;

    if(strUser == "" || strPass == ""){
      alert("Debe de llenar todos los campos");
    }
    else{
      document.getElementById("frmLogin").submit();  
    }
  }

</script>

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12 d-none d-lg-block"></div>
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Bienvenido!</h1>
                  </div>
                  <form class="user" id="frmLogin" name="frmLogin" method="POST" action="login.php" >
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="txtUser" name="txtUser" aria-describedby="emailHelp" placeholder="Ingresar usuario...">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="txtPass" name="txtPass" placeholder="Contrase&ntilde;a">
                    </div>
                    
                    <a onclick="fntLogin();" class="btn btn-primary btn-user btn-block" style="color:#fff;">
                      Iniciar sesion
                    </a>
                    
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.html">Olvide mi contrase&ntilde;a</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.html">Crear un usuario!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
