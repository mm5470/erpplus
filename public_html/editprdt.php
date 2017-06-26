<?
require_once("data/conn.php");
require_once("public.php");
require_once("data/template.ease.php");
session_start();
if(!isset($_SESSION["username"])||$_SESSION["username"]=="")
{
	header("Location:index.php");
}
$db=new Dirver();
$db->DBLink($db_server,$db_username,$db_password,$db_name);
$tl = new template();
$act=$_POST["act"];
$id=$_GET["id"];
$bid=$_GET['bid'];
$pageid=$_GET["page"];
$searchclass=$_GET["searchclass"];

          $sqls="select * from mk_product where id='".$id."'";
           $rs=$db->rows($sqls);		
         
			
		     if(!isset($bid)&&$bid=="")
			  { 
			$sqlc="select * from mk_category where id='".$rs['cid']."'";
			$rsc=$db->rows($sqlc);
			if($rsc['level']==0){
				$bid=$rsc['id'];
				}else
				{
					$bid=$rsc['parsent'];
					$mid=$rsc['id'];
			   }
			  }
		          //大類對應
             $sqlbig="SELECT  * from  mk_category where parsent=0  order by squee desc";
			 $querybig=$db->query($sqlbig);
			 $bigclass_list = array();		 
			 while($bigclass=$db->fetch_array($querybig))
			 {		
			       if($bigclass['id']==$rs['cid']){ $bselect="selected='selected'";}else{$bselect="";}
				   $sqlmid="SELECT * FROM  mk_category  where  parsent='".$bigclass['id']."' order by squee desc";			  
				   $querymid=$db->query($sqlmid);
				   $midclass_list = array();		 
					while($midclass=$db->fetch_array($querymid))
					 {			
					    $sqls="SELECT * FROM  mk_category  where parsent='".$midclass['id']."' order by squee desc";	
						$querysmall=$db->query($sqls);
				        $smallclass_list = array();
						while($smallclass=$db->fetch_array($querysmall))
					    {	
						        if($smallclass['id']==$rs['cid']){ $sselect="selected='selected'";}else{$sselect="";}
						        $smallclass['sselect']=$sselect;
						   		$smallclass_list[]=$smallclass;
					     }	
						if($midclass['id']==$rs['cid']){ $mselect="selected='selected'";}else{$mselect="";}
						$midclass['mselect']=$mselect;
						$midclass['sub']=$smallclass_list;
						$midclass_list[]= $midclass;						
					 }
				 $bigclass['bselect']=$bselect;
				 $bigclass['sub']=$midclass_list;
			     $bigclass_list[]= $bigclass;
			 }		
		
    if($act=="edit"){  	
	  
	 $strproductname=htmlspecialchars($_POST['productname']);
	
//UPDATE
$UpdateSQL = sprintf("UPDATE  mk_product SET `productno`= %s, `cid`= %s, `productname`= %s, `spec`= %s, `color`= %s, `model`= %s, `size`= %s, `weight`= %s, `squee`= %s, `memo`= %s where   `id`= %s and  `productno`= %s ",
	 GetSQLValueString($_POST['productno'] ,"text"),
	 GetSQLValueString($_POST['cid'] ,"int"),
	 GetSQLValueString($strproductname ,"text"),
	 GetSQLValueString($_POST['spec'] ,"text"),
	 GetSQLValueString($_POST['color'] ,"text"),
	 GetSQLValueString($_POST['model'] ,"text"),
	 GetSQLValueString($_POST['size'] ,"text"),
	 GetSQLValueString($_POST['weight'] ,"text"),
	 GetSQLValueString($_POST['squee'] ,"int"),
	 GetSQLValueString($_POST['memo'] ,"text"),
	 GetSQLValueString($_POST['id'],"int") , 
	 GetSQLValueString($_POST['productno'],"text"));
     $db->query($UpdateSQL);
      header("Location:prdtlist.php?searchclass=$searchclass&page=$pageid");
	}
	

$tl->set_file('editprdt');
$tl->n();
$tl->p();
$db->close();
?>