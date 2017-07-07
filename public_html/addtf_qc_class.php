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
$strqcno=$_GET['qc_no'];
     $ListSql = "select * from mk_mf_qc order by  qc_no desc,id desc";
	// echo $ListSql;
	 $query1 = $db->query($ListSql);
	 $mf_qc_list = array();    
	 while($mf_qc= $db->fetch_array($query1))
	   {
		   $mf_qc_list[]=$mf_qc;
		}
	 $strclassno="CL-".date("Y").date("mdHi").rand(0,9);
if($act=="add")
{
$qc_no=$_POST['qc_no'];
$class_no=$_POST['class_no'];
//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_tf_qc_class (`qc_no`,`class_no`,`class_name`,`valid`) VALUES (%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['qc_no'],"text"),
	 GetSQLValueString($_POST['class_no'],"text"),
	 GetSQLValueString($_POST['class_name'],"text"),
	 GetSQLValueString($_POST['valid'],"text"));
     $db->query($InsertSQL);
			  header("Location:addtf_qc_system.php?qc_no=$qc_no&class_no=$class_no");
		
}
$tl->set_file('addtf_qc_class');
$tl->n();
$tl->p();
$db->close();
?>