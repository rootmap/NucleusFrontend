<div class="sidebar" id="left-sidebar">
    <ul class="navigation standard"><!-- standard nav -->
        <?php if ($input_status == 1) { ?>
            <li><a href="index.php" title=""><img src="images/icons/mainnav/dashboard.png" alt="" />Dashboard</a></li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/user.png" alt="" />Customer<strong>3</strong></a>
                <ul>
                    <li><a href="customer.php" title="">New Customer</a></li>
                    <li><a href="customer_list.php" title="">Customer List</a></li>
                    <li><a href="customer_list_import.php" title="">Import Customer</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/page-layouts.png" alt="" />Special Order Parts<strong>2</strong></a>
                <ul>
                    <li><a href="parts.php" title="">Add New Special Order</a></li>
                    <li><a href="parts_list.php" title="">Special Order List</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/page-layouts.png" alt="" />Estimates<strong>2</strong></a>
                <ul>
                    <li><a href="estimate.php" title="">Add New Estimates</a></li>
                    <li><a href="estimate_list.php" title="">Estimates  List</a></li>
                </ul>
            </li>
            <!--<li><a href="#" title="" class="expand"><img src="images/icons/mainnav/typography.png" alt="" />Ticket<strong>2</strong></a>
                <ul>
                    <li><a href="ticket.php" title="">Add New Ticket</a></li>
                    <li><a href="ticket_list.php" title="">Ticket List</a></li>
                </ul>
            </li>-->
            <?php if ($input_by != "1431472960") { ?>
                <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/unlock.png" alt="" />Unlock<strong>2</strong></a>
                    <ul>
                        <li><a href="unlock.php" title="">Add New Unlock</a></li>
                        <li><a href="unlock_list.php" title="">Unlock List</a></li>
                    </ul>
                </li>
            <?php } ?>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/warrenty.png" alt="" />Warranty<strong>2</strong></a>
                <ul>
                    <li><a href="warrenty_search.php" title="">Add New Warranty</a></li>
                    <li><a href="warrenty_list.php" title="">Warranty List</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/buyback.png" alt="" />BuyBack<strong>2</strong></a>
                <ul>
                    <li><a href="buyback.php" title="">Add New BuyBack</a></li>
                    <li><a href="buyback_list.php" title="">BuyBack List</a></li>
                </ul>
            </li>
            <li><a href="startarepair.php"  title=""><img src="images/icons/mainnav/invoice.png" alt="" />Start a repair</a></li>
            <li><a href="#" title="Inventory Detail" class="expand"><img src="images/icons/mainnav/inventory.png" alt="" />Inventory<strong>9</strong></a>
                <ul>
                    <li><a href="inventory.php" title="Add New Other Inventory">Add New Other Inventory</a></li>
                    <li><a href="inventory_phone.php" title="Add New Device Inventory">Add New Device Inventory</a></li>
                    <li><a href="inventory_reoccurring.php" title="Add New Reoccurring Inventory">Add New Reoccurring Inventory</a></li>
                    <li><a href="inventory_list.php" title="Parts Inventory  List">Parts Inventory </a></li>
                    <li><a href="inventory_maintain_list.php" title="Maintain Stock Inventory  List">Maintain Stock Inventory </a></li>
                    <li><a href="phone_inventory_list.php" title="Device Inventory List">Device Inventory</a></li>
                    <li><a href="inventory_other_list.php" title="Other Inventory List">Other Inventory</a></li>
                    <li><a href="inventory_reoccurring_list.php" title="Reoccurring Inventory List">Reoccurring Inventory</a></li>
                    <li><a href="reoccurring_invoice.php" title="Reoccurring Invoice">Reoccurring Invoice</a></li>
                    <li><a href="other_inventory_import.php" title="Import Other Inventory Product from excel">Import Other Inventory</a></li>
                    <li><a href="startaverience.php"  title="Start a verience">Start a Variance</a></li>
                    <li><a href="purchase.php" title=""> Purchase </a></li>
                    <li><a href="reorder.php" title="Inventory Reorder Products"> Reorder</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/money.png" alt="" />POS System<strong>2</strong></a>
                <ul>
                    <li><a href="pos.php" title="">POS </a></li>
                    <li><a href="sales_list.php" title="">POS-Sales List</a></li>
                </ul>
            </li>
            <li><a href="setting_clear.php" title="Clear All Data"><img src="images/icons/mainnav/clear.png" alt="" /> Clear Data </a></li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/report.png" alt="" />Report<strong>17</strong></a>

                <ul>
                    <li><a href="allreport.php" title="">All Report</a></li>
                    <li><a href="buyback_report.php" title="BuyBack Report">BuyBack Report Date wise</a></li>
                    <li><a href="buyback_estimate_report.php" title="Buyback Estimate Request">Buyback Estimate Request</a></li>
                    <li><a href="customer_report.php" title="">Customer Report Date wise</a></li>
                    <li><a href="checkin_report.php" title="">Check In Report Date wise</a></li>
                    <li><a href="cashier_sales_report.php" title="Cashier Sales Report">Cashier Sales Report</a></li>
                    <li><a href="highest_seller_cashier_report.php" title="">Highest Seller List</a></li>
                    <li><a href="inventory_report.php" title="">Inventory Report Date wise</a></li>
                    <li><a href="checkin_lcd_report.php" title="">LCD Status Report Date wise</a></li>
                    <li><a href="payout_report.php" title="">Payout Report Date wise</a></li>
                    <li><a href="profit_report.php" title="Profit Report">Profit Report Date wise</a></li>
                    <li><a href="sales_report.php" title="">Sales Report Date wise</a></li>
                    <li><a href="checkin_salvage_part_report.php" title="">Salvage Part Report Date wise</a></li>
                    <li><a href="store_closing_report.php" title="">Store Closing Report</a></li>
                    <li><a href="part_report.php" title="">Special Order Report Date wise</a></li>
                    <li><a href="tranaction.php" title="">Transaction</a></li>
                    <li><a href="tender_report.php" title="Tender Report">Tender Report Date wise</a></li>
                    <li><a href="ticket_report.php" title="">Ticket Report Date wise</a></li>
                    <li><a href="warrenty_report.php" title="">Warranty Report </a></li>
                    <?php if ($input_by != "1431472960") { ?>
                        <li><a href="unlock_report.php" title="">Unlock Report Date wise</a></li>
                    <?php } ?>
                    <!--<li><a href="#" title="">Backup Report Date wise</a></li>-->
                </ul>
            </li>
           <!-- <li><a href="business_report.php" title=""><img src="images/icons/mainnav/rep2.png" alt="" />Business Report</a></li>-->
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/calendar.png" alt="" />Event Calendar<strong>2</strong></a>
                <ul>
                    <li><a href="add_event_calender.php" title="">New Event/Schedule</a></li>
                    <li><a href="calender.php" title="">View Events & Schedule</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/setting.png" alt="" />System Setting<strong>28</strong></a>
                <ul>
                    <li><a style="border:none;"  class="expand" href="#" title=""><i style="margin-top:4px; margin-left:-20px;" class="icon-random"></i> BuyBack Setting</a>
                        <ul>
                            <li style="border:none;"><a target="_blank" style="font-weight:bolder;" href="buyback_network.php" title="">BuyBack Network</a></li>
                            <li style="border:none;"><a target="_blank" style="font-weight:bolder;" href="buyback_device_type.php" title="">BuyBack Device Type</a></li>
                            <li style="border:none;"><a target="_blank" style="font-weight:bolder;" href="buyback_device_model.php" title="">BuyBack Device Model</a></li>
                            <li style="border:none;"><a target="_blank" style="font-weight:bolder;" href="buyback_device_condition.php" title="">BuyBack Device Condition</a></li>
                            <li style="border:none;"><a target="_blank" style="font-weight:bolder;" href="buyback_estimate_price.php" title="">BuyBack Find Estimate Price</a></li>

                        </ul>
                    </li>

                    <li><a href="barcode.php" title="">Barcode </a></li>
                    <li><a href="backdoor.php" title=""> Backdoor Data </a></li>
                    <li><a href="currency.php" title="">Currency Setting</a></li>
                    <li><a href="setting_customer.php" title="">Customer Setting</a></li>
                    <li><a style="border:none;"  class="expand" href="#" title=""><i style="margin-top:4px; margin-left:-20px;" class="icon-map-marker"></i> Checkin Setting </a>
                        <ul>
                            <li style="border:none;"><a href="checkin_name_setting.php" style="font-weight:bolder;" target="_blank" title="">Check In Category</a></li>
                            <li style="border:none;"><a href="checkin_name_version_setting.php" style="font-weight:bolder;" target="_blank" title="">Check In Category Version</a></li>
                            <li style="border:none;"><a href="checkin_name_version_color_setting.php" style="font-weight:bolder;" target="_blank" title="">Check In Device Color</a></li>

                            <li style="border:none;"><a href="checkin_network.php" target="_blank" style="font-weight:bolder;" title="">Check In Network</a></li>
                            <li style="border:none;"><a href="checkin_problem.php" target="_blank" style="font-weight:bolder;" title="">Check In Problem</a></li>
                            <li style="border:none;"><a href="checkin_price.php" target="_blank" style="font-weight:bolder;" title="">Check In Price</a></li>
                        </ul>
                    </li>
                    <li><a href="checkin_lcd_report.php?dels=all" title="">Clear All LCD Status</a></li>
                    <li><a href="cashier.php" title="Cashier Info ">Cashier</a></li>
                    <li><a href="cashier_punch_history.php" title="Cashier Punch Hostory ">Cashier Punch Log</a></li>
                    <li><a href="country.php" title="">Country</a></li>
                    <li><a href="setting_estimates.php" title="">Estimates Setting</a></li>
                    <li><a href="email_setting.php" title=""> Email Setting </a></li>
                    <li><a href="setting_general.php" title="">General Setting</a></li>
                    <li><a href="setting_inventory.php" title="">Inventory Setting</a></li>
                    
                    <li><a href="manager.php" title="Manager Info ">Manager</a></li>
                    <li><a href="setting_inventory_1.php" title="">Product LCD Color</a></li>
                    <li><a href="setting_parts.php" title="">Parts Setting</a></li>
                    <li><a href="setting_pos.php" title="">POS Setting</a></li>
                    <li><a href="payment_method.php" title="">Payment Method</a></li>
                    <li><a href="pcauthorization.php" title=""> PC Authorize </a></li>
                    
                    <li><a href="report_setting.php" title="">Report Setting</a></li>
                    <li><a href="setting_new_store.php" title="">Set Up New Store Data</a></li>
                    <li><a href="store_list.php" title="">Store</a></li>
                    <li><a href="setting_store_chain_admin.php" title="Store Chain Admin">Store Chain Admin</a></li>
                    <li><a href="asset_type.php" title="">Ticket Asset Type</a></li>
                    <li><a href="ticket_custom_field.php" title="">Ticket Custom Field</a></li>
                    <li><a href="tax.php" title="">Tax </a></li>
                    <?php if ($input_by != "1431472960") { ?>
                        <li><a href="unlock_service.php" title="">Unlock Service</a></li>
                    <?php } ?>
                    <li><a href="vendor_list.php" title=""> Vendor </a></li>
                    <li><a href="video_player_setting.php" title="Video Player Color"> Video Player Color </a></li>
                    <li><a href="video_list.php" title="Video List"> Video List </a></li>
                    <li><a href="backup_db.php" title="Backup Data">Backup</a></li>
                </ul>
            </li>
    <!--            <li><a href="accounts/index.php" title=""><img src="images/icons/mainnav/dashboard.png" alt="" />Accounts</a></li>-->
            <li><a href="helpdesk.php" title="Help Desk?"><img src="images/icons/mainnav/messages.png" alt="" />Help Desk</a>
            <?php }elseif ($input_status == 2) { ?>
            <li><a href="index.php" title=""><img src="images/icons/mainnav/dashboard.png" alt="" />Dashboard</a></li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/user.png" alt="" />Customer<strong>3</strong></a>
                <ul>
                    <li><a href="customer.php" title="">New Customer</a></li>
                    <li><a href="customer_list.php" title="">Customer List</a></li>
                    <li><a href="customer_list_import.php" title="">Import Customer</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/page-layouts.png" alt="" />Special Order Parts<strong>2</strong></a>
                <ul>
                    <li><a href="parts.php" title="">Add New Special Order</a></li>
                    <li><a href="parts_list.php" title="">Special Order List</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/page-layouts.png" alt="" />Estimates<strong>2</strong></a>
                <ul>
                    <li><a href="estimate.php" title="">Add New Estimates</a></li>
                    <li><a href="estimate_list.php" title="">Estimates  List</a></li>
                </ul>
            </li>
            <!--<li><a href="#" title="" class="expand"><img src="images/icons/mainnav/typography.png" alt="" />Ticket<strong>2</strong></a>
                <ul>
                    <li><a href="ticket.php" title="">Add New Ticket</a></li>
                    <li><a href="ticket_list.php" title="">Ticket List</a></li>
                </ul>
            </li>-->
            <?php /* ?><?php if($input_by!="1431472960"){ ?>
              <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/unlock.png" alt="" />Unlock<strong>2</strong></a>
              <ul>
              <li><a href="unlock.php" title="">Add New Unlock</a></li>
              <li><a href="unlock_list.php" title="">Unlock List</a></li>
              </ul>
              </li>
              <?php } ?><?php */ ?>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/warrenty.png" alt="" />Warranty<strong>2</strong></a>
                <ul>
                    <li><a href="warrenty_search.php" title="">Add New Warranty</a></li>
                    <li><a href="warrenty_list.php" title="">Warranty List</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/buyback.png" alt="" />BuyBack<strong>2</strong></a>
                <ul>
                    <li><a href="buyback.php" title="">Add New BuyBack</a></li>
                    <li><a href="buyback_list.php" title="">BuyBack List</a></li>
                </ul>
            </li>
            <li><a href="startarepair.php"  title=""><img src="images/icons/mainnav/invoice.png" alt="" />Start a repair</a>
            <!--<li><a href="#"  class="expand" title=""><img src="images/icons/mainnav/invoice.png" alt="" />Check IN<strong>2</strong></a>
                <ul>
                    <li><a href="checkin.php" title="">Customer Check In Request</a></li>
                    <li><a href="checkin_list.php" title="">Check In List</a></li>
                </ul>
            </li>-->
            <li><a href="#" title="Inventory Detail" class="expand"><img src="images/icons/mainnav/inventory.png" alt="" />Inventory<strong>9</strong></a>
                <ul>
                    <li><a href="inventory.php" title="Add New Other Inventory">Add New Other Inventory</a></li>
                    <li><a href="inventory_phone.php" title="Add New Device Inventory">Add New Device Inventory</a></li>
                    <li><a href="inventory_reoccurring.php" title="Add New Reoccurring Inventory">Add New Reoccurring Inventory</a></li>
                    <li><a href="inventory_list.php" title="Parts Inventory  List">Parts Inventory </a></li>
                    <li><a href="inventory_maintain_list.php" title="Maintain Stock Inventory  List">Maintain Stock Inventory </a></li>
                    <li><a href="phone_inventory_list.php" title="Device Inventory List">Device Inventory</a></li>
                    <li><a href="inventory_other_list.php" title="Other Inventory List">Other Inventory</a></li>
                    <li><a href="inventory_reoccurring_list.php" title="Reoccurring Inventory List">Reoccurring Inventory</a></li>
                    <li><a href="reoccurring_invoice.php" title="Reoccurring Invoice">Reoccurring Invoice</a></li>
                    <li><a href="other_inventory_import.php" title="Import Other Inventory Product from excel">Import Other Inventory</a></li>
                    <li><a href="startaverience.php"  title="Start a verience">Start a Variance</a></li>
                    <li><a href="purchase.php" title=""> Purchase </a></li>
                    <li><a href="reorder.php" title="Inventory Reorder Products"> Reorder</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/money.png" alt="" />POS System<strong>2</strong></a>
                <ul>
                    <li><a href="pos.php" title="">POS </a></li>
                    <li><a href="sales_list.php" title="">POS-Sales List</a></li>
                </ul>
            </li>
           <!--  <li><a href="business_report.php" title=""><img src="images/icons/mainnav/rep2.png" alt="" />Business Report</a></li>-->
            <li><a href="calender.php" title="" class="expand"><img src="images/icons/mainnav/calendar.png" alt="" />Event Calendar<strong>2</strong></a>
                <ul>
                    <li><a href="add_event_calender.php" title="">New Event/Schedule</a></li>
                    <li><a href="calender.php" title="">View Events & Schedule</a></li>
                </ul>
            </li>
                <!--<li><a href="setting_clear.php" title="Clear All Data"><img src="images/icons/mainnav/clear.png" alt="" /> Clear Data </a></li>-->
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/report.png" alt="" />Report<strong>17</strong></a>
                <ul>
                    <li><a href="allreport_store.php" title="">All Report</a></li>
                    <li><a href="buyback_report.php" title="BuyBack Report">BuyBack Report Date wise</a></li>
                    <li><a href="buyback_estimate_report.php" title="Buyback Estimate Request">Buyback Estimate Request</a></li>
                    <li><a href="cashier_sales_report.php" title="Cashier Sales Report">Cashier Sales Report</a></li>
                    <li><a href="customer_report.php" title="">Customer Report Date wise</a></li>
                    <li><a href="checkin_report.php" title="">Check In Report Date wise</a></li>
                    <li><a href="highest_seller_cashier_report.php" title="">Highest Seller List</a></li>
                    <li><a href="inventory_report.php" title="">Inventory Report Date wise</a></li>
                    <li><a href="checkin_lcd_report.php" title="">LCD Status Report Date wise</a></li>
                    <li><a href="payout_report.php" title="">Payout Report Date wise</a></li>
                    <li><a href="profit_report.php" title="Profit Report">Profit Report Date wise</a></li>
                    <li><a href="sales_report.php" title="">Sales Report Date wise</a></li>
                    <li><a href="checkin_salvage_part_report.php" title="">Salvage Part Report Date wise</a></li>
                    <li><a href="store_closing_report.php" title="">Store Closing Report</a></li>
                    <li><a href="part_report.php" title="">Special Order Report Date wise</a></li>
                    <li><a href="tranaction.php" title="">Transaction</a></li>
                    <li><a href="ticket_report.php" title="">Ticket Report Date wise</a></li>
                    <li><a href="tender_report.php" title="Tender Report">Tender Report Date wise</a></li>
                    <li><a href="warrenty_report.php" title="">Warranty Report </a></li>
                    <?php /* ?><?php if($input_by!="1431472960"){ ?>
                      <li><a href="unlock_report.php" title="">Unlock Report Date wise</a></li>
                      <?php } ?><?php */ ?>

                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/setting.png" alt="" />System Setting<strong>26</strong></a>
                <ul>
                    <li><a href="barcode.php" title="">Barcode </a></li>
                    <li><a href="setting_barcode_print.php" title="Barcode Printer Paper Setting">Barcode Print Paper Setting</a></li>
                    <li><a href="customer_wallet.php" title="">Customer Wallet</a></li>
                    <li><a href="store_currency.php" title="">Store Currency Setting</a></li>
                    <li><a href="setting_customer.php" title="">Customer Setting</a></li>
                    <li><a style="border:none;"  class="expand" href="#" title=""><i style="margin-top:4px; margin-left:-20px;" class="icon-map-marker"></i> Checkin Setting </a>
                        <ul>
                            <li style="border:none;"><a href="checkin_name_setting.php" style="font-weight:bolder;" target="_blank" title="">Check In Category</a></li>
                            <li style="border:none;"><a href="checkin_name_version_setting.php" style="font-weight:bolder;" target="_blank" title="">Check In Category Version</a></li>
                            <li style="border:none;"><a href="checkin_name_version_color_setting.php" style="font-weight:bolder;" target="_blank" title="">Check In Device Color</a></li>

                            <li style="border:none;"><a href="checkin_network.php" target="_blank" style="font-weight:bolder;" title="">Check In Network</a></li>
                            <li style="border:none;"><a href="checkin_problem.php" target="_blank" style="font-weight:bolder;" title="">Check In Problem</a></li>
                            <li style="border:none;"><a href="checkin_price.php" target="_blank" style="font-weight:bolder;" title="">Check In Price</a></li>
                        </ul>
                    </li>
                    <li><a href="checkin_lcd_report.php?dels=all" title="">Clear All LCD Status</a></li>
                    <li><a href="cashier.php" title="Cashier Info ">Cashier</a></li>
                    <li><a href="cashier_punch_history.php" title="Cashier Punch Hostory ">Cashier Punch Log</a></li>
                    <li><a href="setting_estimates.php" title="">Estimates Setting</a></li>
                    <li><a href="setting_inventory.php" title="">Inventory Setting</a></li>
                    <li><a href="manager.php" title="Manager Info ">Manager</a></li>
                    <li><a href="setting_parts.php" title="">Parts Setting</a></li>
                    <li><a href="setting_pos.php" title="">POS Setting</a></li>
                    <li><a href="setting_pos_print.php" title="Pos Printer Paper Setting">Pos Print Paper Setting</a></li>
                    <li><a href="report_setting.php" title="">Report Setting</a></li>
                    <li><a href="setting_thermal_print.php" title="Thermal Printer Paper Setting">Thermal Print Paper Setting</a></li>
                    <li><a href="asset_type.php" title="">Ticket Asset Type</a></li>
                    <li><a href="ticket_custom_field.php" title="">Ticket Custom Field</a></li>
                    <li><a href="tax.php" title="">Tax </a></li>
                    <li><a href="punch_in_out.php" title="">Manage Punch In/Out  </a></li>
                    <li><a href="vendor_list.php" title=""> Vendor </a></li>
                </ul>
            </li>
            <li><a href="helpdesk.php" title="Help Desk?"><img src="images/icons/mainnav/messages.png" alt="" />Help Desk</a>
            <?php }elseif ($input_status == 3) { ?>
            <li><a href="index.php" title=""><img src="images/icons/mainnav/dashboard.png" alt="" />Dashboard</a></li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/user.png" alt="" />Customer<strong>3</strong></a>
                <ul>
                    <li><a href="customer.php" title="">New Customer</a></li>
                    <li><a href="customer_list.php" title="">Customer List</a></li>
                    <li><a href="customer_list_import.php" title="">Import Customer</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/page-layouts.png" alt="" />Special Order Parts<strong>2</strong></a>
                <ul>
                    <li><a href="parts.php" title="">Add New Special Order</a></li>
                    <li><a href="parts_list.php" title="">Special Order List</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/page-layouts.png" alt="" />Estimates<strong>2</strong></a>
                <ul>
                    <li><a href="estimate.php" title="">Add New Estimates</a></li>
                    <li><a href="estimate_list.php" title="">Estimates  List</a></li>
                </ul>
            </li>
            <!--<li><a href="#" title="" class="expand"><img src="images/icons/mainnav/typography.png" alt="" />Ticket<strong>2</strong></a>
                <ul>
                    <li><a href="ticket.php" title="">Add New Ticket</a></li>
                    <li><a href="ticket_list.php" title="">Ticket List</a></li>
                </ul>
            </li>-->
            <?php /* ?><?php if($input_by!="1431472960"){ ?>
              <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/unlock.png" alt="" />Unlock<strong>2</strong></a>
              <ul>
              <li><a href="unlock.php" title="">Add New Unlock</a></li>
              <li><a href="unlock_list.php" title="">Unlock List</a></li>
              </ul>
              </li>
              <?php } ?><?php */ ?>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/warrenty.png" alt="" />Warranty<strong>2</strong></a>
                <ul>
                    <li><a href="warrenty_search.php" title="">Add New Warranty</a></li>
                    <li><a href="warrenty_list.php" title="">Warranty List</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/buyback.png" alt="" />BuyBack<strong>2</strong></a>
                <ul>
                    <li><a href="buyback.php" title="">Add New BuyBack</a></li>
                    <li><a href="buyback_list.php" title="">BuyBack List</a></li>
                    <li><a href="buyback_estimate_report.php" title="">Buyback Estimate Request</a></li>
                </ul>
            </li>
            <li><a href="startarepair.php"  title=""><img src="images/icons/mainnav/invoice.png" alt="" />Start a repair</a>
            <!--<li><a href="#"  class="expand" title=""><img src="images/icons/mainnav/invoice.png" alt="" />Check IN<strong>2</strong></a>
                <ul>
                    <li><a href="checkin.php" title="">Customer Check In Request</a></li>
                    <li><a href="checkin_list.php" title="">Check In List</a></li>
                </ul>
            </li>-->
            <li><a href="#" title="Inventory Detail" class="expand"><img src="images/icons/mainnav/inventory.png" alt="" />Inventory<strong>6</strong></a>
                <ul>
                    <li><a href="inventory_list.php" title="Parts Inventory  List">Parts Inventory </a></li>
                    <li><a href="inventory_maintain_list.php" title="Maintain Stock Inventory  List">Maintain Stock Inventory </a></li>
                    <li><a href="inventory_reoccurring_list.php" title="Reoccurring Inventory">Reoccurring Inventory</a></li>
                    <li><a href="reoccurring_invoice.php" title="Reoccurring Invoice">Reoccurring Invoice</a></li>
                    <li><a href="phone_inventory_list.php" title="Device Inventory List">Device Inventory</a></li>
                    <li><a href="inventory_other_list.php" title="Other Inventory List">Other Inventory</a></li>
                    <li><a href="startaverience.php"  title="Start a verience">Start a Variance</a></li>
                    <li><a href="purchase_list_order.php" title=""> Purchase </a></li>
                    <li><a href="reorder.php" title="Inventory Reorder Products"> Reorder</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/money.png" alt="" />POS System<strong>2</strong></a>
                <ul>
                    <li><a href="pos.php" title="">POS </a></li>
                    <li><a href="sales_list.php" title="">POS-Sales List</a></li>
                    <li><a href="payout_report.php" title="">Payout Report Date wise</a></li>
                </ul>
            </li>
            <li><a href="calender.php" title="" class="expand"><img src="images/icons/mainnav/calendar.png" alt="" />Event Calendar<strong>2</strong></a>
                <ul>
                    <li><a href="add_event_calender.php" title="">New Event/Schedule</a></li>
                    <li><a href="calender.php" title="">View Events & Schedule</a></li>
                </ul>
            </li>
            <li><a href="helpdesk.php" title="Help Desk?"><img src="images/icons/mainnav/messages.png" alt="" />Help Desk</a>
            <?php }elseif ($input_status == 4) { ?>
            <li><a href="index.php" title=""><img src="images/icons/mainnav/dashboard.png" alt="" />Dashboard</a></li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/user.png" alt="" />Customer<strong>3</strong></a>
                <ul>
                    <li><a href="customer.php" title="">New Customer</a></li>
                    <li><a href="customer_list.php" title="">Customer List</a></li>
                    <li><a href="customer_list_import.php" title="">Import Customer</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/page-layouts.png" alt="" />Special Order Parts<strong>2</strong></a>
                <ul>
                    <li><a href="parts.php" title="">Add New Special Order</a></li>
                    <li><a href="parts_list.php" title="">Special Order Parts List</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/page-layouts.png" alt="" />Estimates<strong>2</strong></a>
                <ul>
                    <li><a href="estimate.php" title="">Add New Estimates</a></li>
                    <li><a href="estimate_list.php" title="">Estimates  List</a></li>
                </ul>
            </li>
            <!--<li><a href="#" title="" class="expand"><img src="images/icons/mainnav/typography.png" alt="" />Ticket<strong>2</strong></a>
                <ul>
                    <li><a href="ticket.php" title="">Add New Ticket</a></li>
                    <li><a href="ticket_list.php" title="">Ticket List</a></li>
                </ul>
            </li>-->
            <?php /* ?><?php if($input_by!="1431472960"){ ?>
              <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/unlock.png" alt="" />Unlock<strong>2</strong></a>
              <ul>
              <li><a href="unlock.php" title="">Add New Unlock</a></li>
              <li><a href="unlock_list.php" title="">Unlock List</a></li>
              </ul>
              </li>
              <?php } ?><?php */ ?>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/warrenty.png" alt="" />Warranty<strong>2</strong></a>
                <ul>
                    <li><a href="warrenty_search.php" title="">Add New Warranty</a></li>
                    <li><a href="warrenty_list.php" title="">Warranty List</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/buyback.png" alt="" />BuyBack<strong>2</strong></a>
                <ul>
                    <li><a href="buyback.php" title="">Add New BuyBack</a></li>
                    <li><a href="buyback_list.php" title="">BuyBack List</a></li>
                </ul>
            </li>
            <li><a href="startarepair.php"  title=""><img src="images/icons/mainnav/invoice.png" alt="" />Start a repair</a>
            <!--<li><a href="#"  class="expand" title=""><img src="images/icons/mainnav/invoice.png" alt="" />Check IN<strong>2</strong></a>
                <ul>
                    <li><a href="checkin.php" title="">Customer Check In Request</a></li>
                    <li><a href="checkin_list.php" title="">Check In List</a></li>
                </ul>
            </li>-->

            <li><a href="#" title="Inventory Detail" class="expand"><img src="images/icons/mainnav/inventory.png" alt="" />Inventory<strong>6</strong></a>
                <ul>
                    <li><a href="inventory_list.php" title="Parts Inventory  List">Parts Inventory </a></li>
                    <li><a href="inventory_maintain_list.php" title="Maintain Stock Inventory  List">Maintain Stock Inventory </a></li>
                    <li><a href="inventory_reoccurring_list.php" title="Reoccurring Inventory">Reoccurring Inventory</a></li>
                    <li><a href="phone_inventory_list.php" title="Device Inventory List">Device Inventory</a></li>
                    <li><a href="inventory_other_list.php" title="Other Inventory List">Other Inventory</a></li>
                    <li><a href="startaverience.php"  title="Start a verience">Start a Variance</a></li>
                    <li><a href="purchase_list_order.php" title=""> Purchase </a></li>
                    <li><a href="reorder.php" title="Inventory Reorder Products"> Reorder</a></li>
                </ul>
            </li>

            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/money.png" alt="" />POS System<strong>2</strong></a>
                <ul>
                    <li><a href="pos.php" title="">POS </a></li>
                    <li><a href="sales_list.php" title="">POS-Sales List</a></li>
                </ul>
            </li>
            <!-- <li><a href="business_report.php" title=""><img src="images/icons/mainnav/rep2.png" alt="" />Business Report</a></li>-->
            <li><a href="calender.php" title="" class="expand"><img src="images/icons/mainnav/calendar.png" alt="" />Event Calendar<strong>2</strong></a>
                <ul>
                    <li><a href="add_event_calender.php" title="">New Event/Schedule</a></li>
                    <li><a href="calender.php" title="">View Events & Schedule</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/report.png" alt="" />Report<strong>17</strong></a>
                <ul>
                    <li><a href="allreport_store.php" title="">All Report</a></li>
                    <li><a href="buyback_report.php" title="BuyBack Report">BuyBack Report Date wise</a></li>
                    <li><a href="buyback_estimate_report.php" title="Buyback Estimate Request">Buyback Estimate Request</a></li>
                    <li><a href="customer_report.php" title="">Customer Report Date wise</a></li>
                    <li><a href="cashier_sales_report.php" title="Cashier Sales Report">Cashier Sales Report</a></li>
                    <li><a href="checkin_report.php" title="">Check In Report Date wise</a></li>
                    <li><a href="highest_seller_cashier_report.php" title="">Highest Seller List</a></li>
                    <li><a href="inventory_report.php" title="">Inventory Report Date wise</a></li>
                    <li><a href="checkin_lcd_report.php" title="">LCD Status Report Date wise</a></li>
                    <li><a href="profit_report.php" title="Profit Report">Profit Report Date wise</a></li>

                    <li><a href="search_report.php" title="">Search Report </a></li>
                    <li><a href="sales_report.php" title="">Sales Report Date wise</a></li>
                    <li><a href="checkin_salvage_part_report.php" title="">Salvage Part Report Date wise</a></li>
                    <li><a href="part_report.php" title="">Special Order Report Date wise</a></li>
                    <li><a href="tranaction.php" title="">Transaction</a></li>
                    <li><a href="punch_in_out.php" title="">Manage Punch In/Out  </a></li>
                    <li><a href="payout_report.php" title="">Payout Report Date wise</a></li>
                    <li><a href="ticket_report.php" title="">Ticket Report Date wise</a></li>
                    <li><a href="tender_report.php" title="Tender Report">Tender Report Date wise</a></li>
                    <li><a href="warrenty_report.php" title="">Warranty Report </a></li>
                    <?php /* ?><?php if($input_by!="1431472960"){ ?>
                      <li><a href="unlock_report.php" title="">Unlock Report Date wise</a></li>
                      <?php } ?><?php */ ?>
                </ul>
            </li>
            <li><a href="helpdesk.php" title="Help Desk?"><img src="images/icons/mainnav/messages.png" alt="" />Help Desk</a>
            <?php }elseif ($input_status == 5) { ?>

            <li><a href="index.php" title=""><img src="images/icons/mainnav/dashboard.png" alt="" />Dashboard</a></li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/user.png" alt="" />Customer<strong>3</strong></a>
                <ul>
                    <li><a href="customer.php" title="">New Customer</a></li>
                    <li><a href="customer_list.php" title="">Customer List</a></li>
                    <li><a href="customer_list_import.php" title="">Import Customer</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/page-layouts.png" alt="" />Special Order Parts<strong>2</strong></a>
                <ul>
                    <li><a href="parts.php" title="">Add New Special Order</a></li>
                    <li><a href="parts_list.php" title="">Special Order List</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/page-layouts.png" alt="" />Estimates<strong>2</strong></a>
                <ul>
                    <li><a href="estimate.php" title="">Add New Estimates</a></li>
                    <li><a href="estimate_list.php" title="">Estimates  List</a></li>
                </ul>
            </li>
            <!--<li><a href="#" title="" class="expand"><img src="images/icons/mainnav/typography.png" alt="" />Ticket<strong>2</strong></a>
                <ul>
                    <li><a href="ticket.php" title="">Add New Ticket</a></li>
                    <li><a href="ticket_list.php" title="">Ticket List</a></li>
                </ul>
            </li>-->
            <?php /* ?><?php if($input_by!="1431472960"){ ?>
              <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/unlock.png" alt="" />Unlock<strong>2</strong></a>
              <ul>
              <li><a href="unlock.php" title="">Add New Unlock</a></li>
              <li><a href="unlock_list.php" title="">Unlock List</a></li>
              </ul>
              </li>
              <?php } ?><?php */ ?>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/warrenty.png" alt="" />Warranty<strong>2</strong></a>
                <ul>
                    <li><a href="warrenty_search.php" title="">Add New Warranty</a></li>
                    <li><a href="warrenty_list.php" title="">Warranty List</a></li>
                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/buyback.png" alt="" />BuyBack<strong>2</strong></a>
                <ul>
                    <li><a href="buyback.php" title="">Add New BuyBack</a></li>
                    <li><a href="buyback_list.php" title="">BuyBack List</a></li>
                </ul>
            </li>
            <li><a href="startarepair.php"  title=""><img src="images/icons/mainnav/invoice.png" alt="" />Start a repair</a>
            <!--<li><a href="#"  class="expand" title=""><img src="images/icons/mainnav/invoice.png" alt="" />Check IN<strong>2</strong></a>
                <ul>
                    <li><a href="checkin.php" title="">Customer Check In Request</a></li>
                    <li><a href="checkin_list.php" title="">Check In List</a></li>
                </ul>
            </li>-->
            <li><a href="#" title="Inventory Detail" class="expand"><img src="images/icons/mainnav/inventory.png" alt="" />Inventory<strong>9</strong></a>
                <ul>
                    <li><a href="inventory.php" title="Add New Other Inventory">Add New Other Inventory</a></li>
                    <li><a href="inventory_phone.php" title="Add New Device Inventory">Add New Device Inventory</a></li>
                    <li><a href="inventory_reoccurring.php" title="Add New Reoccurring Inventory">Add New Reoccurring Inventory</a></li>
                    <li><a href="inventory_list.php" title="Parts Inventory  List">Parts Inventory </a></li>
                    <li><a href="inventory_maintain_list.php" title="Maintain Stock Inventory  List">Maintain Stock Inventory </a></li>
                    <li><a href="phone_inventory_list.php" title="Device Inventory List">Device Inventory</a></li>
                    <li><a href="inventory_other_list.php" title="Other Inventory List">Other Inventory</a></li>
                    <li><a href="inventory_reoccurring_list.php" title="Reoccurring Inventory List">Reoccurring Inventory</a></li>
                    <li><a href="reoccurring_invoice.php" title="Reoccurring Invoice">Reoccurring Invoice</a></li>
                    <li><a href="other_inventory_import.php" title="Import Other Inventory Product from excel">Import Other Inventory</a></li>
                    <li><a href="startaverience.php"  title="Start a verience">Start a Variance</a></li>
                    <li><a href="purchase.php" title=""> Purchase </a></li>
                    <li><a href="reorder.php" title="Inventory Reorder Products"> Reorder</a></li>
                </ul>

            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/money.png" alt="" />POS System<strong>2</strong></a>
                <ul>
                    <li><a href="pos.php" title="">POS </a></li>
                    <li><a href="sales_list.php" title="">POS-Sales List</a></li>
                </ul>
            </li>
            <!-- <li><a href="business_report.php" title=""><img src="images/icons/mainnav/rep2.png" alt="" />Business Report</a></li>-->
            <li><a href="calender.php" title="" class="expand"><img src="images/icons/mainnav/calendar.png" alt="" />Event Calendar<strong>2</strong></a>
                <ul>
                    <li><a href="add_event_calender.php" title="">New Event/Schedule</a></li>
                    <li><a href="calender.php" title="">View Events & Schedule</a></li>
                </ul>
            </li>
            <li><a href="store_chain_list.php"  title=""><img src="images/icons/mainnav/buttons-icons.png" alt="" />Chain Shops</a>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/report.png" alt="" />Report<strong>17</strong></a>
                <ul>
                    <li><a href="allreport_store.php" title="">All Report</a></li>
                    <li><a href="buyback_report.php" title="BuyBack Report">BuyBack Report Date wise</a></li>
                    <li><a href="buyback_estimate_report.php" title="Buyback Estimate Request">Buyback Estimate Request</a></li>
                    <li><a href="cashier_sales_report.php" title="Cashier Sales Report">Cashier Sales Report</a></li>
                    <li><a href="customer_report.php" title="">Customer Report Date wise</a></li>
                    <li><a href="checkin_report.php" title="">Check In Report Date wise</a></li>
                    <li><a href="highest_seller_cashier_report.php" title="">Highest Seller List</a></li>
                    <li><a href="inventory_report.php" title="">Inventory Report Date wise</a></li>
                    <li><a href="checkin_lcd_report.php" title="">LCD Status Report Date wise</a></li>
                    <li><a href="payout_report.php" title="">Payout Report Date wise</a></li>
                    <li><a href="profit_report.php" title="Profit Report">Profit Report Date wise</a></li>
                    <li><a href="sales_report.php" title="">Sales Report Date wise</a></li>
                    <li><a href="checkin_salvage_part_report.php" title="">Salvage Part Report Date wise</a></li>
                    <li><a href="store_closing_report.php" title="">Store Closing Report</a></li>
                    <li><a href="part_report.php" title="">Special Order Report Date wise</a></li>
                    <li><a href="tranaction.php" title="">Transaction</a></li>
                    <li><a href="ticket_report.php" title="">Ticket Report Date wise</a></li>
                    <li><a href="tender_report.php" title="Tender Report">Tender Report Date wise</a></li>
                    <li><a href="warrenty_report.php" title="">Warranty Report </a></li>
                    <?php /* ?><?php if($input_by!="1431472960"){ ?>
                      <li><a href="unlock_report.php" title="">Unlock Report Date wise</a></li>
                      <?php } ?><?php */ ?>

                </ul>
            </li>
            <li><a href="#" title="" class="expand"><img src="images/icons/mainnav/setting.png" alt="" />System Setting<strong>26</strong></a>
                <ul>
                    <li><a href="barcode.php" title="">Barcode </a></li>
                    <li><a href="setting_customer.php" title="">Customer Setting</a></li>
                    <li><a style="border:none;"  class="expand" href="#" title=""><i style="margin-top:4px; margin-left:-20px;" class="icon-map-marker"></i> Checkin Setting </a>
                        <ul>
                            <li style="border:none;"><a href="checkin_name_setting.php" style="font-weight:bolder;" target="_blank" title="">Check In Category</a></li>
                            <li style="border:none;"><a href="checkin_name_version_setting.php" style="font-weight:bolder;" target="_blank" title="">Check In Category Version</a></li>
                            <li style="border:none;"><a href="checkin_name_version_color_setting.php" style="font-weight:bolder;" target="_blank" title="">Check In Device Color</a></li>

                            <li style="border:none;"><a href="checkin_network.php" target="_blank" style="font-weight:bolder;" title="">Check In Network</a></li>
                            <li style="border:none;"><a href="checkin_problem.php" target="_blank" style="font-weight:bolder;" title="">Check In Problem</a></li>
                            <li style="border:none;"><a href="checkin_price.php" target="_blank" style="font-weight:bolder;" title="">Check In Price</a></li>
                        </ul>
                    </li>
                    <li><a href="checkin_lcd_report.php?dels=all" title="">Clear All LCD Status</a></li>
                    <li><a href="cashier.php" title="Cashier Info ">Cashier</a></li>
                    <li><a href="cashier_punch_history.php" title="Cashier Punch Hostory ">Cashier Punch Log</a></li>
                    <li><a href="setting_estimates.php" title="">Estimates Setting</a></li>
                    <li><a href="setting_inventory.php" title="">Inventory Setting</a></li>
                    <li><a href="manager.php" title="Manager Info ">Manager</a></li>
                    <li><a href="setting_parts.php" title="">Parts Setting</a></li>
                    <li><a href="setting_pos.php" title="">POS Setting</a></li>
                    <li><a href="report_setting.php" title="">Report Setting</a></li>
                    <li><a href="asset_type.php" title="">Ticket Asset Type</a></li>
                    <li><a href="ticket_custom_field.php" title="">Ticket Custom Field</a></li>
                    <li><a href="tax.php" title="">Tax </a></li>
                    <li><a href="vendor_list.php" title=""> Vendor </a></li>
                </ul>
            </li>

            <li><a href="helpdesk.php" title="Help Desk?"><img src="images/icons/mainnav/messages.png" alt="" />Help Desk</a>
            <?php } ?>

    </ul><!-- /standard nav -->

    <div class="separator-doubled"></div>
</div>