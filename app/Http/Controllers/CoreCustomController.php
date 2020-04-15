<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Session;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Excel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Illuminate\Support\Facades\URL;

use App\PageName;
use App\SiteSetting;

class CoreCustomController extends Facade {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    protected static function getFacadeAccessor() {
        //what you want
        return $this;
    }

    public static function storeID() 
    {
        return Auth::user()->store_id;
    }

    public static function storeName() 
    {
        return "Simpleretailpos";
    }

    public static function UserID() 
    {
        return 1;
    }    

    public static function admin_id() 
    {
        return 1;
    }

    public static function UserName() 
    {
        return 'Admin';
    }    

    public static function menuInfo()
    {

        $pageInfo=\DB::select('SELECT 
(SELECT a.module_status FROM our_history_page_infos AS a LIMIT 1) AS ourstory_status,
(SELECT a.module_status FROM reservations AS a LIMIT 1) AS reservations_status');
        
        return $pageInfo[0];


    }

    public static function SiteSetting()
    {

        $SiteSetting=SiteSetting::orderBy('id','DESC')->first();
        return $SiteSetting;


    }


    public static function getAvailableMenus(){
      $tab=PageName::select('name','route_link')->get();

      return $tab;
    }



    public static function ExcelLayout($excelArray=array())
    {

        
        Excel::create($excelArray['report_name'], function($excel) use($excelArray) {

            $excel->sheet(date('d-M-Y').'_'.time(), function($sheet) use($excelArray) {
        
                $alpha = array('A','B','C','D','E','F','G','H','I','J','K', 'L','M','N','O','P','Q','R','S','T','U','V','W','X ','Y','Z');

                $datacol=count($excelArray['data'][0]);

                $colSP=$alpha[$datacol-1]."1";


                $sheet->mergeCells('A1:'.$colSP);
                $sheet->setBorder('A1', 'thin');
                $sheet->cell('A1', function($cell) use ($excelArray) {
                    $cell->setValue($excelArray['report_title']);
                    //$cell->setBackground('#000000');
                   // $cell->setFontColor('#FFF');
                    $cell->setFontSize(16);
                    $cell->setFontWeight('bold');
                    //$cell->setBorder('solid', 'solid', 'solid', 'solid');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });

                $sheet->fromArray($excelArray['data']);
                //$sheet->setBorder('A1:F10', 'thin');

            });

        })->export('xlsx');


    }
    
    
    public static function PDFLayout($report_name,$table='')
    {
                $mpdf=new Mpdf;
                $mpdf->SetTitle($report_name);
                //$mpdf->SetDisplayMode('fullpage');
                //$mpdf->list_indent_first_level=0; // 1 or 0 - whether to indent the first level of a list
                // LOAD a stylesheet
                $stylesheet=file_get_contents(url('assets/css/bootstrap.min.css'));
                $stylesheet2=file_get_contents(url('assets/css/style.css'));
                $html='<table  class="col-md-12" cellpadding="10" style="width:100%;" width="100%;">
                        <tr>
                        
                <td valign="top" style="border-bottom: 5px #000 solid; color: #008000; font-size: 20px; font-weight: bold; padding-left: 0px;">
                
                '.$report_name.' : '.self::storeName().'
                <hr style="height:5px;">

                <b>Report Genarated : '.formatDateTime(date('Y-m-d H:i:s')).'<br /><br /></b></td>
                <tr>
                </table>';
                
                $html.=$table;
                $mpdf->WriteHTML($stylesheet, 1);
                $mpdf->WriteHTML($stylesheet2, 1); // The parameter 1 tells that this is css/style only and no body/html/text
                $mpdf->WriteHTML($html, 2);
                $mpdf->Output('invoice_' . time() . '.pdf', 'I');
                exit();
    }

    public function initMail(
        $to='',
        $subject='',
        $body='',
        $AltBody='This is the body in plain text for non-HTML mail clients',
        $attachment='',
        $debug=0
    )
    {
          $mail = new PHPMailer(true);
          try {
              $mail->SMTPDebug = $debug;
              $mail->isSMTP(); 
              $mail->Host = 'mail.neutrix.systems';
              $mail->SMTPAuth = true;
              $mail->Username = 'noreply@neutrix.systems';
              $mail->Password = '@sdQwe123';
              $mail->SMTPSecure = 'tls';            // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
              $mail->Port       = 26;    

              $mail->setFrom('noreply@neutrix.systems', 'Simple Retail POS');
              
              //$mail->addAddress($to, 'Fahad Bhuyian');
              $mail->addAddress($to);               // Name is optional
              $mail->addReplyTo('support@neutrix.systems', 'Reply - Support Simple Retail POS');
             // $mail->addCC('cc@example.com');
              $mail->addBCC('f.bhuyian@gmail.com');
             // $mail->addBCC('seoprohub@gmail.com');
              //Attachments
              if(!empty($attachment))
              {
                 $mail->addAttachment($attachment);
              }
              //$mail->addAttachment('/var/tmp/file.tar.gz');
              //$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); 

              //Content
              $mail->isHTML(true);
              $mail->Subject = $subject;
              $mail->Body    = $body;
              $mail->AltBody = $AltBody;
              $mail->send();
              return 1;
          } catch (Exception $e) {
              if($debug>0)
              {
                  return 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
              }
              else
              {
                  return 0;
              }
          }
    }

    public function initMailCustomer(
        $to = '',
        $subject = '',
        $body = '',
        $AltBody = 'This is the body in plain text for non-HTML mail clients',
        $attachment = '',
        $debug = 0
    ) {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = $debug;
            $mail->isSMTP();
            $mail->Host = 'mail.simpleretailpos.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'info@simpleretailpos.com';
            $mail->Password = '@sdQwe123';
            $mail->SMTPSecure = 'tls';            // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;

            $mail->setFrom('info@simpleretailpos.com', 'Simple Retail POS');

            //$mail->addAddress($to, 'Fahad Bhuyian');
            $mail->addAddress($to);               // Name is optional
            $mail->addReplyTo('support@neutrix.systems', 'Reply - Support Simple Retail POS');
            // $mail->addCC('cc@example.com');
            $mail->addBCC('f.bhuyian@gmail.com');
            // $mail->addBCC('seoprohub@gmail.com');
            //Attachments
            if (!empty($attachment)) {
                $mail->addAttachment($attachment);
            }
            //$mail->addAttachment('/var/tmp/file.tar.gz');
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); 

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = $AltBody;
            $mail->send();
            return 1;
        } catch (Exception $e) {
            if ($debug > 0) {
                return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            } else {
                return 0;
            }
        }
    }

}
