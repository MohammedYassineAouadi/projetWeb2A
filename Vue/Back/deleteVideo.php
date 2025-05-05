<?php
require_once "../../Controller/videoC.php";

$pdf = new VideoC();

$pdf->deleteVideo($_GET["id_video"]);
echo "<script>window.location='afficherVideo.php';</script>";
exit();
//header('Location:read.php');
?>