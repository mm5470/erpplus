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
$id=$_GET["id"];

if($act=="edit")
{
//UPDATE
$UpdateSQL = sprintf("UPDATE  mk_category SET `name`= %s,`linkname`= %s,   `parsent`= %s, `squee`= %s,`pic`= %s,`keywords`= %s, `description`= %s, `classdesc`= %s where   `id`= %s ",
	 GetSQLValueString($_POST['name'] ,"text"),
	 GetSQLValueString($_POST['linkname'] ,"text"),
	 GetSQLValueString($_POST['parsent'] ,"int"),
	 GetSQLValueString($_POST['squee'] ,"int"),	
	 GetSQLValueString($_POST['pic'] ,"text"),
	 GetSQLValueString($_POST['keywords'] ,"text"),
	 GetSQLValueString($_POST['description'] ,"text"),
	 GetSQLValueString($_POST['classdesc'] ,"text"),
	 GetSQLValueString($_POST['id'],"int"));
$db->query($UpdateSQL);
 
        header("Location:midclass.php");
}
$sqls="select * from mk_category  where level=1 and id='".$id."'";
//echo $sqls;
$rs=$db->rows($sqls);
	 
	 $ListSql = sprintf("select * from mk_category where level=0   order by  `id`= %s  desc",
	 GetSQLValueString($rs['parsent'],"int"));
	// echo $ListSql;
	 $query = $db->query($ListSql);
	 $bigclass_list = array();    
	 while($bigclass= $db->fetch_array($query))
	   {
		   $bigclass_list[]=$bigclass;
		}

$tl->set_file('editmidclass');
$tl->n();
$tl->p();
$db->close();
?>