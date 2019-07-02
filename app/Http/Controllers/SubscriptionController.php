<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Price;
use App\Store;
use App\SiteCustomer;
use App\SiteSetting;

// Used to process plans
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;


use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\ShippingAddress;

   
class SubscriptionController extends Controller
{
    private $apiContext;
    private $mode;
    private $client_id;
    private $secret;
    private $plan_id;

    private $moduleName="Site ";
    private $sdc;
    
    // Create a new instance with our paypal credentials
    public function __construct()
    {
        $this->sdc = new StaticDataController(); 
        // Detect if we are running in live mode or sandbox
        if(config('paypal.settings.mode') == 'live'){
            $this->client_id = config('paypal.live_client_id');
            $this->secret = config('paypal.live_secret');
            $this->plan_id = env('PAYPAL_LIVE_PLAN_ID', '');
        } else {
            $this->client_id = config('paypal.sandbox_client_id');
            $this->secret = config('paypal.sandbox_secret');
            $this->plan_id = env('PAYPAL_SANDBOX_PLAN_ID', '');
        }
        
        // Set the Paypal API Context/Credentials
        $this->apiContext = new ApiContext(new OAuthTokenCredential($this->client_id, $this->secret));
        $this->apiContext->setConfig(config('paypal.settings'));
    }

    public function emailTemplateContactRequest($request)
    {
        $siteInfo=SiteSetting::where('id',1)->first();

        $html='';
        $html .='<!doctype html>
                    <html>
                      <head>
                        <meta name="viewport" content="width=device-width">
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                        <title>Simple Transactional Email</title>
                        <style>
                        /* -------------------------------------
                            INLINED WITH htmlemail.io/inline
                        ------------------------------------- */
                        /* -------------------------------------
                            RESPONSIVE AND MOBILE FRIENDLY STYLES
                        ------------------------------------- */
                        @media only screen and (max-width: 620px) {
                          table[class=body] h1 {
                            font-size: 28px !important;
                            margin-bottom: 10px !important;
                          }
                          table[class=body] p,
                                table[class=body] ul,
                                table[class=body] ol,
                                table[class=body] td,
                                table[class=body] span,
                                table[class=body] a {
                            font-size: 16px !important;
                          }
                          table[class=body] .wrapper,
                                table[class=body] .article {
                            padding: 10px !important;
                          }
                          table[class=body] .content {
                            padding: 0 !important;
                          }
                          table[class=body] .container {
                            padding: 0 !important;
                            width: 100% !important;
                          }
                          table[class=body] .main {
                            border-left-width: 0 !important;
                            border-radius: 0 !important;
                            border-right-width: 0 !important;
                          }
                          table[class=body] .btn table {
                            width: 100% !important;
                          }
                          table[class=body] .btn a {
                            width: 100% !important;
                          }
                          table[class=body] .img-responsive {
                            height: auto !important;
                            max-width: 100% !important;
                            width: auto !important;
                          }
                        }

                        /* -------------------------------------
                            PRESERVE THESE STYLES IN THE HEAD
                        ------------------------------------- */
                        @media all {
                          .ExternalClass {
                            width: 100%;
                          }
                          .ExternalClass,
                                .ExternalClass p,
                                .ExternalClass span,
                                .ExternalClass font,
                                .ExternalClass td,
                                .ExternalClass div {
                            line-height: 100%;
                          }
                          .apple-link a {
                            color: inherit !important;
                            font-family: inherit !important;
                            font-size: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                            text-decoration: none !important;
                          }
                          .btn-primary table td:hover {
                            background-color: #34495e !important;
                          }
                          .btn-primary a:hover {
                            background-color: #34495e !important;
                            border-color: #34495e !important;
                          }
                        }
                        </style>
                      </head>
                      <body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                        <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
                          <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                            <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
                              <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">

                                <!-- START CENTERED WHITE CONTAINER -->
                                <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">This is preheader text. Some clients will show this text as a preview.</span>
                                <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">

                                  <!-- START MAIN CONTENT AREA -->
                                  <tr>
                                    <td align="center"><br><img src="'.url('nucsite/images/logo-red-bl.png').'" width="220"></td>
                                  </tr>
                                  <tr>

                                    <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                                      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                        <tr>
                                          <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                                            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Hi ';

                                            

                                            $name=$request->first_name;
                                            if(!empty($request->last_name))
                                            {
                                                $name .=' '.$request->last_name;
                                            }

                                            $html .="Concern,";


                                            $html .='</p>
                                            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">A contact request has been submitted and need your attention. Below contact detail has been mention below.</p>
                                            <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                                              <tbody>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        Your Full Name 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$name.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        Phone 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->phone.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        E-Mail 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->email.'
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        Message Regarding 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->about_contact.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        Message Details 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->contact_message.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        <a href="mailto:support@neutrix.systems" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">Reply Now</a>
                                                    </td>
                                                </tr>
                                                
                                              </tbody>
                                            </table>
                                            
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>

                                <!-- END MAIN CONTENT AREA -->
                                </table>

                                <!-- START FOOTER -->
                                <div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                    <tr>
                                      <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                                        <span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">'.$siteInfo->address.'</span>
                                        <br>
                                        <span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">'.$siteInfo->phone.'</span>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td class="content-block powered-by" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                                         <a href="http://neutrix.systems" style="color: #999999; font-size: 12px; text-align: center; text-decoration: none;"><img src="http://nucleuspos.com/images/anc.png" width="100"></a>.
                                      </td>
                                    </tr>
                                  </table>
                                </div>
                                <!-- END FOOTER -->

                              <!-- END CENTERED WHITE CONTAINER -->
                              </div>
                            </td>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                          </tr>
                        </table>
                      </body>
                    </html>';

        return $html; 

        //echo $html; die();


    }


