<html>

<head>
    <title>ورود</title>

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
            <a class="btn btn-dark" href="signin.php">ثبت نام</a>
        </div>
    </nav>

    <div id="wrap">
        <?php
            $con = mysqli_connect("localhost", "root", "","registrations") or die(mysqli_error());
            if(isset($_POST['username']) && !empty($_POST['username']) AND                            isset($_POST['password']) && !empty($_POST['password']))
            {
            $username = mysqli_real_escape_string($con,$_POST['username']);
            $password = mysqli_real_escape_string($con,$_POST['password']);
            $check_user = mysqli_query($con,"SELECT * FROM users WHERE username='".$username."' AND password='".md5($password)."'") or die(mysqli_error()); 
            $rowcount=mysqli_num_rows($check_user);
            $rows=mysqli_fetch_assoc($check_user);
            $id= $rows['id'];
            if ($rowcount > 0)
            {
            $Sec = md5($id);
            mysqli_query($con,"UPDATE users SET login='1' WHERE id='$id' ") or die(mysql_error());
            header("Location:show.php?id=$id&Sec=$Sec");
            }
            else
            {
            $msg = 'خطا در ورود ... لطفاً از صحت اطلاعات و فعال بودن حساب خود اطمینان کسب کنید';
            }
            }
        ?>

            <h3>فرم ورود</h3>
            <p>لطفاً نام کاربری و رمز عبور خود را وارد کنید</p>

            <?php 
            if(isset($msg))
            {
                echo '<div class="statusmsg">'.$msg.'</div>';
            } 
        ?>
    </div>

    <div class="module container">
        <form id="form-wrap" action="" method="post">

            <input type="text" placeholder="نام کاربری" name="username" required />
            <input type="password" placeholder="رمز" name="password" required />

            <input type="submit" name="login" value="ورود" class="btn btn-dark" align="center" style="display:inline-block; width: 225; height: 35; cursor:pointer;" />

        </form>
    </div>
</body>

</html>
