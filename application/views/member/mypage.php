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

    <title>Cart</title>
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
<h1>MyPage</h1>
<br>

<table>
	<tr>
        <th width="150px">ID</th>
        <th width="380px"><?php echo $member_info['id']; ?></th>
    </tr>
    <tr>
        <th>PASSWORD</th>
        <th><?php echo $member_info['pw']; ?></th>
    </tr>
    <tr>
        <th>NAME</th>
        <th><?php echo $member_info['name']; ?></th>
    </tr>
    <tr>
        <th>EMAIL</th>
        <th><?php echo $member_info['email']; ?></th>
    </tr>
    <tr>
        <th>POST</th>
        <th><?php echo $member_info['post']; ?></th>
    </tr>
    <tr>
        <th>ADDRESS</th>
        <th><?php echo $member_info['todoadd'].$member_info['address']; ?></th>
    </tr>
    <tr>
        <th>PHONE</th>
        <th><?php echo $member_info['phone']; ?></th>
    </tr>
</table>

<br><br>
<h1>Order Info</h1>
<br>

<? foreach($order_info as $ls) { ?>
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
	<? foreach($order_info_detail as $list) { ?>
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
<br><br>
<hr>
<br><br>
<? } ?>


</div>
</div> <!--div row-->


<? include_once  APPPATH ."views/public/signup.html"; ?>

<? include_once  APPPATH ."views/public/login.html"; ?>



<? include_once  APPPATH ."views/public/footer.html"; ?>


</body>
</html>
