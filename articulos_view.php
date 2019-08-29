<?php

session_start();

include("config.php");
$intEmpresa = $_SESSION["EMPRESA"];
$intUsuario = $_SESSION["ID"];
$intRol = $_SESSION["ROL"];

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

             ORDER BY ar.numero; ";

    $resultado = $connection->query($sql);

    

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
        <div class="sidebar-brand-text mx-3">ARTICULOS INGRESADOS</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item ">
        <a class="nav-link" href="dashboard.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <?php if($intRol === 1){

?>
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
      <?php }?>
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading ">
        Articulos
      </div>

      <li class="nav-item ">
        <a class="nav-link" href="articulos.php">
          <i class="fas fa-fw fa-clipboard-list"></i>
          <span>Ver Articulos</span></a>
      </li>
      <?php if($intRol < 3){

?>
      <li class="nav-item">
        <a class="nav-link" href="empresa_articulos.php">
          <i class="fas fa-fw fa-edit"></i>
          <span>Ingresar Articulos</span></a>
      </li>
      <?php } ?>
      <li class="nav-item active">
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

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Articulos</h1>
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Convenio de Budapest</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Numero</th>
                      <th>Nombre</th>
                      <th>Cumple</th>
                      <th>Respaldo</th>
                      <th>Sancion</th>
                      <th>Plazo</th>
                      <th>Sancion final</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      while($reg = $resultado->fetch_assoc()){

                        $boolcumple = $reg["boolcumple"];
                        $boolrespaldo = $reg["boolrespaldo"];
                        $boolsancion = $reg["boolsancion"];
                        $boolplazo = $reg["boolplazo"];
                        $boolsancion_final = $reg["boolsancion_final"];

                        print "<tr><td>".$reg["numero"]."</td><td>".$reg["nombre"]."</td><td>".$reg["cumple"]."</td><td>".$reg["respaldo"]."</td><td>".$reg["sancion"]."</td><td>".$reg["plazo"]."</td><td>".$reg["sancion_final"]."</td></tr>";
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

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

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
