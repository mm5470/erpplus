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
$groupname=$_POST["groupname"];
$menulink=$_POST["menulink"];
$page=$_GET['page'];
$classnamecss=$_POST["classnamecss"];
$alertstr="";
if($act=="edit")
{
	if($groupname==""){
	  $alertstr.="*群組名稱不能为空!<br/>";
	}
	if($menulink==""){
		$alertstr.="*群組链接不能为空!";
	}	
    if($alertstr==""){
    //UPDATE
        $UpdateSQL = sprintf("UPDATE  mk_menugroup SET `groupname`= %s, `menulink`= %s, `squee`= %s, `classnamecss`= %s where   `id`= %s ",
		 GetSQLValueString($_POST['groupname'] ,"text"),
		 GetSQLValueString($_POST['menulink'] ,"text"),
		 GetSQLValueString($_POST['squee'] ,"int"),
		 GetSQLValueString($_POST['classnamecss'] ,"text"),
		 GetSQLValueString($_POST['id'],"int"));
		 $db->query($UpdateSQL);
		 //echo $UpdateSQL;
         header("Location:menugroup.php?page=$page");
     }
}
$sqls="select * from mk_menugroup where id='".$id."'";
//echo $sqls;
$rs=$db->rows($sqls);

$tl->set_file('editmenugroup');
$tl->n();
$tl->p();
$db->close();
?>