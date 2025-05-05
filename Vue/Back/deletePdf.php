<?php
require_once "../../Controller/pdfC.php";

$pdf = new PdfC();

$pdf->deletePdfs($_GET["id_pdf"]);
echo "<script>window.location='Aafficherpdf.php';</script>";
exit();
//header('Location:read.php');
?>