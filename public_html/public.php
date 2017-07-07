<?php
session_start();

	 
//網站基本信息
$sqlstr = "select * from mk_siteinfo";
$rssiteinfo=$db->rows($sqlstr);




if($_SESSION['grouplist']=="")
{
	$sqlmenugroup=sprintf("select * from mk_menugroup order by squee desc,id desc");

}else
{
	$sqlmenugroup=sprintf("select * from mk_menugroup where id in(".$_SESSION['grouplist'].") order by squee desc,id desc");
}

$querymenugroup=$db->query($sqlmenugroup);
$menugroupl_list=array();
while($menugroupl= $db->fetch_array($querymenugroup))
	{
		$sqlleftmenu=sprintf("select * from mk_menu where menugroup=".$menugroupl['id']." and id in(select id from mk_menu where menugroup='".$menugroupl['id']."') order by squee desc,id desc");	
		$queryleftmenu=$db->query($sqlleftmenu);
		$menunum=$db->nums($sqlleftmenu);
         $leftmenu_list=array();
			while($leftmenu= $db->fetch_array($queryleftmenu))
				{		
					$leftmenu_list[]=$leftmenu;
				}
	    $menugroupl["sub"]=$leftmenu_list;
		$menugroupl["menunums"]=$menunum;
		$menugroupl_list[]=$menugroupl;
	}

 /**
* 数字转换为中文
* @param  string|integer|float  $num  目标数字
* @param  integer $mode 模式[true:金额（默认）,false:普通数字表示]
* @param  boolean $sim 使用小写（默认）
* @return string
*/
 function number2chinese($num,$mode = true,$sim = true){
    if(!is_numeric($num)) return '含有非数字非小数点字符！';
    $char    = $sim ? array('零','一','二','三','四','五','六','七','八','九')
    : array('零','壹','贰','叁','肆','伍','陆','柒','捌','玖');
    $unit    = $sim ? array('','十','百','千','','万','亿','兆')
    : array('','拾','佰','仟','','萬','億','兆');   
    //整数部分
    $str = $mode ? strrev(intval($num)) : strrev($num);
    for($i = 0,$c = strlen($str);$i < $c;$i++) {
        $out[$i] = $char[$str[$i]];
        if($mode){
            $out[$i] .= $str[$i] != '0'? $unit[$i%4] : '';
                if($i>1 and $str[$i]+$str[$i-1] == 0){
                $out[$i] = '';
            }
                if($i%4 == 0){
                $out[$i] .= $unit[4+floor($i/4)];
            }
        }
    }
    $retval = join('',array_reverse($out)) . $retval;
    return $retval;
 }






setcookie("tcount","AAA");
$thisyear=date("Y");
$thisurl=$_SERVER['REQUEST_URI'];
if(strstr($thisurl,"currency")==true){
	//$thisurl="index.html";
	$strl=split("\?currency",$_SERVER["REQUEST_URI"]);
     $thisurl=$strl[count($strl)-2];
	}
$countnum=number_format($rssiteinfo['counts']);

$sitemail="ralphlaurenuksale@gmail.com";

?>