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
$isclass=$_POST["isclass"];
$issystem=$_POST["issystem"];
$systemqty=$_POST["systemqty"];
$systemunit=$_POST["systemunit"];
$systemprice=$_POST["systemprice"];
$isworkitem=$_POST["isworkitem"];
$workitemqty=$_POST["workitemqty"];
$workitemunit=$_POST["workitemunit"];
$workitemprice=$_POST["workitemprice"];
$isproduct=$_POST["isproduct"];
$productqty=$_POST["productqty"];
$productunit=$_POST["productunit"];
$productprice=$_POST["productprice"];
$alertstr="";
$qc_no=$_POST['qc_no'];
if($qc_no==""){$qc_no=$_GET['qc_no'];}

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
	$classsql="select * from mk_tf_qc_class where qc_no='".$qc_no."'";
	$queryc = $db->query($classsql);
	$class_list = array(); 
	while($classl= $db->fetch_array($queryc))
	   {
		    $ck++;
			$systemsql="select * from mk_tf_qc_system where qc_no='".$classl['qc_no']."' and class_no='".$classl['class_no']."'";
		    $querys = $db->query($systemsql);
			$system_list = array(); 
			$sk=0;
			while($system= $db->fetch_array($querys))
			   {
				    $sk++;
					$ListSql = "select * from mk_tf_qc_workitem  where qc_no='".$system['qc_no']."' and class_no='".$system['class_no']."'  and systemmodelid='".$system['systemmodelid']."'";
					// echo $ListSql;
					 $query = $db->query($ListSql);
					 $workitem_list = array();
					 $wk=0;
					 while($workitem= $db->fetch_array($query))
					   {
						   $wk++;
						   $ListSql2 = "select * from mk_tf_qc_product where qc_no='".$workitem['qc_no']."' and class_no='".$workitem['class_no']."'  and systemid='".$workitem['systemmodelid']."' and  workitemname='".$workitem['workitemname']."' ";
						   //echo $ListSql2;
						   $query2=$db->query($ListSql2);
						   $product_list = array();		
                           $pk=0;						   
						   while($product=$db->fetch_array($query2))
							{	
								 $pk++;		
								 $product["k"]=$pk;								
								 $product_list[]= $product;						
							}
						   $workitem['k']=$wk;
						   $workitem['sub']=$product_list; 	   
						   $workitem_list[]=$workitem;
						}
					$system['k']=number2chinese($sk,true);
					$subtotal=$system["total"];
					$system['sub']=$workitem_list; 	   
					$system_list[]=$system;
			   }
        $classl['k']=number2chinese($ck,true,false);
		$classl['sub']=$system_list; 	   
		$class_list[]=$classl;				
       }
	   
$tl->set_file('preview_qc');
$tl->n();
$tl->p();
$db->close();
?>