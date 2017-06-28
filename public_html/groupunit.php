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
mk_groupunit.productno,
mk_product.productname,
mk_groupunit.id,
mk_groupunit.groupunitid,
mk_groupunit.unit,
mk_groupunit.reducedqty,
mk_groupunit.iscommon
FROM
mk_groupunit
LEFT JOIN mk_product ON mk_groupunit.productno = mk_product.productno
 order by  mk_groupunit.groupunitid desc,mk_groupunit.productno desc,mk_groupunit.id desc";
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
	$groupunit_list = array();    
	while($groupunit= $db->fetch_array($query))
	{	
		if($groupunit['iscommon']=="T"){$groupunit['iscommon']="是";}else{$groupunit['iscommon']="否";}
		$groupunit_list[] = $groupunit;
	}
	$phpfile="groupunit.php?page=";	
	$pagearray=pagenumstr($page,$total,$phpfile,$pagenum,$pagelen);
    $pageinfo=$pagearray['pagecode'];		
	
$tl->set_file('groupunit');
$tl->n();
$tl->p();
$db->close();
?>