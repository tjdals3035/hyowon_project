<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/homepage.css">
	<link rel="stylesheet" href="../css/signup.css">
    <link rel="stylesheet" href="../css/productdetail.css">
	<title>Home</title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="http://dinbror.dk/bpopup/assets/jquery.bpopup-0.9.4.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <script>
        function openMessage(IDS) {
            $('#'+IDS).bPopup();
        }

        function addBoard(){
            openMessage('signup');
        }


        function loginform(){
            openMessage('login');
        }

        function buy(){
            openMessage('buy');
        }

        function gocart(){
           var id = $('#pcode').val();
           var qty = $('#pcount').val();
           var name = $("#pname").text();
           var price = $("#pprice").text();
           var image = $("#mainimage").attr("src");

           var result = "";

           $.ajax({
                type:'POST',
                url: "/project/Cart/insert",
                data:{ id: id, qty: qty, price: price, name: name, image:image },
                dataType: 'json',
                success: function(html){
                    console.log(html);
                    result = html;
                    location.href = "/project/Cart/index";
                },
                error: function(request,status,error){
                    alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                }
                });
        }

        function order_rightaway(){
            var id = $('#pcode').val();
            var qty = $('#pcount').val();

            location.href = "/project/Order/rightorder_check?id="+id+"&qty="+qty;
        }

        function page(){
           var id = $('#pcode').val();
           var qty = $('#pcount').val();
           var name = $("#pname").text();
           var price = $("#pprice").text();
           var image = $("#mainimage").attr("src");

           var result = "";

           $.ajax({
                type:'POST',
                url: "/project/Cart/insert",
                data:{ id: id, qty: qty, price: price, name: name, image:image },
                dataType: 'json',
                success: function(html){
                    console.log(html);
                    result = html;
                    $('#buy').bPopup().close();
                },
                error: function(request,status,error){
                    alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                }
                });
        }
    </script>

    <meta charset="UTF-8">
    <title>gogo</title>
</head>
<body>

<script src="../js/basic.js"></script>

<? include "public/header.html" ?>

<? include "public/topnav.html" ?>

<div class="row">

<? include "public/side.html" ?>



<div class="column middle" style="padding-top:50px; padding-right: 50px">

<? foreach($op as $value) {?>
<div class="grid-container">
 <input type="hidden" class="product_all" item_no="<?=$value['product_code']?>" item_price="<?=$value['product_price']?>" item_image="<?=$value['product_m_image']?>">
  <div class="grid-item item1"><img src="<?=$value['product_m_image']?>" id="mainimage"></div>
  <div class="grid-item item2">
      <input type="hidden" id="pcode" value="<?=$value['product_code']?>">
      <p class="pname" id="pname"><?=$value['product_name']?><br></p>
      <p class="pprice" id="pprice"><?=$value['product_price']?>円<br></p>
      <p class="pcount">数量：<input type="text" id="pcount" size="3" maxlength="3" value="1"><br></p>
      <button class="button button2" onclick="buy()"><img src="../img/cart.jpg" width="30px">カート</button>
      <button class="button button2" onclick="order_rightaway()"><img src="../img/buy.png" width="30px">即販売</button>
  </div>
  <div class="grid-item item5">
    <div>
      <p><img src="<?=$value['product_m_image']?>"></p>
      <hr>
    </div>

    <article>
      <p><img src="<?=$value['product_m_image']?>"></p>
      <hr>
    </article>

    <section>
      <p><img src="<?=$value['product_m_image']?>"></p>
    </section>
  </div>
<? } ?>
</div>

</div>

</div>

<? include "public/signup.html" ?>

<? include "public/login.html" ?>

<? include "product/buymethod.php" ?>

<? include "public/footer.html" ?>

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
