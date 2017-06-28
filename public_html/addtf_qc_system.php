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
$qc_no=$_GET['qc_no'];
$class_no=$_GET['class_no'];
$system_id=$_POST['systemmodelid'];
     $ListSql = "select mk_mf_qc.*,mk_tf_qc_class.class_name,mk_project.name as projectname 
	 from mk_tf_qc_class left join mk_mf_qc on mk_mf_qc.qc_no=mk_tf_qc_class.qc_no 
	 left join mk_project on mk_project.projectnum=mk_mf_qc.projectnum where mk_tf_qc_class.qc_no='".$qc_no."' and mk_tf_qc_class.class_no='".$class_no."'";
	$rs=$db->rows($ListSql);
	$ListSql = "select * from mk_systemmodule order by  id desc";
	// echo $ListSql;
	 $query2 = $db->query($ListSql);
	 $systemmodule_list = array();    
	 while($systemmodule= $db->fetch_array($query2))
	   {
		   $systemmodule_list[]=$systemmodule;
		}	 
if($act=="add")
{

//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_tf_qc_system (`id`,`qc_no`,`class_no`,`systemmodelid`,`systemmodel`,`qty`,`unit`,`valid`) VALUES (%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['id'],"int"),
	 GetSQLValueString($qc_no,"text"),
	 GetSQLValueString($class_no,"text"),
	 GetSQLValueString($system_id,"int"),
	  GetSQLValueString($_POST['systemmodel'],"text"),
	 GetSQLValueString($_POST['qty'],"int"),
	 GetSQLValueString($_POST['unit'],"text"),	
	 GetSQLValueString($_POST['valid'],"text"));
$db->query($InsertSQL);
			  header("Location:addtf_qc_workitem.php?qc_no=$qc_no&class_no=$class_no&system_id=$system_id");
		
}
$tl->set_file('addtf_qc_system');
$tl->n();
$tl->p();
$db->close();
?>