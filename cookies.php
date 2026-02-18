<?php
    $cookie_name = "user";
    $cookie_value = "John Doe";
    setcookie($cookie_name,$cookie_value,time()+(300),"/");
?>
<html>
<body>
    <?php
        if(!isset($_COOKIE[$cookie_name])){
            echo "Cookie named '".$cookie_name."' is not set!";
        }
        else{
            echo "Cookie'".$cookie_name."'is set!<br>";
            echo "value is: ".$_COOKIE[$cookie_name];
        }
    ?>
</body>
</html>
<?php
    setcookie($cookie_name,$cookie_value,time()-60,"/");
?>