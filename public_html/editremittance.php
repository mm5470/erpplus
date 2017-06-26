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

//echo $act;
if($act=="edit")
{
//UPDATE
$UpdateSQL = sprintf("UPDATE  mk_remittance SET `banknot`= %s, `branch`= %s, `account`= %s, `name`= %s, `corrunit`= %s, `valid`= %s where   `id`= %s ",
	 GetSQLValueString($_POST['banknot'] ,"text"),
	 GetSQLValueString($_POST['branch'] ,"text"),
	 GetSQLValueString($_POST['account'] ,"text"),
	 GetSQLValueString($_POST['name'] ,"text"),
	 GetSQLValueString($_POST['corrunit'] ,"int"),
	 GetSQLValueString($_POST['valid'] ,"text"),
	 GetSQLValueString($id,"int"));
$db->query($UpdateSQL);
    header("Location:remittancelist.php");
   
}

		$sql="select * from mk_remittance where id='".$id."'";
		$rs=$db->rows($sql);
		

	 $unitsql = "select * from mk_unit where id='".$rs['corrunit']."'";
	 $rsunit=$db->rows($unitsql);
		
		  
$tl->set_file('editremittance');
$tl->n();
$tl->p();
$db->close();
?>