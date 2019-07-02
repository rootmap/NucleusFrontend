<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Session;
use App\Cart;
use Auth;
use Illuminate\Http\Request;

use Mpdf\Mpdf;
use Excel;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use CodeItNow\BarcodeBundle\Utils\QrCode;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//MenuPageController::loggedUser('company_prefix')


class StaticDataController extends Facade {

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
        return "Simple Retail Front-End";
    }

    

    public static function UserID() 
    {
        return Auth::user()->id;
    }

    public static function dataMenuAssigned()
    {
        $dataMenuAssigned = Session()->has('dataMenuAssigned') ?  Session()->get('dataMenuAssigned') : null;
        return $dataMenuAssigned;

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
              $mail->Host = 'mail.spxce.co';
              $mail->SMTPAuth = true;
              $mail->Username = 'simpleretailpos@spxce.co';
              $mail->Password = '@sdQwe123';
              $mail->SMTPSecure = 'tls';
              $mail->Port = 587;

              $mail->setFrom('autoreply@spxce.co', 'NucleusV4');

              //$mail->addAddress($to, 'Fahad Bhuyian');
              $mail->addAddress($to);               // Name is optional
              $mail->addReplyTo('autoreply@spxce.co', 'Reply - NucleusV4');
             // $mail->addCC('cc@example.com');
             // $mail->addBCC('bcc@example.com');

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

    public function checkFile($fileWpath='')
    {

        if (file_exists($fileWpath)) {
            return true;
        }    
    }

}
