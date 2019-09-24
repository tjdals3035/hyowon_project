<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../css/homepage.css">
	<link rel="stylesheet" href="../css/signup.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="http://dinbror.dk/bpopup/assets/jquery.bpopup-0.9.4.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
		<script type="text/javascript">
			function product_clickk(pcode){
				var num = pcode;
				location.href = "/project/Home/product?pcode="+num;
			}
		</script>
</head>
<body>
<script src="../js/basic.js"></script>

<? include "public/header.html" ?>

<? include "public/topnav.html" ?>

<div class="row">

<? include "public/side.html" ?>

<div class="column middle">
  <h2>特商法表記</h2>
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

  <table>
        <tr>
            <th width="150px">販売業者名</th>
            <th width="380px">（株）ヒョ茶</th>
        </tr>
        <tr>
            <th>代表責任者名</th>
            <th>ジョン・ヒョウォン</th>
        </tr>
        <tr>
            <th>所在地</th>
            <th>
〒060-0001<br>北海道札幌市中央区北1条西4-1-2　武田りそなビル</th>
        </tr>
        <tr>
            <th>電話番号</th>
            <th>080-1004-1004</th>
        </tr>
        <tr>
            <th>電話受付時間</th>
            <th>９：３０～１８：３０</th>
        </tr>
        <tr>
            <th>ホームページURL</th>
            <th><?php echo $_SERVER["SERVER_ADDR"]; ?>/project/Home/index</th>
        </tr>
        <tr>
            <th>販売価格</th>
            <th>各商品ページをご参照ください。</th>
        </tr>
        <tr>
            <th>商品代金以外の必要料金</th>
            <th>消費税
送料（全国一律100円。商品5、000円以上の購入で送料無料。）<br>
振込の場合、振込手数料、コンビニ決済の場合、コンビニ決済手数料</th>
        </tr>
        <tr>
            <th>お届け時期</th>
            <th>入金確認後、直ちに商品を発送いたします。</th>
        </tr>
        <tr>
            <th>お支払方法</th>
            <th>銀行振込、クレジットカード、コンビニ決済</th>
        </tr>
        <tr>
            <th>お申込みの有効期限</th>
            <th>７日以内にお願いいたします。<br>
７日間入金がない場合は、キャンセルとさせていただきます。</th>
        </tr>
         <tr>
            <th>返品・交換・キャンセル等</th>
            <th>商品発送後の返品・返却等はお受けいたしかねます。<br>
商品が不良の場合のみ交換いたします。<br>キャンセルは注文後２４時間以内に限り受付いたします。<br>
コンビニ決済を利用された場合、コンビニ店頭での返金はいたしません。</th>
        </tr>
        <tr>
            <th>返品期限</th>
            <th>商品出荷より７日以内にご連絡下さい。</th>
        </tr>
        <tr>
            <th>返品送料</th>
            <th>不良品の場合は弊社が負担いたします。<br>
それ以外はお客様のご負担となります。</th>
        </tr>
    </table>
</div>

</div>

<? include "public/signup.html" ?>

<? include "public/login.html" ?>

<? include "public/footer.html" ?>

</body>
</html>
