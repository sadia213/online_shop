<?php
  session_start();
  if($_SESSION['customer_login_status']!="logged in" and ! isset($_SESSION['user_name'])){
  header("Location:../Login.php");}
  if(isset($_GET['sign']) and $_GET['sign']=="out"){
    $_SESSION['customer_login_status']="logged out";
    unset($_SESSION['user_name']);
  header("Location:../Login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>All Products</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="products.css">

</head>
<body>
<ul>
   <li><a href="home.php">Home</a></li>
  <li><a class="active" href="products.php">All Products</a></li>
  <li><a href="porder.php">Place Order</a></li>
  <li><a href="myprofile.php">My Profile</a></li>
  <li><a href="chngpass.php">Change password</a></li>
  <li><a href="?sign=out">Logout</a></li>
</ul><br>

<div class="row">
  <div class="container">
    <form action="products.php" method="post">
    <div class="row">
      <div class="col-75">
        <label for="category"><b>Select a category: </b></label>
        <select style="height:43px;width:990px;" id="category" name="category">
        
<?php
  include("../connection.php");
  $sql="select distinct ctype from product";
  $r=mysqli_query($con,$sql);
  echo "<option >...</option>";
  while($row=mysqli_fetch_array($r))
  {
    $ctype=$row['ctype'];
	
    echo "<option value= '$ctype'>$ctype</option>";
  }
?>
		</select>
      </div>
    </div>
    <div class="row">
      <input type="submit" class="button" value="Run" name="run">
    </div>
    </form>
  </div>
</div>
<div>
<?php
  include("../connection.php");
  if(isset($_POST['run']))
  {
    $c=$_POST['category'];
    
    $sql="select * from product,store where product.product_id=store.product_id and product.ctype='$c'";
    $r=mysqli_query($con,$sql);
    echo "<table id= 'customers'>";
    echo "<tr>
    <th>Chocolate's Name</th>
    <th>Chocolate type</th>
    <th>Price</th>
    <th>Chocolate's Pic</th>
    
    </tr>";
      while($row=mysqli_fetch_array($r))
      {
        $product_id=$row['product_id'];
        $image=$row['image'];
        $name=$row['name'];
        $ctype=$row['ctype'];
        $sprice=$row['sellingprice'];
      echo "<form action='products.php?action=add&id=$product_id' method='post'>";
      echo "<tr>
      <td>$name</td><td>$ctype</td><td>$sprice</td>
      <td><img src='../uploadedimage/$image' height='150px' width='150px'></td>
      <input type='hidden' value='$name' name='name'>
      <input type='hidden' value='$sprice' name='sprice'>
      </td>
      </tr>";
      echo "</form>";
      }
      echo "</table>";
  }
?>
</div>

</body>
</html>