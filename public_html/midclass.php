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
$foldername="../prdt/";
$id=$_GET["id"];
if($act=="del")
	{		
				
		//刪除產品小類
	    $sqld="delete from mk_category where parsent='".$id."'";
	    $db->query($sqld);
		//刪除產品中類
	    $sqld="delete from mk_category where id='".$id."'";
	    $db->query($sqld);
		
	}

if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
	  $sqlstr="select A.id,A.keywords,A.description,A.istop,A.squee,B.name AS bigname,A.name as midname,B.id as bid,A.id as mid from mk_category A inner join mk_category B on B.id=A.parsent  where 1=1 ";
	  if((isset($searchtitle)&&$searchtitle<>"")){$sqlstr=$sqlstr." and B.name like '%".$searchtitle."%'";}
	  $sqlstr.=" order by B.squee asc,B.id desc,A.squee asc,A.id desc";
	  //echo $sqlstr;
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
	$midclass_list = array();    
	while($midclass= $db->fetch_array($query))
	{
		$k++;	
		if(strlen_utf8($midclass['description'])>100)
		{
			$midclass['strdescription']=msubstr($midclass["description"],0,99)."...";
		}else{
			$midclass['strdescription']=$midclass['description'];
			}
		$midclass['k']=$k+($page-1)*$pagenum;
		$midclass_list[] = $midclass;
	}
	$phpfile="midclass.php?page=";	
	$pagearray=pagenumstr($page,$total,$phpfile,$pagenum,$pagelen);
    $pageinfo=$pagearray['pagecode'];		
	
$tl->set_file('midclass');
$tl->n();
$tl->p();
$db->close();
?>