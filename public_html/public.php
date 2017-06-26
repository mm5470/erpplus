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