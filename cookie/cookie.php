<?php
  $cookie_name = "user";
  if (isset($_GET['action'])) {
    $action = $_GET['action'];
    // Handle cookie update
    // PUT YOUR CODE HERE
     if ($action == "update" && isset($_GET['value'])) {
      $cookie_value = $_GET['value'];
      setcookie($cookie_name, $cookie_value, time() + 600, "/");
    }

    // Handle cookie removal
    // PUT YOUR CODE HERE
    if($action == 'remove'){
        setcookie($cookie_name,$cookie_value,time()-600,"/");
        unset($_COOKIE[$cookie_name]);
    }
    
    // Reload Page
    header("Location: cookie.php");
  }
?>

<html>
  <head>
    <link rel="stylesheet" href="custom_style.css">
  </head>
  <body>
  <div id="cookie_div">
  <?php
    if(!isset($_COOKIE[$cookie_name])) {
      echo "Cookie is not set for this site!";
    } else {
      echo "Cookie '" . $cookie_name . "' is set!<br>";
      echo "Value is: " . $_COOKIE[$cookie_name];
    }
    include "cookie.html";
  ?>
  </div>
  </body>
</html>