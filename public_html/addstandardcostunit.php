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
 $ListSql = "select * from mk_product order by  id desc";
	// echo $ListSql;
	 $query2 = $db->query($ListSql);
	 $product_list = array();    
	 while($product= $db->fetch_array($query2))
	   {
		   $product_list[]=$product;
		}
	$ListSql = "select * from mk_workitem order by  id desc";
	// echo $ListSql;
	 $query2 = $db->query($ListSql);
	 $workitem_list = array();    
	 while($workitem= $db->fetch_array($query2))
	   {
		   $workitem_list[]=$workitem;
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
$InsertSQL = sprintf("INSERT INTO  mk_standardcostunit (`workitemno`,`productno`,`driverestimated`,`costdriverid`,`drivermax`,`drivermin`,`driverfixed`,`classvariable`,`workitemusage`,`usageunit`,`memo`) VALUES (%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['workitemno'],"text"),
	 GetSQLValueString($_POST['productno'],"text"),
	 GetSQLValueString($_POST['driverestimated'],"text"),
	 GetSQLValueString($_POST['costdriverid'],"int"),
	 GetSQLValueString($_POST['drivermax'],"int"),
	 GetSQLValueString($_POST['drivermin'],"int"),
	 GetSQLValueString($_POST['driverfixed'],"int"),
	 GetSQLValueString($_POST['classvariable'],"text"),
	 GetSQLValueString($_POST['workitemusage'],"text"),
	 GetSQLValueString($_POST['usageunit'],"text"),
	 GetSQLValueString($_POST['memo'],"text"));
$db->query($InsertSQL);
			  header("Location:standardcostunit.php");
		
}
$tl->set_file('addstandardcostunit');
$tl->n();
$tl->p();
$db->close();
?>