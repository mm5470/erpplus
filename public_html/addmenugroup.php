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
$groupname=$_POST["groupname"];
$menulink=$_POST["menulink"];
$classnamecss=$_POST["classnamecss"];
$alertstr="";

//echo $alertstr;

if($act=="add")
{
	if($groupname==""){
	  $alertstr.="*群組名稱不能为空!<br/>";
	}
	if($menulink==""){
		$alertstr.="*群組链接不能为空!";
	}	
    if($alertstr==""){
		//INSEART
		$InsertSQL = sprintf("INSERT INTO  mk_menugroup (`groupname`,`menulink`,`squee`,`classnamecss`) VALUES (%s ,%s ,%s ,%s )",
			 GetSQLValueString($_POST['groupname'],"text"),
			 GetSQLValueString($_POST['menulink'],"text"),
			 GetSQLValueString($_POST['squee'],"int"),
			 GetSQLValueString($_POST['classnamecss'],"text"));
		$db->query($InsertSQL);
			 header("Location:menugroup.php"); 
		}
	
}
$tl->set_file('addmenugroup');
$tl->n();
$tl->p();
$db->close();
?>