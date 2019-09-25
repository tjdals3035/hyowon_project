<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {


    public function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->load->library('cart');
	}

    public function index()
	{

		$this->load->view('product/order');
	}

    public function order_check(){
        $data['controller'] = $this;

        $items = $_GET["ITEMS"];

        if($items){
            $items = explode("IX", $items);
        }

        $data['items'] = $items;

        if ($this->session->userdata('logged_in')===true){
            $this->load->model('Home_model');
            $loginID = $this->session->all_userdata()['id'];
            $data['ID_info'] = $this->Home_model->searchIDInfo($loginID);
        }

        $this->load->view('product/order', $data);

    }

    public function checkOrder(){
        $orderNum = $_POST["orderNum"];
        $orderNum = substr($orderNum, 3, strlen($orderNum));

        $this->load->model('Home_model');
        $data['orderData'] = $this->Home_model->searchOrder($orderNum);
        $data['orderDetailData'] = $this->Home_model->searchOrderDetail($orderNum);

        $this->load->view('product/checkOrder', $data);
    }

    public function getiteminfo($item_code){

        $this->load->model('Home_model');
        $itemrow = $this->Home_model->getItemRow($item_code);

        return $itemrow;
    }

    /**
     * 一つ以上の商品の注文
     */
    public function payment(){
        $ITEMS = $_POST["ITEMS"];
        $pname = $_POST["pname"];
        $ordername = $_POST["ordername"];
        $orderphone = $_POST["orderphone"];
        $orderemail = $_POST["orderemail"];
        $orderpost = $_POST["orderpost"];
        $add = $_POST["add"];
        $orderaddress = $_POST["orderaddress"];
        $ordermessage = $_POST["ordermessage"];
        $payck = $_POST["payck"]; 

        $member_pk = $this->session->userdata('member_pk');

        $data = array(
            'member_pk' => $member_pk,
            'ITEMS' => $ITEMS,
            'pname' => $pname,
            'ordername' => $ordername,
            'orderemail' => $orderemail,
            'orderphone' => $orderphone,
            'orderpost' => $orderpost,
            'add' => $add,
            'orderaddress' => $orderaddress,
            'ordermessage' => $ordermessage,
            'payck' => $payck
        );

        $this->load->model('Home_model');
        $orderData = $this->Home_model->insertorder($data);
        $this->order_delete();

        $data['orderdone_info'] = $orderData['orderList'];
        // 注文内容メール送信
        $this->send_mail($data, $orderData['orderNum']);
        $this->load->view('product/orderdone', $data);
    }

    public function rightorder_check(){

        $id = $_GET["id"];

        $this->load->model('Home_model');
        $itemrow = $this->Home_model->getBuyItem($id);
        $data['item_info'] = $itemrow;

        if ($this->session->userdata('logged_in')===true){
            $loginID = $this->session->all_userdata()['id'];
            $data['ID_info'] = $this->Home_model->searchIDInfo($loginID);
        }

        $this->load->view('product/right_order', $data);
    }

    /**
     * 一つの商品の注文
     */
    public function right_payment(){

        $productid = $_POST["pc"];
        $productpn = $_POST["orderproductname"];
        $productpp = $_POST["orderproduct_price"];
        $productpqty = $_POST["orderproduct_qty"];
        $productptotal = $_POST["orderproduct_totalprice"];
        $ordername = $_POST["ordername"];
        $orderphone = $_POST["orderphone"];
        $orderemail = $_POST["orderemail"];
        $orderpost = $_POST["orderpost"];
        $add = $_POST["add"];
        $orderaddress = $_POST["orderaddress"];
        $ordermessage = $_POST["ordermessage"];
        $payck = $_POST["payck"];

        $member_pk = $this->session->userdata('member_pk');

        $data = array(
            'member_pk' => $member_pk,
            'pc' => $productid,
            'pn' => $productpn,
            'pp' => $productpp,
            'pqty' => $productpqty,
            'ptotal' => $productptotal,
            'ordername' => $ordername,
            'orderemail' => $orderemail,
            'orderphone' => $orderphone,
            'orderpost' => $orderpost,
            'add' => $add,
            'orderaddress' => $orderaddress,
            'ordermessage' => $ordermessage,
            'payck' => $payck
        );

        $this->load->model('Home_model');
        $orderData = $this->Home_model->insertoneorder($data);

        $data['orderdone_info'] = $orderData['orderList'];
        // 注文内容メール送信
        $this->send_mail($data, $orderData['orderNum']);

        $this->load->view('product/orderdone', $data);
    }

    public function order_delete(){
        $this->cart->destroy();
    }

    // メールの送信メソッド
    public function send_mail($data, $orderNum)
    {

        if (isset($data['ITEMS'])) 
        {
            $items_goods_arr = explode("IX", $data['ITEMS']);

            for ($i = 0; $i < sizeof($items_goods_arr); $i++) 
            {
                $items_goods = explode("IVV", $items_goods_arr[$i]);
                $sum = $items_goods[3];
                
            }
        }

        $message = "";    
        $message .= $data['ordername'];
        $message .= "様";
        $message .= "<br>";
        $message .= "<br>";
        $message .= "この度は、当店をご利用いただきまして誠にありがとうございます。";
        $message .= "<br>";
        $message .= "<br>";
        $message .= "お客様のご注文を下記の内容で承りましたのでご連絡申し上げます。";
        $message .= "<br>";
        $message .= "ご不明な点ご質問等ございましたら、お気軽にお問合せ下さいますよう
お願い申しあげます。";
        $message .= "<br>";
        $message .= "<br>";
        $message .= "■ご注文内容 -------------------------------------------------------";
        $message .= "<br>";
        $message .= "<br>";
        $message .= "　◆ ご注文番号 ";
        $message .= "000".$orderNum;
        $message .= "<br>";
        $message .= "　◆ ご注文日時 ";
        $message .= date("Y-m-d H:i:s");
        $message .= "<br>";
        $message .= "　◆ お支払方法 ";
        $message .= $data['payck'];
        $message .= "<br>";
        $message .= "　◆ お支払金額 ";
        
        if (isset($data['ITEMS'])) $message .= $sum;
        else $message .= $data['ptotal'];
        
        $message .= "円（税込）";
        $message .= "<br>";
        $message .= "<br>";
        $message .= "===========================================";
        $message .= "<br>";
        $message .= "&emsp;&emsp;品番/品名
        &emsp;&emsp;&emsp;&emsp;価格
        &emsp;&emsp;&emsp;&emsp;数量
        &emsp;&emsp;&emsp;小計";
        $message .= "<br>";
        $message .= "===========================================";

        if (isset($data['ITEMS'])) 
        {
            for ($i = 0; $i < sizeof($items_goods_arr); $i++) 
            { 
                $items_goods = explode("IVV", $items_goods_arr[$i]);
                $message .= "<br>";
                $message .= "&emsp;&emsp;".$items_goods[4]."<br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;".$items_goods[2]."
            &emsp;&emsp;&emsp;&emsp;&emsp;".$items_goods[1]."
            &emsp;&emsp;&emsp;&ensp;".$items_goods[1]*$items_goods[2];
                $message .= "<br>";
                $message .= "===========================================";
            }
        }else{
            $message .= "<br>";
            $message .= "&emsp;&emsp;".$data['pn']."<br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;".$data['pp']."
        &emsp;&emsp;&emsp;&emsp;&emsp;".$data['pqty']."
        &emsp;&emsp;&emsp;&ensp;".$data['ptotal'];
            $message .= "<br>";
            $message .= "===========================================";
        }
         
        $message .= "<br>";
        $message .= "<br>";
        $message .= "■ご注文者情報 ---------------------------------------------------------";
        $message .= "<br>";
        $message .= "<br>";
        $message .= "　[お名前]　";
        $message .= $data['ordername'];
        $message .= "<br>";
        $message .= "　[郵便番号]　";
        $message .= $data['payck'];
        $message .= "<br>";
        $message .= "　[ご住所]　";
        $message .= "〒".$data['orderpost']." ".$data['add'].$data['orderaddress'];
        $message .= "<br>";
        $message .= "　[お電話番号]　";
        $message .= $data['orderphone'];
        $message .= "<br>";
        $message .= "　[メールアドレス]　";
        $message .= $data['orderemail'];
        $message .= "<br>";
        $message .= "<br>";
        $message .= "■連絡先 -----------------------------------------------------------";
        $message .= "<br>";
        $message .= "<br>";
        $message .= "　[販売業者]　";
        $message .= "（株）ヒョ茶 / ジョン・ヒョウォン";
        $message .= "<br>";
        $message .= "　[販売責任者]　";
        $message .= "ジョン・ヒョウォン";
        $message .= "<br>";
        $message .= "　[所在地]　";
        $message .= "〒060-0001 北海道札幌市中央区北1条西4-1-2 武田りそなビル";
        $message .= "<br>";
        $message .= "　[電話番号]　";
        $message .= "080-1004-1004";
        $message .= "<br>";
        $message .= "　[URL]　";
        $message .= $_SERVER["SERVER_ADDR"]."/project/Home/index";
        $message .= "<br>";
        $message .= "　[E-Mail]　";
        $message .= "lee@estore.co.jp";
        $message .= "<br>";
        $message .= "<br>";
        $message .= "ありがとうございます。";

        $this->load->library('email');
        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'lee@estore.co.jp';
        $config['smtp_pass']    = 'dldl4064@@';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or text
        $config['validation'] = TRUE; // bool whether to validate email or not      
        $this->email->initialize($config);

        $this->email->from('lee@estore.co.jp', 'タピオカ専門店　Hyocha');

        $this->email->to(
            array(
                $data['orderemail']
            )
        );

        $this->email->subject('ご注文ありがとうございます（自動送信メール）');
        $this->email->message($message);  

        $this->email->send();
        // if ($send) echo "メール送信成功<br>";
        // else echo "メール送信失敗<br>";
    }
}
