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
     $InsertSQL = sprintf("INSERT INTO  mk_unitclass (`classname`,`squee`) VALUES (%s ,%s )",
	 GetSQLValueString($_POST['classname'],"text"),
	 GetSQLValueString($_POST['squee'],"int"));
    $db->query($InsertSQL);
    header("Location:unitclass.php");   
}

$tl->set_file('addunitclass');
$tl->n();
$tl->p();
$db->close();
?>