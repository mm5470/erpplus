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
	  $sqlstr="SELECT
mk_accountmodel.id,
mk_accountmodel.projectnum,
mk_project.name as projectname,
mk_moneycategory.name as moneycategoryname,
mk_paymentcategory.name as paymentcategoryname,
mk_accountmodel.percentage
FROM
mk_accountmodel
LEFT JOIN mk_project ON mk_project.projectnum = mk_accountmodel.projectnum
LEFT JOIN mk_moneycategory ON mk_moneycategory.id = mk_accountmodel.moneycategory
LEFT JOIN mk_paymentcategory ON mk_paymentcategory.id = mk_accountmodel.paymentcategory
 order by  mk_accountmodel.projectnum asc,mk_accountmodel.id desc";
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
	$accountmodel_list = array();    
	while($accountmodel= $db->fetch_array($query))
	{	
		
		$accountmodel_list[] = $accountmodel;
	}
	$phpfile="accountmodel.php?page=";	
	$pagearray=pagenumstr($page,$total,$phpfile,$pagenum,$pagelen);
    $pageinfo=$pagearray['pagecode'];		
	
$tl->set_file('accountmodel');
$tl->n();
$tl->p();
$db->close();
?>