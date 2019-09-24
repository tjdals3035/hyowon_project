
<div class="column middle">
 <div class="main">
     <img src="../img/main.jpg" alt="" class="mainimg">
     <div class="centered">Make your own tapioca</div>
 </div>
  <? foreach($kkk as $value) { ?>
    <div class="gallery" id="product_click" onclick="product_click('<?=$value['product_code']?>')">
        <a　href="">
          <img src="<?=$value['product_m_image']?>" alt="bbb" width="600" height="400">
        </a>
        <div class="desc"><?=$value['product_name']?><br><?=$value['product_price']?>円</div>
    </div>
    <? } ?>
</div>
