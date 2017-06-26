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
$act=$_POST["act"];

if($act=="add")
{
	
	
//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_product (`productno`,`cid`,`productname`,`spec`,`color`,`model`,`size`,`weight`,`squee`,`memo`) VALUES (%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['productno'],"text"),
	 GetSQLValueString($_POST['cid'],"int"),
	 GetSQLValueString($_POST['productname'],"text"),
	 GetSQLValueString($_POST['spec'],"text"),
	 GetSQLValueString($_POST['color'],"text"),
	 GetSQLValueString($_POST['model'],"text"),
	 GetSQLValueString($_POST['size'],"text"),
	 GetSQLValueString($_POST['weight'],"text"),
	 GetSQLValueString($_POST['squee'],"int"),
	 GetSQLValueString($_POST['memo'],"text"));
$db->query($InsertSQL);
      header("Location:prdtlist.php");
}
 			 $bid=$_GET['bid'];			 
			 $strproductno="P".date("Y").date("mdHis").rand(0,9);
			 
		      //大類對應
  $sqlbig="SELECT  * from  mk_category where parsent=0  order by squee desc";
			 $querybig=$db->query($sqlbig);
			 $bigclass_list = array();		 
			 while($bigclass=$db->fetch_array($querybig))
			 {					  	 
				   $sqlmid="SELECT * FROM  mk_category  where  parsent='".$bigclass['id']."' order by squee desc";			  
				   $querymid=$db->query($sqlmid);
				   $midclass_list = array();		 
					while($midclass=$db->fetch_array($querymid))
					 {			
					    $sqls="SELECT * FROM  mk_category  where parsent='".$midclass['id']."' order by squee desc";	
						$querysmall=$db->query($sqls);
				        $smallclass_list = array();
						while($smallclass=$db->fetch_array($querysmall))
					    {	
						   		$smallclass_list[]=$smallclass;
					     }	
						$midclass['sub']=$smallclass_list;
						$midclass_list[]= $midclass;						
					 }
				 $bigclass['sub']=$midclass_list;
			     $bigclass_list[]= $bigclass;
			 }	
						 
$tl->set_file('addprdt');
$tl->n();
$tl->p();
$db->close();
?>