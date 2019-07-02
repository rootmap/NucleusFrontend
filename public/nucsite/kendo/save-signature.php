<?php
if (isset($_POST['savesignature'])) {
	
	$output = filter_input(INPUT_POST, 'output', FILTER_UNSAFE_RAW);
	$repair_id = filter_input(INPUT_POST, 'repair_id', FILTER_UNSAFE_RAW);
	$terms = filter_input(INPUT_POST, 'terms', FILTER_UNSAFE_RAW);


  if (!json_decode($output)) {
    $errors['output'] = true;
  }

  // No validation errors exist, so we can start the database stuff
  if (empty($errors)) {
    
	
    $db=new PDO("mysql:host=localhost;dbname=nucleusp_pos;","nucleusp_pos","8vxs~(o(1Q{+");
	// Make sure we are talking to the database in UTF-8
    $db->exec('SET NAMES utf8');

    $sig_hash = sha1($output);
    $created = time();

    // 5. Use PDO prepare to insert all the information into the database
    $sql = $db->prepare('
      INSERT INTO signatures (checkin_id, signature, sig_hash, created, terms, ticket_id)
      VALUES (:checkin_id, :signature, :sig_hash, :created, :terms, 0)
    ');
    $sql->bindValue(':checkin_id', $repair_id, PDO::PARAM_STR);
    $sql->bindValue(':signature', $output, PDO::PARAM_STR);
    $sql->bindValue(':sig_hash', $sig_hash, PDO::PARAM_STR);
    $sql->bindValue(':created', $created, PDO::PARAM_INT);
	$sql->bindValue(':terms', $terms, PDO::PARAM_STR);
    $sql->execute();
	
  }
}
