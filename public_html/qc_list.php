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
	    $sqld="delete from mk_mf_qc where id ='".$delid."'";
	    $db->query($sqld);
		
	}

if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
	  $sqlstr="select mk_mf_qc.*,mk_project.name as projectname,mk_tf_qc_system.systemmodelid,mk_tf_qc_class.class_no,mk_tf_qc_class.class_name,
	  mk_tf_qc_system.systemmodelid,mk_systemmodule.name as systemname from mk_mf_qc 
	  left join mk_tf_qc_class on mk_tf_qc_class.qc_no=mk_mf_qc.qc_no
	  left join mk_tf_qc_system on mk_tf_qc_system.class_no=mk_tf_qc_class.class_no
	  left join mk_systemmodule on mk_systemmodule.id=mk_tf_qc_system.systemmodelid
	  left join mk_project on mk_project.projectnum=mk_mf_qc.projectnum 	  
	  order by mk_mf_qc.id desc";
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
	$qc_list = array();    
	while($qc= $db->fetch_array($query))
	{	
		$sqlu="select name from mk_unit where id='".$qc['unitno']."'";
		//echo $sqlu;
		$rsu=$db->rows($sqlu);
		
		$sqlour="select name from mk_unit where id='".$qc['ourunitno']."'";
		//echo $sqlour;
		$rsour=$db->rows($sqlour);
		switch($qc['stage'])
		{
			case 1:$stagename="報價(建築師)";break;
			case 2:$stagename="報價(營造發包)";break;
			case 3:$stagename="簽約";break;
		}
		
		$qc["stagename"]=$stagename;
		$qc["unitname"]=$rsu["name"];
		$qc["ourunitname"]=$rsour["name"];
		$qc_list[] = $qc;
	}
	$phpfile="qc_list.php?page=";	
	$pagearray=pagenumstr($page,$total,$phpfile,$pagenum,$pagelen);
    $pageinfo=$pagearray['pagecode'];		
	
$tl->set_file('qc_list');
$tl->n();
$tl->p();
$db->close();
?>