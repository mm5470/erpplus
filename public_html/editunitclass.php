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
	//UPDATE
$UpdateSQL = sprintf("UPDATE  mk_unitclass SET `classname`= %s, `squee`= %s where   `id`= %s ",
	 GetSQLValueString($_POST['classname'] ,"text"),
	 GetSQLValueString($_POST['squee'] ,"int"),
	 GetSQLValueString($_POST['id'],"int"));
$db->query($UpdateSQL);
 
			header("Location:unitclass.php?page=$page");
	
}
$sqls="select * from mk_unitclass  where  id='".$id."'";
//echo $sqls;
$rs=$db->rows($sqls);
     
	
$tl->set_file('editunitclass');
$tl->n();
$tl->p();
$db->close();
?>