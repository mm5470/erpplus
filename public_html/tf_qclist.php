<?
require_once("data/conn.php");
require_once("public.php");
require_once("data/template.ease.php");
session_start();
if(!isset($_SESSION["username"])||$_SESSION["username"]=="")
{
	header("Location:index.php");
}
$db=new Dirver();
$db->DBLink($db_server,$db_username,$db_password,$db_name);
$tl = new template();
$page=1;
$pagenum=16;
$pagelen=5;
$act=$_GET["act"];
$searchtitle=$_GET['searchtitle'];
if($act=="del")
	{
		$delid=$_GET["id"];	
		$sqld="select * from  mk_tf_qc_class where id='".$delid."'";
		$rsd=$db->rows($sqld);
		$delqcno=$rsd["class_no"];
		//刪除原物料
		$sqld="delete from mk_tf_qc_product where class_no ='".$delqcno."';";
		$db->query($sqld);
         //刪除工項		
		 $sqld="delete from mk_tf_qc_workitem where class_no ='".$delqcno."';";
		 $db->query($sqld);	
		 //刪除系統
         $sqld="delete from mk_tf_qc_system where class_no ='".$delqcno."';";
		 $db->query($sqld);	
		 //刪除類別
	    $sqld="delete from mk_tf_qc_class where id ='".$delid."'";
	    $db->query($sqld);
		
	}

if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
	  $sqlstr="select mk_tf_qc_class.id,mk_mf_qc.qc_no,mk_systemmodule.name as systemname,mk_project.name as projectname,mk_tf_qc_class.class_name,mk_tf_qc_system.qty,mk_tf_qc_system.total 
from  mk_tf_qc_class
left join mk_mf_qc on mk_mf_qc.qc_no=mk_tf_qc_class.qc_no
left join mk_project on mk_project.projectnum=mk_mf_qc.projectnum
left join mk_tf_qc_system on mk_tf_qc_system.class_no=mk_tf_qc_class.class_no 
left join mk_systemmodule on mk_systemmodule.id=mk_tf_qc_system.systemmodelid
order by mk_tf_qc_class.id desc";
	 // echo $sqlstr;
	  if (isset($_GET['total'])) {
	  	$total = $_GET['total'];
		}
	 else {
	  $all_rs = $db->query($sqlstr);
	  $total= $db->num_rows($all_rs); 
	}
	$totalPages=ceil($total/$pagenum);	
	if($totalPages<=0){$totalPages=1;}
	$page= (1>$page || $page>$totalPages) ? $totalPages : $page; 
	$startpage = ($page-1) * $pagenum;	
	$sql=sprintf("%s LIMIT %d, %d",$sqlstr,$startpage,$pagenum);	
	if($total)
	{
		$query = $db->query($sql);
	}
	//echo $sql;
	$tf_qc_list = array();    
	while($tf_qc= $db->fetch_array($query))
	{	
		
		$tf_qc_list[] = $tf_qc;
	}
	$phpfile="tf_qclist.php?page=";	
	$pagearray=pagenumstr($page,$total,$phpfile,$pagenum,$pagelen);
    $pageinfo=$pagearray['pagecode'];		
	
$tl->set_file('tf_qclist');
$tl->n();
$tl->p();
$db->close();
?>