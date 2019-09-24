<?php

class checkDate
{
    public $weekOfDay;
    public $today;

    public function __construct()
    {
        $this->weekOfDay = date("w");
        $this->today = date("Ymd");
    }

    public function getYesterDay()
    {
        if($this->weekOfDay === "0" or $this->weekOfDay === "6") return "weekend";
        else if($this->weekOfDay === "1") return date("Ymd",strtotime("-3 days"));
        else return date("Ymd", strtotime($this->today."-1 day"));
    }
}
