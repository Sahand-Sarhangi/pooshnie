<html>

<head>
    <title>ثبت نام</title>

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
            <a class="btn btn-dark" href="login.php">ورود</a>
        </div>
    </nav>

    <div id="wrap">
        <?php
        $check_error = 0;
        $con=mysqli_connect("localhost", "root", "","registrations") or die(mysqli_error());

        if (    isset($_POST['first_name'])  && !empty($_POST['first_name']) 
            AND isset($_POST['last_name'])   && !empty($_POST['last_name']) 
            AND isset($_POST['username'])    && !empty($_POST['username']) 
            AND isset($_POST['password'])    && !empty($_POST['password']) 
            AND isset($_POST['re_password']) && !empty($_POST['re_password']) 
            AND isset($_POST['email'])       && !empty($_POST['email'])
            AND isset($_POST['birthday'])    && !empty($_POST['birthday']) 
           )
        {
        $first_name   = mysqli_real_escape_string($con,$_POST['first_name']);
        $last_name    = mysqli_real_escape_string($con,$_POST['last_name']);
        $username     = mysqli_real_escape_string($con,$_POST['username']); 
        $password     = mysqli_real_escape_string($con,$_POST['password']);
        $re_password  = mysqli_real_escape_string($con,$_POST['re_password']);
        $email        = mysqli_real_escape_string($con,$_POST['email']);
        $birthday     = mysqli_real_escape_string($con,$_POST['birthday']);
        
        if (preg_match('/^[a-zA-Z0-9 _-]+$/', $username) === 0)
        {
        $msg = "نام کاربری دارای کاراکترهای غیر مجاز است!";
        $check_error = 1;
        }
        
        if ($password != $re_password)
        {
        $msg = "!رمز را اشتباه تکرار کرده اید";
        $check_error = 1;
        }
        
        if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email))
        {
        $msg = 'ایمیل وارد شده معتبر نیست دوباره امتحان کنید!';
        $check_error = 1;
        }
        else
        {
        $check_user = mysqli_query($con,"SELECT * FROM users WHERE username='$username'") or die(mysqli_error());
        $rowcount=mysqli_num_rows($check_user);
        if (!$rowcount)
        {
        $check_user = 0;
        }
        if ($rowcount >= 1)
        {
        $msg = "این نام کاربری قبلا ثبت شده است!";
        $check_error = 1;
        }
            
        $check_email = mysqli_query($con,"SELECT * FROM users WHERE email='$email'") or die(mysqli_error());
        $rowcount=mysqli_num_rows($check_email);
        if (!$rowcount)
        {
        $check_email = 0;
        }
        if ($rowcount >= 1)
        {
        $msg = "این ایمیل قبلا ثبت شده است!";
        $check_error = 1;
        }
            
        if ($check_error != 1)
        {
        mysqli_query($con,"INSERT INTO users (first_name, last_name, username, password, email, birthday) VALUES('$first_name','$last_name','$username',md5('$password'),'$email','$birthday')") or die(mysqli_error());
        echo '<div class="statusmsg">Your account has been activated, you can now login</div>';
        }
        else{
        echo '<div class="statusmsg">The url is either invalid or you already have activated your account.</div>';
        }
        }
        }
        ?>

            <h3>فرم ثبت نام</h3>
            <p>برای عضو شدن در سایت ما فرم زیر را تکمیل کنید</p>

            <?php 
        if(isset($msg))
        {
        echo '<div class="statusmsg">'.$msg.'</div>';
        } 
        ?>

    </div>
    <div class="module container">
        <form id="form-wrap" action="" method="post" enctype="multipart/form-data">

            <input type="text" placeholder="نام" name="first_name" ‪autofocus="autofocus‬‬" ‪value="" required />

            <input type="text" placeholder="نام خانوادگی" name="last_name" ‪value="" required />

            <input type="text" placeholder="نام کاربری" name="username" value="" required />

            <input type="password" placeholder="رمز" name="password" required />

            <input type="password" placeholder="تکرار رمز" name="re_password" required />

            <input type="email" placeholder="ادرس ایمیل" name="email" required />

            <h5> تاریخ تولد : 
            <input type="date" name="birthday">
            </h5>

            <input type="reset" value="پاک کردن فرم" name="reset" class="btn btn-dark" align="center" style="display:inline-block; width: 225; height: 35; cursor:pointer;">

            <input type="submit" value="ثبت اطلاعات" name="register" class="btn btn-dark" align="center" style="display:inline-block; width: 225; height: 35; cursor:pointer;" />

        </form>
    </div>
</body>

</html>
