<?
//載入共用的CSS 與 JQ
include("template_meta.php");
?>
<body>
<?
$BID = _get('BID');
$house = _get('house');
if($BID){
    $mysql->table = 'Business_data';
    $row1 = mysql_fetch_assoc($mysql->select("WHERE BID='$BID'"));
    $info = unserialize($row1['Info']);
    $mysql->table = 'BDataDetail';
    $rs = $mysql->select("WHERE BID='$BID'");
} else {
    alert('連結錯誤!');
}

?>	
<table style="margin-left:auto;margin-right:auto;">
<tr ><td><img src="img/sys_img/test.png" style="display:block; margin:auto;" /></td></tr>
<tr ><td>&nbsp;</td></tr>
<tr ><td style="font-family:'Times New Roman', Times, serif; text-align:center; font-size:24px;"><b>CARDWORX AG</b></td></tr>
<tr ><td>3rd FL, No. 140, Lane 531, Chong Kang Rd.</td></tr>
<tr ><td>Hsin-Chuang City, Taipei, Taiwan, R.O.C.</td></tr>
<tr ><td>TEL: 886-2-2993-3383  FAX: 886-2-2992-0836 </td></tr>
<tr ><td>&nbsp;</td></tr>
<tr ><td style="font-family:'Times New Roman', Times, serif; text-align:center; font-size:24px;"><b><u>INVOICE</u></b></td></tr>
<tr ><td>&nbsp;</td></tr>
</table>	 	    
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td><br />
          <div class="maincontent">
        	<div class="contentinner">
                <table class="table table-bordered">
                    <tr>
                        <th colspan="4">Demand content</th>
                    </tr>
                    <tr>
                        <th>date</th>
                        <th colspan="3"><?=date('Y/m/d H:i:s',$row1['ATime'])?></th>
                    </tr>
                    <tr>
                        <th>Customer</th>
                        <th><?=$info['IName']?></th>
                        <th>Invoice No.</th>
                        <th><?=$row1['SN']?></th>

                    </tr>
                    <tr>
                        <th>Customer Address</th>
                        <th colspan="3"><?=$info['IAddr']?></th>
                    </tr>
                    <tr>
                        <th>Shipping Address</th>
                        <th colspan="3"><?=$info['ISite']?></th>
                    </tr>
                    <tr>
                        <th>Per</th>
                        <th colspan="3"><?=$info['Per']?></th>
                    </tr>
                    <tr>
                        <th>Remark</th>
                        <th colspan="3"><?=$info['INotes']?></th>
                    </tr>
                </table>
                <div class="divider30"></div>
				<table class="table table-bordered">
                        <tr>
                            <th colspan="2">Product List</th>
                        </tr>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <?php if(!$house){?>
                            <th>Unit Price USD</th>
                            <th>Value USD</th>
                            <?php }?>
                        </tr>
                        <? $tot = 0;
                        while($row = mysql_fetch_assoc($rs)){
                            $scount = $row['price'] * $row['count'];
                            $tot += $scount;
                            ?>
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
                            <?php if(!$house){?>
                            <th><?=$row['price']; ?></th>
                            <th><?=$scount ?></th>
                            <?php }?>
                        </tr>
                        <? }?> 
                        <tr>
                            <td colspan="2" rowspan="3"></td>
                            <?php if(!$house){?><td colspan="2">Net Value:<?=$tot?></td><?php }?>
                        </tr>
                        <?php if(!$house){?>
                        <tr>
                            <td colspan="2">Delivery charge:<?=$row1['Freight']?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Invoice Total USD:<?=$row1['Freight']+$tot?></td>
                        </tr>
                        <?php }?>
                </table> 
                <p>&nbsp;</p> 
                <?
				$url="complete_list.php";
				?> 
                <table style="margin-left:inherit;">
                <tr ><td>&nbsp;</td></tr>
                <tr ><td>&nbsp;</td></tr>
                <tr><td style="font-family:'Times New Roman', Times, serif; text-align:center; font-size:24px;"><b><p style="border-top-style:solid; border-top-width:medium;">&nbsp;&nbsp;CARDWORX AG&nbsp;&nbsp;</p></b></td></tr>
                <tr ><td>&nbsp;</td></tr>
                </table>                                   
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
