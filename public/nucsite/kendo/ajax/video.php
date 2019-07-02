<?php

include('../class/auth.php');
extract($_POST);
if ($st == 1) {
    echo $obj->insert("video_comment", array("video_id" => $video_id, "user_id" => $access_id, "comment" => $comment, "date" => date('Y-m-d'), "status" => 1));
}elseif ($st == 2) {
    $sqlcomments=$obj->FlyQuery("SELECT a.*,s.name,IFNULL(s.image,'avater.png') as image,s.status as user_type FROM video_comment as a
                                LEFT JOIN store as s ON s.id=a.user_id
                                WHERE a.video_id='".$video_id."' AND a.status='1' ORDER BY a.id DESC LIMIT 30");
    if(!empty($sqlcomments))
    {
        $comments='';
        foreach ($sqlcomments as $comm):
            
            if($comm->user_type==1)
            {
                $user_label="System Admin";
            }
            elseif($comm->user_type==2)
            {
                $user_label="Store Admin";
            }
            elseif($comm->user_type==3)
            {
                $user_label="Store Cashier";
            }
            elseif($comm->user_type==4)
            {
                $user_label="Store Manager";
            }
            elseif($comm->user_type==5)
            {
                $user_label="Store Chain Admin";
            }
            
            $comments .='<div class="message">
                            <a class="message-img" href="#"><img src="store/'.$comm->image.'" alt="" /></a>
                            <div class="message-body">
                                <div class="text"><p>'.$comm->comment.'</p></div>
                                <p class="attribution">by <a href="javascript:void(0);">'.$comm->name.' | '.$user_label.'</a> at '.date_format(date_create($comm->date_time), 'H:i A, d M Y').'</p>
                            </div>
                        </div>';
        endforeach;
        $nar=array("content"=>$comments,"status"=>1);
        echo json_encode($nar);
    }
} else {
    echo 0;
}
?>