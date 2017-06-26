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
	  $sqlstr="select mk_mf_qc.*,mk_project.name as projectname from mk_mf_qc 
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
	$mf_qc_list = array();    
	while($mf_qc= $db->fetch_array($query))
	{	
		$sqlu="select name from mk_unit where id='".$mf_qc['unitno']."'";
		//echo $sqlu;
		$rsu=$db->rows($sqlu);
		
		$sqlour="select name from mk_unit where id='".$mf_qc['ourunitno']."'";
		//echo $sqlour;
		$rsour=$db->rows($sqlour);
		
		
		$mf_qc["stagename"]=$stagename;
		$mf_qc["unitname"]=$rsu["name"];
		$mf_qc["ourunitname"]=$rsour["name"];
		$mf_qc_list[] = $mf_qc;
	}
	$phpfile="mf_qclist.php?page=";	
	$pagearray=pagenumstr($page,$total,$phpfile,$pagenum,$pagelen);
    $pageinfo=$pagearray['pagecode'];		
	
$tl->set_file('mf_qclist');
$tl->n();
$tl->p();
$db->close();
?>