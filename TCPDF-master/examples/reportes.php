<?php

include("../../config.php");

$empresa = $_GET["empresa"];

$sql = " SELECT ar.numero,ar.nombre, ar.descripcion, 
                    ear.cumple, ear.respaldo, ear.sancion, ear.plazo, ear.sancion_final, ear.id,
                    ear.boolcumple, ear.boolrespaldo, ear.boolsancion, ear.boolplazo, ear.boolsancion_final, em.nombre as emNom
             FROM EMPRESA_ARTICULOS AS ear 
                INNER JOIN ARTICULOS AS ar 
                  ON ar.id = ear.id_articulo
                INNER JOIN EMPRESAS AS em
                  ON em.id = ear.id_empresa 
                
             WHERE ear.activo = 1 
             AND ear.id_empresa = $empresa

             ORDER BY ar.numero; ";
    
    $arrInfo = array(); 

    $resultado = $connection->query($sql);
    
    $intCantArt = 0;
    $intPorcentajeTotal = 0;
    $strEmpresa = "";

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
      $strEmpresa = $reg["emNom"];
    }

   

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('UMG');
$pdf->SetTitle('Reporte Articulos Convenio Budapest');
$pdf->SetSubject('Convenio Budapest');
$pdf->SetKeywords('Budapest, PDF, convenio');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 12);


$pdf->AddPage();

$pdf->Image('https://adep2011.files.wordpress.com/2011/09/logoumg.png', 170, 10, 30, 30, 'PNG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
$pdf->Image('http://nic.ar/sites/default/files/styles/max_325x325/public/2017-12/ConvenioDeBudapest-NOTA.png?itok=h5jECdPu', 15, 10, 80, 40, 'PNG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

$horizontal_alignments = array('L', 'C', 'R');
$vertical_alignments = array('T', 'M', 'B');

$x = 15;
$y = 35;
$w = 30;
$h = 30;

// set some text to print
$html = '<br><br><br><div style="text-align: center;"><span><h2>Reporte de seguimiento articulos convenio de budapest</h2></span></div>
<table border="1" style="border-collapse: collapse; width: 100%;">
<tbody>
<tr>
<td style="width: 25%; color:#fff; background-color:#4e73df;">Articulo</td>
<td style="width: 12%; color:#fff; background-color:#4e73df;">Cumple</td>
<td style="width: 10%; color:#fff; background-color:#4e73df;">Respaldo</td>
<td style="width: 10%; color:#fff; background-color:#4e73df;">Sancion</td>
<td style="width: 10%; color:#fff; background-color:#4e73df;">Plazo</td>
<td style="width: 20%; color:#fff; background-color:#4e73df;">Sancion Final</td>
<td style="width: 12%; color:#fff; background-color:#4e73df;">Porcentaje</td>
</tr>';

foreach($arrInfo as $key => $value){
 

  $porcentaje = $value["porcentaje"] * 100;

  $html.= "<tr><td>".$value["nombre"]."</td><td>".$value["cumple"]."</td><td>".$value["respaldo"]."</td><td>".$value["sancion"]."</td><td>".$value["plazo"]."</td><td>".$value["sancion_final"]."</td><td>".$porcentaje."</td></tr>";
   
}

$intPorcentajeTotal = $intCantArt/48 * 100;
$intPorcentajeTotal = number_format($intPorcentajeTotal, 2);


$html.='
</tbody>
</table>
<p><br /><strong></strong></p>
<p>Con base al ingreso de informacion generada con la herramienta web, da como resultado que de 48 articulos aplicables con el convenio de budapest la empresa '.$strEmpresa.' ha registrado '.$intCantArt.' articulos dando un porcentaje de '.$intPorcentajeTotal.'% de cumplimiento.</p>
<p>Atentamente,</p>
<p>_______________________________</p>
<p>Ing. Ana Lilian Estevez</p>
<p>Equipo Consultor</p>
<p><strong>Auditoria de TI</strong></p>
<p><strong></strong></p>
<p>_______________________________</p>
<p>Ing. Roberto Portillo</p>
<p>Equipo Consultor</p>
<p><strong>Auditoria de TI</strong></p>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_002.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
