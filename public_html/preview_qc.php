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
$class_no=$_GET['class_no'];
$system_id=$_GET['system_id'];

     $ListSql = "select mk_mf_qc.*,mk_tf_qc_system.systemmodel as system_name,mk_tf_qc_class.class_name,mk_project.name as projectname 
	 from mk_tf_qc_class   
	 left join mk_mf_qc on mk_mf_qc.qc_no=mk_tf_qc_class.qc_no 
	 left join mk_tf_qc_system on mk_tf_qc_class.class_no=mk_tf_qc_system.class_no	
	 left join mk_project on mk_project.projectnum=mk_mf_qc.projectnum
     where mk_tf_qc_class.qc_no='".$qc_no."' and mk_tf_qc_class.class_no='".$class_no."' and mk_tf_qc_system.systemmodelid='".$system_id."'";
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
	$ListSql = "select * from mk_tf_qc_workitem  where mk_tf_qc_workitem.qc_no='".$qc_no."' and  mk_tf_qc_workitem.systemmodelid='".$system_id."' and  mk_tf_qc_workitem.class_no='".$class_no."'";
	// echo $ListSql;
	 $query = $db->query($ListSql);
	 $workitem_list = array();    
	 while($workitem= $db->fetch_array($query))
	   {
		   $wk++;
		  $ListSql2 = "select * from mk_tf_qc_product where qc_no='".$qc_no."' and  systemid='".$system_id."' and  class_no='".$class_no."' and  workitemname='".$workitem['workitemname']."' ";
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