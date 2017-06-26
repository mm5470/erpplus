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
  
	$ListSql = "select * from mk_systemmodule order by  id desc";
	// echo $ListSql;
	 $query2 = $db->query($ListSql);
	 $systemmodule_list = array();    
	 while($systemmodule= $db->fetch_array($query2))
	   {
		   $systemmodule_list[]=$systemmodule;
		}
	$ListSql = "select * from mk_costdriven order by  id desc";
	// echo $ListSql;
	 $query3 = $db->query($ListSql);
	 $costdriven_list = array();    
	 while($costdriven= $db->fetch_array($query3))
	   {
		   $costdriven_list[]=$costdriven;
		}
if($act=="add")
{
	
//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_workitem (`systemid`,`itemno`,`name`,`qty`,`unit`,`memo`,`valid`) VALUES (%s ,%s ,%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['systemid'],"int"),
	 GetSQLValueString($_POST['itemno'],"text"),
	 GetSQLValueString($_POST['name'],"text"),
	 GetSQLValueString($_POST['qty'],"text"),
	 GetSQLValueString($_POST['unit'],"text"),
	 GetSQLValueString($_POST['memo'],"text"),
	 GetSQLValueString($_POST['valid'],"text"));
$db->query($InsertSQL);
			  header("Location:workitem.php");
		
}
$tl->set_file('addworkitem');
$tl->n();
$tl->p();
$db->close();
?>