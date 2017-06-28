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
  
    $ListSql = sprintf("select * from mk_moneycategory  order by  `id` desc");
	// echo $ListSql;
	 $query = $db->query($ListSql);
	 $moneycategory_list = array();    
	 while($moneycategory= $db->fetch_array($query))
	   {
		   $moneycategory_list[]=$moneycategory;
		}	
 $ListSql2 = sprintf("select * from mk_paymentcategory  order by  `id`desc");
	// echo $ListSql;
	 $query = $db->query($ListSql2);
	 $paymentcategory_list = array();    
	 while($paymentcategory= $db->fetch_array($query))
	   {
		   $paymentcategory_list[]=$paymentcategory;
		}		
if($act=="add")
{
//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_accountmodel (`projectnum`,`moneycategory`,`paymentcategory`,`percentage`,`closingdate`,`yourdate`,`paymentdate`,`usancebooking`,`adddate`) VALUES (%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['projectnum'],"text"),
	 GetSQLValueString($_POST['moneycategory'],"int"),
	 GetSQLValueString($_POST['paymentcategory'],"int"),
	 GetSQLValueString($_POST['percentage'],"int"),
	 GetSQLValueString($_POST['closingdate'],"text"),
	 GetSQLValueString($_POST['yourdate'],"text"),
	 GetSQLValueString($_POST['paymentdate'],"text"),
	 GetSQLValueString($_POST['usancebooking'],"text"),
	 GetSQLValueString($_POST['adddate'],"date"));
$db->query($InsertSQL);

			 header("Location:accountmodel.php");
		
}
$tl->set_file('addaccountmodel');
$tl->n();
$tl->p();
$db->close();
?>