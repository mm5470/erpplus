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
$searchtitle=trim($_GET['searchtitle']);
$searchnum=trim($_GET['searchnum']);
$getid=trim($_GET['getid']);
$getname=trim($_GET['getname']);
if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
	  $sqlstr="select * from mk_unit where 1=1 ";
	  if($searchtitle<>""){$sqlstr=$sqlstr." and mk_unit.name like '%".$searchtitle."%'";}
	  if($searchnum<>""){$sqlstr=$sqlstr." and mk_unit.serialnumber='".$searchnum."'";}
	  $sqlstr=$sqlstr." order by  adddate desc,id desc";
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
	$unit_list = array();    
	while($unit= $db->fetch_array($query))
	{	
		$kk++;	
        $unit["k"]=$kk;
		$unit_list[] = $unit;
	}
	$phpfile="chooseunit.php?searchtitle=$searchtitle&searchnum=$searchnum&getid=$getid&getname=$getname&page=";	
	$pagearray=pagenumstr($page,$total,$phpfile,$pagenum,$pagelen);
    $pageinfo=$pagearray['pagecode'];		
	
$tl->set_file('chooseunit');
$tl->n();
$tl->p('chooseunit');
$db->close();
?>