<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../css/homepage.css">
	<link rel="stylesheet" href="../css/signup.css">
	<link rel="stylesheet" href="../css/cart.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="http://dinbror.dk/bpopup/assets/jquery.bpopup-0.9.4.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
</head>
<body>

<script src="../js/basic.js"></script>

<? include_once  APPPATH ."views/public/header.html"; ?>

<div class="topnav" id="ttopnav">
	<a href="/project/Home"></a>
</div>

<div class="row">

<? include_once  APPPATH ."views/public/side.html"; ?>

<div class="column middle">
<div class="title">
	注文完了
</div>
<div class="shopping-cart-total">
  <div class="item">
    <div class="total-price" style="padding:10px; width:48%;">商品名</div>
    <div class="total-price" style="padding:10px; width:25%;">数量</div>
    <div class="total-price" style="padding:10px; width:25%;">価格</div>
  </div>
</div>
<?php $total = 0; ?>
<? foreach($orderdone_info as $value) {?>
	<div class="shopping-cart">
		<div class="item">
			<div class="description" style="width:150px; margin-left:180px">
				<span><?=$value['orderpname']?></span>
			</div>
			<div class="description qty" style="margin-left:140px">
				<span><?=$value['orderproduct_qty']?></span>
			</div>
			<div class="description price" style="margin-left:190px">
				<span><?=$value['orderproduct_price']?></span>
			</div>
		</div><!--item-->
	</div>
	<? $total += $value['orderproduct_qty']*$value['orderproduct_price'] ?>
<? } ?>

<div class="shopping-cart-total">
  <div class="item">
    <div class="total-price" style="padding:10px; width:100%; text-align:right">商品合計：<?=$total?>円</div>
  </div>
</div>

</div><!--middle-->

</div>


<? include_once  APPPATH ."views/public/signup.html"; ?>

<? include_once  APPPATH ."views/public/login.html"; ?>



<? include_once  APPPATH ."views/public/footer.html"; ?>

<script>
        window.onscroll = function() {sticker()};

        var topnav = document.getElementById("ttopnav");
        var sticky = topnav.offsetTop;

        function sticker(){

            if(window.pageYOffset > sticky) {
                topnav.classList.add("sticky");
            } else {
                topnav.classList.remove("sticky");
            }
        }
</script>


</body>
</html>
