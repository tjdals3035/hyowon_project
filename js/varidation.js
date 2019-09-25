function check() {
    var chk_radio = document.getElementsByName('payck');
    var sel_type = null;

    for(var i=0;i<chk_radio.length;i++){
        if(chk_radio[i].checked === true){
            sel_type = chk_radio[i].value;
        }
    }

    var checkEmail = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
    var checkPhone = /^\d{11}$/;
    var pattern_spc = /["~'!@#$%^&*()_+|<>?:{}]/;

    if(fr.ordername.value === "" ) {
        alert("名前を入力してください");
        fr.ordername.focus();
        return false;
    }
    else if(fr.ordername.value.length > 10 ) {
        alert("名前が長すぎです");
        fr.ordername.focus();
        return false;
    }
    else if(pattern_spc.test(fr.ordername.value)===true){
        alert("名前に特殊記号があります");
        fr.ordername.focus();
        return false;
    }
    else if(fr.orderphone.value === "" ) {
        alert("電話番号を入力してください");
        fr.orderphone.focus();
        return false;
    }
    else if(checkPhone.test(fr.orderphone.value)===false){
        alert("電話番号を確認してください");
        fr.orderphone.focus();
        return false;
    }
    else if(fr.orderemail.value === "") {
        alert("Emailを入力してください");
        fr.orderemail.focus();
        return false;
    }
    else if(checkEmail.test(fr.orderemail.value)===false){
        alert("メールを確認してください");
        fr.orderemail.focus();
        return false;
    }
    else if(fr.orderpost.value === "") {
        alert("郵便番号を入力してください");
        fr.orderpost.focus();
        return false;
    }
    else if(fr.orderpost.value.length > 8 ) {
        alert("郵便番号が長すぎです");
        fr.orderpost.focus();
        return false;
    }
    else if(pattern_spc.test(fr.orderpost.value)===true){
        alert("郵便番号に特殊記号があります");
        fr.orderpost.focus();
        return false;
    }
    else if(fr.todoadd.value === "") {
        alert("都道府県を入力してください");
        fr.todoadd.focus();
        return false;
    }
    else if(fr.todoadd.value.length > 50 ) {
        alert("都道府県が長すぎです");
        fr.todoadd.focus();
        return false;
    }
    else if(pattern_spc.test(fr.todoadd.value)===true){
        alert("都道府県に特殊記号があります");
        fr.todoadd.focus();
        return false;
    }
    else if(fr.orderaddress.value === "") {
        alert("住所を入力してください");
        fr.orderaddress.focus();
        return false;
    }
    else if(fr.orderaddress.value.length > 25 ) {
        alert("住所が長すぎです");
        fr.orderaddress.focus();
        return false;
    }
    else if(pattern_spc.test(fr.orderaddress.value)===true){
        alert("住所に特殊記号があります");
        fr.orderaddress.focus();
        return false;
    }
    else if(sel_type === null){
        alert("お支払い方法を選択してください");
        return false;
    }
    else return true;
}