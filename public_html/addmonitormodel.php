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
$InsertSQL = sprintf("INSERT INTO  mk_projectmonitor_model (`monitornum`,`notify_model`,`notify_id`,`notify_flag`,`notify_person`) VALUES (%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['monitornum'],"text"),
	 GetSQLValueString($_POST['notify_model'],"int"),
	 GetSQLValueString($_POST['notify_id'],"int"),
	 GetSQLValueString($_POST['notify_flag'],"text"),
	 GetSQLValueString($_POST['notify_person'],"text"));
$db->query($InsertSQL);

			 header("Location:monitormodel.php");
		
}
$tl->set_file('addmonitormodel');
$tl->n();
$tl->p();
$db->close();
?>