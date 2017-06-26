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
$UpdateSQL = sprintf("UPDATE  mk_projectmonitor_model SET `monitornum`= %s, `notify_model`= %s, `notify_id`= %s, `notify_flag`= %s, `notify_person`= %s where   `id`= %s ",
	 GetSQLValueString($_POST['monitornum'] ,"text"),
	 GetSQLValueString($_POST['notify_model'] ,"int"),
	 GetSQLValueString($_POST['notify_id'] ,"int"),
	 GetSQLValueString($_POST['notify_flag'] ,"text"),
	 GetSQLValueString($_POST['notify_person'] ,"text"),
	 GetSQLValueString($_POST['id'],"int"));
$db->query($UpdateSQL);
 
 
     header("Location:monitormodel.php");
   
}

		$sql="select * from  mk_projectmonitor_model where id='".$id."'";
		$rs=$db->rows($sql);
	
	 
	   if($rs["notify_model"]=="1"){$chk1="checked='checked';";}	 
	   if($rs["notify_model"]=="2"){$chk2="checked='checked';";}
	   if($rs["notify_model"]=="3"){$chk3="checked='checked';";}
	  
	  
$tl->set_file('editmonitormodel');
$tl->n();
$tl->p();
$db->close();
?>