    public function emailTemplateDemoRequest($request)
    {
        $siteInfo=SiteSetting::where('id',1)->first();
        $html='';
        $html .='<!doctype html>
                    <html>
                      <head>
                        <meta name="viewport" content="width=device-width">
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                        <title>Simple Transactional Email</title>
                        <style>
                        /* -------------------------------------
                            INLINED WITH htmlemail.io/inline
                        ------------------------------------- */
                        /* -------------------------------------
                            RESPONSIVE AND MOBILE FRIENDLY STYLES
                        ------------------------------------- */
                        @media only screen and (max-width: 620px) {
                          table[class=body] h1 {
                            font-size: 28px !important;
                            margin-bottom: 10px !important;
                          }
                          table[class=body] p,
                                table[class=body] ul,
                                table[class=body] ol,
                                table[class=body] td,
                                table[class=body] span,
                                table[class=body] a {
                            font-size: 16px !important;
                          }
                          table[class=body] .wrapper,
                                table[class=body] .article {
                            padding: 10px !important;
                          }
                          table[class=body] .content {
                            padding: 0 !important;
                          }
                          table[class=body] .container {
                            padding: 0 !important;
                            width: 100% !important;
                          }
                          table[class=body] .main {
                            border-left-width: 0 !important;
                            border-radius: 0 !important;
                            border-right-width: 0 !important;
                          }
                          table[class=body] .btn table {
                            width: 100% !important;
                          }
                          table[class=body] .btn a {
                            width: 100% !important;
                          }
                          table[class=body] .img-responsive {
                            height: auto !important;
                            max-width: 100% !important;
                            width: auto !important;
                          }
                        }

                        /* -------------------------------------
                            PRESERVE THESE STYLES IN THE HEAD
                        ------------------------------------- */
                        @media all {
                          .ExternalClass {
                            width: 100%;
                          }
                          .ExternalClass,
                                .ExternalClass p,
                                .ExternalClass span,
                                .ExternalClass font,
                                .ExternalClass td,
                                .ExternalClass div {
                            line-height: 100%;
                          }
                          .apple-link a {
                            color: inherit !important;
                            font-family: inherit !important;
                            font-size: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                            text-decoration: none !important;
                          }
                          .btn-primary table td:hover {
                            background-color: #34495e !important;
                          }
                          .btn-primary a:hover {
                            background-color: #34495e !important;
                            border-color: #34495e !important;
                          }
                        }
                        </style>
                      </head>
                      <body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                        <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
                          <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                            <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
                              <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">

                                <!-- START CENTERED WHITE CONTAINER -->
                                <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">This is preheader text. Some clients will show this text as a preview.</span>
                                <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">

                                  <!-- START MAIN CONTENT AREA -->
                                  <tr>
                                    <td align="center"><br><img src="'.url('nucsite/images/logo-red-bl.png').'" width="220"></td>
                                  </tr>
                                  <tr>

                                    <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                                      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                        <tr>
                                          <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                                            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Hi ';

                                            

                                            $name=$request->first_name;
                                            if(!empty($request->last_name))
                                            {
                                                $name .=' '.$request->last_name;
                                            }

                                            $html .="Concern,";


                                            $html .='</p>
                                            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">NucleusV4 demo access request has been submitted, take your necessary step. Detail mention below. </p>
                                            <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                                              <tbody>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        Store Name 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->store_name.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        Full Name 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$name.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        Phone 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->phone.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        E-Mail 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->email.'
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        Password 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->password.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        Business Type 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->business_type.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        <a href="mailto:support@neutrix.systems" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">Response Now</a>
                                                    </td>
                                                </tr>
                                                
                                              </tbody>
                                            </table>
                                            
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>

                                <!-- END MAIN CONTENT AREA -->
                                </table>

                                <!-- START FOOTER -->
                                <div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                    <tr>
                                      <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                                        <span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">'.$siteInfo->address.'</span>
                                        <br>
                                        <span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">'.$siteInfo->phone.'</span>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td class="content-block powered-by" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                                         <a href="http://neutrix.systems" style="color: #999999; font-size: 12px; text-align: center; text-decoration: none;"><img src="http://nucleuspos.com/images/anc.png" width="100"></a>.
                                      </td>
                                    </tr>
                                  </table>
                                </div>
                                <!-- END FOOTER -->

                              <!-- END CENTERED WHITE CONTAINER -->
                              </div>
                            </td>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                          </tr>
                        </table>
                      </body>
                    </html>';

        return $html; 

        //echo $html; die();


    }



