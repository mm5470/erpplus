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
  
  $strgroupunitidno="GP-".date("Y").date("mdHi").rand(0,9);   	
if($act=="add")
{

//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_groupunit (`groupunitid`,`productno`,`unit`,`reducedqty`,`iscommon`) VALUES (%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['groupunitid'],"text"),
	 GetSQLValueString($_POST['productno'],"text"),
	 GetSQLValueString($_POST['unit'],"text"),
	 GetSQLValueString($_POST['reducedqty'],"int"),
	 GetSQLValueString($_POST['iscommon'],"text"));
$db->query($InsertSQL);

			 header("Location:groupunit.php");
		
}
$tl->set_file('addgroupunit');
$tl->n();
$tl->p();
$db->close();
?>