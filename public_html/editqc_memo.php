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
    $UpdateSQL = sprintf("UPDATE  mk_qc_memo SET `qc_no`= %s, `memo`= %s,`valid`= %s,   `lastrevision`= %s, `lastmodifiedtime`= %s where   `id`= %s ",
	 GetSQLValueString($_POST['qc_no'],"text"),
	 GetSQLValueString($_POST['memo'] ,"text"),	
	 GetSQLValueString($_POST['valid'] ,"text"),
	 GetSQLValueString($_SESSION['username'] ,"text"),
	 GetSQLValueString($_POST['lastmodifiedtime'] ,"date"),	
	 GetSQLValueString($_POST['id'],"int"));
   $db->query($UpdateSQL);
     header("Location:qc_memo.php");
   
}

        $sql="select * from  mk_qc_memo  where  id='".$id."'";
		$rs=$db->rows($sql);
		
		$sqlp="select projectnum  from mk_mf_qc  where qc_no='".$rs['qc_no']."'";
		$rsproject=$db->rows($sqlp);
	
		
			
$tl->set_file('editqc_memo');
$tl->n();
$tl->p();
$db->close();
?>