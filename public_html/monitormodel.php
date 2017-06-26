<?
require_once("data/conn.php");
require_once("public.php");
require_once("data/template.ease.php");
session_start();
if(!isset($_SESSION["username"])||$_SESSION["username"]=="")
{
	header("Location:index.php");
}
$db=new Dirver();
$db->DBLink($db_server,$db_username,$db_password,$db_name);
$tl = new template();
$page=1;
$pagenum=16;
$pagelen=5;
$act=$_GET["act"];
$searchtitle=$_GET['searchtitle'];
if($act=="del")
	{
		$delid=$_GET["id"];		
	    $sqld="delete from mk_projectmonitor_model where id ='".$delid."'";
	    $db->query($sqld);
		
	}

if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
	  $sqlstr="select * from mk_projectmonitor_model where 1=1 ";
	 // echo $sqlstr;
	  if (isset($_GET['total'])) {
	  	$total = $_GET['total'];
		}
	 else {
	  $all_rs = $db->query($sqlstr);
	  $total= $db->num_rows($all_rs); 
	}
	$totalPages=ceil($total/$pagenum);	
	if($totalPages<=0){$totalPages=1;}
	$page= (1>$page || $page>$totalPages) ? $totalPages : $page; 
	$startpage = ($page-1) * $pagenum;	
	$sql=sprintf("%s LIMIT %d, %d",$sqlstr,$startpage,$pagenum);	
	if($total)
	{
		$query = $db->query($sql);
	}
	//echo $sql;
	$monitormodel_list = array();    
	while($monitormodel= $db->fetch_array($query))
	{	switch($monitormodel['notify_model'])
		{
		  case 1:$notify_model="email";break;
		  case 2:$notify_model="簡訊";break;
		  case 3:$notify_model="登入告知";break;
		  default:$notify_model="email";break;
		}
       switch($monitormodel['notify_flag'])
		{
		  case "C":$notify_flag="聯絡人資料表";break;
		  case "U":$notify_flag="員工資料表";break;
		 
		  default:$notify_flag="聯絡人資料表";break;
		}		
		$monitormodel['notify_model']=$notify_model;
		$monitormodel['notify_flag']=$notify_flag;
		$monitormodel_list[] = $monitormodel;
	}
	$phpfile="monitormodel.php?page=";	
	$pagearray=pagenumstr($page,$total,$phpfile,$pagenum,$pagelen);
    $pageinfo=$pagearray['pagecode'];		
	
$tl->set_file('monitormodel');
$tl->n();
$tl->p();
$db->close();
?>