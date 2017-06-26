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
$InsertSQL = sprintf("INSERT INTO  mk_projectmemo (`projectnum`,`memo`,`adddate`,`lastrevision`,`valid`,`corr_oddnum`) VALUES (%s ,%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['projectnum'],"text"),
	 GetSQLValueString($_POST['memo'],"text"),
	 GetSQLValueString($_POST['adddate'],"date"),
	 GetSQLValueString($_SESSION['username'],"text"),
	 GetSQLValueString($_POST['valid'],"text"),
	 GetSQLValueString($_POST['corr_oddnum'],"text"));
     $db->query($InsertSQL);
			  header("Location:projectmemo.php");
		
}
$tl->set_file('addprojectmemo');
$tl->n();
$tl->p();
$db->close();
?>