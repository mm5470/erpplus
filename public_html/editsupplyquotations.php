<?
require_once("data/conn.php");
require_once("public.php");
require_once("data/template.ease.php");
session_start();
$db=new Dirver();
$db->DBLink($db_server,$db_username,$db_password,$db_name);
$tl = new template();
if(!isset($_SESSION["username"])||$_SESSION["username"]=="")
{
	header("Location:index.php");
}
$act=$_POST["act"];
$id=$_GET["id"];
$page=$_GET['page'];
$alertstr="";
if($act=="edit")
{
	
    if($alertstr==""){
		
		//UPDATE
		$UpdateSQL = sprintf("UPDATE  mk_supplyquotations SET `quotationno`= %s, `productno`= %s, `supplier_unitid`= %s, `price`= %s, `quotation_unit`= %s, `supplier_productno`= %s, `valid`= %s, `sort`= %s, `memo`= %s, `lastrevision`= %s, `lastmodifiedtime`= %s where   `id`= %s ",
			 GetSQLValueString($_POST['quotationno'] ,"text"),
			 GetSQLValueString($_POST['productno'] ,"text"),
			 GetSQLValueString($_POST['supplier_unitid'] ,"int"),
			 GetSQLValueString($_POST['price'] ,"double"),
			 GetSQLValueString($_POST['quotation_unit'] ,"int"),
			 GetSQLValueString($_POST['supplier_productno'] ,"text"),
			 GetSQLValueString($_POST['valid'] ,"text"),
			 GetSQLValueString($_POST['sort'] ,"int"),
			 GetSQLValueString($_POST['memo'] ,"text"),
			 GetSQLValueString($_SESSION['username'],"text"),
			 GetSQLValueString($_POST['lastmodifiedtime'] ,"date"),
			 GetSQLValueString($_POST['id'],"int"));
		    $db->query($UpdateSQL);
         header("Location:supplyquotations.php?page=$page");
     }
}
$sqls="select * from mk_supplyquotations where id='".$id."'";
//echo $sqls;
$rs=$db->rows($sqls);

$sqlp="select * from mk_product where productno='".$rs['productno']."'";
//echo $sqls;
$rsprdt=$db->rows($sqlp);

$sqlu="select * from mk_unit where id='".$rs['supplier_unitid']."'";
//echo $sqls;
$rsunit=$db->rows($sqlu);

$sqlg="select * from mk_groupunit where id='".$rs['quotation_unit']."'";
//echo $sqls;
$rsprdtunit=$db->rows($sqlg);

$tl->set_file('editsupplyquotations');
$tl->n();
$tl->p();
$db->close();
?>