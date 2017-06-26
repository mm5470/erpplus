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

$alertstr="";
  //list post
	 $ListSql = "select * from mk_contact order by  contactnum desc";
	// echo $ListSql;
	 $query1 = $db->query($ListSql);
	 $contact_list = array();    
	 while($contact= $db->fetch_array($query1))
	   {
		   $contact_list[]=$contact;
		}
	$ListSql = "select * from mk_unit order by  id desc";
	// echo $ListSql;
	 $query2 = $db->query($ListSql);
	 $unit_list = array();    
	 while($unit= $db->fetch_array($query2))
	   {
		   $unit_list[]=$unit;
		}
	$ListSql = "select * from mk_project order by  id desc";
	// echo $ListSql;
	 $query3 = $db->query($ListSql);
	 $project_list = array();    
	 while($project= $db->fetch_array($query3))
	   {
		   $project_list[]=$project;
		}
if($act=="add")
{
		//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_projectstatus (`projectnum`,`status`,`unit1`,`unit2`,`contact1`,`contact2`,`contact3`,`statusstartdate`,`statusenddate`,`valid`,`adddate`) VALUES (%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['projectnum'],"text"),
	 GetSQLValueString($_POST['status'],"text"),
	 GetSQLValueString($_POST['unit1'],"int"),
	 GetSQLValueString($_POST['unit2'],"int"),
	 GetSQLValueString($_POST['contact1'],"int"),
	 GetSQLValueString($_POST['contact2'],"int"),
	 GetSQLValueString($_POST['contact3'],"int"),
	 GetSQLValueString($_POST['statusstartdate'],"date"),
	 GetSQLValueString($_POST['statusenddate'],"date"),
	 GetSQLValueString($_POST['valid'],"text"),
	 GetSQLValueString($_POST['adddate'],"date"));
$db->query($InsertSQL);
			  header("Location:projectstatus.php");
		
}
$tl->set_file('addprojectstatus');
$tl->n();
$tl->p();
$db->close();
?>