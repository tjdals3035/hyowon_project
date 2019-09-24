<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../css/homepage.css">
	<link rel="stylesheet" href="../css/signup.css">
	<title>Home</title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="http://dinbror.dk/bpopup/assets/jquery.bpopup-0.9.4.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script type="text/javascript">

        function openMessage(IDS) {
            $('#'+IDS).bPopup();
        }

        function addBoard(){
            openMessage('signup');
        }

        function loginform(){
            openMessage('login');
        }

        function product_click(pcode){
             var num = pcode;
             location.href = "/project/Home/product?pcode="+num;
        }

        function ggcart() {
            location.href = "/project/Cart/index";
        }

        function signin(){
            var id = $('#id').val();
            var pw = $('#pw').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var post = $('#post').val();
            var address = $('#address').val();
            var phone = $('#phone').val();

            $.ajax({
                type: 'POST',
                url: "/project/Home/signup",
                data: {id: id, pw: pw, name: name, email: email, post: post, address: address, phone: phone},
                //dataType: 'json',
                success: function(){
                    alert("会員登録完成");
                    location.reload();
                },
                error: function(request,status,error){
                    location.reload();
                }
            });
        }

        function gologin(){
            var mid = $('#mid').val();
            var mpw = $('#mpw').val();

            $.ajax({
                type: 'POST',
                url: "/project/Login/gologin",
                data: {mid: mid, mpw: mpw},
                success: function(res){
                    alert("loginok");
                    location.reload();
                },
                error: function(request,status,error){
                  alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                }
            });
        }

        function logout(){
            $.ajax({
                type: 'POST',
                url: "/project/Login/logout",
                success: function(){
                    alert("aaa");
                    location.reload();
                },
                error: function(request,status,error){
                  alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                }
            });
        }

    </script>

</head>
<body>


<? include_once  APPPATH ."views/public/header.html"; ?>

<? include_once  APPPATH ."views/public/topnav.html"; ?>

<div class="row">

<? include_once APPPATH ."views/public/side.html" ?>

<div class="column middle">
        <? foreach($show_category_product as $value) { ?>
        <div class="gallery" id="product_click" onclick="product_click('<?=$value['product_code']?>')">
          <a　href="">
            <img src="<?=$value['product_m_image']?>" alt="bbb" width="600" height="400">
          </a>
          <div class="desc"><?=$value['product_name']?><br><?=$value['product_price']?>円</div>
        </div>
        <? } ?>
    </div>

</div>

<? include_once APPPATH ."views/public/signup.html" ?>

<? include_once APPPATH ."views/public/login.html" ?>

<? include_once APPPATH ."views/public/footer.html" ?>

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
