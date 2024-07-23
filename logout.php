<?php
    $con=mysqli_connect("localhost", "root", "","registrations") or die(mysqli_error());
    if( isset($_GET['id']) && !empty($_GET['id']) AND isset($_GET['Sec']) && !empty($_GET['Sec']))
    {
    $id = mysqli_real_escape_string($con,$_GET['id']);
    $Sec = mysqli_real_escape_string($con,$_GET['Sec']);
    $im_out=mysqli_query($con,"UPDATE users SET login='0' WHERE id='$id' ") or die(mysql_error());
    }
    else
    {
    header("Location: 404.php");
    }
    header("Location: index.php");
?>