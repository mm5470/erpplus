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

$alertstr="";
  
if($act=="edit")
{
	//UPDATE
$UpdateSQL = sprintf("UPDATE  mk_standardcostprice SET `name`= %s, `unit`= %s, `price`= %s, `lastmodifiedtime`= %s, `memo`= %s where   `id`= %s ",
	 GetSQLValueString($_POST['name'] ,"text"),
	 GetSQLValueString($_POST['unit'] ,"text"),
	 GetSQLValueString($_POST['price'] ,"text"),
	 GetSQLValueString($_POST['lastmodifiedtime'] ,"date"),
	 GetSQLValueString($_POST['memo'] ,"text"),
	 GetSQLValueString($_POST['id'],"int"));
$db->query($UpdateSQL);
 
 
			  header("Location:standardcostprice.php");
		
}
   $sql="select * from mk_standardcostprice where id='".$id."'";
   $rs=$db->rows($sql);
  

		
$tl->set_file('editstandardcostprice');
$tl->n();
$tl->p();
$db->close();
?>