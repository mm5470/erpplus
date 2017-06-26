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
		$UpdateSQL = sprintf("UPDATE  mk_costdriven SET `name`= %s, `storeprocedure`= %s, `valid`= %s, `memo`= %s where   `id`= %s ",
			 GetSQLValueString($_POST['name'] ,"text"),
			 GetSQLValueString($_POST['storeprocedure'] ,"text"),
			 GetSQLValueString($_POST['valid'] ,"text"),
			 GetSQLValueString($_POST['memo'] ,"text"),
			 GetSQLValueString($_POST['id'],"int"));
		$db->query($UpdateSQL);
         header("Location:costdriven.php?page=$page");
     }
}
$sqls="select * from mk_costdriven where id='".$id."'";
//echo $sqls;
$rs=$db->rows($sqls);

$tl->set_file('editcostdriven');
$tl->n();
$tl->p();
$db->close();
?>