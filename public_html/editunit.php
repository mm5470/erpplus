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
	$category=$_POST["category"];//頭部菜單清單
	$snum2=count($category)-1;
	while( $sid2=$category[$snum2--])
	{
		$categorylist.="'".$sid2."',";
	}
	$categorylist=utf8Substr($categorylist,0,strlen($categorylist)-1);
	//UPDATE
$UpdateSQL = sprintf("UPDATE  mk_unit SET `name`= %s, `address`= %s, `tel1`= %s, `tel2`= %s, `fax`= %s, `serialnumber`= %s, `capital`= %s, `responsibleperson`= %s, `valid`= %s,  `lastrevision`= %s, `lastmodifiedtime`= %s, `requestday`= %s, `loanday`= %s, `category`= %s where   `id`= %s ",
	 GetSQLValueString($_POST['name'] ,"text"),
	 GetSQLValueString($_POST['address'] ,"text"),
	 GetSQLValueString($_POST['tel1'] ,"text"),
	 GetSQLValueString($_POST['tel2'] ,"text"),
	 GetSQLValueString($_POST['fax'] ,"text"),
	 GetSQLValueString($_POST['serialnumber'] ,"text"),
	 GetSQLValueString($_POST['capital'] ,"text"),
	 GetSQLValueString($_POST['responsibleperson'] ,"text"),
	 GetSQLValueString($_POST['valid'] ,"text"),
	 GetSQLValueString($_SESSION['username'],"text"),
	 GetSQLValueString($_POST['lastmodifiedtime'] ,"date"),
	 GetSQLValueString($_POST['requestday'] ,"text"),
	 GetSQLValueString($_POST['loanday'] ,"text"),
	 GetSQLValueString($categorylist ,"text"),
	 GetSQLValueString($id,"int"));
     $db->query($UpdateSQL);
 
			header("Location:unitlist.php?page=$page");
	
}
$sqls="select * from mk_unit  where  id='".$id."'";
//echo $sqls;
$rs=$db->rows($sqls);

     $sql="select * from mk_unitclass order by  squee desc,id desc";
   $query = $db->query($sql);
   $unitclass_list = array();    
	while($unitclass= $db->fetch_array($query))
	{	
          $kk++;
		  if(strstr($rs['category'],"'".$unitclass['id']."'"))
					{
						$chk="checked";
					}else{
						$chk="";
						}
		$unitclass['k']=$kk;
		$unitclass['chk']=$chk;
		$unitclass_list[] = $unitclass;
	}
	 
	 
$tl->set_file('editunit');
$tl->n();
$tl->p();
$db->close();
?>