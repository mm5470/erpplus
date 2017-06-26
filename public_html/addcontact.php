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
//echo $act;
if($act=="add")
{
//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_contact (`name`,`tel1`,`tel2`,`tel3`,`fax1`,`fax2`,`email`,`address1`,`address2`,`sex`,`birthday`,`idnum`,`valid`,`adddate`) VALUES (%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['name'],"text"),
	 GetSQLValueString($_POST['tel1'],"text"),
	 GetSQLValueString($_POST['tel2'],"text"),
	 GetSQLValueString($_POST['tel3'],"text"),
	 GetSQLValueString($_POST['fax1'],"text"),
	 GetSQLValueString($_POST['fax2'],"text"),
	 GetSQLValueString($_POST['email'],"text"),
	 GetSQLValueString($_POST['address1'],"text"),
	 GetSQLValueString($_POST['address2'],"text"),
	 GetSQLValueString($_POST['sex'],"text"),
	 GetSQLValueString($_POST['birthday'],"date"),
	 GetSQLValueString($_POST['idnum'],"text"),
	 GetSQLValueString($_POST['valid'],"text"),
	 GetSQLValueString($_POST['adddate'],"date"));
	// echo  $InsertSQL;
     $db->query($InsertSQL);
    header("Location:contactlist.php");
   
}

$tl->set_file('addcontact');
$tl->n();
$tl->p();
$db->close();
?>