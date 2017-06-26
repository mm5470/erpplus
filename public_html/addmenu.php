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
$menuname=$_POST["menuname"];
$menulink=$_POST["menulink"];
$alertstr="";
  //list post
	 $ListSql = "select * from mk_menugroup order by  squee desc,id desc";
	// echo $ListSql;
	 $query1 = $db->query($ListSql);
	 $menugroup1_list = array();    
	 while($menugroup1= $db->fetch_array($query1))
	   {
		   $menugroup1_list[]=$menugroup1;
		}
if($act=="add")
{
	if($menuname==""){
	  $alertstr.="*菜單名稱不能为空!<br/>";
	}
	if($menulink==""){
		$alertstr.="*菜單链接不能为空!";
	}	
    if($alertstr==""){
		//INSEART
		$InsertSQL = sprintf("INSERT INTO  mk_menu (`menugroup`,`menuname`,`menulink`,`squee`) VALUES (%s ,%s ,%s ,%s )",
			 GetSQLValueString($_POST['menugroup'],"int"),
			 GetSQLValueString($_POST['menuname'],"text"),
			 GetSQLValueString($_POST['menulink'],"text"),
			 GetSQLValueString($_POST['squee'],"int"));
		$db->query($InsertSQL);
			  header("Location:menulist.php");
		}
}
$tl->set_file('addmenu');
$tl->n();
$tl->p();
$db->close();
?>