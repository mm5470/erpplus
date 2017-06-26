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
$UpdateSQL = sprintf("UPDATE  mk_jobtitle SET `id`= %s, `jobname`= %s, `squee`= %s where   `id`= %s ",
	 GetSQLValueString($_POST['id'] ,"int"),
	 GetSQLValueString($_POST['jobname'] ,"text"),
	 GetSQLValueString($_POST['squee'] ,"int"),
	 GetSQLValueString($_POST['id'],"int"));
$db->query($UpdateSQL);
 
			header("Location:jobtitle.php?page=$page");
	
}
$sqls="select * from mk_jobtitle  where  id='".$id."'";
//echo $sqls;
$rs=$db->rows($sqls);
     
	
$tl->set_file('editjobtitle');
$tl->n();
$tl->p();
$db->close();
?>