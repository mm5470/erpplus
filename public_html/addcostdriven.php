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
  

if($act=="add")
{
	
//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_costdriven (`name`,`storeprocedure`,`valid`,`memo`) VALUES (%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['name'],"text"),
	 GetSQLValueString($_POST['storeprocedure'],"text"),
	 GetSQLValueString($_POST['valid'],"text"),
	 GetSQLValueString($_POST['memo'],"text"));
$db->query($InsertSQL);
			  header("Location:costdriven.php");
		
}
$tl->set_file('addcostdriven');
$tl->n();
$tl->p();
$db->close();
?>