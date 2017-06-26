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
	
    if($alertstr==""){
		//UPDATE
			$UpdateSQL = sprintf("UPDATE  mk_systemmodule SET `name`= %s, `valid`= %s where   `id`= %s ",
				 GetSQLValueString($_POST['name'] ,"text"),
				 GetSQLValueString($_POST['valid'] ,"text"),
				 GetSQLValueString($_POST['id'],"int"));
			$db->query($UpdateSQL);
         header("Location:systemmodule.php?page=$page");
     }
}
$sqls="select * from mk_systemmodule where id='".$id."'";
//echo $sqls;
$rs=$db->rows($sqls);

$tl->set_file('editsystemmodule');
$tl->n();
$tl->p();
$db->close();
?>