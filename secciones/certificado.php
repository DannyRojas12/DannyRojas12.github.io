<?php
require ('../librerias/fpdf/fpdf.php');
include_once '../configuraciones/bd.php';
$conexionBD=BD::crearInstancia();


function agregarTexto($pdf,$texto,$x,$y,$align='L',$fuente,$size=10,$r=0,$g=0,$b=0){
    $pdf->SetFont($fuente,'',$size);
    $pdf->SetXY($x,$y);
    $pdf->SetTextColor($r,$g,$b);
    $pdf->Cell(0,10,$texto,0,0,$align);
   
}

function agregarImagen($pdf,$image,$x,$y){
    $pdf->Image($image,$x,$y,0);
}

$id_curso=isset($_GET['id_curso'])?$_GET['id_curso']:'';
$id_alumno=isset($_GET['id_alumno'])?$_GET['id_alumno']:'';

$sql="SELECT alumnos.nombre, alumnos.apellidos, cursos.nombre_curso  
FROM alumnos, cursos WHERE alumnos.id=:id_alumno AND cursos.id=:id_curso";

        $consulta=$conexionBD->prepare($sql);
        $consulta->bindParam(':id_alumno',$id_alumno);
        $consulta->bindParam(':id_curso',$id_curso);
        $consulta->execute();
        $alumno=$consulta->fetch(PDO::FETCH_ASSOC);


$pdf=new FPDF("L","mm",array(254,194));
$pdf->AddPage();
$pdf->SetFont("Arial","B",16);
agregarImagen($pdf,"../src/certificado_.jpg",0,0);
agregarTexto($pdf,ucwords(utf8_decode($alumno['nombre']." ".$alumno['apellidos'])),68,59,'L',"Helvetica",30,0,0,0);
agregarTexto($pdf,$alumno['nombre_curso'],10,85,'C',"Helvetica",30,0,0,0);
$pdf->Output();



?>