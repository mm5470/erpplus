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
    $strqcno="QC-".date("Y").date("mdHi").rand(0,9);
	$ListSql = "select * from mk_unit order by  id desc";
	// echo $ListSql;
	 $query = $db->query($ListSql);
	 $unit_list = array();    
	 while($unit= $db->fetch_array($query))
	   {
		   $unit_list[]=$unit;
		}
	$ListSql = "select * from mk_project order by  id desc";
	// echo $ListSql;
	 $query2 = $db->query($ListSql);
	 $project_list = array();    
	 while($project= $db->fetch_array($query2))
	   {
		   $project_list[]=$project;
		}
	$ListSql = "select * from mk_contact order by  contactnum desc";
	// echo $ListSql;
	 $query3 = $db->query($ListSql);
	 $contact_list = array();    
	 while($contact= $db->fetch_array($query3))
	   {
		   $contact_list[]=$contact;
		}
		$ListSql = "select * from mk_remittance order by  id desc";
	// echo $ListSql;
	 $query4 = $db->query($ListSql);
	 $remittance_list = array();    
	 while($remittance= $db->fetch_array($query4))
	   {
		   $remittance_list[]=$remittance;
		}
if($act=="add")
{

//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_mf_qc (`qc_no`,`projectnum`,`stage`,`unitno`,`contactno`,`serialnumber`,`address`,`tel`,`fax`,`memo`,`taxclass`,`yourday`,`loanday`,`remittanceno`,`ourunitno`,`ourcontactno`,`ourserialnumber`,`ouraddress`,`ourtel`,`ourfax`) VALUES (%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['qc_no'],"text"),
	 GetSQLValueString($_POST['projectnum'],"text"),
	 GetSQLValueString($_POST['stage'],"text"),
	 GetSQLValueString($_POST['unitno'],"int"),
	 GetSQLValueString($_POST['contactno'],"int"),
	 GetSQLValueString($_POST['serialnumber'],"text"),
	 GetSQLValueString($_POST['address'],"text"),
	 GetSQLValueString($_POST['tel'],"text"),
	 GetSQLValueString($_POST['fax'],"text"),
	 GetSQLValueString($_POST['memo'],"text"),
	 GetSQLValueString($_POST['taxclass'],"int"),
	 GetSQLValueString($_POST['yourday'],"text"),
	 GetSQLValueString($_POST['loanday'],"text"),
	 GetSQLValueString($_POST['remittanceno'],"int"),
	 GetSQLValueString($_POST['ourunitno'],"int"),
	 GetSQLValueString($_POST['ourcontactno'],"text"),
	 GetSQLValueString($_POST['ourserialnumber'],"text"),
	 GetSQLValueString($_POST['ouraddress'],"text"),
	 GetSQLValueString($_POST['ourtel'],"text"),
	 GetSQLValueString($_POST['ourfax'],"text"));
$db->query($InsertSQL);
			  header("Location:mf_qclist.php");
		
}
$tl->set_file('addmf_qc');
$tl->n();
$tl->p();
$db->close();
?>