<?
require_once("data/conn.php");
require_once("public.php");
require_once("data/template.ease.php");
session_start();
$db=new Dirver();
$db->DBLink($db_server,$db_username,$db_password,$db_name);
$tl = new template();
if(!isset($_SESSION["username"])||$_SESSION["username"]=="")
{
	header("Location:index.php");
}
$act=$_POST["act"];
$alertstr="";
$qc_no=$_GET['qc_no'];

     $ListSql = "select mk_mf_qc.*,mk_project.name as projectname 
	 from mk_mf_qc  
	 left join mk_project on mk_project.projectnum=mk_mf_qc.projectnum
     where mk_mf_qc.qc_no='".$qc_no."'";
	$rs=$db->rows($ListSql);
	  
     	$sqlu="select name from mk_unit where id='".$rs['unitno']."'";
		//echo $sqlu;
		$rsu=$db->rows($sqlu);		
		 $sqlc="select name from mk_contact where contactnum='".$rs['contactno']."'";
		//echo $sqlu;
		$rsc=$db->rows($sqlc);
         $sqlour="select name from mk_unit where id='".$rs['ourunitno']."'";
		//echo $sqlour;
		$rsour=$db->rows($sqlour);		
		$sqlcour="select name from mk_contact where contactnum='".$rs['ourcontactno']."'";
		//echo $sqlour;
		$rscour=$db->rows($sqlcour);
	
	switch($rs['taxclass'])
		{
			case 1:$taxclassname="應稅外加";break;
			case 2:$taxclassname="應稅內含";break;
			case 3:$taxclassname="零稅率";break;
		}
	$ListSql = "select * from mk_tf_qc_workitem  where mk_tf_qc_workitem.qc_no='".$qc_no."'";
	 echo $ListSql;
	 $query = $db->query($ListSql);
	 $workitem_list = array();    
	 while($workitem= $db->fetch_array($query))
	   {
		   $wk++;
		  $ListSql2 = "select * from mk_tf_qc_product where qc_no='".$qc_no."' and  workitemname='".$workitem['workitemname']."' ";
	       //echo $ListSql2;
		   $query2=$db->query($ListSql2);
		   $product_list = array();		   
		   while($product=$db->fetch_array($query2))
			{	
                 $pk++;		
				 $product["k"]=$pk;
				 $subtotal=$subtotal+$product["total"];
				 $product_list[]= $product;						
			}
		   $workitem['k']=$wk;
		   $workitem['sub']=$product_list; 	   
		   $workitem_list[]=$workitem;
		}	

$tl->set_file('preview_qc');
$tl->n();
$tl->p();
$db->close();
?>