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
    <meta charset="utf32_persian_ci" />
</head>

<body id="page-top" class="container-fluid">
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color: #000C19">
        <a class="navbar-brand btn btn-dark" href="index.php">پوشنی </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <?php
        $con=mysqli_connect("localhost", "root", "","registrations") or die(mysqli_error());
        if(isset($_GET['id']) && !empty($_GET['id']))
        {
        $id = mysqli_real_escape_string($con,$_GET['id']);
        $Sec = md5($id);
        echo '<a class="btn btn-dark" href="show.php?id='.$id.'&Sec='.$Sec.'">تنظیمات</a>';
        echo '<a class="btn btn-dark" href="logout.php?id='.$id.'&Sec='.$Sec.'">خروج</a>';
        }
        ?>
        </div>
    </nav>
    <div class="container">
    <div class="row">
    <?php
    session_start();
    $con=mysqli_connect("localhost", "root", "","registrations") or die(mysqli_error());
    mysqli_set_charset($con,"utf8");
    if( isset($_GET['id'])  && !empty($_GET['id']) AND 
        isset($_GET['Sec']) && !empty($_GET['Sec']))
    { 
    $id = mysqli_real_escape_string($con,$_GET['id']);
    $Sec = mysqli_real_escape_string($con,$_GET['Sec']);    
    $check_user = mysqli_query($con,"SELECT * FROM users WHERE id='$id' ") or die(mysqli_error()); 
    $rowcount=mysqli_num_rows($check_user);
    if ($rowcount > 0)
    {
    $rows=mysqli_fetch_assoc($check_user);
    $login= $rows['login'];
    if ($login != 1)
    {
     header("Location:401.php");
    }
    }
    else
    {
    header("Location:402.php");
    }
    }
    if(isset($_POST["add_to_cart"]))
    {
	if(isset($_SESSION["shopping_cart"]))
	{
    $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
    if(!in_array($_GET["pid"], $item_array_id))
	{
	$count = count($_SESSION["shopping_cart"]);
	$item_array = array(
	'item_id'			=>	$_GET["pid"],
	'item_name'			=>	$_POST["hidden_name"],
	'item_price'		=>	$_POST["hidden_price"],
	'item_quantity'		=>	$_POST["quantity"]
	);
	$_SESSION["shopping_cart"][$count] = $item_array;
	}
	}
	else
	{
	$item_array = array(
	'item_id'			=>	$_GET["pid"],
	'item_name'			=>	$_POST["hidden_name"],
	'item_price'		=>	$_POST["hidden_price"],
	'item_quantity'		=>	$_POST["quantity"]
	);
	$_SESSION["shopping_cart"][0] = $item_array;
	}
    }

    if(isset($_GET["action"]))
    {
	if($_GET["action"] == "delete")
	{
    foreach($_SESSION["shopping_cart"] as $keys => $values)
    {
        if($values["item_id"] == $_GET["pid"])
        {
        unset($_SESSION["shopping_cart"][$keys]);
        }
    }
	}
    }
    ?>
    <?php
	$result = mysqli_query($con,"SELECT * FROM tbl_product ORDER BY pid ASC");
    
	if(mysqli_num_rows($result) > 0)
	{
    while($row = mysqli_fetch_array($result))
    {
    ?>
    <div class="col-lg-4 col-md-6 mb-4">
    <form method="post" action="shop.php?action=add&pid=<?php echo $row["pid"]; ?>">
    <div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
    <img src="img/<?php echo $row["image"]; ?>" class="img-responsive" />
    <br />
    
    <h4>
    <?php echo $row["name"]; ?>
    </h4>

    <h4 class="text-danger">تومان
    <?php echo $row["price"]; ?>
    </h4>

    <input type="text" name="quantity" value="1" class="form-control" />

    <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />

    <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />

    <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="افزودن به لیست" />
    </div>
    </form>
    </div>
    <?php
    }
    }
    ?>
    </div>
    <div style="clear:both"></div>
    <br />
    <h3>صورت حساب</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th width="40%">نام کالا</th>
                <th width="10%">تعداد</th>
                <th width="20%">قیمت</th>
                <th width="15%">قیمت کل</th>
                <th width="5%">ردیف</th>
            </tr>
            
            <?php
            if(!empty($_SESSION["shopping_cart"]))
            {
            $total = 0;
            foreach($_SESSION["shopping_cart"] as $keys => $values)
            {
            ?>
            <tr>
            <td>
                <?php echo $values["item_name"]; ?>
            </td>
            <td>
                <?php echo $values["item_quantity"]; ?>
            </td>
            <td>$
                <?php echo $values["item_price"]; ?>
            </td>
            <td>$
                <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?>
            </td>
            <td>
            <a href="shop.php?action=delete&pid=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
            </tr>
        
           <?php
            $total = $total + ($values["item_quantity"] * $values["item_price"]);
            }
            ?>
            <tr>
                <td colspan="3" align="right">مبلغ قابل پرداخت</td>
                <td align="right">$
                    <?php echo number_format($total, 2); ?>
                </td>
                <td></td>
            </tr>
            <?php
            }
            ?>
            </table>
    </div>
    </div>
</body>
</html>