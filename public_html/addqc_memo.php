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
 
	
if($act=="add")
{
				//INSEART
			$InsertSQL = sprintf("INSERT INTO  mk_qc_memo (`qc_no`,`memo`,`valid`,`addman`,`adddate`) VALUES (%s ,%s ,%s ,%s ,%s )",
				 GetSQLValueString($_POST['qc_no'],"text"),
				 GetSQLValueString($_POST['memo'],"text"),
				GetSQLValueString($_POST['valid'],"text"),
				 GetSQLValueString($_SESSION['username'],"text"),	
				 GetSQLValueString($_POST['adddate'],"date"));
			$db->query($InsertSQL);	
              if($_POST['isover']=="T"){
				  $InsertSQL2 = sprintf("INSERT INTO  mk_projectmemo (`projectnum`,`memo`,`adddate`) VALUES (%s ,%s ,%s )",
				 GetSQLValueString($_POST['projectnum'],"text"),
				 GetSQLValueString($_POST['memo'],"text"),					
				 GetSQLValueString($_POST['adddate'],"date"));
				 $db->query($InsertSQL2);	
			  }			
			  header("Location:qc_memo.php");
		
}
$tl->set_file('addqc_memo');
$tl->n();
$tl->p();
$db->close();
?>