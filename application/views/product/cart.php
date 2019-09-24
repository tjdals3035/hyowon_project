<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="../css/homepage.css">
	<link rel="stylesheet" href="../css/signup.css">
    <link rel="stylesheet" href="../css/cart.css">
    <style>
      .button {
        background-color: #f1f1f1;
        border: none;
        color: white;
        padding: 16px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        -webkit-transition-duration: 0.4s; /* Safari */
        transition-duration: 0.4s;
        cursor: pointer;
      }
      .button1 {
        background-color: white;
        color: black;
        border: 2px solid #f1f1f1;
      }

      .button1:hover {
        background-color: #f1f1f1;
        color: black;
      }
      .description1{
        text-align: right;
        margin-right: 310px;
      }
    </style>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="http://dinbror.dk/bpopup/assets/jquery.bpopup-0.9.4.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script>
        function updateCart() {
            var delimeter = "IX";
            var qty_all = "";
            var itemrowid_all = "";

            var i = 1;
            while($('#qty'+i).length > 0){
                var itemrowid = $('#qty'+i).attr("itemrowid");
                var qty = $('#qty'+i).val();

                if(isNaN(qty)){
                    alert("write in number");
                    $('#qty'+i).focus();
                    return false;
                }

                if(qty && itemrowid) {
                    if(itemrowid_all){
                        itemrowid_all += delimeter;
                    }
                    itemrowid_all += itemrowid;

                    if(qty){
                        qty += delimeter;
                    }
                    qty_all += qty;
                }
                i++;
            }

            $.ajax({
                type : 'POST',
                url : "/project/Cart/cartupdate",
                data : { qty_all: qty_all, itemrowid_all: itemrowid_all, delimeter: delimeter },
                dataType: 'json',
                success: function(html){
                    location.reload();
                },
                error: function(request,status,error){
                    alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                }
                });
        }

        function deleteCart(rowid){
            $.ajax({
               type : 'POST',
                url : "/project/Cart/cartdelete",
                data : { rowid: rowid},
                dataType : 'json',
                success: function(res){
                    location.reload();
                },
                error: function(request,status,error){
                    alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                }
            });
        }

        function order_form(){
            var delimeter = "IX";
            var delimeter_second = "IVV";
            var itemid_all = "";

            $(".cart_all").each(function(){
               if($("#"+this.id).val()){
                   if(itemid_all){
                       itemid_all += delimeter;
                   }
                   itemid_all += $("#"+this.id).attr("item_no") + delimeter_second + $("#"+this.id).attr("item_qty") + delimeter_second + $("#"+this.id).attr("eachitemtotal")
                   + delimeter_second + $("#"+this.id).attr("item_total")+ delimeter_second + $("#"+this.id).attr("pname");
               }
                console.log($("#"+this.id).attr("eachitemtotal"));
            });

            if(itemid_all.length == 0){
              alert("cart none");
              return;
            }
            
            location.href = "/project/Order/order_check?ITEMS="+itemid_all;
        }

        function delete_all(){
            location.href = "/project/Cart/cartalldelete";
        }

        function zero(){

        }
    </script>
    <title>Cart</title>
</head>
<body>

<script src="../js/basic.js"></script>

<? include_once  APPPATH ."views/public/header.html"; ?>

<? include_once  APPPATH ."views/public/topnav.html"; ?>
<div class="row">

<? include_once  APPPATH ."views/public/side.html"; ?>

<div class="column middle">
<div class="title">
    カート
</div>
<div class="shopping-cart-total">
  <div class="item">
    <div class="total-price" style="padding:10px; width:48%;">商品</div>
    <div class="total-price" style="padding:10px; width:25%;">数量</div>
    <div class="total-price" style="padding:10px; width:25%;">価格</div>
    <div class="total-price" style="padding:10px; width:25%;">小計</div>
  </div>
</div>
<? $i = 1; ?>
<? foreach($this->cart->contents() as $items){ ?>
<div class="shopping-cart">
  <div class="item">
    <input type="hidden" id="<?='rowid'.$i?>" class="cart_all" value="<?=$items['rowid']?>" item_qty="<?=$items['qty']?>" item_no="<?=$items['id']?>" eachitemtotal="<?=$items['subtotal']?>"
    item_total="<?=$this->cart->total()?>" pname="<?=$items['name']?>">

    <input type="hidden" value="<?=$i.'rowid'?>">
    <div class="buttons">
      <img src="../img/delete.png" id="delete<?=$i?>" class="delete-btn" onclick="javascript:deleteCart('<?=$items['rowid']?>')">
    </div>

    <div class="image">
      <img src="<?=$items['image']?>" alt="" style="min-height:110px; height:50px;"/>
    </div>

    <div class="description" style="width: 80px">
      <span><?=$items['name']?></span>
    </div>

    <p class="pcount" style="padding-left:50px; margin-top: 30px; margin-left: 60px;">
    <input class="qty10" type="text" itemrowid="<?=$items['rowid']?>" id="<?='qty'.$i?>" name="<?='qty'.$i?>" size="3" maxlength="3" value="<?=$items['qty']?>"><br>
    </p>

    <div class="each-price"><?=$items['price']?>円</div>
    <div class="total-price"><?=$items['subtotal']?>円</div>
  </div>
</div>
<? $i++; ?>
<? } ?>
<div class="shopping-cart-total">
  <div class="item">
    <div class="total-price" style="padding:10px; width:100%; text-align:right">商品合計：<?=$this->cart->total()?>円</div>
  </div>
</div>

<div class="description1" style="text-align: right; margin-right::310px">
    <button class="button button1" onclick="javascript:delete_all()">Delete all</button>
    <button class="button button1" onclick="javascript:updateCart()">Update</button>
    <button class="button button1" onclick="javascript:order_form()">Order</button>
</div>

</div> <!--div column middle-->
</div> <!--div row-->


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
