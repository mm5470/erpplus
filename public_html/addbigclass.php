<?
require_once("data/conn.php");
require_once("public.php");
require_once("data/template.ease.php");
session_start();
$db=new Dirver();
$db->DBLink($db_server,$db_username,$db_password,$db_name);
$tl = new template();
$foldername="../category/";
if(!isset($_SESSION["username"])||$_SESSION["username"]=="")
{
	header("Location:index.php");
}
$act=$_POST["act"];
if($act=="add")
{
    //INSEART
$InsertSQL = sprintf("INSERT INTO  mk_category (`name`,`parsent`,`squee`,`level`,`description`) VALUES (%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['name'],"text"),	
	 GetSQLValueString(0,"int"),
	 GetSQLValueString($_POST['squee'],"int"),	 
	 GetSQLValueString(0,"int"),
	 GetSQLValueString($_POST['description'],"text"));
	 $db->query($InsertSQL);
      header("Location:bigclass.php");
}
$tl->set_file('addbigclass');
$tl->n();
$tl->p();
$db->close();
?>