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

if($act=="edit")
{
  //UPDATE
   $UpdateSQL = sprintf("UPDATE  mk_category SET `name`= %s,`squee`= %s,`description`= %s where   `id`= %s ",
	 GetSQLValueString($_POST['name'] ,"text"),	 
	 GetSQLValueString($_POST['squee'] ,"int"),	
	 GetSQLValueString($_POST['description'] ,"text"),
	 GetSQLValueString($_POST['id'],"int"));
       $db->query($UpdateSQL);    
        header("Location:bigclass.php");
}
$sqls="select * from mk_category where level=0 and id='".$id."'";
//echo $sqls;
$rs=$db->rows($sqls);


$tl->set_file('editbigclass');
$tl->n();
$tl->p();
$db->close();
?>