    public function contactRequest(Request $request)
    {
        $this->validate($request,
        [
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'about_contact'=>'required',
            'contact_message'=>'required',
        ]);

        $emailTemp=$this->emailTemplateContactRequest($request);
        $mailsend=$this->sdc->initMail("f.bhuyian@gmail.com",'Contact request has been submitted.',$emailTemp,'','',0);
        if($mailsend)
        {
            return redirect(url('contact.php'))->with('succmsg','Thank You, Request has been submitted.');
        }
        else
        {
            return redirect(url('contact.php'))->with('stcerror','Failed, Please try again.');
        }
    }

    public function demoRequest(Request $request)
    {
        $this->validate($request,
        [
            'store_name'=>'required',
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'password'=>'required',
            'business_type'=>'required',
        ]);

        $emailTemp=$this->emailTemplateDemoRequest($request);

        //echo $emailTemp; die();

        $mailsend=$this->sdc->initMail("f.bhuyian@gmail.com",'Contact request has been submitted.',$emailTemp,'','',0);
        if($mailsend)
        {
            return redirect(url('signup.php'))->with('succmsg','Request has been submitted. Our support team will contact with you shortly.');
        }
        else
        {
            return redirect(url('signup.php'))->with('stcerror','Failed, Please try again.');
        }
    }

