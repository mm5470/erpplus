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
     $ListSql = "select mk_mf_qc.*,mk_tf_qc_system.qty,mk_tf_qc_system.unit,mk_tf_qc_system.systemmodel as system_name,mk_tf_qc_class.class_name,mk_project.name as projectname 
	 from mk_tf_qc_class    
	 left join mk_mf_qc on mk_mf_qc.qc_no=mk_tf_qc_class.qc_no 
	 left join mk_tf_qc_system on mk_tf_qc_class.class_no=mk_tf_qc_system.class_no	
	 left join mk_project on mk_project.projectnum=mk_mf_qc.projectnum
     where mk_tf_qc_class.qc_no='".$qc_no."' and mk_tf_qc_class.class_no='".$class_no."'";
	$rs=$db->rows($ListSql);
	
	$ListSql = "select * from mk_workitem where systemid='".$system_id."' order by  id desc";
	//echo $ListSql;
	 $query2 = $db->query($ListSql);
	 $workitem_list = array();    
	 while($workitem= $db->fetch_array($query2))
	   {
		   $k++;
		   $workitem['k']=$k;
		   $workitem['qty']=$rs['qty'];
		   $workitem['total']=(int)($workitem['qty']*$workitem['price']);
		   $workitem_list[]=$workitem;
		}	
if($act=="add")
{
	  
      $workitem_id=$_POST["workitem_id"];
	  $workitemname=$_POST["workitemname"];
	  $qty=$_POST["qty"];
	  $unit=$_POST["unit"];
	  $price=$_POST["price"];
	  $total=$_POST["total"];
	  $valid=$_POST["valid"];
	 
	  foreach($workitemname as  $k=>$v)
	  {	    
			
			   $InsertSQL = sprintf("INSERT INTO  mk_tf_qc_workitem (`qc_no`,`class_no`,`systemmodelid`,`workitem_id`,`workitemname`,`qty`,`unit`,`price`,`total`,`valid`) VALUES (%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s )",
				 GetSQLValueString($qc_no,"text"),
				 GetSQLValueString($class_no,"text"),
				 GetSQLValueString($system_id,"int"),
				 GetSQLValueString($workitem_id[$k],"int"),
				 GetSQLValueString($workitemname[$k],"text"),
				 GetSQLValueString($qty[$k],"int"),
				 GetSQLValueString($unit[$k],"text"),
				 GetSQLValueString($price[$k],"nodefile"),
				 GetSQLValueString($total[$k],"nodefile"),
				 GetSQLValueString($valid,"text"));
				 //echo $InsertSQL;
			    $db->query($InsertSQL);
	 }
	header("Location:addtf_qc_product.php?qc_no=$qc_no&class_no=$class_no&system_id=$system_id");
		
}
$tl->set_file('addtf_qc_workitem');
$tl->n();
$tl->p();
$db->close();
?>