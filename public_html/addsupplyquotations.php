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

$alertstr="";
  
  $strsupplyquotationsno="SQ-".date("Y").date("mdHi").rand(0,9);   	
if($act=="add")
{

//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_supplyquotations (`quotationno`,`productno`,`supplier_unitid`,`price`,`quotation_unit`,`supplier_productno`,`valid`,`sort`,`memo`) VALUES (%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['quotationno'],"text"),
	 GetSQLValueString($_POST['productno'],"text"),
	 GetSQLValueString($_POST['supplier_unitid'],"int"),
	 GetSQLValueString($_POST['price'],"double"),
	 GetSQLValueString($_POST['quotation_unit'],"int"),
	 GetSQLValueString($_POST['supplier_productno'],"text"),
	 GetSQLValueString($_POST['valid'],"text"),
	 GetSQLValueString($_POST['sort'],"int"),
	 GetSQLValueString($_POST['memo'],"text"));
$db->query($InsertSQL);

			 header("Location:supplyquotations.php");
		
}
$tl->set_file('addsupplyquotations');
$tl->n();
$tl->p();
$db->close();
?>