    public function emailTemplateSuccessSignup($request)
    {
        $siteInfo=SiteSetting::where('id',1)->first();

        $html='';
        $html .='<!doctype html>
                    <html>
                      <head>
                        <meta name="viewport" content="width=device-width">
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                        <title>Simple Transactional Email</title>
                        <style>
                        /* -------------------------------------
                            INLINED WITH htmlemail.io/inline
                        ------------------------------------- */
                        /* -------------------------------------
                            RESPONSIVE AND MOBILE FRIENDLY STYLES
                        ------------------------------------- */
                        @media only screen and (max-width: 620px) {
                          table[class=body] h1 {
                            font-size: 28px !important;
                            margin-bottom: 10px !important;
                          }
                          table[class=body] p,
                                table[class=body] ul,
                                table[class=body] ol,
                                table[class=body] td,
                                table[class=body] span,
                                table[class=body] a {
                            font-size: 16px !important;
                          }
                          table[class=body] .wrapper,
                                table[class=body] .article {
                            padding: 10px !important;
                          }
                          table[class=body] .content {
                            padding: 0 !important;
                          }
                          table[class=body] .container {
                            padding: 0 !important;
                            width: 100% !important;
                          }
                          table[class=body] .main {
                            border-left-width: 0 !important;
                            border-radius: 0 !important;
                            border-right-width: 0 !important;
                          }
                          table[class=body] .btn table {
                            width: 100% !important;
                          }
                          table[class=body] .btn a {
                            width: 100% !important;
                          }
                          table[class=body] .img-responsive {
                            height: auto !important;
                            max-width: 100% !important;
                            width: auto !important;
                          }
                        }

                        /* -------------------------------------
                            PRESERVE THESE STYLES IN THE HEAD
                        ------------------------------------- */
                        @media all {
                          .ExternalClass {
                            width: 100%;
                          }
                          .ExternalClass,
                                .ExternalClass p,
                                .ExternalClass span,
                                .ExternalClass font,
                                .ExternalClass td,
                                .ExternalClass div {
                            line-height: 100%;
                          }
                          .apple-link a {
                            color: inherit !important;
                            font-family: inherit !important;
                            font-size: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                            text-decoration: none !important;
                          }
                          .btn-primary table td:hover {
                            background-color: #34495e !important;
                          }
                          .btn-primary a:hover {
                            background-color: #34495e !important;
                            border-color: #34495e !important;
                          }
                        }
                        </style>
                      </head>
                      <body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                        <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
                          <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                            <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
                              <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">

                                <!-- START CENTERED WHITE CONTAINER -->
                                <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">This is preheader text. Some clients will show this text as a preview.</span>
                                <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">

                                  <!-- START MAIN CONTENT AREA -->
                                  <tr>
                                    <td align="center"><br><img src="'.url('nucsite/images/logo-red-bl.png').'" width="220"></td>
                                  </tr>
                                  <tr>

                                    <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                                      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                        <tr>
                                          <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                                            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Hi '.$request->name.',</p>
                                            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Congratulations, your account is successfuly created. Please find the below credentials & please change your password on your first login. </p>
                                            <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                                              <tbody>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        Store Name 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->store_name.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        Your Full Name 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->name.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        Phone 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->phone.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        E-Mail 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->email.'
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        Password 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->password.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        App Login Link 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        http://v4.nucleuspos.com/home
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        App Login Button 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        <a href="http://v4.nucleuspos.com/home" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">Click here to login</a>
                                                    </td>
                                                </tr>
                                                
                                              </tbody>
                                            </table>
                                            
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>

                                <!-- END MAIN CONTENT AREA -->
                                </table>

                                <!-- START FOOTER -->
                                <div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                    <tr>
                                      <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                                        <span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">'.$siteInfo->address.'</span>
                                        <br>
                                        <span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">'.$siteInfo->phone.'</span>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td class="content-block powered-by" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                                         <a href="http://neutrix.systems" style="color: #999999; font-size: 12px; text-align: center; text-decoration: none;"><img src="http://nucleuspos.com/images/anc.png" width="100"></a>.
                                      </td>
                                    </tr>
                                  </table>
                                </div>
                                <!-- END FOOTER -->

                              <!-- END CENTERED WHITE CONTAINER -->
                              </div>
                            </td>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                          </tr>
                        </table>
                      </body>
                    </html>';

        return $html; 

        //echo $html; die();


    }

