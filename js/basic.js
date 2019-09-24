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

        function signin(){
            var id = $('#id').val();
            var pw = $('#pw').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var post = $('#post').val();
            var address = $('#address').val();
            var phone = $('#phone').val();
            var select = $('#todoadd').val();

            var chk_radio = document.getElementsByName('payck');
            var sel_type = null;

            var checkEmail = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
            var checkPhone = /^\d{11}$/;
            var pattern_spc = /["~'!@#$%^&*()_+|<>?:{}]/;

            if($('#id').val() === "" ) {
                alert("IDを入力してください");
                $('#id').focus();
                return false;
            }
            else if($('#id').val().length > 20 ) {
                    alert("IDが長すぎです");
                    $('#id').focus();
                return false;
            }
            else if(pattern_spc.test($('#id').val())===true){
                alert("IDに特殊記号があります");
                $('#id').focus();
                return false;
            }
            else if($('#pw').val() === "" ) {
                alert("パスワードを入力してください");
                $('#pw').focus();
                return false;
            }
            else if($('#pw').val().length > 20 ) {
                alert("パスワードが長すぎです");
                $('#pw').focus();
                return false;
            }
            else if(pattern_spc.test($('#pw').val())===true){
                alert("パスワードに特殊記号があります");
                $('#pw').focus();
                return false;
            }
            else if($('#name').val() === "" ) {
                alert("お名前を入力してください");
                $('#name').focus();
                return false;
            }
            else if($('#name').val().length > 20 ) {
                alert("お名前が長すぎです");
                $('#name').focus();
                return false;
            }
            else if(pattern_spc.test($('#name').val())===true){
                alert("お名前に特殊記号があります");
                $('#name').focus();
                return false;
            }
            else if($('#email').val() === "" ) {
                alert("メールアドレスを入力してください");
                $('#email').focus();
                return false;
            }
            else if(checkEmail.test($('#email').val())===false){
                alert("メールの形式が違います");
                $('#email').focus();
                return false;
            }
            else if($('#post').val() === "" ) {
                alert("郵便番号を入力してください");
                $('#post').focus();
                return false;
            }
            else if($('#post').val().length > 8 ) {
                alert("郵便番号が長すぎです");
                $('#post').focus();
                return false;
            }
            else if(pattern_spc.test($('#post').val())===true){
                alert("郵便番号に特殊記号があります");
                $('#post').focus();
                return false;
            }
            else if($('#todoadd').val() === "" ) {
                alert("都道府県を入力してください");
                $('#todoadd').focus();
                return false;
            }
            else if($('#todoadd').val().length > 50 ) {
                alert("都道府県が長すぎです");
                $('#todoadd').focus();
                return false;
            }
            else if(pattern_spc.test($('#todoadd').val())===true){
                alert("都道府県に特殊記号があります");
                $('#todoadd').focus();
                return false;
            }
            else if($('#address').val() === "" ) {
                alert("住所を入力してください");
                $('#address').focus();
                return false;
            }
            else if($('#address').val().length > 25 ) {
                alert("住所が長すぎです");
                $('#address').focus();
                return false;
            }
            else if(pattern_spc.test($('#address').val())===true){
                alert("住所に特殊記号があります");
                $('#address').focus();
                return false;
            }
            else if($('#phone').val() === "" ) {
                alert("携帯番号を入力してください");
                $('#phone').focus();
                return false;
            }
            else if(checkPhone.test($('#phone').val())===false){
                alert("電話番号を確認してください");
                $('#phone').focus();
                return false;
            }

            $.ajax({
                type: 'POST',
                url: "/project/Home/signup",
                data: {id: id, pw: pw, name: name, email: email, post: post, address: address, phone: phone, todoadd: select},
                success: function(res){
                    alert(res);
                    location.reload();
                },
                error: function(request,status,error){
                    alert("会員登録X");
                    location.reload();
                }
            });
        }

        function gologin(){
            var mid = $('#mid').val();
            var mpw = $('#mpw').val();

            if (mid === "")
            {
                alert("IDを入力してください");
                return false;
            }
            else if (mpw === "")
            {
                alert("Passwordを入力してください");
                return false;
            }

            $.ajax({
                type: 'POST',
                url: "/project/Login/gologin",
                data: {mid: mid, mpw: mpw},
                success: function(res){

                    if(res == "1"){
                        alert("ログインできました");
                        location.reload();
                    }else{
                        alert("アカウントやパスワードを確認してください");
                    }
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
                success: function(res){
                    alert("logoutok");
                    location.reload();
                },
                error: function(request,status,error){
                  alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                }
            });
        }

        function mypage(){
            location.href="/Login/mypageview";
        }
