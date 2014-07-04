<?php
/* *
 * @author      eric
 * @version     $Id: Allyes.php 14983 2012-02-01 06:39:48Z alan $
 * @filesource
 * @package     imedia.components
 * @since 2011-1-17
 */
 class Allyes extends Yii
 {
     public $getCurrentLanguage = 'cn';

     public static function mktimeOfDate($testDate)
    {
        return mktime(0,0,0,substr($testDate,5,2),substr($testDate,8,2),substr($testDate,0,4));
    }
    public static function getNextDay($testDate)
    {
        $testmktime = self::mktimeOfDate($testDate);
        $testmktime = $testmktime+(24*60*60);
        return date("Y-m-d",$testmktime);
    }
    public static function getLastDay($testDate)
    {
        $testmktime = self::mktimeOfDate($testDate);
        $testmktime = $testmktime-(24*60*60);
        return date("Y-m-d",$testmktime);
    }
    public static function getNdays($n,$testDate)
    {
        $testmktime = self::mktimeOfDate($testDate);
        $testmktime = $testmktime-(24*60*60*$n);
        return date("Y-m-d",$testmktime);
    }
    public static function getWeekDaysBefore($testDate)
    {
        $testmktime = self::mktimeOfDate($testDate);
        $testmktime = $testmktime-(24*60*60*7);
        return date("Y-m-d",$testmktime);
    }
    public static function getWeekDaysLater($testDate)
    {
        $testmktime = self::mktimeOfDate($testDate);
        $testmktime = $testmktime+(24*60*60*7);
        return date("Y-m-d",$testmktime);
    }
    public static function isearly($startDate,$endDate)
    {
        $startmk = self::mktimeOfDate($startDate);
        $endmk = self::mktimeOfDate($endDate);
        if(($endmk-$startmk)>0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    //得到投放的单日结束时间
    public static function get_solution_start_end_time($start, $quit, $end_time, $type="CPM")
    {
        $type = strtoupper($type);
        if ($type!="CPM")
            return $quit;//不是CPM的投放
        if ($start>=$end_time)
            return $quit;//开始时间在18点之后的
        if ($quit<=$end_time)
            return $quit;//结束时间在18点之前的
        else
            return $end_time;//结束时间在18点之后的
    }

    #    date_inter($ary_A,$ary_B,$str="AnB")
    #    时间数组($ary_A,$ary_B)的交或并的实现 函数。
    #
    #    $str            是求数组关系的字符串行式，有几种：
    #                    AnB        A 交 B
    #                    An~B    A 交 B的补集
    #                    ~An~B    A的补集 交 B
    #                    AuB        A 并 B
    #                    Au~B    A 并 B的补集
    #                    ~Au~B    A的补集 并 B的补集
    #
    #    数组的结构是    Array    (
    #                            0 => array(    0 => starttime , 1 => endtime),
    #                            1 => array(    0 => starttime , 1 => endtime),
    #                            2 => array(    0 => starttime , 1 => endtime)
    #                            ...
    #                        )
    #
    #    starttime/endtime 的格式为    YYYY-MM-DD，HH-mm-ss
    #
    #    函数返回交集数组机构:
    #                Array    (
    #                            0 => array(    0 => starttime , 1 => endtime),
    #                            1 => array(    0 => starttime , 1 => endtime),
    #                            2 => array(    0 => starttime , 1 => endtime)
    #                            ...
    #                        )

    public static function date_inter($ary_A,$ary_B,$str="AnB")
    {
        $i = 0;
        switch ($str)
        {
            case "An~B":
                $AA_ary = unite_date($ary_A);//合并函数
                $BBB_ary = unite_date($ary_B);//求补函数
                $BB_ary = outer($BBB_ary);
                $Re_ary = assoc_date($AA_ary,$BB_ary);//求相交函数
                break;
            case "AnB":
                $AA_ary = unite_date($ary_A);
                $BB_ary = unite_date($ary_B);
                $Re_ary = assoc_date($AA_ary,$BB_ary);
                break;
            case "~An~B":
                $AAA_ary = unite_date($ary_A);
                $AA_ary = outer($AAA_ary);

                $BBB_ary = unite_date($ary_B);
                $BB_ary = outer($BBB_ary);
                $Re_ary = assoc_date($AA_ary,$BB_ary);
                break;
            case "AuB":
                $Re_ary = unite_date($ary_A,$ary_B);
                break;
            case "Au~B":
                $AA_ary = $ary_A;
                $BB_ary = unite_date($ary_B);
                $BBB_ary = outer($BB_ary);
                $Re_ary = unite_date($ary_A,$BBB_ary);
                break;
            case "~Au~B":
                $AA_ary = unite_date($ary_A);
                $AAA_ary = outer($AA_ary);
                $BB_ary = unite_date($ary_B);
                $BBB_ary = outer($BB_ary);
                $Re_ary = unite_date($AAA_ary,$BBB_ary);
                break;
        }
        return $Re_ary;
    }

    #    outer($A_ary)
    #    数组的求补函数,实现数组的补
    #    数组的结构是     Array    (
    #                            0 => array(    0 => starttime , 1 => endtime),
    #                            1 => array(    0 => starttime , 1 => endtime),
    #                            2 => array(    0 => starttime , 1 => endtime)
    #                            ...
    #                        )
    #
    #    负无穷用 "" 表示. 正无穷用 "9999-99-99,99:99:99".
    #
    #    starttime/endtime 的格式为    YYYY-MM-DD，HH-mm-ss
    #
    #    函数返回交集数组机构:
    #                Array    (
    #                            0 => array(    0 => starttime , 1 => endtime),
    #                            1 => array(    0 => starttime , 1 => endtime),
    #                            2 => array(    0 => starttime , 1 => endtime)
    #                            ...
    #                        )

    function outer($A_ary)
    {//求补函数
        $i = 0;
        $AAA_ary[$i][0] = "";//无穷小
        foreach ($A_ary as $Akey => $Avalue)
        {
            $ary_da = explode(",",$Avalue[0]);
            $mktie =($ary_da[1] == "00:00:00")?date("Y-m-d",(mktime(0,0,0,substr($ary_da[0],5,2),substr($ary_da[0],8,2),substr($ary_da[0],0,4))-(24*60*60))).",24:00:00":$Avalue[0];
            $AAA_ary[$i][1] = $mktie;
            $i++;

            $ary_da = explode(",",$Avalue[1]);
            $mktie =($ary_da[1] == "24:00:00")?date("Y-m-d",(mktime(0,0,0,substr($ary_da[0],5,2),substr($ary_da[0],8,2),substr($ary_da[0],0,4))+(24*60*60))).",00:00:00":$Avalue[1];
            $AAA_ary[$i][0] = $mktie;
        }
        $AAA_ary[$i][1] = "9999-99-99,99:99:99";//无穷大

        return $AAA_ary;
    }

    #    assoc_date($ary_A,$ary_B)
    #    数组的交集函数,实现数组的交集
    #    数组的结构是  Array( 0 => array(    0 => starttime , 1 => endtime),
    #                        1 => array(    0 => starttime , 1 => endtime),
    #                        2 => array(    0 => starttime , 1 => endtime))
    #
    #    starttime/endtime 的格式为    YYYY-MM-DD，HH-mm-ss
    #
    #    函数返回交集数组机构:
    #                Array( 0 => array(    0 => starttime , 1 => endtime),
    #                        1 => array(    0 => starttime , 1 => endtime),
    #                        2 => array(    0 => starttime , 1 => endtime))

    function assoc_date($ary_A,$ary_B)
    {//交集
        foreach ($ary_A as $key1 => $value1)
        {
            $ary_inner[] = $value1[0];
            $ary_inner[] = $value1[1];
        }
        foreach ($ary_B as $key2 => $value2)
        {
            $ary_inner[] = $value2[0];
            $ary_inner[] = $value2[1];
        }

        sort($ary_inner);

        foreach ($ary_inner as $key => $value)
        {
            $point[$value] = 0;
            $kiki = ($value=="")?"-9999-99-99,99:99:99":$value;
            foreach ($ary_A as $keya => $valuea)
            {
                if ($value >= $valuea[0] && $value < $valuea[1])
                {
                    $point[$kiki] += 1;
                    break;
                }
            }
            foreach ($ary_B as $keyb => $valueb)
            {
                if ($value >= $valueb[0] && $value < $valueb[1])
                {
                    $point[$value] += 1;
                    break;
                }
            }
        }

        $k = 0;
        foreach ($point as $pkey => $pvalue)
        {
            if ($stflag == 1)
            {
                $ary_da = explode(",",$pkey);
                $mktie =($ary_da[1] == "00:00:00")?date("Y-m-d",(mktime(0,0,0,substr($ary_da[0],5,2),substr($ary_da[0],8,2),substr($ary_da[0],0,4))-(24*60*60))).",24:00:00":$pkey;
                $Re_ary[$k][1] = $mktie;
                $k++;
                $stflag = 0;
            }
            if ($pvalue == 2)
            {
                $Re_ary[$k][0] = $pkey;
                $stflag = 1;
            }
        }
        return $Re_ary;
    }

    #    unite_date($A_ary,$B_ary="")
    #    数组的合并函数,一个数组为合并时间段，两个实现数组的并集
    #    数组的结构是  Array( 0 => array(    0 => starttime , 1 => endtime),
    #                        1 => array(    0 => starttime , 1 => endtime),
    #                        2 => array(    0 => starttime , 1 => endtime))
    #
    #    starttime/endtime 的格式为    YYYY-MM-DD，HH-mm-ss
    #
    #    函数返回交集数组机构:
    #                Array( 0 => array(    0 => starttime , 1 => endtime),
    #                        1 => array(    0 => starttime , 1 => endtime),
    #                        2 => array(    0 => starttime , 1 => endtime))

    function unite_date($A_ary,$B_ary="")
    {//并集
        $array_date = $Re_ary = array();
        foreach ($A_ary as $key => $value)
        {
            if (empty($array_date[$value[0]]))
            {
                $array_date[$value[0]][0] = $value[0];
                $array_date[$value[0]][1] = $value[1];
            }
            else
            {
                $array_date[$value[0]][1] = max($value[1],$array_date[$value[0]][1]);
            }
        }
        if ($B_ary != "")
        {
            foreach ($B_ary as $bkey => $bvalue)
            {
                if (empty($array_date[$bvalue[0]]))
                {
                    $array_date[$bvalue[0]][0] = $bvalue[0];
                    $array_date[$bvalue[0]][1] = $bvalue[1];
                }
                else
                {
                    $array_date[$bvalue[0]][1] = max($bvalue[1],$array_date[$bvalue[0]][1]);
                }
            }
        }
        ksort($array_date);

        $maxtime = "";
        $i = 0;
        foreach ($array_date as $key => $value)
        {
            if ($maxtime == "")
            {
                $Re_ary[$i][0] = $value[0];
                $Re_ary[$i][1] = $value[1];
                $maxtime = $value[1];
                $i++;
            }
            else
            {
                $ary_da = explode(",",$maxtime);
                if ($ary_da[1] == "24:00:00")
                {
                    $mktie = mktime(0,0,0,substr($ary_da[0],5,2),substr($ary_da[0],8,2),substr($ary_da[0],0,4))+(24*60*60);
                    $kk = date("Y-m-d",$mktie);
                    $bandate = $kk.",00:00:00";
                }
                else
                {
                    $bandate = $maxtime;
                }

                if ($bandate >= $value[0])
                {
                    $Re_ary[$i-1][1] = max($value[1],$maxtime);
                    $maxtime = max($value[1],$maxtime);
                }
                else
                {
                    $Re_ary[$i][0] = $value[0];
                    $Re_ary[$i][1] = $value[1];
                    $maxtime = $value[1];
                    $i++;
                }
            }
        }
        return $Re_ary;
    }
    /**
     * 对记录文件的封装
     * @param $msg
     * @param $level
     * @param $category
     * @param $pathname
     */
     public static function log($msg,$level=CLogger::LEVEL_INFO,$category='application',$pathname='')
    {
        if(YII_DEBUG == TRUE)
        {
            echo $msg;
        }
        $path = Yii::getPathOfAlias('application.runtime').DIRECTORY_SEPARATOR.$pathname;
        if(!is_dir($path)){
            if(mkdir($path,0777,true) === false){
                echo '文件不能被创建，请查看有runtime是否有写权限！';
                return false;
            }
        }
        if(!empty($pathname) && $level == 'info'){
            Yii::app()->log->routes[1]->logFile = $pathname.DIRECTORY_SEPARATOR.date('Y-m-d').'.log';
            Yii::log($msg,$level,$category);
        }else{
            Yii::log($msg,$level,$category);
        }

    }

    public static function getCurrentLanguage(){
        if(Yii::app()->user->language != 'en'){
            return 'cn';
        }else{
            return 'en';
        }
    }

     public static function getWeek($date){
        $time = mktime(0,0,0,substr($date,5,2),substr($date,8,2),substr($date,0,4));
        $Arry = getdate($time);
        $week = $Arry['weekday'];
        return $week;
    }

     // check date  whether is changjia
    public static function checkHoliday($date){
        $tempWeek =self::toWeek($date);
        $lunar    = new Lunar(substr($date,0,4),substr($date,5,2),substr($date,8,2));
        $chunjie = $lunar->display();
        $date = substr($date,5,2).substr($date,8,2);

        if(($date<="1007"&&$date>="1001")||($date<="0503"&&$date>="0501")||
        ($chunjie<="0107"&&$chunjie>="0101")) {
            return true;
        }
        else{
               return false;
        }
    }
    // check date  whether is  normal date
    public static function check($date)
    {
        $tempWeek = self::toWeek($date);
        $lunar    = new Lunar(substr($date,0,4),substr($date,5,2),substr($date,8,2));
        $chunjie = $lunar->display();
        $date = substr($date,5,2).substr($date,8,2);

        if(($date<="1007"&&$date>="1001")||($date<="0503"&&$date>="0501")||
         ($chunjie<="0107"&&$chunjie>="0101")||$tempWeek=="Saturday"||
        $tempWeek=="Sunday")
        {
            return true;
        }
        else
            {
           return false;
        }
    }
     // date string   transfer to week
    public static function toWeek($date){
        $time = mktime(0,0,0,substr($date,5,2),substr($date,8,2),substr($date,0,4));
        $Arry = getdate($time);
        $week = $Arry['weekday'];
        if($week=="Saturday"||$week=="Sunday"){
            return $week;
        }else{
            return "normal";
        }
    }


    //截取字符串函数
    public static function mystrcut($string,$length,$etc='...'){
        $result= '';
        $string = html_entity_decode(trim(strip_tags($string)),ENT_QUOTES,'UTF-8');
        $strlen = strlen($string);
        for($i=0; (($i<$strlen)&& ($length> 0));$i++){
            $number=strpos(str_pad(decbin(ord(substr($string,$i,1))), 8, '0', STR_PAD_LEFT), '0');
            if($number){
                if($length   <   1.0) {
                    break;
                }
                  $result   .=   substr($string, $i, $number);
                   $length   -=   1.0;
                $i   +=   $number   -   1;
            }else{
                $result   .=   substr($string, $i, 1);
                $length   -=   0.5;
            }
        }
        $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        if($i<$strlen){
            $result   .=   $etc;
        }
        return   $result;
    }

    /**
     * 生成随机数
     * @param int $randStringLength 字符长度
     */
    public static function randomString($randStringLength=7)
    {
    $timestring = microtime();
    $secondsSinceEpoch=(integer) substr($timestring, strrpos($timestring, " "), 100);
    $microseconds=(double) $timestring;
    $seed = mt_rand(0,1000000000) + 10000000 * $microseconds + $secondsSinceEpoch;
    mt_srand($seed);
    $randstring = "";
    for($i=0; $i < $randStringLength; $i++)
        {
        $randstring .= mt_rand(0, 9);
        $randstring .= chr(ord('A') + mt_rand(0, 5));

       }
    return($randstring);
   }

     /**
     *
     * 获取按工作日计算的n天后(前)的日期
     * @param Date $date 日期Y-m-d
     * @param int $delayDay 延后天数
     */
    public static function getNextWorkDay($date,$delayDay){
        if($delayDay>0)
        {
            $stepday=1;
        }
        else if($delayDay<0)
        {
            $stepday=-1;
        }
        else{
            return $date;
        }
        $count = abs($delayDay);
        $curday = $date;
        $i = 0;
        while(true){
            $time=mktime(0,0,0,substr($curday,5,2),substr($curday,8,2),substr($curday,0,4));
            $curday = ($stepday>0?date("Y-m-d", $time+24*60*60):date("Y-m-d", $time-24*60*60));
            $reval = self::isChangJia($curday);
            if (!$reval) $i++;
            if ($i>=$count) break;
        }
        return $curday;
    }

    /**
     * 检查是否长假
     * @param Date $date 日期
     * @return boolean true 是 false 否
     */
     public static function isChangJia($date){
        if (!self::isWorkDay($date))
        {
            return true;
        }
        else{
            $lunar = new Lunar(substr($date,0,4),substr($date,5,2),substr($date,8,2));
            $chunjie = $lunar->display();
            $date = substr($date,5,2).substr($date,8,2);
            if(($date<="1007"&&$date>="1001")||($date<="0507"&&$date>="0501")||($chunjie<="0107"&&$chunjie>="0101")){
                return true;
            }
            else{
                return false;
            }
        }
    }

    /**
     * 检查是否为工作日
     * Enter description here ...
     * @param unknown_type $date
     */
     public static function isWorkDay($date){
        $time = mktime(0,0,0,substr($date,5,2),substr($date,8,2),substr($date,0,4));
        $Arry = getdate($time);
        $week = $Arry['weekday'];
        if($week=="Saturday"||$week=="Sunday"){
            return false;
        }else{
            return true;
        }
    }


    /**
     *
     * 获取格式化时间数组
     * @param string $time_type 类型 year|month|day
     * @param date $start_tmp 开始时间
     * @param date $end_tmp 结束时间
     * @return array
     */
    public static function getDealDateFormat($time_type,$start_tmp,$end_tmp){

        $start = min($start_tmp,$end_tmp);
        $end = max($start_tmp,$end_tmp);

        $date_array = array();

        $list_type = 0;
        switch ($time_type){
                case 'year':
                    $date_array['current'] = substr($start,0,4);
                   $date_array['start'] = substr($start,0,10);
                    $date_array['end'] = substr($end,0,10);
                    $date_array['type'] = 0;
                    $date_array['string'] = 'year';
                    $date_array['count'] = substr($end,0,4) - substr($start,0,4);
                    break;
                case 'month':
                    $date_array['current'] = substr($start,0,7);
                    $date_array['start'] = substr($start,0,10);
                    $date_array['end'] = substr($end,0,10);

               //     $date_array['end'] = date(substr($end,0,7).'-t');
                    $date_array['type'] = 1;
                    $date_array['string'] = 'month';

                    if (substr($start,0,4)==substr($end,0,4)) $date_array['count'] = substr($end,5,2) - substr($start,5,2);
                    else $date_array['count'] = (substr($end,0,4) - substr($start,0,4) - 1) * 12 + (12 - substr($start,5,2)) + substr($end,5,2);
                    break;
                case 'day':
                    $date_array['current'] = substr($start,0,7);
                    $date_array['start'] = substr($start,0,10);
                    $date_array['end'] = substr($end,0,10);
                    $date_array['type'] = 2;
                    $date_array['string'] = 'day';
                    $date_array['count'] = (strtotime($date_array['end']) - strtotime($date_array['start']))/3600/24;
                    break;
        }
        $date_array['start_strtotime'] = strtotime($date_array['start']);
        $date_array['end_strtotime'] = strtotime($date_array['end']);
        $date_array['count'] ++;

        $date_array['array'] = array();

        for($i = 0;$i<$date_array['count'];$i++) {
            if ($date_array['type']==0) $date_key = date('Y',mktime(0,0,0,substr($date_array['start'],5,2),substr($date_array['start'],8,2),substr($date_array['start'],0,4)+$i));
            else if ($date_array['type']==1) $date_key = date('Y-m',mktime(0,0,0,substr($date_array['start'],5,2)+$i,substr($date_array['start'],8,2),substr($date_array['start'],0,4)));
            else $date_key = date('Y-m-d',mktime(0,0,0,substr($date_array['start'],5,2),substr($date_array['start'],8,2)+$i,substr($date_array['start'],0,4)));
            $date_array['array'][] = $date_key;
        }
        return $date_array;
    }

    //日期转换函数
    public static function dateConver($date)
    {
        if(empty($date)){
            echo "<script language=javascript>alert('日期为空!');</script>";
            exit;
        }
        $lunar    = new Lunar(substr($date,0,4),substr($date,5,2),substr($date,8,2));
        $chunjie = $lunar->display();
        $time = mktime(0,0,0,substr($date,5,2),substr($date,8,2),substr($date,0,4));
        $mktime = $time-24*60*60*7;
        $Arry =getdate($time);
        $week = $Arry['weekday'];
        if($week=="Monday") $weekflag= 1;
        if($week=="Tuesday") $weekflag= 2;
        if($week=="Wednesday") $weekflag= 3;
        if($week=="Thursday") $weekflag= 4;
        if($week=="Friday") $weekflag= 5;
        if($week=="Saturday") $weekflag= 6;
        if($week=="Sunday") $weekflag= 7;
        $tempDate = substr($date,5,2).substr($date,8,2);

        switch($weekflag):
        case 1://星期一
            $time = mktime(0,0,0,substr($date,5,2),substr($date,8,2),substr($date,0,4));
        $mktime = $time-24*60*60*7;
        $yuceDate = date("Y-m-d", $mktime);
        for($i=0;$i<5;$i++){
            $time = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
            $mktime4 = $time-24*60*60*4;
            $mktime3 = $time-24*60*60*3;
            $mktime7 = $time-24*60*60*7;
            $yuceDate4 = date("Y-m-d", $mktime4);
            $yuceDate7 = date("Y-m-d", $mktime7);
            $yuceDate3 = date("Y-m-d", $mktime3);
            $dateAry[$i] = array("normal",$yuceDate3,$yuceDate4,$yuceDate7,$yuceDate);
            if(Allyes::check($yuceDate4)||Allyes::check($yuceDate3)||Allyes::check($yuceDate7)||Allyes::check($yuceDate))
            {
                $time = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                $yuceDate = date("Y-m-d", ($time-24*60*60*7));
                $ttime = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                $mktime4 = $ttime-24*60*60*4;
                $mktime3 = $ttime-24*60*60*3;
                $mktime7 = $ttime-24*60*60*7;
                $yuceDate4 = date("Y-m-d", $mktime4);
                $yuceDate7 = date("Y-m-d", $mktime7);
                $yuceDate3 = date("Y-m-d", $mktime3);
                if(Allyes::check($yuceDate4)||Allyes::check($yuceDate3)||Allyes::check($yuceDate7)||Allyes::check($yuceDate))
                {
                    $time = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                    $yuceDate = date("Y-m-d", ($time-24*60*60*7));
                    $ttime = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                    $mktime4 = $ttime-24*60*60*4;
                    $mktime3 = $ttime-24*60*60*3;
                    $mktime7 = $ttime-24*60*60*7;
                    $yuceDate4 = date("Y-m-d", $mktime4);
                    $yuceDate7 = date("Y-m-d", $mktime7);
                    $yuceDate3 = date("Y-m-d", $mktime3);
                    $dateAry[$i] = "";
                    $dateAry[$i] = array("normal",$yuceDate3,$yuceDate4,$yuceDate7,$yuceDate);
                }
                else
                {
                    $dateAry[$i] = "";
                    $dateAry[$i] = array("normal",$yuceDate3,$yuceDate4,$yuceDate7,$yuceDate);
                }
            }

            $yucetime =mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
            $yuceDate = date("Y-m-d",($yucetime-24*60*60*7));
        }
        return $dateAry;
        break;
        case 2://星期二
            $time = mktime(0,0,0,substr($date,5,2),substr($date,8,2),substr($date,0,4));
            $mktime = $time-24*60*60*7;
            $yuceDate = date("Y-m-d", $mktime);
            for($i=0;$i<5;$i++){
                $time = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                $mktime4 = $time-24*60*60*4;
                $mktime1 = $time-24*60*60*1;
                $mktime7 = $time-24*60*60*7;
                $yuceDate4 = date("Y-m-d", $mktime4);
                $yuceDate7 = date("Y-m-d", $mktime7);
                $yuceDate1 = date("Y-m-d", $mktime1);
                $dateAry[$i] = array("normal",$yuceDate1,$yuceDate4,$yuceDate7,$yuceDate);
                if(Allyes::check($yuceDate4)||Allyes::check($yuceDate1)||Allyes::check($yuceDate7)||Allyes::check($yuceDate))
                {
                    $time = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                    $yuceDate = date("Y-m-d", ($time-24*60*60*7));
                    $ttime = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                    $mktime4 = $ttime-24*60*60*4;
                    $mktime1 = $ttime-24*60*60*1;
                    $mktime7 = $ttime-24*60*60*7;
                    $yuceDate4 = date("Y-m-d", $mktime4);
                    $yuceDate7 = date("Y-m-d", $mktime7);
                    $yuceDate1 = date("Y-m-d", $mktime1);
                    if(Allyes::check($yuceDate4)||Allyes::check($yuceDate1)||Allyes::check($yuceDate7)||Allyes::check($yuceDate))
                    {
                        $time = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                        $yuceDate = date("Y-m-d", ($time-24*60*60*7));
                        $ttime = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                        $mktime4 = $ttime-24*60*60*4;
                        $mktime1 = $ttime-24*60*60*1;
                        $mktime7 = $ttime-24*60*60*7;
                        $yuceDate4= date("Y-m-d", $mktime4);
                        $yuceDate7 = date("Y-m-d", $mktime7);
                        $yuceDate1 = date("Y-m-d", $mktime1);
                        $dateAry[$i] = "";
                        $dateAry[$i] = array("normal",$yuceDate1,$yuceDate4,$yuceDate7,$yuceDate);
                    }
                    else
                    {
                        $dateAry[$i] = "";
                        $dateAry[$i] = array("normal",$yuceDate1,$yuceDate4,$yuceDate7,$yuceDate);
                    }
                }

                $yucetime =mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                $yuceDate = date("Y-m-d",($yucetime-24*60*60*7));
            }
            return $dateAry;
            break;
        case 3:
        case 4:
        case 5://星期三、四、五
            $time = mktime(0,0,0,substr($date,5,2),substr($date,8,2),substr($date,0,4));
            $mktime = $time-24*60*60*7;
            $yuceDate = date("Y-m-d", $mktime);
            for($i=0;$i<5;$i++){
                $time = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                $mktime2 = $time-24*60*60*2;
                $mktime1 = $time-24*60*60*1;
                $mktime7 = $time-24*60*60*7;
                $yuceDate2 = date("Y-m-d", $mktime2);
                $yuceDate7 = date("Y-m-d", $mktime7);
                $yuceDate1 = date("Y-m-d", $mktime1);

                $dateAry[$i] = array("normal",$yuceDate1,$yuceDate2,$yuceDate7,$yuceDate);
                if(Allyes::check($yuceDate2)||Allyes::check($yuceDate1)||Allyes::check($yuceDate7)||Allyes::check($yuceDate))
                {
                    $time = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                    $yuceDate = date("Y-m-d", ($time-24*60*60*7));
                    $ttime = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                    $mktime2 = $ttime-24*60*60*2;
                    $mktime1 = $ttime-24*60*60*1;
                    $mktime7 = $ttime-24*60*60*7;
                    $yuceDate2 = date("Y-m-d", $mktime2);
                    $yuceDate7 = date("Y-m-d", $mktime7);
                    $yuceDate1 = date("Y-m-d", $mktime1);
                    if(Allyes::check($yuceDate2)||Allyes::check($yuceDate1)||Allyes::check($yuceDate7)||Allyes::check($yuceDate))
                    {
                        $time = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                        $yuceDate = date("Y-m-d", ($time-24*60*60*7));
                        $tttime = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                        $mmktime2 = $tttime-24*60*60*2;
                        $mmktime1 = $tttime-24*60*60*1;
                        $mmktime7 = $tttime-24*60*60*7;
                        $yuceDate2 = date("Y-m-d", $mmktime2);
                        $yuceDate7 = date("Y-m-d", $mmktime7);
                        $yuceDate1 = date("Y-m-d", $mmktime1);
                        $dateAry[$i] = "";
                        $dateAry[$i] = array("normal",$yuceDate1,$yuceDate2,$yuceDate7,$yuceDate);
                    }
                    else
                    {
                        $dateAry[$i] = "";
                        $dateAry[$i] = array("normal",$yuceDate1,$yuceDate2,$yuceDate7,$yuceDate);
                    }
                }
                else
                {
                    $dateAry[$i] = "";
                    $dateAry[$i] = array("normal",$yuceDate1,$yuceDate2,$yuceDate7,$yuceDate);
                }

                $yucetime =mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                $yuceDate = date("Y-m-d",($yucetime-24*60*60*7));
            }
            return $dateAry;
            break;
        case 6:
        case 7://双休日
            $time = mktime(0,0,0,substr($date,5,2),substr($date,8,2),substr($date,0,4));
            $mktime = $time-24*60*60*7;
            $yuceDate = date("Y-m-d", $mktime);

            for($i=0;$i<5;$i++){
                $time = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                $mktime6 = $time-24*60*60*6;
                $mktime7 = $time-24*60*60*7;
                $yuceDate7 = date("Y-m-d", $mktime7);
                $yuceDate6 = date("Y-m-d", $mktime6);
                $dateAry[$i] = array("shuangxiu",$yuceDate6,$yuceDate7,$yuceDate);

                if(Allyes::checkHoliday($yuceDate7)||Allyes::checkHoliday($yuceDate6)||Allyes::checkHoliday($yuceDate))
                {
                    $time = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                    $yuceDate = date("Y-m-d", ($time-24*60*60*7));
                    $ttime = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                    $week = Yii::toWeek($yuceDate);
                    if($week=="Saturday"){
                        $mktime6 = $ttime-24*60*60*8;
                        $mktime7 = $ttime-24*60*60*7;
                    }
                    if($week=="Sunday"){
                        $mktime6 = $ttime-24*60*60*6;
                        $mktime7 = $ttime-24*60*60*7;
                    }
                    $yuceDate6 = date("Y-m-d", $mktime6);
                    $yuceDate7 = date("Y-m-d", $mktime7);
                    if(Allyes::checkHoliday($yuceDate6)||Allyes::checkHoliday($yuceDate7)||Allyes::checkHoliday($yuceDate))
                    {
                        $time = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                        $yuceDate = date("Y-m-d", ($time-24*60*60*7));
                        $ttime = mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                        $week = Yii::toWeek($yuceDate);
                        if($week=="Saturday"){
                            $mktime6 = $ttime-24*60*60*8;
                            $mktime7 = $ttime-24*60*60*7;
                        }
                        if($week=="Sunday"){
                            $mktime6 = $ttime-24*60*60*6;
                            $mktime7 = $ttime-24*60*60*7;
                        }
                        $yuceDate6 = date("Y-m-d", $mktime6);
                        $yuceDate7 = date("Y-m-d", $mktime7);
                        $dateAry[$i] = "";
                        $dateAry[$i] = array("shuangxiu",$yuceDate6,$yuceDate7,$yuceDate);
                    }
                    else
                    {
                        $dateAry[$i] = "";
                        $dateAry[$i] = array("shuangxiu",$yuceDate6,$yuceDate7,$yuceDate);
                    }
                }
                $yucetime =mktime(0,0,0,substr($yuceDate,5,2),substr($yuceDate,8,2),substr($yuceDate,0,4));
                $yuceDate = date("Y-m-d",($yucetime-24*60*60*7));

            }
            return $dateAry;
            break;
        default:
            return;
        break;
        endswitch;
    }

    //日期转换函数
    public static function dateConver2($date)
    {
        $dateAry = array();
        if(empty($date))
        {
            echo "<script language=javascript>alert('日期为空!');</script>";
            exit;
        }
        $lunar    = new Lunar(substr($date,0,4),substr($date,5,2),substr($date,8,2));
        $chunjie = $lunar->display();
        $time = mktime(0,0,0,substr($date,5,2),substr($date,8,2),substr($date,0,4));
        $Arry =getdate($time);
        $week = $Arry['weekday'];
        $ary = array("01-01","01-02","01-03","01-04","01-05","01-06","01-07","01-08","01-09","01-10",
                          "01-11","01-12","01-13","01-14","01-15","01-16","01-17","01-18","01-19","01-20",
                          "01-21","01-22","01-23","01-24","01-25","01-26","01-27","01-28","01-29","01-30",
                          "01-31",
                          "02-01","02-02","02-03","02-04","02-05","02-06","02-07","02-08","02-09","02-10",
                          "02-11","02-12","02-13","02-14","02-15","02-16","02-17","02-18","02-19","02-20",
                          "02-21","02-22","02-23","02-24","02-25","02-26","02-27","02-28");
        for($i=0;$i<count($ary);$i++)
        {
        $tempdate=substr($date,0,4)."-".$ary[$i];
        $lunar = new Lunar(substr($tempdate,0,4),substr($tempdate,5,2),substr($tempdate,8,2));
        $flag  = $lunar->display();
        if($flag=="0101"){
        $chunjieDate=substr($date,0,4)."-".$ary[$i];
        }
        }
        for($i=0;$i<count($ary);$i++)
        {
        $lastYear =substr($date,0,4)-1;
        $lastYearDate =$lastYear."-".$ary[$i];
        $lunarlast    = new Lunar(substr($lastYearDate,0,4),substr(   $lastYearDate,5,2),substr($lastYearDate,8,2));
        $flagLast = $lunarlast->display();
        if($flagLast=="0101"){
        $lastChunjie=$lastYear."-".$ary[$i];
        }

        }
        for($i=0;$i<count($ary);$i++)
        {
            $nextYear =substr($date,0,4)+1;
            $nextYearDate =$nextYear."-".$ary[$i];
            $lunarnext    = new Lunar(substr($nextYearDate,0,4),substr($nextYearDate,5,2),substr($nextYearDate,8,2));
            $flagNext = $lunarnext->display();
            if($flagNext=="0101"){
            $nextChunjie=$nextYear."-".$ary[$i];
            }
            }

            $dateflag=substr($date,5,2).substr($date,8,2);
            $chunjieflag=substr($chunjieDate,5,2).substr($chunjieDate,8,2);
            $dateC1= date ("Y-m-d", mktime (0,0,0,substr($chunjieDate,5,2),substr($chunjieDate,8,2),substr($chunjieDate,0,4))+24*60*60);
            $dateC2= date ("Y-m-d", mktime (0,0,0,substr($chunjieDate,5,2),substr($chunjieDate,8,2),substr($chunjieDate,0,4))+24*60*60*2);
            $dateC3= date ("Y-m-d", mktime (0,0,0,substr($chunjieDate,5,2),substr($chunjieDate,8,2),substr($chunjieDate,0,4))+24*60*60*3);
            $dateC4= date ("Y-m-d", mktime (0,0,0,substr($chunjieDate,5,2),substr($chunjieDate,8,2),substr($chunjieDate,0,4))+24*60*60*4);
            $dateC5= date ("Y-m-d", mktime (0,0,0,substr($chunjieDate,5,2),substr($chunjieDate,8,2),substr($chunjieDate,0,4))+24*60*60*5);
            $dateC6= date ("Y-m-d", mktime (0,0,0,substr($chunjieDate,5,2),substr($chunjieDate,8,2),substr($chunjieDate,0,4))+24*60*60*6);
            $dateC7= date ("Y-m-d", mktime (0,0,0,substr($chunjieDate,5,2),substr($chunjieDate,8,2),substr($chunjieDate,0,4))+24*60*60*7);

            $DateCAry = array(substr($dateC1,5),substr($dateC2,5),substr($dateC3,5),substr($dateC4,5),substr($dateC5,5),substr($dateC6,5),substr($dateC7,5));

            if($dateflag>"0101"&&$dateflag<"0501"&&!in_array($dateflag,$DateCAry))
            {
            /*$date1= date ("Y-m-d", mktime (0,0,0,substr($lastChunjie,5,2),substr($lastChunjie,8,2),substr($lastChunjie,0,4))+24*60*60);
            $date2= date ("Y-m-d", mktime (0,0,0,substr($lastChunjie,5,2),substr($lastChunjie,8,2),substr($lastChunjie,0,4))+24*60*60*2);
                $date3= date ("Y-m-d", mktime (0,0,0,substr($lastChunjie,5,2),substr($lastChunjie,8,2),substr($lastChunjie,0,4))+24*60*60*3);
            $date4= date ("Y-m-d", mktime (0,0,0,substr($lastChunjie,5,2),substr($lastChunjie,8,2),substr($lastChunjie,0,4))+24*60*60*4);
            $date5= date ("Y-m-d", mktime (0,0,0,substr($lastChunjie,5,2),substr($lastChunjie,8,2),substr($lastChunjie,0,4))+24*60*60*5);
            $date6= date ("Y-m-d", mktime (0,0,0,substr($lastChunjie,5,2),substr($lastChunjie,8,2),substr($lastChunjie,0,4))+24*60*60*6);
            $date7= date ("Y-m-d", mktime (0,0,0,substr($lastChunjie,5,2),substr($lastChunjie,8,2),substr($lastChunjie,0,4))+24*60*60*7);

            $DateAry = array(substr($date1,5),substr($date2,5),substr($date3,5),substr($date4,5),substr($date5,5),substr($date6,5),substr($date7,5));*/
            $wuYiDateAry = array("05-01","05-02","05-03","05-04","05-05","05-06","05-07");
            $subDate =substr($date,0,4);
            for($i=0;$i<7;$i++)
            {
            $temp = $subDate."-".$wuYiDateAry[$i];
                    $tempWeek =Allyes::getWeek($temp);
            if($week==$tempWeek){
            $nian = substr($date,0,4);
            $returnDate = $nian."-".$wuYiDateAry[$i];
            $dateAry =self::converChangjia($returnDate);
            }
            }

            }
            else if($dateflag<"1001"&&$dateflag>"0507")
                {
                $shiyiDateAry = array("10-01","10-02","10-03","10-04","10-05","10-06","10-07");
                for($i=0;$i<7;$i++)
                {
                $temp = substr($date,0,4)."-".$shiyiDateAry[$i];
                    //$tempWeek =$this->getWeek($temp);
                $tempWeek =Allyes::getWeek($temp);
                    if($tempWeek==$week)
                {
                $returnDate = substr($date,0,4)."-".$shiyiDateAry[$i];
                $dateAry =self::converChangjia($returnDate);
                }
                }

                }
                else if($dateflag > "1007")
                {
                $date1= date ("Y-m-d", mktime (0,0,0,substr($nextChunjie,5,2),substr($nextChunjie,8,2),substr($nextChunjie,0,4))+24*60*60);
                $date2= date ("Y-m-d", mktime (0,0,0,substr($nextChunjie,5,2),substr($nextChunjie,8,2),substr($nextChunjie,0,4))+24*60*60*2);
                    $date3= date ("Y-m-d", mktime (0,0,0,substr($nextChunjie,5,2),substr($nextChunjie,8,2),substr($nextChunjie,0,4))+24*60*60*3);
                    $date4= date ("Y-m-d", mktime (0,0,0,substr($nextChunjie,5,2),substr($nextChunjie,8,2),substr($nextChunjie,0,4))+24*60*60*4);
                $date5= date ("Y-m-d", mktime (0,0,0,substr($nextChunjie,5,2),substr($nextChunjie,8,2),substr($nextChunjie,0,4))+24*60*60*5);
                $date6= date ("Y-m-d", mktime (0,0,0,substr($nextChunjie,5,2),substr($nextChunjie,8,2),substr($nextChunjie,0,4))+24*60*60*6);
                $date7= date ("Y-m-d", mktime (0,0,0,substr($nextChunjie,5,2),substr($nextChunjie,8,2),substr($nextChunjie,0,4))+24*60*60*7);

                $DateAry = array(substr($date1,5),substr($date2,5),substr($date3,5),substr($date4,5),substr($date5,5),substr($date6,5),substr($date7,5));
                $nextNian = substr($date,0,4)+1;
                    for( $i=0;$i<count($DateAry);$i++){
                    $temp = $nextNian."-".$DateAry[$i];
                    //$tempWeek =$this->getWeek($temp);
                    $tempWeek =Allyes::getWeek($temp);
                    if($tempWeek==$week){
                    $returnDate = $nextNian."-".$DateAry[$i];
                    $dateAry =self::converChangjia($returnDate);
                    }
                    }
                    }
                    else
                    {//是长假
                    $ary = array("01-01","01-02","01-03","01-04","01-05","01-06","01-07","01-08","01-09","01-10",
                    "01-11","01-12","01-13","01-14","01-15","01-16","01-17","01-18","01-19","01-20",
                    "01-21","01-22","01-23","01-24","01-25","01-26","01-27","01-28","01-29","01-30",
                          "01-31",
                          "02-01","02-02","02-03","02-04","02-05","02-06","02-07","02-08","02-09","02-10",
                          "02-11","02-12","02-13","02-14","02-15","02-16","02-17","02-18","02-19","02-20",
                          "02-21","02-22","02-23","02-24","02-25","02-26","02-27","02-28");
                    for($i=0;$i<count($ary);$i++)
                {
                    $tempdate=substr($date,0,4)."-".$ary[$i];
                    $lunar = new Lunar(substr($tempdate,0,4),substr($tempdate,5,2),substr($tempdate,8,2));
                    $flag  = $lunar->display();
                    if($flag=="0101")
                    {
                    $chunjieDate=substr($date,0,4)."-".$ary[$i];
                    }
                    }
                    $lunar = new Lunar(substr($date,0,4),substr($date,5,2),substr($date,8,2));
                    $temchunjie  = $lunar->display();
                    $dateflag=substr($date,5,2).substr($date,8,2);
                    if($dateflag<="0503"&&$dateflag>="0501")
                    {
                    $tempdate=substr($date,0,4)."-01-01";
                    $dateAry = array("changjia",$chunjieDate,substr($date,8,2));
                    }
                    if($dateflag<="1007"&&$dateflag>="1001")
                    {
                  $tempdate=substr($date,0,4)."-05-01";
                    $dateAry = array("changjia",$tempdate,substr($date,8,2));
                    }
                    if($temchunjie<="0107"&&$temchunjie>="0101") {
                    $tempdate=(substr($date,0,4)-1)."-10-01";
                    $dateAry = array("changjia",$tempdate,substr($temchunjie,2,2));
                    }

                    }
                    return $dateAry;
                    }
                    //--function转换长假的函数
                    public static function converChangjia($date)
                    {
                        $dateAry = array();
                        $ary = array("01-01","01-02","01-03","01-04","01-05","01-06","01-07","01-08","01-09","01-10","01-11","01-12","01-13","01-14","01-15","01-16","01-17","01-18","01-19","01-20","01-21","01-22","01-23","01-24","01-25","01-26","01-27","01-28","01-29","01-30","01-31","02-01","02-02","02-03","02-04","02-05","02-06","02-07","02-08","02-09","02-10","02-11","02-12","02-13","02-14","02-15","02-16","02-17","02-18","02-19","02-20","02-21","02-22","02-23","02-24","02-25","02-26","02-27","02-28");
                        for($i=0;$i<count($ary);$i++)
                        {
                            $tempdate=substr($date,0,4)."-".$ary[$i];
                            $lunar          = new Lunar(substr($tempdate,0,4),substr($tempdate,5,2),substr($tempdate,8,2));
                            $flag  = $lunar->display();
                            if($flag=="0101")
                            {
                                $chunjieDate=substr($date,0,4)."-".$ary[$i];
                            }
                        }
                        $lunar = new Lunar(substr($date,0,4),substr($date,5,2),substr($date,8,2));
                        $temchunjie  = $lunar->display();

                        $dateflag=substr($date,5,2).substr($date,8,2);
                        if($dateflag<="0503"&&$dateflag>="0501")
                        {
                            $tempdate=substr($date,0,4)."-01-01";
                            $dateAry = array("changjia",$chunjieDate,substr($date,8,2));
                        }
                        if($dateflag<="1007"&&$dateflag>="1001")
                        {
                            $tempdate=substr($date,0,4)."-05-01";
                            $dateAry = array("changjia",$tempdate,substr($date,8,2));
                        }
                        if($temchunjie<="0107"&&$temchunjie>="0101")
                        {
                            $tempdate=(substr($date,0,4)-1)."-10-01";
                            $dateAry = array("changjia",$tempdate,substr($temchunjie,2,2));
                        }
                        return $dateAry;
                    }

    /**
     * 获取客户端真实IP
     * @return string $ip
     */
    public static function getIP() {
        if (@$_SERVER["HTTP_X_FORWARDED_FOR"]) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (@$_SERVER["HTTP_CLIENT_IP"]) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } else if (@$_SERVER["REMOTE_ADDR"]) {
            $ip = $_SERVER["REMOTE_ADDR"];
        } else if (@getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (@getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } else if (@getenv("REMOTE_ADDR")) {
            $ip = getenv("REMOTE_ADDR");
        } else {
            $ip = "Unknown";
        }
        return $ip;
    }

    /**
     * 计算两个日期的相差时间
     *
     * @param date $dateTimeBegin
     * @param date $dateTimeEnd
     * @param string $interval 返回相差的格式
     *
     * $return int 时间
     */
    public function dateDiff($dateTimeBegin, $dateTimeEnd, $interval='d') {
         //Parse about any English textual datetime
         //$dateTimeBegin, $dateTimeEnd

         $dateTimeBegin=strtotime($dateTimeBegin);
         if($dateTimeBegin === -1) {
           return("..begin date Invalid");
         }

         $dateTimeEnd=strtotime($dateTimeEnd);
         if($dateTimeEnd === -1) {
           return("..end date Invalid");
         }

         $dif=$dateTimeEnd - $dateTimeBegin;

         switch($interval) {
           case "s"://seconds
               return($dif);

           case "n"://minutes
               return(floor($dif/60)); //60s=1m

           case "h"://hours
               return(floor($dif/3600)); //3600s=1h

           case "d"://days
               return(floor($dif/86400)); //86400s=1d

           case "ww"://Week
               return(floor($dif/604800)); //604800s=1week=1semana

           case "m": //similar result "m" dateDiff Microsoft
               $monthBegin=(date("Y",$dateTimeBegin)*12)+
                 date("n",$dateTimeBegin);
               $monthEnd=(date("Y",$dateTimeEnd)*12)+
                 date("n",$dateTimeEnd);
               $monthDiff=$monthEnd-$monthBegin;
               return($monthDiff);

           case "yyyy": //similar result "yyyy" dateDiff Microsoft
               return(date("Y",$dateTimeEnd) - date("Y",$dateTimeBegin));

           default:
               return(floor($dif/86400)); //86400s=1d
         }

       }
       /*
        *
       * 返回开始时间到结束时间的日期
       * @param date $start 开始时间
       * @param date $end 结束时间
       * @return array $years
       * */
       public static function getChannelForecastYmd($start,$end){
           $sinfo = getdate ( strtotime ( $start ) );
           $einfo = getdate ( strtotime ( $end ) );
           $syear = $sinfo ['year'];
           $eyear = $einfo ['year'];
           $dates = array ();
           do {
               if ($syear == $eyear) {
                   $dates [$syear] = Allyes::getYears ( $start, $end );
               } else {
                   $dates [$syear] = Allyes::getYears ( $start, ($syear) . '-12-31' );
               }
               $syear ++;
               $start = $syear . '-01-01';
           } while ( $syear <= $eyear );
           return $dates;
       }
       /*
        * 聚合getChannelForecastYmd
       */
       public function getYears($start,$end){
           $months = array ();
           $sinfo = getdate ( strtotime ( $start ) );
           $einfo = getdate ( strtotime ( $end ) );
           if ($sinfo ['mon'] != $einfo ['mon'])
               $months [$sinfo ['mon']] = array_fill ( $sinfo ['mday'], date ( 'd', strtotime ( "{$sinfo['year']}-{$sinfo['mon']}-01 + 1 month -1 day" ) ) - $sinfo ['mday'] + 1, 1 );
           else {
               $months [$sinfo ['mon']] = array_fill ( $sinfo ['mday'], ($einfo ['mday'] - $sinfo ['mday'] + 1), 1 );
           }
           $tm = $sinfo ['mon'];
           $em = $einfo ['mon'];
           while ( $tm <= $em ) {
               $time = strtotime ( $sinfo ['year'] . "-$tm-1" );
               if (! key_exists ( $tm, $months )) {
                   $months [$tm] = array_fill ( 1, Allyes::getMonthCount ( $time ), 1 );
               }
               $tm ++;
           }
           if(count($months) > 1)
            $months [-- $tm] = array_fill ( 1, $einfo ['mday'], 1 );
           return $months;
       }
       /*
        * 聚合getChannelForecastYmd
       * 获取天数
       */
       public function getMonthCount($date) {
           $timestamp = strtotime('+1 month -1 day',$date);
           $dcount =  (date('d',$timestamp));
           return $dcount;
       }

    /**
     * 获取返回缩短日期
     * $day = array (
                '2012-10-10',
                '2012-10-11',
                '2012-10-12',
                '2012-10-13',
                '2012-10-14',
                '2012-10-15',
                '2012-10-17',
                '2012-10-18',
                '2012-10-19'
            );
            getShotByDays($day);
            reutn array(
                      0 => string '2012-10-10 ~ 2012-10-15',
                      1 => string '2012-10-17 ~ 2012-10-19')


     * 获取客户端真实IP
     * @param array $days;
     * @return array $tmp;
     */
     public static function getShotByDays(array $days){
          if(empty($days))
                  return;
           $rest = array_shift ( $days );
           $tmp = array();
           $first = $rest;
           foreach($days as $d){
               if(strtotime($d) != strtotime($first." +1 day")){
                   $tmp [] = $rest.' ~ '.$first;
                   $rest = $d;
               }
               $first = $d;
           }
           $tmp[] = $rest.' ~ '.$first;
           return $tmp;
      }
}

?>
