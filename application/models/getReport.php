<?php

class getReport{

  public function getCVR($date){

    $date = date("Y-m-d", strtotime($date));
    $mysql_hostname = 'localhost';
    $mysql_username = 'root';
    $mysql_password = 'rootroot';
    $mysql_database = 'h_project';
    $mysql_charset = 'utf8';

    $connect = new mysqli($mysql_hostname,$mysql_username,$mysql_password,$mysql_database);
    if($connect->connect_errno){
      echo "disconnected";
      return;
    }
    $query = "select * from orders where orderdate = '".$date."'";
    $result = $connect->query($query);
    $connect->close();

    return $result;
  }

  public function getRank($date){
    $date = date("Y-m-d", strtotime($date));
    $mysql_hostname = 'localhost';
    $mysql_username = 'root';
    $mysql_password = 'rootroot';
    $mysql_database = 'h_project';
    $mysql_charset = 'utf8';

    $connect = new mysqli($mysql_hostname,$mysql_username,$mysql_password,$mysql_database);
    if($connect->connect_errno){
      echo "disconnected";
      return;
    }
    $query =
    "select count(ordersdetail.orderproduct_code) as order_num
    , (select sum(sub2.orderproduct_qty)
      from orders as sub1, ordersdetail as sub2
      where sub2.orderproduct_code = ordersdetail.orderproduct_code
      and sub1.ordernum = sub2.ordernum
      and sub1.orderdate = '$date'
      group by sub2.orderproduct_code) as qty
    , (select sub4.orderpname
      from orders as sub3, ordersdetail as sub4
      where sub4.orderproduct_code = ordersdetail.orderproduct_code
      and sub3.ordernum = sub4.ordernum
      and sub3.orderdate = '$date'
      group by sub4.orderpname) as name
      FROM orders, ordersdetail
      where orders.ordernum = ordersdetail.ordernum
      and orders.orderdate = '$date'
      group by ordersdetail.orderproduct_code
      order by order_num desc
    ";
    
    $result = $connect->query($query);

    return $result;
  }
}
?>
