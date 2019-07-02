<?php
// The basic Signature Pad HTML template
//  with the addition of server side validation error messages
?>
<form method="post" class="sigPad">
  <?php if (isset($errors['output'])) : ?>
  <p class="error">Please sign the document</p>
  <?php endif; ?>
  <?php if (isset($errors['name'])) : ?>
  <p class="error">Please enter your name</p>
  <?php endif; ?>
  <ul class="sigNav" style="display:block">
    <li class="drawIt">Draw your signature</li>
    <li class="clearButton"><a href="#clear">Clear</a></li>
  </ul>
  <div class="sig sigWrapper" style="display:block">
    <div class="typed"></div>
    <canvas class="pad" width="198" height="55"></canvas>
    <input type="hidden" name="output" class="output">
    <input type="hidden" name="repair_id" id="repair_id" value="<?=$_REQUEST['ticket_id']?>">
  </div>
  <button name="savesignature" type="submit">I accept the terms of this agreement.</button>
</form>
