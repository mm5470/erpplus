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
 
	$ListSql = "select * from mk_unit order by  id desc";
	// echo $ListSql;
	 $query2 = $db->query($ListSql);
	 $unit_list = array();    
	 while($unit= $db->fetch_array($query2))
	   {
		   $unit_list[]=$unit;
		}
if($act=="add")
{
	
//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_remittance (`banknot`,`branch`,`account`,`name`,`corrunit`,`valid`) VALUES (%s ,%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['banknot'],"text"),
	 GetSQLValueString($_POST['branch'],"text"),
	 GetSQLValueString($_POST['account'],"text"),
	 GetSQLValueString($_POST['name'],"text"),
	 GetSQLValueString($_POST['corrunit'],"int"),
	 GetSQLValueString($_POST['valid'],"text"));
$db->query($InsertSQL);
			  header("Location:remittancelist.php");
		
}
$tl->set_file('addremittance');
$tl->n();
$tl->p();
$db->close();
?>