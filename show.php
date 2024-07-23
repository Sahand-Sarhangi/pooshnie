<!doctype html>
<html>

<head>
    <title>حساب کاربری</title>

    <!-- CSS 
    ================================================== -->
    <link href="css/style.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap 
    ================================================== -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>

    <!-- Farsi 
    ================================================== -->
    <meta charset="utf-8" />
</head>

<body id="page-top" class="container-fluid">
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color: #000C19">
        <a class="navbar-brand btn btn-dark" href="index.php">پوشنی </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
           <?php
            $con=mysqli_connect("localhost", "root", "") or die(mysqli_error());
            mysqli_select_db($con,"registrations") or die(mysqli_error());
            if(isset($_GET['id']) && !empty($_GET['id']))
            {
            $id = mysqli_real_escape_string($con,$_GET['id']);
            $Sec = md5($id);
            echo '<a class="btn btn-dark" href="shop.php?id='.$id.'&Sec='.$Sec.'">فروشگاه</a>';
            }
            ?>
        </div>
    </nav>

    <div id="wrap">
        <?php
        $con=mysqli_connect("localhost", "root", "","registrations") or die(mysqli_error());
        $check_error = 0;
        if( isset($_GET['id']) && !empty($_GET['id']) AND isset($_GET['Sec']) && !empty($_GET['Sec']) )
        {
        $id = mysqli_real_escape_string($con,$_GET['id']);
        $Sec = mysqli_real_escape_string($con,$_GET['Sec']);
        $sql = mysqli_query($con,"SELECT * FROM users WHERE id='".$id."' ") or die(mysql_error()); 
        $rows=mysqli_fetch_assoc($sql);
        $username = $rows['username'];
        $password = $rows['password'];
        $first_name = $rows['first_name'];
        $last_name = $rows['last_name'];
        $email = $rows['email'];
        $birthday= $rows['birthday'];
        $login= $rows['login'];
        echo "خوش آمدی  " , $username;
        echo "<br />" , "<br />";
        if (    isset($_POST['New_first_name'])  && !empty($_POST['New_first_name']) 
            AND isset($_POST['New_last_name'])   && !empty($_POST['New_last_name']) 
            AND isset($_POST['New_username'])    && !empty($_POST['New_username']) 
            AND isset($_POST['New_email'])       && !empty($_POST['New_email'])
            AND isset($_POST['New_birthday'])    && !empty($_POST['New_birthday']) 
            AND isset($_POST['New_password'])    && !empty($_POST['New_password'])
           )
        {
        $New_first_name   = mysqli_real_escape_string($con,$_POST['New_first_name']);
        $New_last_name    = mysqli_real_escape_string($con,$_POST['New_last_name']);
        $New_username     = mysqli_real_escape_string($con,$_POST['New_username']); 
        $New_email        = mysqli_real_escape_string($con,$_POST['New_email']);
        $New_birthday     = mysqli_real_escape_string($con,$_POST['New_birthday']);
        $New_password     = mysqli_real_escape_string($con,$_POST['New_password']);
        mysqli_query($con,"UPDATE users SET first_name='$New_first_name', last_name='$New_last_name', username='$New_username', email='$New_email', password='$New_password', birthday='$New_birthday' WHERE id='$id' ") or die(mysql_error());
        header('Location: '. $_SERVER['REQUEST_URI']);   
        }
        if ($login != 1)
        {
        header("Location:404.php");  
        }    
        if(isset($_POST['logout'])) 
        {
        header("Location: logout.php?id=$id&Sec=$Sec");
        exit;
        }
        if(isset($_POST['delete'])) 
        {
        mysqli_query($con,"DELETE FROM users WHERE id='$id'") or die(mysql_error());
        header("Location: index.php");
        exit;
        }
        }
    ?>

            <?php 
        if(isset($msg)){
            echo '<div class="statusmsg">'.$msg.'</div>';
        }
    ?>
            <div class="module container">
                <form id="form-wrap" action="" method="post" enctype="multipart/form-data">
                    <input type="text" name="New_first_name" 
                    value="<?php echo $rows['first_name']; ?>" required />
                    
                    <input type="text" name="New_last_name" 
                    value="<?php echo $rows['last_name']; ?>" required />
                    
                    <input type="text" name="New_username" 
                    value="<?php echo $username; ?>" required />
                    
                    <input type="password" name="New_password" 
                    value="<?php echo $rows['password']; ?>" required />
                    
                    <input type="email" name="New_email" 
                    value="<?php echo $rows['email']; ?>" required />
                    
                    <input type="date" name="New_birthday" 
                    value="<?php echo $rows['birthday']; ?>">
                    
                    <br />
                    
                    <input type="submit" value="بروزرسانی" name="register" class="btn btn-dark" style="display:inline-block;cursor:pointer;" />
                    
                    <input type="submit" value="خروج" name="logout" class="btn btn-dark" style="display:inline-block;cursor:pointer;" />
                    
                    <input type="submit" value="حذف حساب" name="delete" class="btn btn-delete" style="display:inline-block;cursor:pointer;" />
                </form>
            </div>
    </div>
</body>

</html>
