<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/homepage.css">
    <link rel="stylesheet" href="../css/signup.css">
    <link rel="stylesheet" href="../css/cart.css">

    <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="http://dinbror.dk/bpopup/assets/jquery.bpopup-0.9.4.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <title>checkOrder</title>
</head>
<style type="text/css">
    table {
        width: 100%;
        border: 1px solid ;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid ;
        padding: 9px;
    }
</style>

<body>

<script src="../js/basic.js"></script>

<? include_once  APPPATH ."views/public/header.html"; ?>

<? include_once  APPPATH ."views/public/topnav.html"; ?>
<div class="row">

    <? include_once  APPPATH ."views/public/side.html"; ?>

    <div class="column middle">
        <h2> 注文履歴</h2><br>
        <hr>
        <br>
        <form method="post" action="/project/Order/checkOrder">
        注文番号で確認 :

        <input type="text" name="orderNum">
        <input type="submit" value="　検索　">
        <br><br>
        </form>

        <br><br>

        <? if(isset($orderData)){ ?>
            <? foreach($orderData as $ls) { ?>
                <table>
                    <tr>
                        <th width="100px">注文番号</th>
                        <th width="250px">000<?=$ls['ordernum']?></th>
                        <th width="100px">注文日時</th>
                        <th><?=$ls['orderdate']?></th>
                    </tr>
                    <tr>
                        <th>注文者名</th>
                        <th><?=$ls['ordername']?></th>
                        <th>携帯番号</th>
                        <th><?=$ls['orderphone']?></th>
                    </tr>
                    <tr>
                        <th>注文価格</th>
                        <th><?=$ls['ordertotal_price']?> 円</th>
                        <th>決済方法</th>
                        <th><?=$ls['orderpayment']?></th>
                    </tr>
                    <tr>
                        <th>配送先</td>
                        <th colspan="3"><?=$ls['orderpost']?> <?=$ls['orderadd']?><?=$ls['orderadd_detail']?></td>
                    </tr>
                </table>
                <br>
                <table>
                    <tr>
                        <th width="100px">IMG</th>
                        <th>Product Name</th>
                        <th width="100px">Qty</th>
                        <th width="100px">Price</th>
                    </tr>
                    <? foreach($orderDetailData as $list) { ?>
                        <? if ($ls['ordernum'] === $list['ordernum']) { ?>

                            <tr>
                                <th><img src="<?=$list['product_m_image']?>" width="80px"></th>
                                <th><?=$list['orderpname']?></th>
                                <th><?=$list['orderproduct_qty']?> 個</th>
                                <th><?=$list['orderproduct_price']?> 円</th>
                            </tr>

                        <? } ?>
                    <? } ?>
                </table>
            <? } ?>
        <? } ?>
        
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
