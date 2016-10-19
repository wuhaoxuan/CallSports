<?php
  // include function files for this application
  require_once('user_auth_fns.php');
  

  //create short variable names
  $email=$_POST['email'];
  $username=$_POST['username'];
  $passwd=$_POST['passwd'];
  $passwd2=$_POST['passwd2'];
  
  try   {
    // check forms filled in
    if (!filled_out($_POST)) {
      throw new Exception('You have not filled the form out correctly - please go back and try again.');
    }

    // email address not valid
    if (!valid_email($email)) {
      throw new Exception('That is not a valid email address.  Please go back and try again.');
    }

    // passwords not the same
    if ($passwd != $passwd2) {
      throw new Exception('The passwords you entered do not match - please go back and try again.');
    }

    // check password length is ok
    // ok if username truncates, but passwords will get
    // munged if they are too long.
    if ((strlen($passwd) < 6) || (strlen($passwd) > 16)) {
      throw new Exception('Your password must be between 6 and 16 characters Please go back and try again.');
    }

    // attempt to register
    // this function can also throw an exception
    register($username, $email, $passwd);
 
    //put the result to phone	
    echo json_encode(array('result' => 'success'));
    exit;
  }
  catch (Exception $e) {
      $errInfo = $e->getMessage();
      echo json_encode(array('result' => $errInfo));      
      exit;
  }
?>
