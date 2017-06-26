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
$UpdateSQL = sprintf("UPDATE  mk_contact SET `name`= %s, `tel1`= %s, `tel2`= %s, `tel3`= %s, `fax1`= %s, `fax2`= %s, `email`= %s, `address1`= %s, `address2`= %s, `sex`= %s, `birthday`= %s, `idnum`= %s, `valid`= %s, `adddate`= %s, `lastrevision`= %s, `lastmodifiedtime`= %s where   `contactnum`= %s ",
	 GetSQLValueString($_POST['name'] ,"text"),
	 GetSQLValueString($_POST['tel1'] ,"text"),
	 GetSQLValueString($_POST['tel2'] ,"text"),
	 GetSQLValueString($_POST['tel3'] ,"text"),
	 GetSQLValueString($_POST['fax1'] ,"text"),
	 GetSQLValueString($_POST['fax2'] ,"text"),
	 GetSQLValueString($_POST['email'] ,"text"),
	 GetSQLValueString($_POST['address1'] ,"text"),
	 GetSQLValueString($_POST['address2'] ,"text"),
	 GetSQLValueString($_POST['sex'] ,"text"),
	 GetSQLValueString($_POST['birthday'] ,"date"),
	 GetSQLValueString($_POST['idnum'] ,"text"),
	 GetSQLValueString($_POST['valid'] ,"text"),
	 GetSQLValueString($_POST['adddate'] ,"date"),
	 GetSQLValueString($_POST['lastrevision'] ,"text"),
	 GetSQLValueString($_POST['lastmodifiedtime'] ,"date"),
	 GetSQLValueString($id,"int"));
$db->query($UpdateSQL);
 
			header("Location:contactlist.php?page=$page");
	
}
$sqls="select * from mk_contact  where  contactnum='".$id."'";
//echo $sqls;
$rs=$db->rows($sqls);

	 
	 
$tl->set_file('editcontact');
$tl->n();
$tl->p();
$db->close();
?>