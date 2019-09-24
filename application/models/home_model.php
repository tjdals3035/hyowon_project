<?php
/*ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);*/

class home_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    //option이라는 배열을 받는다
    //option의 값을 받아서 insert에 넣는다.
    function add($option){
        $this->db->set('id', $option['id']);
        $this->db->set('pw', $option['pw']);
        $this->db->set('name', $option['name']);
        $this->db->set('email', $option['email']);
        $this->db->set('post', $option['post']);
        $this->db->set('address', $option['address']);
        $this->db->set('phone', $option['phone']);
        $this->db->set('todoadd', $option['todoadd']);

        $result = $this->db->insert('member');
        $this->db->insert_id();
        return $result;

    }

    function searchIDInfo($loginID){
        return $this->db->query("select * from member WHERE id='".$loginID."'")->result_array();
    }

    function checkID($id){
        return $this->db->query("select COUNT(*) from member WHERE id='".$id."'")->result_array();
    }

    function get_all_product(){
        return $this->db->query("select * from product")->result_array();
    }

    function get_one_product($pnum){
        return $this->db->query("select * from product where product_code ='".$pnum."'")->result_array();
    }

    function getItemRow($item_code){
        $sql = "select product_name, product_price, product_m_image from product where product_code ='".$item_code."'";
        $query = $this->db->query($sql);
        return $query->row();
    }

    function getBuyItem($item_code){
        $sql = "select product_name, product_price, product_m_image from product where product_code ='".$item_code."'";
        return $this->db->query($sql)->result_array();

    }

    function logincheck($auth){

        $sql = "select id, name, member_pk from member where id ='".$auth['id']."' and pw='".$auth['pw']."'";
        $query = $this->db->query($sql);

        if($query){
            return $query->row();
        }else{
            return false;
        }
    }

    function insertorder($items = array()) {
        if( !is_array($items) or count($items) == 0){
            return false;
        }

        $sql = "
                insert into orders
                    ( 
                    ordername,
                    member_pk,
                    ordermail, 
                    orderphone, 
                    orderpost, 
                    orderadd, 
                    orderadd_detail, 
                    ordertext, 
                    orderpayment, 
                    orderdate
                    ) 
                values
                    (
                    '".$items['ordername']."',
                    '".$items['member_pk']."',
                    '".$items['orderemail']."',
                    '".$items['orderphone']."',
                    '".$items['orderpost']."',
                    '".$items['add']."',
                    '".$items['orderaddress']."',
                    '".$items['ordermessage']."',
                    '".$items['payck']."', 
                    now()
                  )";
        $result = $this->db->query($sql);

        $sql = "select max(ordernum) as ordernum from orders";
        $query = $this->db->query($sql);
        $resultRow = $query->row();
        //echo "<hr>".$resultRow."<hr>";

        $ordernum = $resultRow->ordernum;

        $items_goods_arr = explode("IX", $items['ITEMS']);


        for($i = 0; $i<count($items_goods_arr); $i++){
           $items_each_goods = $items_goods_arr[$i];
           if($items_each_goods) {
              $items_each_goods_component = explode("IVV", $items_each_goods);
              $goods_id = $items_each_goods_component[0];
              $goods_cnt = $items_each_goods_component[1];
              $goods_total = $items_each_goods_component[3];
              $pname = $items_each_goods_component[4];
                   if($goods_id && is_numeric($goods_cnt)){

                       $sql = "select product_price from product where product_code='".$goods_id."'";
                       $query = $this->db->query($sql);
                       $resultRow = $query->row();
                       $goods_price = $resultRow->product_price;

                       $sql = "insert into ordersdetail(ordernum, orderproduct_code, orderproduct_qty, orderproduct_price, orderpname) values('".$ordernum."','".$goods_id."','".$goods_cnt."','".$goods_price."','".$pname."')";
                       $result = $this->db->query($sql);
                   }
                }
            }

        $sql = "update orders set ordertotal_price ='".$goods_total."' where ordernum='".$ordernum."'";

        $this->db->query($sql);

        //print_r($goods_total);

        $sql = "select * from ordersdetail where ordernum = '".$ordernum."'";

        $sql = "
          select
          ordername, ordermail, ordertotal_price, orderproduct_qty, orderproduct_price, orderpname
          from orders, ordersdetail
          where orders.ordernum=".$ordernum." and ordersdetail.ordernum=".$ordernum."
        ";

        //echo $ordernum;
        $orderData = array
        (
          'orderList' => $this->db->query($sql)->result_array(),
           'orderNum' => $ordernum 
         );
        return $orderData;

    }


    function insertoneorder($item = array()){
       $sql = "
                insert into orders
                  (
                    ordername, 
                    member_pk,
                    ordermail, 
                    orderphone, 
                    orderpost, 
                    orderadd, 
                    orderadd_detail, 
                    ordertext, 
                    orderpayment, 
                    orderdate, 
                    ordertotal_price
                  ) 
                  values
                  (
                    '".$item['ordername']."',
                    '".$item['member_pk']."',
                    '".$item['orderemail']."',
                    '".$item['orderphone']."',
                    '".$item['orderpost']."',
                    '".$item['add']."',
                    '".$item['orderaddress']."',
                    '".$item['ordermessage']."',
                    '".$item['payck']."', 
                    now(),
                    '".$item['ptotal']."'
                  )";
       $result = $this->db->query($sql);
       $sql = "select max(ordernum) as ordernum from orders";
       $query = $this->db->query($sql);
       $resultRow = $query->row();
       $ordernum = $resultRow->ordernum;


       $sql = "insert into ordersdetail(ordernum, orderproduct_code, orderproduct_qty, orderproduct_price, orderpname)
       values('".$ordernum."','".$item['pc']."','".$item['pqty']."','".$item['pp']."','".$item['pn']."')";;

       $this->db->query($sql);

       $sql = "
         select
         ordername, ordermail, ordertotal_price, orderproduct_qty, orderproduct_price, orderpname
         from orders, ordersdetail
         where orders.ordernum=".$ordernum." and ordersdetail.ordernum=".$ordernum."
       ";

       $orderData = array
        (
          'orderList' => $this->db->query($sql)->result_array(),
           'orderNum' => $ordernum 
         );
        return $orderData;
    }

    function get_one_category($cname){
       $sql = "select * from product where pcname ='".$cname."'";
       return $this->db->query($sql)->result_array();
    }

    function member_info($member_pk){
       $sql = "select * from member where member_pk ='".$member_pk."'";
       return $this->db->query($sql)->result_array();
    }

    function member_order_info($member_pk){
       $sql = "select * from orders where member_pk ='".$member_pk."'";
       return $this->db->query($sql)->result_array();
    }

    function member_order_info_detail(){
       $sql = 
          "
            select odd.ordernum, odd.orderpname, odd.orderproduct_qty, odd.orderproduct_price, pd.product_m_image
            from ordersdetail as odd
            JOIN product as pd
            ON pd.product_code = odd.orderproduct_code
          ";
       return $this->db->query($sql)->result_array();
    }

    function searchOrder($od_num){
        $sql = "select * from orders where ordernum ='".$od_num."'";
        return $this->db->query($sql)->result_array();
    }

    function searchOrderDetail($od_num){
//        $sql = "select * from ordersdetail where ordernum ='".$od_num."'";
//        return $this->db->query($sql)->result_array();
        $sql =
            "
            select odd.ordernum, odd.orderpname, odd.orderproduct_qty, odd.orderproduct_price, pd.product_m_image
            from ordersdetail as odd
            JOIN product as pd
            ON pd.product_code = odd.orderproduct_code
            where odd.ordernum ='".$od_num."'
          ";
        return $this->db->query($sql)->result_array();
    }

}
