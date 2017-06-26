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
$UpdateSQL = sprintf("UPDATE  mk_projectmemo SET `projectnum`= %s, `memo`= %s,  `lastrevision`= %s, `valid`= %s, `corr_oddnum`= %s where   `id`= %s ",
	 GetSQLValueString($_POST['projectnum'] ,"text"),
	 GetSQLValueString($_POST['memo'] ,"text"),
	 GetSQLValueString($_SESSION['username'] ,"text"),
	 GetSQLValueString($_POST['valid'] ,"text"),
	 GetSQLValueString($_POST['corr_oddnum'] ,"text"),
	 GetSQLValueString($_POST['id'],"int"));
$db->query($UpdateSQL);
     header("Location:projectmemo.php");
   
}

		$sql="select * from mk_projectmemo where id='".$id."'";
		$rs=$db->rows($sql);
	
		
			$projectsql = "select name from mk_project where projectnum='".$rs['projectnum']."'";
	$rsproject=$db->rows($projectsql);	
	
	  
$tl->set_file('editprojectmemo');
$tl->n();
$tl->p();
$db->close();
?>