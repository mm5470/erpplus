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
$id=$_GET["id"];

//echo $act;
if($act=="edit")
{
	
	
//UPDATE
$UpdateSQL = sprintf("UPDATE  mk_workitem SET `systemid`= %s, `itemno`= %s, `name`= %s, `driverestimated`= %s, `costdriverid`= %s, `drivermax`= %s, `drivermin`= %s, `driverfixed`= %s, `qty`= %s, `unit`= %s, `memo`= %s, `valid`= %s where   `id`= %s ",
	 GetSQLValueString($_POST['systemid'] ,"int"),
	 GetSQLValueString($_POST['itemno'] ,"text"),
	 GetSQLValueString($_POST['name'] ,"text"),
	 GetSQLValueString($_POST['driverestimated'] ,"text"),
	 GetSQLValueString($_POST['costdriverid'] ,"int"),
	 GetSQLValueString($_POST['drivermax'] ,"int"),
	 GetSQLValueString($_POST['drivermin'] ,"int"),
	 GetSQLValueString($_POST['driverfixed'] ,"int"),
	 GetSQLValueString($_POST['qty'] ,"text"),
	 GetSQLValueString($_POST['unit'] ,"text"),
	 GetSQLValueString($_POST['memo'] ,"text"),
	 GetSQLValueString($_POST['valid'] ,"text"),
	 GetSQLValueString($_POST['id'],"int"));
$db->query($UpdateSQL);
    header("Location:workitem.php");
   
}

		$sql="select * from mk_workitem where id='".$id."'";
		$rs=$db->rows($sql);
		
		 $ListSql = "select * from mk_systemmodule where id='".$rs['systemid']."'";
	    $rss=$db->rows($ListSql);
		   
		$ListSql = "select * from mk_costdriven order by  id desc";
	// echo $ListSql;
	 $query3 = $db->query($ListSql);
	 $costdriven_list = array();    
	 while($costdriven= $db->fetch_array($query3))
	   {
		   if($rs['costdriverid']==$costdriven['id'])
					{
						$chk2="selected";
					}else{
						$chk2="";
						}
		   //echo $chk;
		   $costdriven['chk']=$chk2;
		   $costdriven_list[]=$costdriven;
		}  
$tl->set_file('editworkitem');
$tl->n();
$tl->p();
$db->close();
?>