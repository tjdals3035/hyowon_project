<?php

include "checkDate.php";
include "/var/www/html/project/application/models/getReport.php";

 class getPVCVR {

  public $date;
  public $checkedDate;
  public $getReport;

  public function __construct(){
    $this->date = new checkDate();
    $this->getReport = new getReport();
    $this->checkedDate = $this->date->getYesterDay();
  }

  public function countPV(){
    $checkWholeIP = "^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$";
    $count = 0;
    $user = 0;
    $ipArr = array();

    if($this->checkedDate === "weekend"){
      return "store closed";
    }else{
      $fileroot = "/etc/httpd/logs/access_log.$this->checkedDate";
      if(file_exists($fileroot)){
        $fileopen = fopen($fileroot, "r");
        if(!$fileopen){
          return "file no open";
        }else{
          while(!feof($fileopen)){
            $line = fgets($fileopen);
            if($line != ""){
                $info = explode(" ", $line);
                if(preg_match('/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/',$info[0])) {
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
          }//while
        }//else
      }else{
        return "no file";
      }//no exist file
    }//not weekend

    $uu = sizeof(array_unique($ipArr));
    $uuIp = array_unique($ipArr);

    $isClose = fclose($fileopen);

    if(!$isClose){echo "file no close";return;}

    $countArr = array(
                  'pv' => $count,
                  'uu' => $uu
                );

     return $countArr;
  }


   public function countCVR(){
      $resFromCountPV = $this->countPV();
      $realpv = $resFromCountPV['pv'];
      if($resFromCountPV === "no file"){
        return;
      }
      if($this->checkedDate === "weekend"){
        echo "closed for today";
        return;
      }else if($realpv === 0){
        echo "no pv";
        return;
      }
      $orderArr = array();
      $result = $this->getReport->getCVR($this->checkedDate);
      while($row = $result->fetch_array()){
        array_push($orderArr, $row['orderdate']);
      }
      $totalOrder = sizeof($orderArr);
      $cvr = round(($totalOrder/$realpv)*100, 3);
      $cvrAndTotalOrder = array(
                          'cvr' => $cvr,
                          'totalOrder' => $totalOrder
                         );
      return $cvrAndTotalOrder;
    }

    public function rankingProduct(){
      $result = $this->getReport->getRank($this->checkedDate);
      $testingArr = array();
      while($info = $result->fetch_array()){
        array_push($testingArr, $info);
      }
      $data = array();
      for($i=0; $i<2 ; $i++){
        array_push($data, $testingArr[$i][2]);
      }
      return $data;
    }
 }
