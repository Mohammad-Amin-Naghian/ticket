<?php

namespace classes;

class helical
{
    //2021-12-27 20:30:28
    public function convert($data)
    {
        $level1 = explode(' ',$data);
        list($year,$month,$date) = explode('-',$level1[0]);
        list($hour,$minute,$second) = explode(':',$level1[1]);
        $timestap = mktime($hour,$minute,$second,$month,$date,$year);
        return jdate('زمان Y/m/d - تاریخ : H:i:s',$timestap);
    }
}