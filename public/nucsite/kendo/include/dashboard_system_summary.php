<button type="button" class="btn btn-success" id="dashboard_system_summary" onclick="dashboard_system_summary()" style="position:absolute; right:3px;"><i class="icon-refresh"></i> Load Data</button>
<table>

    <tbody>
    
        <tr>
    
    
    
            <td width="70%"><a  style="height:32px; width:180px; line-height:32px; font-size:18px;" href="customer_list.php" class="btn"><i class="icon-th-list"></i> Customer List</a></td>
    
            <td width="30%"> <a style="width:auto; text-align:center; margin-left:30px; height:32px;  line-height:32px; font-size:18px;" class="btn" id="customer_total">0</a></td>
    
        </tr>
    
    
    
        <tr>
    
    
    
            <td><a  style="height:32px; width:180px; line-height:32px; font-size:18px;" href="ticket_list.php" class="btn"><i class="icon-th-list"></i> Ticket Request</a></td>
    
            <td> <a style="width:auto; text-align:center; margin-left:30px; height:32px;  line-height:32px; font-size:18px;" class="btn" id="ticket_total">0</a> </td>
    
        </tr>
    
    
    
        <tr>
    
    
    
            <td><a  style="height:32px; width:180px; line-height:32px; font-size:18px;" href="checkin.php" class="btn"><i class="icon-th-list"></i> Check In Request</a></td>
    
            <td> <a style="width:auto; text-align:center; margin-left:30px; height:32px;  line-height:32px; font-size:18px;" class="btn" id="checkin_total">0</a> </td>
    
        </tr>
        <?php if($input_status!=5){ ?>
        <tr>
    
        
    
        <td><a  style="height:32px; width:180px; line-height:32px; font-size:18px;" href="sales_list.php" class="btn"><i class="icon-th-list"></i> Nucleus Sales </a></td>
    
        <td> <a style="width:auto; text-align:center; margin-left:30px; height:32px;  line-height:32px; font-size:18px;" class="btn" id="sales_total_quantity">0</a> </td>
    
        </tr>
        <?php } ?>
     
    
        <tr>
    
    <td><a  style="height:32px; width:180px; line-height:32px; font-size:18px;" href="estimate_list.php" class="btn"><i class="icon-th-list"></i> Estimate</a></td>
    
    <td> <a style="width:auto; text-align:center; margin-left:30px; height:32px;  line-height:32px; font-size:18px; margin-bottom:7px;" class="btn" id="estimate_total">0</a> </td>
    
    </tr>
    
    
    
    <tr>
    
    
    
        <td><a  style="height:32px; width:180px; line-height:32px; font-size:18px;" href="buyback_list.php" class="btn"><i class="icon-th-list"></i> BuyBack List </a></td>
    
        <td> <a style="width:auto; text-align:center; margin-left:30px; height:32px;  line-height:32px; font-size:18px;" class="btn" id="buyback_total">0</a> </td>
    
    </tr>
    
    <?php if($input_by!="1431472960"){ 
    if($input_status==1)
    {
    ?>
    
    <tr>
    
    
    
    
        <td><a  style="height:32px; width:180px; line-height:32px; font-size:18px;" href="unlock_list.php" class="btn"><i class="icon-th-list"></i> Unlock List </a></td>
    
        <td> <a style="width:auto; text-align:center; margin-left:30px; height:32px;  line-height:32px; font-size:18px;" class="btn" id="unlock_total">0</a> </td>
    
    </tr>
    <?php 
    }
    } ?>
    
    
    </tbody>
    
    </table>