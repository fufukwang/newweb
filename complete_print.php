<?
//載入共用的CSS 與 JQ
include("template_meta.php");
?>
<body>
<?
//判斷是否有抓到 id 如果有,把抓到的id 帶入變數中
  if ($_GET['cid']!= ''){
  $cid=$_GET['cid'];
  $pn=$_GET['pn'];
  $info=$_GET['info'];
  }
?>
<?
$sql = 'select * from complete_detail_data';
$sql .='  WHERE group_id='.$cid;
$sql .='  ORDER BY create_time DESC';
$mysql->table = 'complete_data';
$row1 = mysql_fetch_assoc($mysql->select("WHERE complete_id=".$cid));
$rs = mysql_query($sql)or die(mysql_error()); //sql查詢
?>
<table style="margin-left:auto;margin-right:auto;">
<tr ><td><img src="img/sys_img/test.png" style="display:block; margin:auto;" /></td></tr>
<tr ><td>&nbsp;</td></tr>
<tr ><td style="font-family:'Times New Roman', Times, serif; font-size:18px;"><b>PLAYCARD AG</b></td></tr>
<tr ><td>ACTASYS, INC.</td></tr>
<tr ><td>NO.140, LANE 531, CHONG KANG Rd.</td></tr>
<tr ><td>HSIN CHUANG CITY, TAIPEI, TAIWAN</td></tr>
<tr ><td>Tel : 886 2 2993 3383        Fax:886 2 2992 0836</td></tr>
<tr ><td>&nbsp;</td></tr>
<tr ><td style="font-family:'Times New Roman', Times, serif; text-align:center; font-size:24px;"><b><u>PRO FORMA INVOICE</u></b></td></tr>
<tr ><td>&nbsp;</td></tr>
</table>			 	    
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td><br />
          <div class="maincontent">
        	<div class="contentinner">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>成品建立編號</th>
                            <th>建立時間</th>
                            <th>預計完成時間</th>
                            <th>備註</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><? echo $pn?></td>
                            <td><?=date("Y-m-d H:i:s",$row1['ATime'])?></td>
                            <td><?=$row1['create_time'];?></td>
                            <td><?=$info;?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="divider30"></div>
				<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>商品型號</th>
                            <th>數量</th>
                            <th>&nbsp;</th>
                        </tr>
                        <? while($row = mysql_fetch_assoc($rs)){?>
                        <tr>
                            <?
							$sql = 'select * from product_data';
							$sql .=' Where product_id ='.$row['product_id'];
							$sql .='  ORDER BY inx DESC';
							$rs2 = mysql_query($sql)or die(mysql_error()); //sql查詢
							?>
                            <? while($row2 = mysql_fetch_assoc($rs2)){?>
                            <th><?=$row2['number']; ?>(<?=$row2['name']; ?>)</th>
                            <? }?> 
                            <th><?=$row['count']; ?></th>
                            <th></th>
                        </tr>
                        <? }?> 
                    </thead>
                    <tbody id="test"> 
                        
                    </tbody>
                </table> 
                <p>&nbsp;</p> 
                <?
				$url="complete_list.php";
				?>                                  
            </div><!--contentinner-->
        </div><!--contentinner--></td>
    </tr>
  </table>
<div class="clearfix"></div>
<script language=javascript>
  	print()
</script>      
</body>
</html>
