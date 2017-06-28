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
$UpdateSQL = sprintf("UPDATE  mk_accountmodel SET `projectnum`= %s, `moneycategory`= %s, `paymentcategory`= %s, `percentage`= %s, `closingdate`= %s, `yourdate`= %s, `paymentdate`= %s, `usancebooking`= %s,  `lastrevisiondate`= %s, `finalmodifier`= %s where   `id`= %s ",
	 GetSQLValueString($_POST['projectnum'] ,"text"),
	 GetSQLValueString($_POST['moneycategory'] ,"int"),
	 GetSQLValueString($_POST['paymentcategory'] ,"int"),
	 GetSQLValueString($_POST['percentage'] ,"int"),
	 GetSQLValueString($_POST['closingdate'] ,"text"),
	 GetSQLValueString($_POST['yourdate'] ,"text"),
	 GetSQLValueString($_POST['paymentdate'] ,"text"),
	 GetSQLValueString($_POST['usancebooking'] ,"text"),	 
	 GetSQLValueString($_POST['lastrevisiondate'] ,"date"),
	 GetSQLValueString($_SESSION['username'],"text"),
	 GetSQLValueString($_POST['id'],"int"));
$db->query($UpdateSQL);
 
     header("Location:accountmodel.php");
   
}

		$sql="select * from mk_accountmodel where id='".$id."'";
		$rs=$db->rows($sql);
	    
		$ListSql = sprintf("select * from mk_moneycategory  order by  `id`= %s  desc",GetSQLValueString($rs['moneycategory'],"int"));
		// echo $ListSql;
		 $query = $db->query($ListSql);
		 $moneycategory_list = array();    
		 while($moneycategory= $db->fetch_array($query))
		   {
			   $moneycategory_list[]=$moneycategory;
			}	
    $ListSql2 = sprintf("select * from mk_paymentcategory   order by  `id`= %s  desc",GetSQLValueString($rs['paymentcategory'],"int"));
	// echo $ListSql;
	 $query = $db->query($ListSql2);
	 $paymentcategory_list = array();    
	 while($paymentcategory= $db->fetch_array($query))
	   {
		   $paymentcategory_list[]=$paymentcategory;
		}		
		
			$projectsql = "select name from mk_project where projectnum='".$rs['projectnum']."'";
	        $rsproject=$db->rows($projectsql);	
	
	  
$tl->set_file('editaccountmodel');
$tl->n();
$tl->p();
$db->close();
?>