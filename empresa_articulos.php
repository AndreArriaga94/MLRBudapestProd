<?php

session_start();

include("config.php");
$intEmpresa = $_SESSION["EMPRESA"];
$intUsuario = $_SESSION["ID"];
$intRol = $_SESSION["ROL"];

  if(isset($_POST["buscar"])){

    $arrInfo = array(); 

    $sql = " SELECT numero,nombre, descripcion FROM ARTICULOS  WHERE ACTIVO = 1 AND numero = ".$_POST["articulo"]." ORDER BY ID; ";

    $resultado = $connection->query($sql);

    while($reg = $resultado->fetch_assoc()){
      $arrInfo["descripcion"] = $reg["descripcion"];
    }

    $sql = " SELECT ar.numero,ar.nombre, ar.descripcion, 
                    ear.cumple, ear.respaldo, ear.sancion, ear.plazo, ear.sancion_final, ear.id,
                    ear.boolcumple, ear.boolrespaldo, ear.boolsancion, ear.boolplazo, ear.boolsancion_final
             FROM EMPRESA_ARTICULOS AS ear 
                INNER JOIN ARTICULOS AS ar 
                  ON ar.id = ear.id_articulo
                INNER JOIN EMPRESAS AS em
                  ON em.id = ear.id_empresa 
                
             WHERE ear.activo = 1 
             AND ear.id_empresa = $intEmpresa
             AND ar.numero = ".$_POST["articulo"]."  

             ORDER BY ar.numero; ";
    
    

    $resultado = $connection->query($sql);

    while($reg = $resultado->fetch_assoc()){
      $arrInfo["id"] = $reg["id"];
      $arrInfo["descripcion"] = $reg["descripcion"];
      $arrInfo["cumple"] = $reg["cumple"];
      $arrInfo["respaldo"] = $reg["respaldo"];
      $arrInfo["sancion"] = $reg["sancion"];
      $arrInfo["plazo"] = $reg["plazo"];
      $arrInfo["sancion_final"] = $reg["sancion_final"];

      $arrInfo["boolcumple"] = $reg["boolcumple"];
      $arrInfo["boolrespaldo"] = $reg["boolrespaldo"];
      $arrInfo["boolsancion"] = $reg["boolsancion"];
      $arrInfo["boolplazo"] = $reg["boolplazo"];
      $arrInfo["boolsancion_final"] = $reg["boolsancion_final"];

      $porcentaje = intval($arrInfo["boolsancion_final"]) + intval($arrInfo["boolplazo"]) + intval($arrInfo["boolsancion"]) + intval($arrInfo["boolrespaldo"]) + intval($arrInfo["boolcumple"]);


      $arrInfo["porcentaje"] = $porcentaje / 5 ;
    }

    print json_encode($arrInfo);

    die();
  }
  if(isset($_POST["guardar"]) && $_POST["guardar"] == "true"){

    

    $strCumple = $_POST["txtCumple"]; 
    $strSancion = $_POST["txtSancion"]; 
    $strRespaldo = $_POST["txtRespaldo"]; 
    $strPlazo = $_POST["txtPlazo"]; 
    $strSancionFinal = $_POST["txtSancionFinal"]; 


    $boolCumple = isset($_POST["chkCumple"]) ? 1:0; 
    $boolSancion = isset($_POST["chkSancion"]) ? 1:0; 
    $boolRespaldo = isset($_POST["chkRespaldo"]) ? 1:0; 
    $boolPlazo = isset($_POST["chkPlazo"]) ? 1:0; 
    $boolSancionFinal = isset($_POST["chkSancionFinal"]) ? 1:0; 

    $empresa = $intEmpresa;
    $articulo = $_POST["sltArticulo"];
    $usuario =  $intUsuario;

    if(isset($_POST["id"]) && intval($_POST["id"]) > 0){

      
      $sql = " UPDATE EMPRESA_ARTICULOS 
               SET CUMPLE = '$strCumple',
                   BOOLCUMPLE = $boolCumple,
                   RESPALDO = '$strRespaldo',
                   BOOLRESPALDO = $boolRespaldo,
                   SANCION = '$strSancion',
                   BOOLSANCION = $boolSancion,
                   PLAZO = '$strPlazo',
                   BOOLPLAZO = $boolPlazo,
                   SANCION_FINAL = '$strSancionFinal',
                   BOOLSANCION_FINAL = $boolSancionFinal,
                   MOD_USER = '$usuario',
                   MOD_FECHA = now() 
               WHERE ID = ".$_POST["id"];

      $connection->query($sql);

    }
    else{

      $sql = " INSERT INTO EMPRESA_ARTICULOS(ID_EMPRESA,ID_ARTICULO,CUMPLE,RESPALDO,SANCION,PLAZO,SANCION_FINAL,BOOLCUMPLE,BOOLRESPALDO,BOOLSANCION,BOOLPLAZO,BOOLSANCION_FINAL,ADD_USER,ADD_FECHA,ACTIVO)
               VALUES('$empresa','$articulo','$strCumple','$strRespaldo','$strSancion','$strPlazo','$strSancionFinal','$boolCumple','$boolRespaldo','$boolSancion','$boolPlazo','$boolSancionFinal','$usuario',now(),'1')";


      $connection->query($sql);

    }
  }
    
  ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Articulos</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <?php


    

    $sql = " SELECT numero,nombre, descripcion FROM ARTICULOS WHERE ACTIVO = 1 ORDER BY ID; ";

    $resArticulos = $connection->query($sql);

    

    

  ?>

  

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">INGRESO DE ARTICULOS</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item ">
        <a class="nav-link" href="dashboard.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Cuenta
      </div>

      <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-user"></i>
          <span>Informacion</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading ">
        Articulos
      </div>

      <li class="nav-item">
        <a class="nav-link" href="articulos.php">
          <i class="fas fa-fw fa-clipboard-list"></i>
          <span>Ver Articulos</span></a>
      </li>

      <li class="nav-item active">
        <a class="nav-link" href="empresa_articulos.php">
          <i class="fas fa-fw fa-edit"></i>
          <span>Ingresar Articulos</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="articulos_view.php">
          <i class="fas fa-fw fa-eye"></i>
          <span>Ver progreso Articulos</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Reportes
      </div>

      <li class="nav-item">
        <a class="nav-link" href="TCPDF-master/examples/reportes.php?empresa=<?php print $intEmpresa; ?>">
          <i class="fas fa-fw fa-chart-bar"></i>
          <span>Generar Reporte</span></a>
      </li>

      

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <br>

        <!-- Begin Page Content -->
        <div class="container-fluid">
        <form id="frmArtEmp" name="frmArtEmp" method="POST" action="empresa_articulos.php" >
          <!-- Page Heading -->
          <h1 class="h3 mb-1 text-gray-800">Configuracion de articulos</h1>
        
          <!-- Content Row -->
          <div class="row">

            <div class="col-lg-12">

            <!-- Dropdown No Arrow -->
            <div class="card mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Articulos</h6>
              </div>
              <div class="card-body">
                <select class="browser-default custom-select" id="sltArticulo" name="sltArticulo" onchange="fntSelectArticulo();">
                      <option value="0" selected> Seleccione un articulo... </option>
                      <?php
                        while($reg = $resArticulos->fetch_assoc()){
                          print "<option value='".$reg["numero"]."'>".$reg["nombre"]."</option>";
                        }
                      ?>
                </select>
              </div>
            </div>

             
              <div class="card mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Descripción</h6>
                </div>
                <div class="card-body" id="descripcion" name="descripcion">    
                </div>
              </div>

          </div> 
        </div>

        <div class="row">

          <div class="col-lg-6">      
              <!-- Progress Small -->
              <div class="card mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Progreso del articulo</h6>
                </div>
                <div class="card-body">
                  <input id="id" name="id" type="hidden">
                  <input id="guardar" name="guardar" type="hidden">
                  <div class="progress mb-4">
                    <div name="barArt" id="barArt" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
              
          </div>

          <div class="col-lg-6">
            <div class="card mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cumple</h6>
                  </div>
                  <div class="card-body">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <input id="chkCumple" name="chkCumple" type="checkbox" aria-label="Checkbox for following text input" >
                        </div>
                      </div>
                      <input id="txtCumple" name="txtCumple" type="text" class="form-control" aria-label="Text input with checkbox">
                    </div>      
                </div>
            </div>
          </div>
          
        </div>

        <div class="row">

          <div class="col-lg-6">
            <div class="card mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sancion</h6>
                  </div>
                  <div class="card-body">
                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <input id="chkSancion" name="chkSancion" type="checkbox" aria-label="Checkbox for following text input">
                        </div>
                      </div>
                      <input id="txtSancion" name="txtSancion" type="text" class="form-control" aria-label="Text input with checkbox">
                    </div>
                  </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="card mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Respaldo</h6>
                  </div>
                  <div class="card-body">
                    
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <input id="chkRespaldo" name="chkRespaldo" type="checkbox" aria-label="Checkbox for following text input">
                        </div>
                      </div>
                      <input id="txtRespaldo" name="txtRespaldo" type="text" class="form-control" aria-label="Text input with checkbox">
                    </div>

                  </div>
            </div>
          </div>
          
        </div>

        <div class="row">

          <div class="col-lg-6">
            <div class="card mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Plazo</h6>
                  </div>
                  <div class="card-body">
                    
                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <input id="chkPlazo" name="chkPlazo" type="checkbox" aria-label="Checkbox for following text input">
                        </div>
                      </div>
                      <input id="txtPlazo" name="txtPlazo" type="text" class="form-control" aria-label="Text input with checkbox">
                    </div>



                  </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="card mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sancion Final</h6>
                  </div>
                  <div class="card-body">
                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <input id="chkSancionFinal" name="chkSancionFinal" type="checkbox" aria-label="Checkbox for following text input">
                        </div>
                      </div>
                      <input id="txtSancionFinal" name="txtSancionFinal" type="text" class="form-control" aria-label="Text input with checkbox">
                    </div>
                  </div>
            </div>
          </div>
          
        </div>
        
        <div class="row">
          <div class="col-lg-12">

          <button onclick="fntGuardar();" class="btn btn-primary btn-lg btn-block">Guardar</button>

          </div>
      </div>

      </div>

        
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
                      </form >
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
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

  <script>

    function fntSelectArticulo(){
      $.ajax({
        type: "POST",
        url: "empresa_articulos.php",
        data: {
          buscar: 1,
          articulo: $("#sltArticulo").val(),
          dataType: "json"
        } ,
        success: function(data){
          info = JSON.parse(data);
          console.log(info);
          $("#id").val(info.id);
          $("#txtCumple").val(info.cumple);
          $("#txtRespaldo").val(info.respaldo);
          $("#txtSancion").val(info.sancion);
          $("#txtPlazo").val(info.plazo);
          $("#txtSancionFinal").val(info.sancion_final);

          if(parseInt(info.boolcumple) == 1){
            $("#chkCumple").prop('checked',true);
          }else{
            $("#chkCumple").prop('checked',false);
          }

          if(parseInt(info.boolrespaldo) == 1){
            $("#chkRespaldo").prop('checked',true);
          }else{
            $("#chkRespaldo").prop('checked',false);
          }

          if(parseInt(info.boolsancion) == 1){
            $("#chkSancion").prop('checked',true);
          }else{
            $("#chkSancion").prop('checked',false);
          }

          if(parseInt(info.boolplazo) == 1){
            $("#chkPlazo").prop('checked',true);
          }else{
            $("#chkPlazo").prop('checked',false);
          }

          if(parseInt(info.boolsancion_final) == 1){
            $("#chkSancionFinal").prop('checked',true);
          }else{
            $("#chkSancionFinal").prop('checked',false);
          }

          info.porcentaje = info.porcentaje * 100;
          
          $('#barArt').attr("aria-valuenow",info.porcentaje); 
          $('#barArt').attr("style","width:"+info.porcentaje+"%");  
          
          $("#descripcion").html(info.descripcion);
        }
      });
    }

    function fntGuardar(){
      $("#guardar").val("true");
    }
    
  </script>

</body>

</html>
