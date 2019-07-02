<?php 

							if($input_status==1){ 
									
									$sqltotday_data=$index->FlyQuery("SELECT COUNT(id) AS `today_checkin_total`,
(SELECT COUNT(id) FROM `ticket` WHERE date='".$dashboard_today."')  as today_ticket_total,
(SELECT COUNT(id) FROM `buyback` WHERE date='".$dashboard_today."')  as today_buyback_total,
(SELECT COUNT(id) FROM `invoice` WHERE date='".$dashboard_today."' AND doc_type='2')  as today_estimate_total,
(SELECT COUNT(id) FROM `unlock_request` WHERE date='".$dashboard_today."')  as today_unlock_total 
 FROM `checkin_request` WHERE date='".$dashboard_today."'");
?>

                                    <li><div style="width: 94px; height: 94px; line-height: 94px;" class="easyPieChart" data-percent="<?php echo $sqltotday_data[0]->today_ticket_total; ?>"><?php echo $sqltotday_data[0]->today_ticket_total; ?><canvas width="94" height="94"></canvas></div><span>Today Ticket</span></li>

                                    <li><div style="width: 94px; height: 94px; line-height: 94px;" class="easyPieChart" data-percent="<?php echo $sqltotday_data[0]->today_checkin_total; ?>"><?php echo $sqltotday_data[0]->today_checkin_total; ?><canvas width="94" height="94"></canvas></div><span> Today CheckIn</span></li>

                                    <li><div style="width: 94px; height: 94px; line-height: 94px;" class="easyPieChart" data-percent="<?php echo $sqltotday_data[0]->today_buyback_total; ?>"><?php echo $sqltotday_data[0]->today_buyback_total; ?><canvas width="94" height="94"></canvas></div><span> Today Buyback</span></li>

                                    <li><div style="width: 94px; height: 94px; line-height: 94px;" class="easyPieChart" data-percent="<?php echo $sqltotday_data[0]->today_estimate_total; ?>"><?php echo $sqltotday_data[0]->today_estimate_total; ?><canvas width="94" height="94"></canvas></div><span> Today Estimate</span></li>

                                    <li><div style="width: 94px; height: 94px; line-height: 94px;" class="easyPieChart" data-percent="<?php echo $sqltotday_data[0]->today_unlock_total; ?>"><?php echo $sqltotday_data[0]->today_unlock_total; ?><canvas width="94" height="94"></canvas></div><span> Today Unlock</span></li>
									<?php }elseif($input_status==5){ 
									
									$sqltotday_data=$index->FlyQuery("SELECT COUNT(id) AS `today_checkin_total`,
(SELECT COUNT(id) FROM `ticket` WHERE input_by='".$input_by."' AND date='".$dashboard_today."')  as today_ticket_total,
(SELECT COUNT(id) FROM `buyback` WHERE input_by='".$input_by."' AND date='".$dashboard_today."')  as today_buyback_total,
(SELECT COUNT(id) FROM `invoice` WHERE input_by='".$input_by."' AND date='".$dashboard_today."' AND doc_type='2')  as today_estimate_total,
(SELECT COUNT(id) FROM `unlock_request` WHERE input_by='".$input_by."' AND date='".$dashboard_today."')  as today_unlock_total 
 FROM `checkin_request` WHERE input_by='".$input_by."' AND date='".$dashboard_today."'");
									
									?>

                                    <li><div style="width: 94px; height: 94px; line-height: 94px;" class="easyPieChart" data-percent="<?php echo $sqltotday_data[0]->today_ticket_total; ?>"><?php echo $sqltotday_data[0]->today_ticket_total; ?><canvas width="94" height="94"></canvas></div><span>Today Ticket</span></li>

                                    <li><div style="width: 94px; height: 94px; line-height: 94px;" class="easyPieChart" data-percent="<?php echo $sqltotday_data[0]->today_checkin_total; ?>"><?php echo $sqltotday_data[0]->today_checkin_total; ?><canvas width="94" height="94"></canvas></div><span> Today CheckIn</span></li>

                                    <li><div style="width: 94px; height: 94px; line-height: 94px;" class="easyPieChart" data-percent="<?php echo $sqltotday_data[0]->today_buyback_total; ?>"><?php echo $sqltotday_data[0]->today_buyback_total; ?><canvas width="94" height="94"></canvas></div><span> Today Buyback</span></li>

                                    <li><div style="width: 94px; height: 94px; line-height: 94px;" class="easyPieChart" data-percent="<?php echo $sqltotday_data[0]->today_estimate_total; ?>"><?php echo $sqltotday_data[0]->today_estimate_total; ?><canvas width="94" height="94"></canvas></div><span> Today Estimate</span></li>

                                    <li><div style="width: 94px; height: 94px; line-height: 94px;" class="easyPieChart" data-percent="<?php echo $sqltotday_data[0]->today_unlock_total; ?>"><?php echo $sqltotday_data[0]->today_unlock_total; ?><canvas width="94" height="94"></canvas></div><span> Today Unlock</span></li>

                                    <?php }else{ 
									
									$sqltotday_data=$index->FlyQuery("SELECT COUNT(id) AS `today_checkin_total`,
(SELECT COUNT(id) FROM `ticket` WHERE input_by='".$input_by."' AND date='".$dashboard_today."')  as today_ticket_total,
(SELECT COUNT(id) FROM `buyback` WHERE input_by='".$input_by."' AND date='".$dashboard_today."')  as today_buyback_total,
(SELECT COUNT(id) FROM `invoice` WHERE input_by='".$input_by."' AND date='".$dashboard_today."' AND doc_type='2')  as today_estimate_total,
(SELECT COUNT(id) FROM `unlock_request` WHERE input_by='".$input_by."' AND date='".$dashboard_today."')  as today_unlock_total 
 FROM `checkin_request` WHERE input_by='".$input_by."' AND date='".$dashboard_today."'");
									?>

                                    <li><div style="width: 94px; height: 94px; line-height: 94px;" class="easyPieChart" data-percent="<?php echo $sqltotday_data[0]->today_ticket_total; ?>"><?php echo $sqltotday_data[0]->today_ticket_total; ?><canvas width="94" height="94"></canvas></div><span>Today Ticket</span></li>

                                    <li><div style="width: 94px; height: 94px; line-height: 94px;" class="easyPieChart" data-percent="<?php echo $sqltotday_data[0]->today_checkin_total; ?>"><?php echo $sqltotday_data[0]->today_checkin_total; ?><canvas width="94" height="94"></canvas></div><span> Today CheckIn</span></li>

                                    <li><div style="width: 94px; height: 94px; line-height: 94px;" class="easyPieChart" data-percent="<?php echo $sqltotday_data[0]->today_buyback_total; ?>"><?php echo $sqltotday_data[0]->today_buyback_total; ?><canvas width="94" height="94"></canvas></div><span> Today Buyback</span></li>

                                    <li><div style="width: 94px; height: 94px; line-height: 94px;" class="easyPieChart" data-percent="<?php echo $sqltotday_data[0]->today_estimate_total; ?>"><?php echo $sqltotday_data[0]->today_estimate_total; ?><canvas width="94" height="94"></canvas></div><span> Today Estimate</span></li>

                                    <li><div style="width: 94px; height: 94px; line-height: 94px;" class="easyPieChart" data-percent="<?php echo $sqltotday_data[0]->today_unlock_total; ?>"><?php echo $sqltotday_data[0]->today_unlock_total; ?><canvas width="94" height="94"></canvas></div><span> Today Unlock</span></li>

                                    <?php } ?>