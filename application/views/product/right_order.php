<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="../css/homepage.css">
	<link rel="stylesheet" href="../css/signup.css">
    <link rel="stylesheet" href="../css/cart.css">
    <link rel="stylesheet" href="../css/order.css">
    <script>
       $( function() {
        $( "#tabs" ).tabs();
       } );
    </script>
    <style>
    .button1 {
      background-color: #f1f1f1; /* Green */
      border: none;
      color: white;
      padding: 16px 70px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      -webkit-transition-duration: 0.4s; /* Safari */
      transition-duration: 0.4s;
      cursor: pointer;
      margin-left: 250px;
    }

    .button11 {
      background-color: white;
      color: black;
      border: 2px solid #f1f1f1;
    }

    .button11:hover {
      background-color: #f1f1f1;
      color: black;
    }
    </style>
    <title>Order</title>
</head>
<body>


<script src="../js/varidation.js"></script>

<? include_once  APPPATH ."views/public/header.html"; ?>

<div class="topnav" id="ttopnav">
	<a href="/project/Home/index">Home</a>
</div>

<div class="row">

<? include_once  APPPATH ."views/public/side.html"; ?>

<div class="column middle" style="padding: 50px">

<div id="tabs">
  <ul><li><a href="#tabs-1">注文ページ</a></li></ul>

<form action="right_payment" method="post" name="fr" onsubmit="return check()">
<input type="hidden" name="pc" value="<?=$_GET['id']?>">
<div id="tabs-1">
<?
    foreach($item_info as $item){
?>
<input type="hidden" name="orderproductname" value="<?=$item['product_name']?>">
<input type="hidden" name="orderproduct_price" value="<?=$item['product_price']?>">
<input type="hidden" name="orderproduct_qty" value="<?=$_GET['qty']?>">
   <div class="shopping-cart-reform">
      <div class="item">
        <div class="image">
          <img src="<?=$item['product_m_image']?>" alt="" style="min-height:88px; height:50px;"/>
        </div>

        <div class="description">
          <p name="orderproductname" class="pn" value="<?=$item['product_name']?>"><?=$item['product_name']?></p>
        </div>
        <?php $total=$item['product_price']*$_GET['qty'] ?>
        <div name="orderproduct_price" class="total-price" value="<?=$item['product_price']?>"><?=$item['product_price']?>円</div>
        <div name="orderproduct_qty" class="total-price" value="<?=$_GET['qty']?>"><?=$_GET['qty']?>個</div>
        <div name="orderproduct_totalprice" class="each-price" value="<?=$total?>"><?=$total?>円</div>
        <input type="hidden" name="orderproduct_totalprice" value="<?=$total?>">
      </div>
    </div>
<? } ?>
<div class="shopping-cart-total" style="width:1000px">
  <div class="item">
    <div class="total-price" style="padding:10px; width:100%; text-align:right">商品合計：<?=$total?>円</div>
  </div>
</div>
</div>

<div class="container">
  <div class="form-part">
    <h2>購入者の情報</h2>
    <div class="form-inputs">
      <div class="sqr-input">
        <div class="text-input margin-bottom-zero">
          <div class="sqr-input">
            <div class="text-input">
              <label for="fname">名前</label>
              <input type="text" name="ordername" id="ordername" style="width:220px" value="<? if (isset($ID_info)) echo $ID_info[0]['id']; ?>">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="text-input">
          <label for="phone">電話番号</label>
          <input type="text" name="orderphone" id="orderphone" value="<? if (isset($ID_info)) echo $ID_info[0]['phone']; ?>">
        </div>
        <div class="clearfix"></div>
      </div>

      <div class="text-input">
        <label for="email">Email</label>
        <input type="text" name="orderemail" id="orderemail" value="<? if (isset($ID_info)) echo $ID_info[0]['email']; ?>">
      </div>

        <div class="text-input">
            <label for="address">郵便番号</label>
            <input type="text" name="orderpost" id="post" value="<? if (isset($ID_info)) echo $ID_info[0]['post']; ?>">
        </div>

        <script type="text/javascript">
            $("#post").change(function(){
                var post = $('#post').val();
                var url = "/project/Home/ajax_zipcode/"+post;

                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(res){
                        if (res === "error") {
                        }else{
                            $('#todoadd').val(res);
                        }
                    },
                    error: function(request,status,error){
                        alert("error");
                        location.reload();
                    }
                });
            });
        </script>

        <div class="text-input">
            <label for="address">都道府県</label>
            <input type="text" name="add" id="todoadd" value="<? if (isset($ID_info)) echo $ID_info[0]['todoadd']; ?>">
        </div>

   

      <div class="text-input">
        <label for="address">住所</label>
        <input type="text" name="orderaddress" id="orderaddress"value="<? if (isset($ID_info)) echo $ID_info[0]['address']; ?>" >
      </div>

      <div class="text-input">
        <label for="message">備考</label>
        <textarea name="ordermessage" id="ordermessage"></textarea>
      </div>

    </div>

  </div>
</div> <!--container-->
<hr>
    <div class="container">
    <div class="form-part">
     <h2>お支払い方法を選択</h2>
     <table class="type04">
    <tr>
        <td><input type="radio" value="代金引換" name="payck" class="ck" onclick="doOpenCheck(this)">代金引換</td>
    </tr>
    <tr>
        <td class="payment">商品お届けの際、運送会社のドライバーに直接お支払いください。</td>
    </tr>
    <tr>
        <td><input type="radio" value="銀行振込" name="payck" class="ck" onclick="doOpenCheck(this)">銀行振込</td>
    </tr>
     <tr>
        <td class="payment">【振込口座】 ゆうちょ銀行札幌支店　普通0000000　カ）ヤマダコウギョウ</td>
    </tr>
    <tr>
        <td><input type="radio" value="郵便振替" name="payck" class="ck" onclick="doOpenCheck(this)">郵便振替</td>
    </tr>
     <tr>
        <td class="payment">【振替口座】 00000-0-00000　カ）ヤマダコウギョウ</td>
    </tr>
    </table>
    </div>
    <input type="submit" value="注文確定" class="button1 button11">
    </div>
    </div>
    </div>
</form>
</div><!--tab-->

</div> <!--div column middle-->
</div> <!--div row-->


<? include_once  APPPATH ."views/public/signup.html"; ?>

<? include_once  APPPATH ."views/public/login.html"; ?>


<? include_once  APPPATH ."views/public/footer.html"; ?>
<script>
        function doOpenCheck(chk){
            var obj = document.getElementsByName("ck");
            for(var i=0; i<obj.length; i++){
                if(obj[i] != chk){
                    obj[i].checked = false;
                }
            }
        }

        function addcheck() {
            var addcheck = $("select[name=add]").val();

            var radioVal = $("input[name='ck']:checked").val();
            alert(radioVal);

        }
</script>
</body>
</html>
