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
$pagenum=10;
$pagelen=5;
$searchtitle=$_GET['searchtitle'];
$getid=trim($_GET['getid']);
$getname=trim($_GET['getname']);
if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
	  $sqlstr="select *,CONCAT_WS(',',tel1,tel2,tel3) as contacttel from mk_contact where 1=1 ";
	  if($searchtitle<>""){$sqlstr=$sqlstr." and mk_contact.name like '%".$searchtitle."%'";}
	  $sqlstr=$sqlstr." order by  adddate desc,contactnum desc";
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
	$contact_list = array();    
	while($contact= $db->fetch_array($query))
	{	$kk++;	
        $contact["k"]=$kk;
		$contact_list[] = $contact;
	}
	$phpfile="choosecontact.php?searchtitle=$searchtitle&getid=$getid&getname=$getname&page=";	
	$pagearray=pagenumstr($page,$total,$phpfile,$pagenum,$pagelen);
    $pageinfo=$pagearray['pagecode'];		
	
$tl->set_file('choosecontact');
$tl->n();
$tl->p();
$db->close();
?>