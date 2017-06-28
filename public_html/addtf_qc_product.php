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
     $ListSql = "select mk_mf_qc.*,mk_systemmodule.name as system_name,mk_tf_qc_class.class_name,mk_project.name as projectname 
	 from mk_tf_qc_class    left join mk_mf_qc on mk_mf_qc.qc_no=mk_tf_qc_class.qc_no 
	 left join mk_tf_qc_system on mk_tf_qc_class.class_no=mk_tf_qc_system.class_no
	 left join mk_systemmodule on mk_systemmodule.id=mk_tf_qc_system.systemmodelid
	 left join mk_project on mk_project.projectnum=mk_mf_qc.projectnum
     where mk_tf_qc_class.qc_no='".$qc_no."' and mk_tf_qc_class.class_no='".$class_no."' and  mk_tf_qc_system.systemmodelid='".$system_id."'";
	$rs=$db->rows($ListSql);
	
	$ListSql = "select * from mk_tf_qc_workitem  where mk_tf_qc_workitem.qc_no='".$qc_no."' and mk_tf_qc_workitem.class_no='".$class_no."' and  mk_tf_qc_workitem.systemmodelid='".$system_id."'";
	 //echo $ListSql;
	 $query = $db->query($ListSql);
	 $workitem_list = array();    
	 while($workitem= $db->fetch_array($query))
	   {
		   $wk++;
		  $ListSql2 = "select mk_product.productno,mk_product.productname,mk_tf_qc_workitem.workitem_id,mk_tf_qc_workitem.qty,mk_tf_qc_workitem.unit,mk_tf_qc_workitem.price,mk_tf_qc_workitem.total
from mk_product
left join  mk_standardcostunit on  mk_product.productno=mk_standardcostunit.productno
left join mk_workitem on mk_workitem.itemno=mk_standardcostunit.workitemno
left join mk_tf_qc_workitem on mk_tf_qc_workitem.workitem_id=mk_workitem.id
where mk_tf_qc_workitem.qc_no='".$qc_no."' and  mk_tf_qc_workitem.systemmodelid='".$system_id."' and mk_tf_qc_workitem.class_no='".$class_no."' and  mk_tf_qc_workitem.workitemname='".$workitem['workitemname']."'";
	       //echo $ListSql2;
		   $query2=$db->query($ListSql2);
		   $product_list = array();		   
		   while($product=$db->fetch_array($query2))
			{	
                 $pk++;		
				 $product["k"]=$pk;
				 $product_list[]= $product;						
			}
		   $workitem['k']=$wk;
		   $workitem['sub']=$product_list;
         //print_r($workitem['sub']);		   
		   $workitem_list[]=$workitem;
		}	
if($act=="add")
{
	  
      $workitemname=$_POST["workitemname"];
	  $productno=$_POST["productno"];
	  $productname=$_POST["productname"];
	  $qty=$_POST["qty"];
	  $unit=$_POST["unit"];
	  $price=$_POST["price"];
	  $total=$_POST["total"];
	  $valid=$_POST["valid"];
	  if($productname==null)
	  {
		  header("Location:preview_qc.php?qc_no=$qc_no&class_no=$class_no&system_id=$system_id");
	  }
	  else{
	 foreach($productname as  $k=>$v)
		 {	    
					//INSEART
					$InsertSQL = sprintf("INSERT INTO  mk_tf_qc_product (`qc_no`,`class_no`,`systemid`,`workitemname`,`productno`,`productname`,`qty`,`unit`,`price`,`total`) VALUES (%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s  )",
				 GetSQLValueString($qc_no,"text"),
					 GetSQLValueString($class_no,"text"),
					 GetSQLValueString($system_id,"int"),
					 GetSQLValueString($workitemname[$k],"text"),
					  GetSQLValueString($productno[$k],"text"),
					 GetSQLValueString($productname[$k],"text"),
					 GetSQLValueString($qty[$k],"int"),
					 GetSQLValueString($unit[$k],"text"),
					 GetSQLValueString($price[$k],"nodefile"),
					 GetSQLValueString($total[$k],"nodefile")
					 );
					$db->query($InsertSQL);
				 
		 }
	 }
	header("Location:preview_qc.php?qc_no=$qc_no");
		
}
$tl->set_file('addtf_qc_product');
$tl->n();
$tl->p();
$db->close();
?>