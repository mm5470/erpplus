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
$UpdateSQL = sprintf("UPDATE  mk_projectmonitor SET `monitornum`= %s, `projectnum`= %s, `memo`= %s, `startdate`= %s, `enddate`= %s, `valid`= %s, `adddate`= %s, `lastrevision`= %s, `lastmodifiedtime`= %s, `corr_document_num`= %s, `corr_rule`= %s where   `id`= %s ",
	 GetSQLValueString($_POST['monitornum'] ,"text"),
	 GetSQLValueString($_POST['projectnum'] ,"text"),
	 GetSQLValueString($_POST['memo'] ,"text"),
	 GetSQLValueString($_POST['startdate'] ,"date"),
	 GetSQLValueString($_POST['enddate'] ,"date"),
	 GetSQLValueString($_POST['valid'] ,"text"),
	 GetSQLValueString($_POST['adddate'] ,"date"),
	 GetSQLValueString($_POST['lastrevision'] ,"text"),
	 GetSQLValueString($_POST['lastmodifiedtime'] ,"date"),
	 GetSQLValueString($_POST['corr_document_num'] ,"text"),
	 GetSQLValueString($_POST['corr_rule'] ,"text"),
	 GetSQLValueString($_POST['id'],"int"));
$db->query($UpdateSQL);
     header("Location:projectmonitor.php");
   
}

		$sql="select * from mk_projectmonitor where id='".$id."'";
		$rs=$db->rows($sql);
	
	$projectsql = "select name from mk_project where projectnum='".$rs['projectnum']."'";
	$rsproject=$db->rows($projectsql);	
	  
$tl->set_file('editprojectmonitor');
$tl->n();
$tl->p();
$db->close();
?>