


<?php 
//Display guest welcome message, Login and Registration links
//when shopper has yet to login,



$content1 = "Welcome Guest<br />";
$searchBar ="<li class='nav-item'>
<span class='search-container'>
<form action='search.php' method='get'>";
if (isset($_GET['keywords'])) {
    $searchBar.="<input type='search' id='search'placeholder='Search for product..',  name='keywords', value='$_GET[keywords]',>";
}
else{
    $searchBar.="<input type='search' placeholder='Search for product..',  name='keywords'>";
}

$searchBar.="<button style= 'background-color: Transparent;border-radius: 10px;display: inline-block;'type='submit'><i class='fa fa-search'></i></button>
</form>
</span>
</li>";
$content2=$searchBar;
$content2.= "
            <li class='nav-item'>
		     <a class='nav-link' href='register.php' style='color:#000000'>Sign Up</a></li>
			 <li class='nav-item'>
             <a class='nav-link' href='login.php' style='color:#000000'>Login</a></li>
             ";

// If $_SESSION["ShopperName"] is not null
if(isset($_SESSION["ShopperName"])) { 
	//To Do 1 (Practical 2) - 
    //Display a greeting message, Change Password and logout links 
    //after shopper has logged in.
    $content1 = "Welcome <b>$_SESSION[ShopperName]</b>";
    $content2=$searchBar;

    $content2 .= " 
    <li class='nav-item'>
    <a class='nav-link' href='updateProfile.php' style='color:#000000'>Update Profile</a></li>
    <li class='nav-item'>
    <a class='nav-link' href='logout.php' style='color:#000000'>Logout</a></li>";
    
	//To Do 2 (Practical 4) - 
    //Display number of item in cart
	if (isset($_SESSION["NumCartItem"])){
        $content1 .= ", $_SESSION[NumCartItem] item(s) in shopping cart";
    }
}

//get dropdown items
include("mysql_conn.php");
 $qry = "SELECT * FROM category";
 $result2=$conn->query($qry);
 $content3="";
 while($row2=$result2->fetch_array()){
    $catname=urlencode($row2["CatName"]);
    $catProduct="catProduct.php?cid=$row2[CategoryID]&catName=$catname";
    $content3.="<a class='dropdown-item' href='$catProduct'>$catname</a>";
    
 }

?>
<!-- To Do 3 (Practical 1) - 
     Display a navbar which is visible before or after collapsing -->
<nav class="navbar navbar-expand-md navbar-dark" style="background-color: #FFB6C1";>
    <!-- Dynamic Text Display -->
    <span class="navbar-text ml-md-2" style="color:#000000; max-width:80%;">
        <?php echo $content1; ?>
    </span>
    <!-- Toggler/Collapsible Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>

<!-- To Do 4 (Practical 1) - 
     Define a collapsible navbar -->
<nav class="navbar navbar-expand-md navbar-dark" style="background-color: #FFB6C1";>
    <!-- Collapsible part of navbar -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <!-- Left-justified menu items -->
        <ul class="navbar-nav mr-auto">
         
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="category.php"  aria-haspopup="true" aria-expanded="false"style="color:#000000">
                Product Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <?php echo $content3; ?>
                </div>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="search.php" style="color:#000000">Product Search</a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="shoppingCart.php" style="color:#000000">Shopping Cart</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="feedback.php" style="color:#000000">Feedback</a>
            </li>
      
        </ul>
        <!-- Right-justified menu items -->
        <ul class="navbar-nav ml-auto">
            <?php echo $content2; ?>
        </ul>
    </div>
        
</nav>
