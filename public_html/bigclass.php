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
$id=$_GET["id"];
if($act=="del")
	{
		//刪除產品小類
	    $sqls="select id from mk_category where parsent='".$id."'";
	    $querys = $db->query($sqls);
		$dmidclass_list = array();    
	    while($dmidclass= $db->fetch_array($query))
	    {
			 $sqls="delete from mk_category where parsent='".$dmidclass["id"]."'";
	         $db->query($sqls);			
		}
		//刪除產品中類
	    $sqld="delete from mk_category where parsent='".$id."'";
	    $db->query($sqld);
		//刪除產品大類
	    $sqld="delete from mk_category where id='".$id."'";
	    $db->query($sqld);
		
	}

if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
	  $sqlstr="SELECT * FROM mk_category  where level=0 ";
	  if((isset($searchtitle)&&$searchtitle<>"")){$sqlstr=$sqlstr." and mk_category.name like '%".$searchtitle."%'";}
	  $sqlstr.=" order by mk_category.squee asc,mk_category.id desc";
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
	$bigclass_list = array();    
	while($bigclass= $db->fetch_array($query))
	{
		if(strlen_utf8($bigclass['keywords'])>80)
		{
			$bigclass['strkeywords']=msubstr($bigclass["keywords"],0,79)."...";
		}else{
			$bigclass['strkeywords']=$bigclass['keywords'];
			}
		if(strlen_utf8($bigclass['description'])>100)
		{
			$bigclass['strdescription']=msubstr($bigclass["description"],0,99)."...";
		}else{
			$bigclass['strdescription']=$bigclass['description'];
			}
		$bigclass_list[] = $bigclass;
	}
	$phpfile="bigclass.php?page=";	
	$pagearray=pagenumstr($page,$total,$phpfile,$pagenum,$pagelen);
    $pageinfo=$pagearray['pagecode'];		
	
$tl->set_file('bigclass');
$tl->n();
$tl->p();
$db->close();
?>