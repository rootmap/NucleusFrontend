<?php
/*include('class/db_Class.php');	
$signobj = new db_class();
$ticket_id=$_REQUEST['ticket_id'];
echo $ticket_id;*/
$getSign=$_SESSION['getSign'];
$terms=$_SESSION['terms'];
unset($_SESSION['getSign']);
?>
  <link rel="stylesheet" href="signature-pad/build/jquery.signaturepad.css">
  <script type="text/javascript" src="http://dzlawoffices.com/nucleus/js/jquery-1.9.1.js"></script>
  <script>
  var $j = $.noConflict();
  </script>
  

  <?php
  	if($getSign==''){
     	?>
        <form method="post" class="sigPad">
		  <?php if (isset($errors['output'])) : ?>
          <p class="error">Please sign the document</p>
          <?php endif; ?>
          <ul class="sigNav" style="display:block">
            <li class="drawIt">Draw your signature</li>
            <li class="clearButton"><a href="#clear">Clear</a></li>
          </ul>
          <div class="sig sigWrapper" style="display:block">
            <div class="typed"></div>
            <canvas class="pad" width="498" height="100" id="canvas"></canvas>
            <input type="hidden" name="output" class="output">
            <input type="hidden" name="repair_id" id="repair_id" value="<?=$_REQUEST['ticket_id']?>">
            <input type="hidden" name="terms" id="terms" value="<?=$terms?>">
          </div>
          <button name="savesignature" type="submit">I accept the terms of this agreement.</button>
        </form>
        <?php
	}else{
		?>
        <div class="sigPad signed">
          <div class="sigWrapper">
            <canvas class="pad" width="498" height="100" id="canvas"></canvas>
          </div>
        </div>
        <?php
	}
  ?>
  <script src="signature-pad/build/jquery.signaturepad.min.js"></script>
  <?php
    // Another trigger to write the appropriate Javascript to the page:
    //  If we are showing the form, write the initialization code
    //  If we are showing the final signature, write the regeneration code
    if ($getSign=='') :
  ?>
  <script>
    $j(document).ready(function () {
      $j('.sigPad').signaturePad({drawOnly : true});
    });
  </script>
  <?php else : ?>
  <script>
    $j(document).ready(function () {
	  // Write out the complete signature from the database to Javascript
      var sig = <?php echo $getSign; ?>;
      $j('.sigPad').signaturePad({displayOnly : true}).regenerate(sig);
    });
  </script>
  <?php endif; ?>
  <script src="signature-pad/build/json2.min.js"></script>
