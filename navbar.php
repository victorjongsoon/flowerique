

<?php 
//Display guest welcome message, Login and Registration links
//when shopper has yet to login,
$content1 = "Welcome Guest<br />";
$content2 = "<li class='nav-item'>
		     <a class='nav-link' href='register.php'>Sign Up</a></li>
			 <li class='nav-item'>
		     <a class='nav-link' href='login.php'>Login</a></li>";

// If $_SESSION["ShopperName"] is not null
if(isset($_SESSION["ShopperName"])) { 
	//To Do 1 (Practical 2) - 
    //Display a greeting message, Change Password and logout links 
    //after shopper has logged in.
    $content1 = "Welcome <b>$_SESSION[ShopperName]</b>";
    $content2 = "<li class='nav-item'>
    <a class='nav-link' href='changePassword.php'>Change Password</a></li>
    <li class='nav-item'>
    <a class='nav-link' href='logout.php'>Logout</a></li>";
    
	//To Do 2 (Practical 4) - 
    //Display number of item in cart
	if (isset($_SESSION["NumCartItem"])){
        $content1 .= ", $_SESSION[NumCartItem] item(s) in shopping cart";
    }
}
?>
   
<header class="">
    <nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php"><h2>Flowerique <em>Store</em></h2></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home
                    <span class="sr-only">(current)</span>
                </a>
            </li> 

            <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">More</a>
                
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="about-us.php">About Us</a>
                    <a class="dropdown-item" href="blog.php">Blog</a>
                    <a class="dropdown-item" href="testimonials.php">Testimonials</a>
                    <a class="dropdown-item" href="terms.php">Terms</a>
                </div>
            </li>
            
            <li class="nav-item"><a class="nav-link" href="checkout.php">Checkout</a></li>

            <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
            <li class="nav-item">
                <?php echo $content2; ?>
            </li>
        </ul>
        </div>
    </div>
    </nav>
</header>