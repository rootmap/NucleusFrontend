<?php 
include('../class/db_Class.php');
$obj = new db_class();

$news=$obj->FlyQuery("SELECT 
a.id,
cn.id as news_id,
cn.news_headding,
TRIM(Replace(Replace(Replace(cn.news_short_details,'\t',''),'\n',''),'\r','')) AS news_short_details,
r.name as reporter,
cn.news_thumble,
cn.news_date_time
FROM `top_news` as a 
INNER JOIN compose_news as cn ON cn.id=a.news_id
INNER JOIN reporter AS r ON r.id=cn.reporter
ORDER BY id DESC
LIMIT 0,5");

if(!empty($news))
{
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>So much exciting news in our website. ! Visit BdNewsRobot.com</title>
    </head>

    <body>

    <div align="center" style="height: 100%; margin: 0 auto; border-top-width: 0px;">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; border: 1px solid #ccc;">
            <tbody>
                <tr>
                    <td valign="top" style="border-top-width: 0px; border-bottom-width: 0px; padding-top: 9px; padding-bottom: 9px; background-color: #FFFFFF;">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="min-width: 100%; border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td valign="top" style="padding: 9px;">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="min-width: 100%; border-collapse: collapse;">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" style="padding: 0px 9px; text-align: center;">
                                                        <img align="middle" style="padding-bottom: 0px; vertical-align: bottom; border: 0px none; height: auto; outline: medium none; text-decoration: none; display: inline;" alt="bdnewsrobot" src="<?php echo $obj->baseUrlF(); ?>images/rlogo.png" width="300" height="100"/>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="min-width: 100%; border-collapse: collapse; table-layout: fixed ! important;">
                            <tbody>
                            	<tr>
                                    <td style="min-width: 100%; padding: 18px;">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="min-width: 100%; border-top: 2px solid #f44336; border-collapse: collapse;">
                                            <tbody>
                                                <tr>
                                                    <td><span></span><br></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="min-width: 100%; border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td valign="top" style="padding-top: 9px;">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="max-width: 100%; min-width: 100%; border-collapse: collapse;">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" style="padding: 0px 18px 9px; color: rgb(101, 101, 101); font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif; font-size: 12px; line-height: 150%; text-align: left;">
                                                        <div style="text-align: center;">
                                                            <span style="font-size: 20px;">
                                                                <span style="color: rgb(0, 0, 0);">
                                                                    <strong>So much exciting news in our website. ! Visit BdNewsRobot.com</strong>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top" style="border-top-width: 0px; border-bottom-width: 0px;  padding-bottom: 0px; background-color: rgb(255, 255, 255);">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                                <tr>
                                    <td valign="top">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" style="padding: 0px 0px; text-align: center;">
                                                        <img align="middle" style="padding-bottom: 0px; vertical-align: bottom; width:100%; border: 0px none; height: 500px; outline: medium none; text-decoration: none; display: inline;" alt="BdNewsRobot" src="<?php echo $obj->baseUrlF(); ?>news_thumble/<?php echo $news[0]->news_thumble; ?>"/>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top" style="border-top-width: 0px; border-bottom-width: 0px; padding-top: 9px; padding-bottom: 0px; background-color: #FFFFFF;">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="min-width: 100%; border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td valign="top" style="padding-top: 9px;">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="max-width: 100%; min-width: 100%; border-collapse: collapse;">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" style="padding: 0px 18px 9px; color: rgb(32, 32, 32); font-family: helvetica; font-size: 16px; line-height: 150%; text-align: left;">
                                                        <h1 style="text-align: center; display: block; margin: 0px; padding: 0px; color: rgb(32, 32, 32); font-family: helvetica; font-size: 26px; font-style: normal; font-weight: bold; line-height: 125%; letter-spacing: normal;">
                                                            <strong><a href="" target="_blank" style="font-size: 24px; text-transform:uppercase; text-decoration:none; color:#ef5350;"><?php echo $news[0]->news_headding; ?></a></strong>
                                                        </h1>
                                                        <div style="line-height: 20.8px; text-align: center;">
                                                        	<span style="color:#1A237E; font-weight:bold;">
                                                        	<?php echo $news[0]->news_date_time; ?>
                                                            <br>
                                                            <br>
                                                            News Source : <?php echo $news[0]->reporter; ?>
                                                            </span>
                                                        </div>
                                                        <div style="line-height: 20.8px; text-align: justify;">

                                                            <br>
                                                            <span style="box-sizing:border-box;color:#4b4f56;font-family:helvetica, arial, sans-serif;font-size:14px;"><?php echo $news[0]->news_short_details; ?>...</span><br>
                                                            <br>
                                                        </div>
                                                        <br>
                                                        <span>
                                                            <a style="background: #8BC34A; border-radius: 28px; color: #ffffff; font-size: 16px; padding: 10px 15px 10px 15px; text-decoration: none !important; font-weight: normal;" 
                                                               target="_blank" href="<?php echo $obj->baseUrlF(); ?>newsdetail/<?php echo $news[0]->news_id; ?>/<?php echo $news[0]->news_headding; ?>"><strong style="color: #FFFFFF;">See News Detail &raquo;</strong>
                                                            </a>
                                                        </span>
                                                        <br>
                                                        <br>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top" style="border-top-width: 0px; border-bottom: 2px solid rgb(234, 234, 234); padding-top: 0px; padding-bottom: 9px; background-color: rgb(255, 255, 255);">
                        <table width="50%" cellspacing="0" cellpadding="0" border="0" align="left" style="border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td valign="top">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" style="padding: 9px 9px 9px 0px; ">
                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="border-collapse: collapse; background-color: #FFFFFF;">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="top" align="left" style="padding: 0px;">
                                                                        <img style="width:100%; border: 0px none; height:200px !important; outline: medium none; text-decoration: none; vertical-align: bottom;" alt="" src="<?php echo $obj->baseUrlF(); ?>news_thumble/<?php echo $news[1]->news_thumble; ?>">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="246" valign="top" style="padding: 9px 18px 9px 18px; font-family: helvetica; font-size: 14px; font-weight: normal; line-height: 18px; text-align: center; color: rgb(32, 32, 32);">
                                                                        <div style="text-align: center;">
                                                                            <p style="text-align: center; font-family: helvetica; font-size: 14px; font-weight: normal; line-height: 18px; margin: 10px 0px; padding: 0px; color: rgb(32, 32, 32);" class="p1"><span style="font-size: 18px;">
                                                                                    <a href=""  target="_blank" style="text-decoration:none;"><strong style="text-transform:uppercase; color:#ef5350;"><?php echo $news[1]->news_headding; ?></strong></a>
                                                                                </span>
                                                                            </p>
                                                                            <div style="line-height: 20.8px; text-align: center;">
                                                                            	<span style="color:#1A237E; font-weight:bold;">
                                                                                <?php echo $news[1]->news_date_time; ?>
                                                                                </span>
                                                                            </div>
                                                                            <div style="line-height: 20.8px; text-align: justify;">
                                                                            <span style="color:#4b4f56;font-family:helvetica, arial, sans-serif;font-size:14px;line-height:18.76px;">
                                                                            <span style="box-sizing:border-box;color:#4b4f56;font-family:helvetica, arial, sans-serif;font-size:14px;"><?php echo $news[1]->news_short_details; ?>...</span>
                                                                           </div>
                                                                            <br>
                                                                            <span>
                                                                                <a style="background: #8BC34A; border-radius: 28px; color: #ffffff; font-size: 16px; padding: 10px 15px 10px 15px; text-decoration: none !important; font-weight: normal;" 
                                                                                target="_blank" href="<?php echo $obj->baseUrlF(); ?>newsdetail/<?php echo $news[1]->news_id; ?>/<?php echo $news[1]->news_headding; ?>"><strong style="color: #FFFFFF;">See News Detail &raquo;</strong>
                                                                                </a>
                                                                            </span>
                                                                            <br>
                                                                            <br>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" style="padding: 9px 9px 9px 0px; ">
                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="border-collapse: collapse; background-color: #FFFFFF;">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="top" align="left" style="padding: 0px;">
                                                                        <img style="width:100%; border: 0px none; height:200px !important; outline: medium none; text-decoration: none; vertical-align: bottom;" alt="" src="<?php echo $obj->baseUrlF(); ?>news_thumble/<?php echo $news[2]->news_thumble; ?>">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="246" valign="top" style="padding: 9px 18px; font-family: helvetica; font-size: 14px; font-weight: normal; text-align: center; color: rgb(32, 32, 32); line-height: 150%;">
                                                                        <div style="text-align: center;">
                                                                            <span style="font-size: 18px; text-transform:uppercase;">
                                                                                <a href="#"  target="_blank" style="text-decoration:none; color:#ef5350;"><strong><?php echo $news[2]->news_headding; ?></strong></a>
                                                                            </span>
                                                                        </div>
                                                                        <br>
                                                                        <div style="text-align: center;">
                                                                            <span style="color:#1A237E; font-weight:bold;">
                                                                               <?php echo $news[2]->news_date_time; ?>
                                                                            <br>
                                                                            <p style="box-sizing:border-box;margin-bottom:10px;color:#444444;font-family:Roboto, 'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:13px;"><span style="box-sizing:border-box;color:#4b4f56;font-family:helvetica, arial, sans-serif;font-size:14px;"><?php echo $news[2]->news_short_details; ?>...</span></p><br>
                                                                            <span>
                                                                                <a style="background: #8BC34A; border-radius: 28px; color: #ffffff; font-size: 16px; padding: 10px 15px 10px 15px; text-decoration: none !important; font-weight: normal;" 
                                                                                target="_blank" href="<?php echo $obj->baseUrlF(); ?>newsdetail/<?php echo $news[2]->news_id; ?>/<?php echo $news[2]->news_headding; ?>"><strong style="color: #FFFFFF;">See News Detail &raquo;</strong>
                                                                                </a>
                                                                            </span>
                                                                            <br>
                                                                            <br>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="50%" cellspacing="0" cellpadding="0" border="0" align="right" style="border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td valign="top">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" style="padding: 9px 0px 9px 9px; ">
                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="right" style="border-collapse: collapse; background-color: #FFFFFF;">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="top" align="left" style="padding: 0px;">
                                                                        <img  style="width:100%; border: 0px none; height:200px !important; outline: medium none; text-decoration: none; vertical-align: bottom;" alt="" src="<?php echo $obj->baseUrlF(); ?>news_thumble/<?php echo $news[3]->news_thumble; ?>">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" style="padding: 9px 18px; font-family: helvetica; font-size: 14px; font-weight: normal; line-height: 18px; text-align: center; color: rgb(32, 32, 32);">
                                                                        <div style="text-align: center;">
                                                                            <br>
                                                                            <span style="font-size: 18px; text-transform:uppercase;">
                                                                                <a href=""  target="_blank" style="text-decoration:none; color:#ef5350;"><strong><?php echo $news[3]->news_headding; ?></strong></a>
                                                                            </span>
                                                                            <br>
                                                                            <br>
                                                                            <span style="color:#1A237E; font-weight:bold;">
                                                                            <?php echo $news[3]->news_date_time; ?>
                                                                                <p><span style="box-sizing:border-box;font-family:Roboto, 'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:13px;color:#4b4f56;"><span style="box-sizing:border-box;font-size:14px;"><?php echo $news[3]->news_short_details; ?></span></span></p><br>
                                                                            <span>
                                                                                <a style="background: #8BC34A; border-radius: 28px; color: #ffffff; font-size: 16px; padding: 10px 15px 10px 15px; text-decoration: none !important; font-weight: normal;" 
                                                                                target="_blank" href="<?php echo $obj->baseUrlF(); ?>newsdetail/<?php echo $news[3]->news_id; ?>/<?php echo $news[3]->news_headding; ?>"><strong style="color: #FFFFFF;">See News Detail &raquo;</strong>
                                                                                </a>
                                                                            </span>
                                                                            <br>
                                                                            <br>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" style="padding: 9px 0px 9px 9px; ">
                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="right" style="border-collapse: collapse; background-color: #FFFFFF;">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="top" align="left" style="padding: 0px;">
                                                                        <img style="width:100%; border: 0px none; height:200px !important; outline: medium none; text-decoration: none; vertical-align: bottom;" alt="" src="<?php echo $obj->baseUrlF(); ?>news_thumble/<?php echo $news[4]->news_thumble; ?>">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="246" valign="top" style="padding: 9px 18px; font-family: helvetica; font-size: 14px; font-weight: normal; line-height: 18px; text-align: center; color: rgb(32, 32, 32);">
                                                                        <div style="text-align: center;">
                                                                            <br>
                                                                            <span style="font-size: 18px; text-transform:uppercase;">
                                                                                <a href=""  target="_blank" style="text-decoration:none; color:#ef5350;"><strong><?php echo $news[4]->news_headding; ?></strong></a>
                                                                            </span>
                                                                        </div>
                                                                        <div style="text-align: center;">&nbsp;</div>
                                                                        <div style="text-align: center;">
                                                                        	<span style="color:#1A237E; font-weight:bold;">
                                                                        	<?php echo $news[4]->news_date_time; ?>
                                                                            <br>
                                                                            <p><?php echo $news[4]->news_short_details; ?></p>
                                                                            <br>
                                                                            <br>
                                                                            <span>
                                                                                <a style="background: #8BC34A; border-radius: 28px; color: #ffffff; font-size: 16px; padding: 10px 15px 10px 15px; text-decoration: none !important; font-weight: normal;" 
                                                                                target="_blank" href="<?php echo $obj->baseUrlF(); ?>newsdetail/<?php echo $news[4]->news_id; ?>/<?php echo $news[4]->news_headding; ?>"><strong style="color: #FFFFFF;">See News Detail &raquo;</strong>
                                                                                </a>
                                                                            </span>
                                                                            <br>
                                                                            <br>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top" style="border-top-width: 0px; border-bottom-width: 0px; padding-top: 9px; padding-bottom: 9px; background-color: #FFFFFF;" >
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="min-width: 100%; border-collapse: collapse;">
                        </table>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="min-width: 100%; border-collapse: collapse; table-layout: fixed ! important;">
                            <tbody>
                                <tr>
                                    <td style="min-width: 100%; padding: 5px 10px 0px;">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="min-width: 100%; border-top: 2px solid #f44336; border-collapse: collapse;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <span></span>
                                                        <br>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="min-width: 100%; border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td valign="top" style="padding-top: 9px;">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="max-width: 100%; min-width: 100%; border-collapse: collapse;">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" style="padding: 0px 18px 9px; color: rgb(101, 101, 101); font-family: helvetica; font-size: 12px; line-height: 150%; text-align: center;">
                                                        <br>
                                                        <span>
                                                        	<span>
                                                                <a target="_blank" href="#">
                                                                    <img height="54" border="0"  title="Bdnewsrobot" alt="Email Marketing Powered by BdNewsRobot"  src="<?php echo $obj->baseUrlF(); ?>images/rlogo.png">
                                                                </a>
                                                            </span>
                                                        </span>
                                                        <br>
                                                        <em><b>Copyright &copy; 2016 Bdnewsrobot, All rights reserved.</b></em>
                                                        
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>
<?php } ?>