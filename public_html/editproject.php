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
$UpdateSQL = sprintf("UPDATE  mk_project SET `projectnum`= %s, `name`= %s, `address`= %s, `adddate`= %s, `lastrevision`= %s, `lastmodifiedtime`= %s, `valid`= %s where   `id`= %s and  `projectnum`= %s ",
	 GetSQLValueString($_POST['projectnum'] ,"text"),
	 GetSQLValueString($_POST['name'] ,"text"),
	 GetSQLValueString($_POST['address'] ,"text"),
	 GetSQLValueString($_POST['adddate'] ,"date"),
	 GetSQLValueString($_POST['lastrevision'] ,"text"),
	 GetSQLValueString($_POST['lastmodifiedtime'] ,"date"),
	 GetSQLValueString($_POST['valid'] ,"text"),
	 GetSQLValueString($_POST['id'],"int") , 
	 GetSQLValueString($_POST['projectnum'],"text"));
     $db->query($UpdateSQL);
header("Location:projectlist.php?page=$page");
	
}
$sqls="select * from mk_project  where  id='".$id."'";
//echo $sqls;
$rs=$db->rows($sqls);

	 
	 
$tl->set_file('editproject');
$tl->n();
$tl->p();
$db->close();
?>