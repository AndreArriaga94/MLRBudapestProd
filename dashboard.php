<?php
   
  
   session_start();

    include("config.php");
   $intEmpresa = $_SESSION["EMPRESA"];
   $intRol = $_SESSION["ROL"];

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
    
    $arrInfo = array(); 

    $resultado = $connection->query($sql);
    
    $intCantArt = 0;
    $intPorcentajeTotal = 0;

    while($reg = $resultado->fetch_assoc()){
      $intCantArt++;
      $arrInfo[$reg["id"]]["id"] = $reg["id"];
      $arrInfo[$reg["id"]]["nombre"] = $reg["nombre"];
      $arrInfo[$reg["id"]]["descripcion"] = $reg["descripcion"];
      $arrInfo[$reg["id"]]["cumple"] = $reg["cumple"];
      $arrInfo[$reg["id"]]["respaldo"] = $reg["respaldo"];
      $arrInfo[$reg["id"]]["sancion"] = $reg["sancion"];
      $arrInfo[$reg["id"]]["plazo"] = $reg["plazo"];
      $arrInfo[$reg["id"]]["sancion_final"] = $reg["sancion_final"];

      $arrInfo[$reg["id"]]["boolcumple"] = $reg["boolcumple"];
      $arrInfo[$reg["id"]]["boolrespaldo"] = $reg["boolrespaldo"];
      $arrInfo[$reg["id"]]["boolsancion"] = $reg["boolsancion"];
      $arrInfo[$reg["id"]]["boolplazo"] = $reg["boolplazo"];
      $arrInfo[$reg["id"]]["boolsancion_final"] = $reg["boolsancion_final"];

      $porcentaje = intval($arrInfo[$reg["id"]]["boolsancion_final"]) + intval($arrInfo[$reg["id"]]["boolplazo"]) + intval($arrInfo[$reg["id"]]["boolsancion"]) + intval($arrInfo[$reg["id"]]["boolrespaldo"]) + intval($arrInfo[$reg["id"]]["boolcumple"]);


      $arrInfo[$reg["id"]]["porcentaje"] = $porcentaje / 5 ;
    }

    $intPorcentajeTotal = $intCantArt/48 * 100;
    $intPorcentajeTotal = number_format($intPorcentajeTotal, 2);

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Dashboard</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="dashboard.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <?php if(intval($intRol) === 1){

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

      <?php
      }
      ?>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Articulos
      </div>

      <li class="nav-item">
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

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="TCPDF-master/examples/reportes.php?empresa=<?php print $intEmpresa; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generar PDF</a>
            <a href="login.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Salir</a>
          </div>

          <!-- Content Row -->
          <div class="row">

            
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Articulos completados</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php print $intPorcentajeTotal ?>%</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: <?php print $intPorcentajeTotal ?>%" aria-valuenow="<?php print $intPorcentajeTotal ?>" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Articulos Pedientes</div>
                      <input type="hidden" name="cantArt" id="cantArt" value="<?php print $intCantArt; ?>">
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php print 48 - $intCantArt; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-check fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="row">

          

            <!-- Pie Chart -->
            <div class="col-lg-6">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Articulos ingresados vs no ingresados</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Ingresados
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> No Ingresados
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6 mb-4">

              <!-- Project Card Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Articulos ingresados</h6>
                </div>
                <div class="card-body">
                  <?php
                  
                  foreach($arrInfo as $key => $value){
 

                    $porcentaje = $value["porcentaje"] * 100;

                    print '<h4 class="small font-weight-bold">'.$value["nombre"].'<span class="float-right">'.$porcentaje.'%</span></h4>';

                    print '<div class="progress mb-4">';
                    print '<div class="progress-bar bg-info" role="progressbar" style="width: '.$porcentaje.'%" aria-valuenow="'.$porcentaje.'" aria-valuemin="0" aria-valuemax="100"></div>';
                    print '</div>';
                  
                    
                  }
                  
                  ?>

                  
                </div>
              </div>

              

            </div>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Content Column -->
            

            
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; UMG MARCO LEGAL Y REGULATORIO 2019</span>
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
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>

  <script>

    var cantIngresados = $("#cantArt").val() * 100 / 48;
    var cantNoIngresados = (48 - cantIngresados) * 100 / 48;

    cantIngresados = parseFloat(cantIngresados).toFixed(2);
    cantNoIngresados = parseFloat(cantNoIngresados).toFixed(2);
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    // Pie Chart Example
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["Ingresados", "No Ingresados"],
        datasets: [{
          data: [cantIngresados, cantNoIngresados],
          backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
          hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: false
        },
        cutoutPercentage: 80,
      },
    });
  </script>  

</body>

</html>
