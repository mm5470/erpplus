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
$UpdateSQL = sprintf("UPDATE  mk_projectstatus SET `projectnum`= %s, `status`= %s, `unit1`= %s, `unit2`= %s, `contact1`= %s, `contact2`= %s, `contact3`= %s, `statusstartdate`= %s, `statusenddate`= %s, `valid`= %s, `lastrevision`= %s, `lastmodifiedtime`= %s where   `id`= %s ",
	 GetSQLValueString($_POST['projectnum'] ,"text"),
	 GetSQLValueString($_POST['status'] ,"text"),
	 GetSQLValueString($_POST['unit1'] ,"int"),
	 GetSQLValueString($_POST['unit2'] ,"int"),
	 GetSQLValueString($_POST['contact1'] ,"int"),
	 GetSQLValueString($_POST['contact2'] ,"int"),
	 GetSQLValueString($_POST['contact3'] ,"int"),
	 GetSQLValueString($_POST['statusstartdate'] ,"date"),
	 GetSQLValueString($_POST['statusenddate'] ,"date"),
	 GetSQLValueString($_POST['valid'] ,"text"),
	 GetSQLValueString($_SESSION['username'] ,"text"),
	 GetSQLValueString($_POST['lastmodifiedtime'] ,"date"),
	 GetSQLValueString($_POST['id'],"int"));
    $db->query($UpdateSQL);
     header("Location:projectstatus.php");
   
}

		$sql="select * from mk_projectstatus where id='".$id."'";
		$rs=$db->rows($sql);
	$projectsql = "select name from mk_project where projectnum='".$rs['projectnum']."'";
	$rsproject=$db->rows($projectsql);	
	$unitsql = "select name from mk_unit where id='".$rs['unit1']."'";
	$rsunit1=$db->rows($unitsql);
	$unitsql2 = "select name from mk_unit where id='".$rs['unit2']."'";
	$rsunit2=$db->rows($unitsql2);	
	$contactsql = "select name from mk_contact where contactnum='".$rs['contact1']."'";
	$rscontact1=$db->rows($contactsql);
	$contactsql2 = "select name from mk_contact where contactnum='".$rs['contact2']."'";
	$rscontact2=$db->rows($contactsql2);
	$contactsql3 = "select name from mk_contact where contactnum='".$rs['contact2']."'";
	$rscontact3=$db->rows($contactsql3);
$tl->set_file('editprojectstatus');
$tl->n();
$tl->p();
$db->close();
?>