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

$searchnum=trim($_GET['searchnum']);

$getname=trim($_GET['getname']);
if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
	  $sqlstr="select distinct mk_projectstatus.`status`,mk_project.projectnum,mk_project.name as projectname from mk_projectstatus left join mk_project on mk_project.projectnum=mk_projectstatus.projectnum where 1=1";	 
	  if($searchnum<>""){$sqlstr=$sqlstr." and mk_projectstatus.projectnum='".$searchnum."'";}
	  $sqlstr=$sqlstr." order by  mk_projectstatus.adddate desc,mk_projectstatus.id desc";
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
	$projectstatus_list = array();    
	while($projectstatus= $db->fetch_array($query))
	{	
		$kk++;	
        $projectstatus["k"]=$kk;
		$projectstatus_list[] = $projectstatus;
	}
	$phpfile="choosestatus.php?searchnum=$searchnum&getid=$getid&getname=$getname&page=";	
	$pagearray=pagenumstr($page,$total,$phpfile,$pagenum,$pagelen);
    $pageinfo=$pagearray['pagecode'];		
	
$tl->set_file('choosestatus');
$tl->n();
$tl->p();
$db->close();
?>