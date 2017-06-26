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
	    $sqld="delete from mk_projectstatus where id ='".$delid."'";
	    $db->query($sqld);
		
	}

if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
	  $sqlstr="select mk_project.projectnum,mk_project.id as projectid,mk_projectstatus.id,mk_project.name,mk_projectstatus.valid,mk_projectstatus.status,mk_projectstatus.statusstartdate,mk_projectstatus.statusenddate,mk_projectstatus.unit1,mk_projectstatus.unit2,mk_projectstatus.contact1,mk_projectstatus.contact2,mk_projectstatus.contact3 from mk_projectstatus left join mk_project on mk_project.projectnum=mk_projectstatus.projectnum order by mk_project.id desc,mk_project.adddate desc";
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
	$projectstatus_list = array();    
	while($projectstatus= $db->fetch_array($query))
	{	
		if($projectstatus['unit1']<>"" && $projectstatus['unit1']<>"null"){			
			$sqlunit1="select * from mk_unit where id='".$projectstatus['unit1']."'";			
			$rsunit1=$db->rows($sqlunit1);
			$unitname1="1,".$rsunit1["name"]."<br/>";;
		}else{$unitname1="";}
		if($projectstatus['unit2']<>"" && $projectstatus['unit2']<>"null"){			
			$sqlunit2="select * from mk_unit where id='".$projectstatus['unit2']."'";
			$rsunit2=$db->rows($sqlunit2);
			$unitname2="2,".$rsunit2["name"];
		}else{$unitname2="";}
		if($projectstatus['contact1']<>"" && $projectstatus['contact1']<>"null"){			
			$sqlcontact1="select * from mk_contact where contactnum='".$projectstatus['contact1']."'";			
			$rscontact1=$db->rows($sqlcontact1);
			$contact1="1,".$rscontact1["name"]."<br/>";
		}else{$contact1="";}
		if($projectstatus['contact2']<>"" && $projectstatus['contact2']<>"null"){			
			$sqlcontact2="select * from mk_contact where contactnum='".$projectstatus['contact2']."'";			
			$rscontact2=$db->rows($sqlcontact2);
			$contact2="2,".$rscontact2["name"]."<br/>";
		}else{$contact2="";}
		if($projectstatus['contact3']<>"" && $projectstatus['contact3']<>"null"){			
			$sqlcontact3="select * from mk_contact where contactnum='".$projectstatus['contact3']."'";			
			$rscontact3=$db->rows($sqlcontact3);
			$contact3="3,".$rscontact3["name"];
		}else{$contact3="";}
		$projectstatus["contactname"]=$contact1." ".$contact2." ".$contact3;
		$projectstatus["unitname"]=$unitname1." ".$unitname2;
		$projectstatus_list[] = $projectstatus;
	}
	$phpfile="projectstatus.php?page=";	
	$pagearray=pagenumstr($page,$total,$phpfile,$pagenum,$pagelen);
    $pageinfo=$pagearray['pagecode'];		
	
$tl->set_file('projectstatus');
$tl->n();
$tl->p();
$db->close();
?>