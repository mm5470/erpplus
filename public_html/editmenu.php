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
$menuname=$_POST["menuname"];
$menulink=$_POST["menulink"];
$page=$_GET['page'];
$alertstr="";
if($act=="edit")
{
	if($menuname==""){
	  $alertstr.="*群組名稱不能为空!<br/>";
	}
	if($menulink==""){
		$alertstr.="*群組链接不能为空!";
	}	
    if($alertstr==""){
		//UPDATE
	$UpdateSQL = sprintf("UPDATE  mk_menu SET `menugroup`= %s, `menuname`= %s, `menulink`= %s, `squee`= %s where   `id`= %s ",
		 GetSQLValueString($_POST['menugroup'] ,"int"),
		 GetSQLValueString($_POST['menuname'] ,"text"),
		 GetSQLValueString($_POST['menulink'] ,"text"),
		 GetSQLValueString($_POST['squee'] ,"int"),
		 GetSQLValueString($_POST['id'],"int"));
	$db->query($UpdateSQL); 
			header("Location:menulist.php?page=$page");
	}
}
$sqls="select * from mk_menu  where  id='".$id."'";
//echo $sqls;
$rs=$db->rows($sqls);
	 
	 $ListSql = sprintf("select * from mk_menugroup order by  `id`= %s  desc",
	 GetSQLValueString($rs['menugroup'],"int"));
	//echo $ListSql;
	 $query1 = $db->query($ListSql);
	 $menugroup1_list = array();    
	 while($menugroup1= $db->fetch_array($query1))
	   {
		   $menugroup1_list[]=$menugroup1;
		}
$tl->set_file('editmenu');
$tl->n();
$tl->p();
$db->close();
?>