    public function store(Request $request)
    {

        

        $this->validate($request,
        [
            'store_name'=>'required',
            'user_name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'phone'=>'required',
        ]);

        $signup=\DB::table('stores_request')->insert([
                'store_name'=>$request->store_name,
                'name'=>$request->user_name,
                'email'=>$request->email,
                'password'=>$request->password,
                'phone'=>$request->phone,
                'package'=>4,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
        ]);

        $siteUser=\DB::table('stores_request')->where('email',$request->email)->where('password',$request->password)->first();
        $siteUserID=$siteUser->id;
        return $this->create_plan($siteUserID);
        //echo $siteUserID; die();
    }

    public function paypalRedirect($plan_id='')
    {
        // Create new agreement
        $agreement = new Agreement();
        $agreement->setName('NucleusV4 Yearly Subscription Agreement')
          ->setDescription('NucleusV4 Yearly Subscription')
          ->setStartDate(\Carbon\Carbon::now()->addMinutes(1)->toIso8601String());

        // Set plan id
        $plan = new Plan();
        $plan->setId($plan_id);
        $agreement->setPlan($plan);

        // Add payer type
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);

        try {
          // Create agreement
          $agreement = $agreement->create($this->apiContext);

          // Extract approval URL to redirect user
          $approvalUrl = $agreement->getApprovalLink();

          return redirect($approvalUrl);
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
          return redirect(url('pricing.php'))->with('stcerror','Failed, Please try again or you can contact with support.');
        } catch (Exception $ex) {
          return redirect(url('pricing.php'))->with('stcerror','Failed, Please try again or you can contact with support.');
        }

    }

    public function paypalReturn(Request $request,$userPlan=0){

        $token = $request->token;
        $agreement = new \PayPal\Api\Agreement();

        try {
            // Execute agreement
            $result = $agreement->execute($token, $this->apiContext);
            /*$user = Auth::user();
            $user->role = 'subscriber';
            $user->paypal = 1;
            if(isset($result->id)){
                $user->paypal_agreement_id = $result->id;
            }
            $user->save();*/

            //echo "<pre>";
            //dd($result->agreement_details->next_billing_date); 
            $start_date=date('Y-m-d h:i:s',strtotime($result->start_date));
            $next_billing_date=date('Y-m-d h:i:s',strtotime($result->agreement_details->next_billing_date));
            $last_payment_date=date('Y-m-d h:i:s',strtotime($result->agreement_details->last_payment_date));
            $final_payment_date=date('Y-m-d h:i:s',strtotime($result->agreement_details->final_payment_date));
            //dd($result);
            $siteUser=\DB::table('stores_request')->where('id',$userPlan)->update([
                'token'=>$result->id,
                'state'=>$result->state,
                'start_date'=>$start_date,
                'cycles_remaining'=>$result->agreement_details->cycles_remaining,
                'cycles_completed'=>$result->agreement_details->cycles_completed,
                'next_billing_date'=>$next_billing_date,
                'last_payment_date'=>$last_payment_date,
                'final_payment_date'=>$final_payment_date
            ]);

            $siteUser=\DB::table('stores_request')->where('id',$userPlan)->first();

           // dd($siteUser);

            $storeInfoRaw=serialize(json_encode($siteUser));

            $package=Price::find($siteUser->package);

            $someModel = new Store;
            $someModel->setConnection('mysql2'); // non-static method

            //$systemResponse=0;
            $someModelSite = new SiteCustomer;
            $someModelSite->setConnection('mysql2'); // non-static method

            $storeEX = $someModel::max('store_id');
            $newStoreID=$storeEX+1;

            

            $storeEXCount = $someModel::where('email',$siteUser->email)->count();
            $storeEXSiteCount = $someModelSite::where('email',$siteUser->email)->count();

            if($storeEXCount==0 && $storeEXSiteCount==0)
            {
                $something = $someModel;
                $something->name = $siteUser->store_name;
                $something->email = $siteUser->email;
                $something->phone = $siteUser->phone;
                $something->address = "Not Mention";
                $something->store_id = $newStoreID;

                $something->package_id = $siteUser->package;
                $something->package_name = $package->title;
                $something->membership_since = $siteUser->created_at;
                $something->activation_date = $siteUser->created_at;
                $something->expire_date = $next_billing_date;
                $something->account_raw_data = $storeInfoRaw;

                $something->created_by = 1000000;
                $something->save();


                

                $siteData=$someModelSite;
                $siteData->name=$siteUser->name;
                $siteData->user_type=2;
                $siteData->store_id=$newStoreID;
                $siteData->email=$siteUser->email;
                $siteData->phone=$siteUser->phone;
                $siteData->address="Not Mention";
                $siteData->password=\Hash::make($siteUser->password);
                $siteData->remember_token=$siteUser->token;
                $siteData->created_by=1000000;
                $siteData->save();

                
                $emailTemplate=$this->emailTemplateSuccessSignup($siteUser); 
                $this->sdc->initMail($request->email,'Thank you for signup with NucleusV4',$emailTemplate,'','',0);
                $this->sdc->initMail('f.bhuyian@gmail.com','NucleusV4 new subscribe request made.',$emailTemplate,'','',0);
                //die();

                //$systemResponse=1;

                return redirect(url('pricing.php'))->with('succmsg','Thank You, Your account is created successfully. Please login or check your email for login information.');

            }
            else
            {
                return redirect(url('pricing.php'))->with('succmsg','Thank You, Your account is already exists. Please send a mail to support to recover your Email & Password.');
            }

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return redirect(url('pricing.php'))->with('stcerror','Failed, Canceled payment process.');
        }
    }

    public function create_plan($siteUserID=0)
    {

        // Create a new billing plan
        $plan = new Plan();
        $plan->setName('NucleusV4 Monthly Billing')
          ->setDescription('Monthly Subscription for the NucleusV4')
          ->setType('fixed');

        // Set billing plan definitions
        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payments')
          ->setType('REGULAR')
          ->setFrequency('YEAR')
          ->setFrequencyInterval('1')
          ->setCycles('12')
          ->setAmount(new Currency(array('value' =>100, 'currency' => 'USD')));

        // Set merchant preferences
        $merchantPreferences = new MerchantPreferences();
        $merchantPreferences->setReturnUrl(url('subscribe/paypal/'.$siteUserID.'/return'))
          ->setCancelUrl(url('subscribe/paypal/'.$siteUserID.'/return'))
          ->setAutoBillAmount('yes')
          ->setInitialFailAmountAction('CONTINUE')
          ->setMaxFailAttempts('0');

        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        //create the plan
        try {

            $createdPlan = $plan->create($this->apiContext);

            try {
                $patch = new Patch();
                $value = new PayPalModel('{"state":"ACTIVE"}');
                $patch->setOp('replace')
                  ->setPath('/')
                  ->setValue($value);
                $patchRequest = new PatchRequest();
                $patchRequest->addPatch($patch);
                $createdPlan->update($patchRequest, $this->apiContext);
                $plan = Plan::get($createdPlan->getId(), $this->apiContext);

                // Output plan id
                //echo 'Plan ID:' . $plan->getId();
                $plan_id=$plan->getId();
                return $this->paypalRedirect($plan_id);
            } catch (PayPal\Exception\PayPalConnectionException $ex) {
                return redirect(url('pricing.php'))->with('stcerror','Failed, Please try again or you can contact with support.');
            } catch (Exception $ex) {
                return redirect(url('pricing.php'))->with('stcerror','Failed, Please try again or you can contact with support.');
            }
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            return redirect(url('pricing.php'))->with('stcerror','Failed, Please try again or you can contact with support.');
        } catch (Exception $ex) {
            return redirect(url('pricing.php'))->with('stcerror','Failed, Please try again or you can contact with support.');
        }

    }

    
}