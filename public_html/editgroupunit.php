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
$page=$_GET['page'];
$alertstr="";
if($act=="edit")
{
	
    if($alertstr==""){
		
		//UPDATE
		$UpdateSQL = sprintf("UPDATE  mk_groupunit SET `groupunitid`= %s, `productno`= %s, `unit`= %s, `reducedqty`= %s, `iscommon`= %s where   `id`= %s ",
			 GetSQLValueString($_POST['groupunitid'] ,"text"),
			 GetSQLValueString($_POST['productno'] ,"text"),
			 GetSQLValueString($_POST['unit'] ,"text"),
			 GetSQLValueString($_POST['reducedqty'] ,"int"),
			 GetSQLValueString($_POST['iscommon'] ,"text"),
			 GetSQLValueString($_POST['id'],"int"));
		$db->query($UpdateSQL);
         header("Location:groupunit.php?page=$page");
     }
}
$sqls="select * from mk_groupunit where id='".$id."'";
//echo $sqls;
$rs=$db->rows($sqls);
$sqlp="select * from mk_product where productno='".$rs['productno']."'";
//echo $sqls;
$rsprdt=$db->rows($sqlp);
$tl->set_file('editgroupunit');
$tl->n();
$tl->p();
$db->close();
?>