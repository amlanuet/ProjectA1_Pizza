<?php
session_start();
include_once("config.php");
//current URL of the Page. cart_update.php redirects back to this URL
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <title>Menu</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">

        <!-- Font -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
        <link rel="stylesheet" href="fonts/beyond_the_mountains-webfont.css" type="text/css"/>

        <!-- Stylesheets -->
        <link href="plugin-frameworks/bootstrap.min.css" rel="stylesheet">
        <link href="plugin-frameworks/swiper.css" rel="stylesheet">
        <link href="fonts/ionicons.css" rel="stylesheet">
        <link href="common/styles.css" rel="stylesheet">
        <link href="images/heading_logo.png" rel="icon">
        <link href="./style.css" rel="stylesheet" type="text/css">

</head>
<body>
        
<!-- View Cart Box Start -->
<?php
if(isset($_SESSION["cart_products"]) && count($_SESSION["cart_products"])>0)
{
	echo '<div class="cart-view-table-front" id="view-cart">';
	echo '<h3>Your Shopping Cart</h3>';
	echo '<form method="post" action="cart_update.php">';
	echo '<table width="100%"  cellpadding="6" cellspacing="0">';
	echo '<tbody>';

	$total =0;
	$b = 0;
	foreach ($_SESSION["cart_products"] as $cart_itm)
	{
		$product_name = $cart_itm["product_name"];
		$product_qty = $cart_itm["product_qty"];
		$product_price = $cart_itm["product_price"];
		$product_code = $cart_itm["product_code"];
		$bg_color = ($b++%2==1) ? 'odd' : 'even'; //zebra stripe
		echo '<tr class="'.$bg_color.'">';
		echo '<td>Qty <input type="text" size="2" maxlength="2" name="product_qty['.$product_code.']" value="'.$product_qty.'" /></td>';
		echo '<td>'.$product_name.'</td>';
		echo '<td><input type="checkbox" name="remove_code[]" value="'.$product_code.'" /> Delete</td>';
		echo '</tr>';
		$subtotal = ($product_price * $product_qty);
		$total = ($total + $subtotal);
	}
	echo '<td colspan="4">';
	echo '<button type="submit">Update</button><a href="view_cart.php" class="button">Afrekenen</a>';
	echo '</td>';
	echo '</tbody>';
	echo '</table>';
	
	$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
	echo '</form>';
	echo '</div>';

}
?>
<!-- View Cart Box End -->

<header>
        <div class="container">
                <div class="right-area">
                        <h6><a class="plr-20 color-white btn-fill-primary" href="#">BESTEL: +31 6 12345678</a></h6>
                </div><!-- right-area -->

                <a class="menu-nav-icon" data-menu="#main-menu" href="#"><i class="ion-navicon"></i></a>

                <ul class="main-menu font-mountainsre" id="main-menu">
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="02_menu.php">MENU</a></li>
                        <li><a href="03_contact.php">CONTACT</a></li>
                </ul>

                <div class="clearfix"></div>
        </div><!-- container -->
</header>

<section class="bg-5 h-500x main-slider pos-relative">
        <div class="triangle-up pos-bottom"></div>
        <div class="container h-100">
                <div class="dplay-tbl">
                        <div class="dplay-tbl-cell center-text color-white pt-90">

                        </div><!-- dplay-tbl-cell -->
                </div><!-- dplay-tbl -->
        </div><!-- container -->
</section>

<section class="story-area bg-seller color-white pos-relative">
        <div class="pos-bottom triangle-up"></div>
        <div class="pos-top triangle-bottom"></div>
        <div class="container">
                <div class="heading">
                        <img class="heading-img" src="images/heading_logo.png" alt="">
                        <h2>Menu</h2>
                </div>

                <div class="row">
                <!-- Products List Start -->
                <?php
                $results = $mysqli->query("SELECT product_code, product_name, product_desc, product_img_name, price FROM products ORDER BY id ASC");
                if($results){ 
                $products_item = '<ul class="products">';
                //fetch results set as object and output HTML
                while($obj = $results->fetch_object())
                {
                $products_item .= <<<EOT
                        <li class="product">
                        <form method="post" action="cart_update.php">
                        <div class="product-content"><h3>{$obj->product_name}</h3>
                        <div class="product-thumb"><img src="images/{$obj->product_img_name}"></div>
                        <div class="product-desc">{$obj->product_desc}</div>
                        <div class="product-info">
                        Price {$currency}{$obj->price} 
                        
                        <fieldset>
                                
                        <label>
                                <span>Quantity</span>
                                <input type="text" size="2" maxlength="2" name="product_qty" value="1" />
                        </label>
                        
                        </fieldset>
                        <input type="hidden" name="product_code" value="{$obj->product_code}" />
                        <input type="hidden" name="type" value="add" />
                        <input type="hidden" name="return_url" value="{$current_url}" />
                        <div align="center"><h6 class="mt-20"><a href="#" class="btn-brdr-primary plr-25"><b></b>BESTELLEN</a></h6></div>
                        </div></div>
                        </form>
                        </li>
                EOT;
                }
                $products_item .= '</ul>';
                echo $products_item;
                }
                ?>    
                <!-- Products List End -->
                </div>
        </div><!-- container -->
</section>

<div class="map-area h-700x mb--30">
        <div id="map" style="height:100%;"></div>
</div><!-- map-area -->

<footer class="pb-50  pt-70 pos-relative">
        <div class="pos-top triangle-bottom"></div>
        <div class="container-fluid">
                <a href="index.html"><img src="images/heading_logo.png" alt="Logo"></a>

                <div class="pt-30">
                        <p class="underline-secondary"><b>Adres:</b></p>
                        <p>Sopranos pizza Rotterdam</p>
                        <p>Sopranos pizza Amsterdam</p>
                        <p>pizza Utrecht</p>
                </div>

                <div class="pt-30">
                        <p class="underline-secondary mb-10"><b>Telefoon:</b></p>
                        <a href="tel:+53 345 7953 32453 ">+06 12345678</a>
                </div>

                <div class="pt-30">
                        <p class="underline-secondary mb-10"><b>Email:</b></p>
                        <a href="mailto:yourmail@gmail.com">teunteun@live.nl</a>
                </div>
</footer>

<!-- SCIPTS -->
<script src="plugin-frameworks/jquery-3.2.1.min.js"></script>
<script src="plugin-frameworks/bootstrap.min.js"></script>
<script src="plugin-frameworks/swiper.js"></script>
<script src="common/scripts.js"></script>
</body>
</html>