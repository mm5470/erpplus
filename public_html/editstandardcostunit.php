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

$alertstr="";
  
if($act=="edit")
{
	//UPDATE
$UpdateSQL = sprintf("UPDATE  mk_standardcostunit SET `workitemno`= %s, `productno`= %s, `driverestimated`= %s, `costdriverid`= %s, `drivermax`= %s, `drivermin`= %s, `driverfixed`= %s, `classvariable`= %s, `workitemusage`= %s, `usageunit`= %s, `memo`= %s where   `id`= %s ",
	 GetSQLValueString($_POST['workitemno'] ,"text"),
	 GetSQLValueString($_POST['productno'] ,"text"),
	 GetSQLValueString($_POST['driverestimated'] ,"text"),
	 GetSQLValueString($_POST['costdriverid'] ,"int"),
	 GetSQLValueString($_POST['drivermax'] ,"int"),
	 GetSQLValueString($_POST['drivermin'] ,"int"),
	 GetSQLValueString($_POST['driverfixed'] ,"int"),
	 GetSQLValueString($_POST['classvariable'] ,"text"),
	 GetSQLValueString($_POST['workitemusage'] ,"text"),
	 GetSQLValueString($_POST['usageunit'] ,"text"),
	 GetSQLValueString($_POST['memo'] ,"text"),
	 GetSQLValueString($_POST['id'],"int"));
    $db->query($UpdateSQL);
 
			  header("Location:standardcostunit.php");
		
}
   $sql="select * from mk_standardcostunit where id='".$id."'";
   $rs=$db->rows($sql);
   
    $ListSql = "select * from mk_product where productno='".$rs['productno']."'";
	$rsp=$db->rows($ListSql);
	$ListSql = "select * from mk_workitem where itemno='".$rs['workitemno']."'";
	// echo $ListSql;
	$rsw=$db->rows($ListSql);
		$ListSql = "select * from mk_costdriven order by  id desc";
	// echo $ListSql;
	 $query3 = $db->query($ListSql);
	 $costdriven_list = array();    
	 while($costdriven= $db->fetch_array($query3))
	   {
		    if($rs['costdriverid']==$costdriven['id'])
					{
						$chk="selected";
					}else{
						$chk="";
						}
		   //echo $chk;
		   $costdriven['chk']=$chk;
		   $costdriven_list[]=$costdriven;
		}
$tl->set_file('editstandardcostunit');
$tl->n();
$tl->p();
$db->close();
?>