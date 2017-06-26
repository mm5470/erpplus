<?
require_once("data/conn.php");
require_once("public.php");
require_once("data/template.ease.php");
session_start();
$db=new Dirver();
$db->DBLink($db_server,$db_username,$db_password,$db_name);
$tl = new template();
$foldername="../category/";
if(!isset($_SESSION["username"])||$_SESSION["username"]=="")
{
	header("Location:index.php");
}
$act=$_POST["act"];
//list post
	$ListSql = sprintf("select * from mk_category where level=0  order by  `id`= %s  desc",
	 GetSQLValueString($_GET['bid'],"int"));
	// echo $ListSql;
	 $query = $db->query($ListSql);
	 $bigclass_list = array();    
	 while($bigclass= $db->fetch_array($query))
	   {
		   $bigclass_list[]=$bigclass;
		}
if($act=="add")
{
//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_category (`name`,`parsent`,`squee`,`level`,`description`) VALUES (%s ,%s,%s ,%s  ,%s  )",
	 GetSQLValueString($_POST['name'],"text"),
	 GetSQLValueString($_POST['parsent'],"int"),
	 GetSQLValueString($_POST['squee'],"int"),	
	 GetSQLValueString(1,"int"),	
	 GetSQLValueString($_POST['description'],"text"));
$db->query($InsertSQL);
	 //echo $InsertSQL;
      header("Location:midclass.php");
}
$tl->set_file('addmidclass');
$tl->n();
$tl->p();
$db->close();
?>