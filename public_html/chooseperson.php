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
$getflag=trim($_GET['getflag']);
$getname=trim($_GET['getname']);
if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
	  $sqlstr="select  contactnum as personid,'C'as personflag,name as personname  from mk_contact
union
select  id as personid,'U'as personflag,username as personname from mk_user where 1=1 ";
	  if($searchtitle<>""){$sqlstr=$sqlstr." and personname like '%".$searchtitle."%'";}
	  $sqlstr=$sqlstr." order by  personid desc";
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
	$person_list = array();    
	while($person= $db->fetch_array($query))
	{	$kk++;	
        $person["k"]=$kk;
		$person_list[] = $person;
	}
	$phpfile="chooseperson.php?searchtitle=$searchtitle&getid=$getid&getflag=$getflag&getname=$getname&page=";	
	$pagearray=pagenumstr($page,$total,$phpfile,$pagenum,$pagelen);
    $pageinfo=$pagearray['pagecode'];		
	
$tl->set_file('chooseperson');
$tl->n();
$tl->p();
$db->close();
?>