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
//echo $act;
if($act=="add")
{
    
//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_moneycategory (`id`,`name`,`squee`) VALUES (%s ,%s ,%s )",
	 GetSQLValueString($_POST['id'],"int"),
	 GetSQLValueString($_POST['name'],"text"),
	 GetSQLValueString($_POST['squee'],"int"));
$db->query($InsertSQL);
    header("Location:moneycategory.php");   
}

$tl->set_file('addmoneycategory');
$tl->n();
$tl->p();
$db->close();
?>