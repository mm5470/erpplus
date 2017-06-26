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
//echo $act;
if($act=="add")
{
	
	$category=$_POST["category"];//頭部菜單清單
	$snum2=count($category)-1;
	while( $sid2=$category[$snum2--])
	{
		$categorylist.="'".$sid2."',";
	}
	$categorylist=utf8Substr($categorylist,0,strlen($categorylist)-1);
	
//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_unit (`name`,`address`,`tel1`,`tel2`,`fax`,`serialnumber`,`capital`,`responsibleperson`,`valid`,`adddate`,`requestday`,`loanday`,`category`) VALUES (%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['name'],"text"),
	 GetSQLValueString($_POST['address'],"text"),
	 GetSQLValueString($_POST['tel1'],"text"),
	 GetSQLValueString($_POST['tel2'],"text"),
	 GetSQLValueString($_POST['fax'],"text"),
	 GetSQLValueString($_POST['serialnumber'],"text"),
	 GetSQLValueString($_POST['capital'],"text"),
	 GetSQLValueString($_POST['responsibleperson'],"text"),
	 GetSQLValueString($_POST['valid'],"text"),
	 GetSQLValueString($_POST['adddate'],"date"),	
	 GetSQLValueString($_POST['requestday'],"text"),
	 GetSQLValueString($_POST['loanday'],"text"),
	 GetSQLValueString($categorylist,"text"));
	// echo  $InsertSQL;
     $db->query($InsertSQL);
    header("Location:unitlist.php");
   
}
  $sql="select * from mk_unitclass order by  squee desc,id desc";
   $query = $db->query($sql);
   $unitclass_list = array();    
	while($unitclass= $db->fetch_array($query))
	{	
        $kk++;
		$unitclass['k']=$kk;
		$unitclass_list[] = $unitclass;
	}
$tl->set_file('addunit');
$tl->n();
$tl->p();
$db->close();
?>