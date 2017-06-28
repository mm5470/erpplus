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
$searchtitle=$_GET['searchtitle'];
$searchnum=$_GET['searchnum'];
$getid=trim($_GET['getid']);
$getname=trim($_GET['getname']);
if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
	  $sqlstr="SELECT
mk_product.productname,
mk_groupunit.productno,
mk_groupunit.id,
mk_groupunit.unit,
mk_groupunit.iscommon
FROM
mk_groupunit
LEFT JOIN mk_product ON mk_product.productno = mk_groupunit.productno where 1=1 ";
	   if($searchtitle<>""){$sqlstr=$sqlstr." and mk_product.productname like '%".$searchtitle."%'";}
	  if($searchnum<>""){$sqlstr=$sqlstr." and mk_groupunit.productno='".$searchnum."'";}
	  $sqlstr=$sqlstr." order by  id desc";
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
	$product_list = array();    
	while($product= $db->fetch_array($query))
	{	$kk++;	
        $product["k"]=$kk;
		$product_list[] = $product;
	}
	$phpfile="chooseprdtunit.php?searchtitle=$searchtitle&searchnum=$searchnum&getid=$getid&getname=$getname&page=";	
	$pagearray=pagenumstr($page,$total,$phpfile,$pagenum,$pagelen);
    $pageinfo=$pagearray['pagecode'];		
	
$tl->set_file('chooseprdtunit');
$tl->n();
$tl->p();
$db->close();
?>