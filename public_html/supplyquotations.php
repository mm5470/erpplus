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
	    $sqld="delete from mk_supplyquotations where id ='".$delid."'";
	    $db->query($sqld);
		
	}

if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
	  $sqlstr="SELECT mk_supplyquotations.*,mk_product.productname,mk_unit.name as unitname,mk_groupunit.unit as productunit
FROM
mk_supplyquotations
LEFT JOIN mk_product ON mk_supplyquotations.productno = mk_product.productno
LEFT JOIN mk_unit on mk_unit.id=mk_supplyquotations.supplier_unitid
LEFT JOIN mk_groupunit on mk_groupunit.id=mk_supplyquotations.quotation_unit
 order by  mk_supplyquotations.quotationno desc,mk_supplyquotations.productno desc,mk_supplyquotations.id desc";
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
	$supplyquotations_list = array();    
	while($supplyquotations= $db->fetch_array($query))
	{	
		if($supplyquotations['valid']=="T"){$supplyquotations['valid']="是";}else{$supplyquotations['valid']="否";}
		$supplyquotations_list[] = $supplyquotations;
	}
	$phpfile="supplyquotations.php?page=";	
	$pagearray=pagenumstr($page,$total,$phpfile,$pagenum,$pagelen);
    $pageinfo=$pagearray['pagecode'];		
	
$tl->set_file('supplyquotations');
$tl->n();
$tl->p();
$db->close();
?>