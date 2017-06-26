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

$searchtext=$_GET['searchtext'];

if($act=="del")
	{
		$delid=$_GET["id"];		
	    $sqld="delete from mk_user where id='".$delid."'";
		//echo $sqld;
	    $db->query($sqld);
		
	}

if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
	  $sqlstr="SELECT * FROM mk_user  where 1=1 ";
	  if((isset($searchtext)&&$searchtext<>"")){$sqlstr=$sqlstr." and mk_user.username like '%".$searchtext."%'";}
	  $sqlstr.=" order by mk_user.id desc";
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
	$user_list = array();    
	while($user= $db->fetch_array($query))
	{
		$k++;		
		$user['k']=$k+($page-1) * $pagenum;		
		$user_list[] = $user;
	}
	$phpfile="employeelist.php?page=";	
	$pagearray=pagenumstr($page,$total,$phpfile,$pagenum,$pagelen);
    $pageinfo=$pagearray['pagecode'];
	
$tl->set_file('employeelist');
$tl->n();
$tl->p();
$db->close();
?>