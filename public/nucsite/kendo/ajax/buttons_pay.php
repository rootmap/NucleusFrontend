<?php
include('../class/auth.php');
extract($_GET);
if ($cart != '') {
    ?>
    <input type="hidden" name="invoice" value="<?php echo $cart; ?>">
    <input type="hidden" name="action" value="pdf">
    <button class="btn" data-dismiss="modal">Exit</button>
    <select onchange="PrintFromPos(this.value)" name="printopt" id="printopt"   style="margin-top: -2px;">
        <option value="0">Select A Print Method</option> 
        <option value="1">Pos Print</option> 
        <option value="2">Barcode Print</option> 
        <option value="3">Thermal Print</option> 
    </select>
    <button style="position: absolute; left: -2000px;" onClick="loadblankpage(<?php echo $cart; ?>)" id="paidnprint" name="paidnprint" type="submit"></button>
    <button class="btn btn-success" name="onlypaid" type="submit">Only Paid</button>
    
       

<?php
} else {
    echo "Re-Load Page";
}
?>