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

    $sql="select * from mk_mf_qc where id='".$id."'";
	$rs=$db->rows($sql);	
	switch($rs['taxclass'])
	{
		case 1:$tk1="selected";$tk2="";$tk3=""; break;
		case 2:$tk1="";$tk2="selected";$tk3="";break;
		case 3:$tk1="";$tk2="";$tk3="selected";break;
	}
	$ListSql = "select * from mk_project where  projectnum='".$rs['projectnum']."'";
	$rsproject=$db->rows($ListSql);
	$ListSql = "select * from mk_unit where id='".$rs['unitno']."'";
	// echo $ListSql;
	$rsunit=$db->rows($ListSql);
	$ListSql = "select * from mk_unit where id='".$rs['ourunitno']."'";
	// echo $ListSql;
	$rsourunit=$db->rows($ListSql);
	
	$ListSql = "select * from mk_contact where  contactnum='".$rs['contactno']."'";
	$rscontact=$db->rows($ListSql);
	$ListSql = "select * from mk_contact where  contactnum='".$rs['ourcontactno']."'";
	$rsourcontact=$db->rows($ListSql);
	
		$ListSql = "select * from mk_remittance order by  id desc";
	// echo $ListSql;
	 $query4 = $db->query($ListSql);
	 $remittance_list = array();    
	 while($remittance= $db->fetch_array($query4))
	   {
		     if($rs['remittanceno']==$remittance['id'])
					{
						$chk="selected";
					}else{
						$chk="";
						}
			$remittance['chk']=$chk;
		   $remittance_list[]=$remittance;
		}
if($act=="edit")
{

//UPDATE
$UpdateSQL = sprintf("UPDATE  mk_mf_qc SET `qc_no`= %s, `projectnum`= %s, `stage`= %s, `unitno`= %s, `contactno`= %s, `serialnumber`= %s, `address`= %s, `tel`= %s, `fax`= %s, `memo`= %s, `taxclass`= %s, `yourday`= %s, `loanday`= %s, `remittanceno`= %s, `ourunitno`= %s, `ourcontactno`= %s, `ourserialnumber`= %s, `ouraddress`= %s, `ourtel`= %s, `ourfax`= %s where   `id`= %s and  `qc_no`= %s ",
	 GetSQLValueString($_POST['qc_no'] ,"text"),
	 GetSQLValueString($_POST['projectnum'] ,"text"),
	 GetSQLValueString($_POST['stage'] ,"text"),
	 GetSQLValueString($_POST['unitno'] ,"int"),
	 GetSQLValueString($_POST['contactno'] ,"int"),
	 GetSQLValueString($_POST['serialnumber'] ,"text"),
	 GetSQLValueString($_POST['address'] ,"text"),
	 GetSQLValueString($_POST['tel'] ,"text"),
	 GetSQLValueString($_POST['fax'] ,"text"),
	 GetSQLValueString($_POST['memo'] ,"text"),
	 GetSQLValueString($_POST['taxclass'] ,"int"),
	 GetSQLValueString($_POST['yourday'] ,"text"),
	 GetSQLValueString($_POST['loanday'] ,"text"),
	 GetSQLValueString($_POST['remittanceno'] ,"int"),
	 GetSQLValueString($_POST['ourunitno'] ,"int"),
	 GetSQLValueString($_POST['ourcontactno'] ,"text"),
	 GetSQLValueString($_POST['ourserialnumber'] ,"text"),
	 GetSQLValueString($_POST['ouraddress'] ,"text"),
	 GetSQLValueString($_POST['ourtel'] ,"text"),
	 GetSQLValueString($_POST['ourfax'] ,"text"),
	 GetSQLValueString($_POST['id'],"int") , 
	 GetSQLValueString($_POST['qc_no'],"text"));
     $db->query($UpdateSQL);
	header("Location:mf_qclist.php");
		
}
$tl->set_file('editmf_qc');
$tl->n();
$tl->p();
$db->close();
?>