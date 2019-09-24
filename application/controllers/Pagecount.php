#!/usr/bin/php -q
<?php

class Pagecount {

    public function countPV(){
      $checkWholeIP = "^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$";
      $today = date("Ymd");
      $fileroot = "/etc/httpd/logs/access_log.$today";
      $filename = fopen($fileroot, "r");
      $count = 0;
      $user = 0;
      $ipArr = array();

      if(!$filename){
        echo "file no open";
      }else{
        while(!feof($filename)){

          $line = fgets($filename);

          if($line != ""){
              $info = explode(" ", $line);
              if (preg_match('/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/',$info[0])) {
                  $var1 = "/project/Home/product";
                  $var2 = "/project/Cart/index";
                  $var3 = "/project/Order";
                  if($info[6] == "/project/Home/index"){
                      $count++;
                  }else if(strstr($info[6], $var1)){
                      $count++;
                  }else if(strstr($info[6], $var2)){
                      $count++;
                  }else if(strstr($info[6], $var3)){
                      $count++;
                  }
                  array_push($ipArr, $info[0]);
              }
          }
          flush();
        }
      }//else

      $uu = sizeof(array_unique($ipArr));
      $uuIp = array_unique($ipArr);


      $isClose = fclose($filename);
      if(!$isClose){
        echo "file no close";
      }

      $countArr = array(
                    'pv' => $count,
                    'uu' => $uu
                  );

       return $countArr;

    }

    public function countCVR(){
      $mysql_hostname = 'localhost';
      $mysql_username = 'root';
      $mysql_password = 'rootroot';
      $mysql_database = 'h_project';
      $mysql_charset = 'utf8';

      //today date for - form
      $dateString = date("Y-m-d", time());

      $connect = new mysqli($mysql_hostname,$mysql_username,$mysql_password,$mysql_database);

      if($connect->connect_errno){
        return "disconnected";
      }

      $query = "select * from orders where orderdate = '".$dateString."'";

      $result = $connect->query($query);

      $res = array();
      while($row = $result->fetch_array()){
        array_push($res, $row['orderdate']);
      }

      $totalOrder = sizeof($res);

      $pvv = $this->countPV();

      $realpv = $pvv['pv'];

      $cvr = ($totalOrder/$realpv)*100;

      $connect->close();

      return $cvr;
    }

    public function sendMail(){
      $pvuuData = $this->countPV();
      $cvrData = $this->countCVR();

      $mailToPV = $pvuuData['pv'];
      $mailToUU = $pvuuData['uu'];

      $mailTo = "hwjeon6669@gmail.com";
      $title = "REPORT";
      $content = "pv: $mailToPV uu: $mailToUU cvr: $cvrData";

      mail($mailTo, $title, $content);

    }


}

$sendmail = new Pagecount();

$sendmail->countPV();
$sendmail->countCVR();
$sendmail->sendMail();

?>
