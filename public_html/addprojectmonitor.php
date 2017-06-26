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
  
	$ListSql = "select * from mk_project order by  id desc";
	// echo $ListSql;
	 $query3 = $db->query($ListSql);
	 $project_list = array();    
	 while($project= $db->fetch_array($query3))
	   {
		   $project_list[]=$project;
		}
	 $ListSql = "select * from mk_contact order by  contactnum desc";
	// echo $ListSql;
	 $query1 = $db->query($ListSql);
	 $contact_list = array();    
	 while($contact= $db->fetch_array($query1))
	   {
		   $contact_list[]=$contact;
		}
	       
		  $sqls="select  (max(right(monitornum,3))+1) as maxnum from mk_projectmonitor";	
			 $maxrow=$db->rows($sqls);
			 $maxnum=$maxrow['monitornum']; 
			 $num=$db->nums($sqls);
			 //echo  $num;
			 if($num>=1 && $maxnum<>null){				 
				     switch(strlen(floor($maxnum))){
					 case 1: 
					  $maxnum="00".$maxnum;
					  break; 
					  case 2:
					  $maxnum="0".$maxnum;
					  break;					 					  
					 default:	 
					 $maxnum= $maxnum;
					 break;				  
					 }
			}else
			 {
				 $maxnum="001";
		    }
			$maxmonitornum=date("Y").$maxnum;   
if($act=="add")
{
	         $sqls="select  * from  mk_projectmonitor where monitornum='".$_POST['monitornum']."'";	
	         $num1=$db->nums($sqls);
			 
			 if($num1>=1)
			    {
					 $sqls="select  (max(right(monitornum,3))+1) as maxnum from mk_projectmonitor";	
					 $maxrow=$db->rows($sqls);
					 $maxnum=$maxrow['maxnum']; 
					 $num=$db->nums($sqls);
					// echo  $maxnum;
					 if($num>=1){				 
						 switch(strlen(floor($maxnum))){
							 case 1: 
							  $maxnum="00".$maxnum;
							  break; 
							  case 2:
							  $maxnum="0".$maxnum;
							  break;					 					  
							 default:	 
							 $maxnum= $maxnum;
							 break;				  
							 }
						 }else{$maxnum="001";}
					 
						  $maxmonitornum=date("Y").$maxnum;
						 }
				 else
				 {
					 $maxmonitornum=$_POST['monitornum'];
					 }	

//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_projectmonitor (`monitornum`,`projectnum`,`memo`,`startdate`,`enddate`,`valid`,`adddate`,`lastrevision`,`lastmodifiedtime`,`corr_document_num`,`corr_rule`) VALUES (%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($maxmonitornum,"text"),
	 GetSQLValueString($_POST['projectnum'],"text"),
	 GetSQLValueString($_POST['memo'],"text"),
	 GetSQLValueString($_POST['startdate'],"date"),
	 GetSQLValueString($_POST['enddate'],"date"),
	 GetSQLValueString($_POST['valid'],"text"),
	 GetSQLValueString($_POST['adddate'],"date"),
	 GetSQLValueString($_POST['lastrevision'],"text"),
	 GetSQLValueString($_POST['lastmodifiedtime'],"date"),
	 GetSQLValueString($_POST['corr_document_num'],"text"),
	 GetSQLValueString($_POST['corr_rule'],"text"));
  $db->query($InsertSQL);
			 header("Location:projectmonitor.php");
		
}
$tl->set_file('addprojectmonitor');
$tl->n();
$tl->p();
$db->close();
?>