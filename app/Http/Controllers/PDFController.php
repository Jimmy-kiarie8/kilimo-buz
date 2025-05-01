<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
//use Fpdf;
use Modules\Usermanagement\Entities\Profile;
use Modules\Institution\Entities\Institution;
class PDFController extends Controller
{
    //
    public function generatePDF()
    {
        $text="Text";
        $model=Institution::find(12);

     $id_no =$model->emp_idno;
	 $client_names =$model->title.". ". $model->emp_name;
	$serialNo = "255255";
	$personalNo = $model->emp_personalno;
	$station = $model->emp_station;
	$Designation =$model->emp_designation;
	$tarehe = "2023-04-23";
	$experyDate = "2023-04-23";

    $date=date_create($tarehe);
    $approval_date= date_format($date,"d F Y");

    $date=date_create($experyDate);
    $experyDate= date_format($date,"d F Y");
    $imagePath = public_path('profiles/'.$model->emp_avatar); // Update with the correct path to your image 
  $filename=$id_no.'.png';


  \QrCode::size(300)
            ->format('png')
            ->generate('http://localhost/aridhisasa/public/'.$model->id_no, public_path('images/'.$filename));
            $qrpath=public_path('images/'.$filename);



        $pdf = new Fpdf('L', 'mm', 'A4');
        $pdf->AddPage('L', 'A4');
        $pdf->Image(public_path('img/idcards.png'), 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight(), 'PNG');
       $pdf->SetFont('Arial', 'B', 12);
        $pdf->Image($imagePath, 14, 65, 58, 0, $model->file_type);
       $pdf->SetTextColor(0, 0, 0); // Set text color (RGB values)
       $pdf->SetXY(80, 63); // Set position for text
       $pdf->Cell(0, 10, $client_names, 0, 1); // Add the text

       $pdf->SetXY(80, 80); // Set position for text
       $pdf->Cell(0, 10, $id_no, 0, 1); // Add the text

       $pdf->SetXY(80, 100); // Set position for text
       $pdf->Cell(0, 10, $personalNo, 0, 1); // Add the text

       $pdf->SetXY(80, 115); // Set position for text
       $pdf->Cell(0, 10, $station, 0, 1); // Add the text

       $pdf->SetXY(80, 132); // Set position for text
       $pdf->Cell(0, 10, $Designation, 0, 1); // Add the text


       $pdf->SetXY(12, 153); // Set position for text
       $pdf->Cell(0, 10, $approval_date, 0, 1); // Add the text


       $pdf->SetXY(12, 167); // Set position for text
       $pdf->Cell(0, 10, $experyDate, 0, 1); // Add the text
      

      $pdf->Image($qrpath, 90, 150, 25, 0, 'PNG');

        $pdf->SetXY(97, 179); // Set position for text
       $pdf->Cell(0, 10, $serialNo, 0, 1); // Add the text

       $pdf->SetXY(97, 179); // Set position for text
       $pdf->Cell(0, 10, $serialNo, 0, 1); // Add the text
       
       
       $pdf->Output();
        exit;
    }


    public function generateStaffID()
    {
        $text="Text";

        $model=Institution::find(12);

     $id_no =$model->emp_idno ;
   $Institution_Name =$model->Institution_Name;
  $serialNo = $model->cardno;
  $personalNo =$model->Id;
  
  $tarehe =$model->last_renewal_date;
  $experyDate = "2023-04-23";
     $imagePath = public_path('img/ppt.jpg'); // Update with the correct path to your image

     // Get the path to the image
    $bgpath = public_path('img/bg/bg.jpg');

     $imagePath = public_path('certTemp.png'); // Update with the correct path to your image 
  $filename=$id_no.'.png';
   

           // $qrpath=public_path('images/'.$filename);



    $date=date_create($tarehe);
    $approval_date= date_format($date,"d-M,Y");

    $date=date_create($experyDate);
    $experyDate= date_format($date,"d F Y");


        $pdf = new Fpdf('L', 'mm', 'A4');
        $pdf->AddPage('l', 'A4');
        $pdf->Image(public_path('certTemp.png'), 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight(), 'PNG');
       

        $pdf->SetFont('Helvetica', 'B', 25);

        $pdf->SetXY(82, 100); // Set position for text
       $pdf->Cell(0, 14, $Institution_Name, 0, 1); // Add the tex

        

       $pdf->SetFont('Helvetica', 'B', 26);
       $pdf->SetTextColor(0, 0, 0); // Set text color (RGB values)
       


       $pdf->SetFont('Helvetica', 'B', 18);
       $pdf->SetXY(65, 179.911199999988888); // Set position for text
       $pdf->Cell(10,10, $approval_date,5, 1); // Add the tex


       $pdf->SetFont('Helvetica', 'B', 18);
       $pdf->SetXY(228, 179.911199999988888); // Set position for text
       $pdf->Cell(10,10, $approval_date,5, 1); // Add the tex
       $pdf->Output('certs/'.$personalNo.".pdf",'i');
        exit;

    }
}
