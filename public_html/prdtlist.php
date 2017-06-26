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
$pagenum=20;
$pagelen=5;
$act=$_GET["act"];
$id=$_GET['id'];

if($act=="del")
	{
	    $sqld="delete from mk_product where id ='".$id."'";
		//echo $sqld;
	    $db->query($sqld);
		
	}

if (isset($_GET['page'])) {
	$page = $_GET['page'];
} 
	  $sqlstr="SELECT * FROM mk_product where  1=1 ";
	  $sqlstr.=" order by mk_product.id desc,mk_product.cid desc ";
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
	$prdt_list = array();    
	while($prdt= $db->fetch_array($query))
	{
		$k++;		
	     $sql="select * from mk_category  where id='".$prdt['cid']."'";
	//echo $sql;	
	$rsc=$db->rows($sql);
	if($rsc['parsent']<>"" &&$rsc['parsent']<>0){
		$sqlb="select * from mk_category  where id='".$rsc['parsent']."'";
		$rsb=$db->rows($sqlb);
		        $bid=$rsb['id'];
				$bigname=$rsb['name'];				
				$mid=$rsc['id'];
				$midname=$rsc['name'];			
				$strinfo=$rsc["classdesc"];	
				$strname=$midname;				
				$strtitle=$bigname."::".$midname;	
				
		}else{
				$bid=$rsc['id'];
				$bigname=$rsc['name'];			
				$strname=$bigname;
				$strinfo=$rsb["classdesc"];				
				$strtitle=$bigname;			
				}   
		$prdt['bigname']=$bigname;
		$prdt['midname']=$midname;
		$prdt['k']=$k+($page-1)*$pagenum;
		$prdt_list[] = $prdt;
	}
	$phpfile="prdtlist.php?page=";	
	$pagearray=pagenumstr($page,$total,$phpfile,$pagenum,$pagelen);
    $pageinfo=$pagearray['pagecode'];		
	
$tl->set_file('prdtlist');
$tl->n();
$tl->p();
$db->close();
?>