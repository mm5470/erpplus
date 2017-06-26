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
//echo $act;
if($act=="add")
{
	         $sqls="select  * from  mk_project where projectnum='".$_POST['projectnum']."'";	
	         $num1=$db->nums($sqls);
			 if($num1>=1){
			 $sqls="select  (max(right(projectnum,3))+1) as maxnum from mk_project";	
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
			 
			      $maxprojectnum=date("Y").$maxnum;
				 }
				 else{
					 $maxprojectnum=$_POST['projectnum'];
					 }
//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_project (`projectnum`,`name`,`address`,`adddate`,`valid`) VALUES (%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['projectnum'],"text"),
	 GetSQLValueString($_POST['name'],"text"),
	 GetSQLValueString($_POST['address'],"text"),
	 GetSQLValueString($_POST['adddate'],"date"),	
	 GetSQLValueString($_POST['valid'],"text"));
   $db->query($InsertSQL);
    header("Location:projectlist.php");
   
}
          
     		 $sqls="select  (max(right(projectnum,3))+1) as maxnum from mk_project";	
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
			}else
			 {
				 $maxnum="001";
		    }
			$maxprojectnum=date("Y").$maxnum;
		
$tl->set_file('addproject');
$tl->n();
$tl->p();
$db->close();
?>