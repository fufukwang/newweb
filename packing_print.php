<?
//載入共用的CSS 與 JQ
include("template_meta.php");
?>
<body>
<?
$PID = _get('PID');
if($PID){
    $mysql->table = 'Packing';
    $row = mysql_fetch_assoc($mysql->select("WHERE PID='$PID'"));
    $shipments_id = $row['shipments_id'];
    $mysql->table = 'shipments_data';
    $row1 = mysql_fetch_assoc($mysql->select("LEFT JOIN BShipLink USING(shipments_id) LEFT JOIN mail_data USING(mail_id) WHERE shipments_id='$shipments_id'"));
    $info1 = unserialize($row1['info']);
    $mysql->table = 'Business_data';
    $row2 = mysql_fetch_assoc($mysql->select("LEFT JOIN member_data USING(member_id) WHERE BID='{$row1['BID']}'"));
    $info2 = unserialize($row2['Info']);
    $mysql->table = 'shipments_detail_data';
    $rs = $mysql->select("LEFT JOIN product_data USING(product_id) WHERE group_id='$shipments_id'");
} else {
    alert('連結錯誤!');
}

?> 	 	    
<table style="margin-left:auto;margin-right:auto;">
<tr ><td><img src="img/sys_img/logo2.png" style="display:block; margin:auto;" /></td></tr>
<tr ><td>3rd FL, No. 140, Lane 531, Chong Kang Rd.</td></tr>
<tr ><td>Hsin-Chuang City, Taipei, Taiwan, R.O.C.</td></tr>
<tr ><td>TEL: 886-2-2993-3383  FAX: 886-2-2992-0836 </td></tr>
<tr ><td>&nbsp;</td></tr>
<tr ><td style="font-family:'Times New Roman', Times, serif; text-align:center; font-size:24px;"><b><u>PACKING LIST</u></b></td></tr>
<tr ><td>&nbsp;</td></tr>
<tr ><td>&nbsp;</td></tr>
</table>        
<table width="100%" class="table table-bordered">
  <tr>
    <td rowspan="4">Shipping Address:</br>
    <?=$info1['OutAddr']?></td>
    <td>Order Date:<?=date('Y/m/d H:i:s',$row2['ATime'])?></td>
  </tr>
  <tr>
    <td>Packing NO.:<?=$row1['number']?></td>
  </tr>
  <tr>
    <td>Invoice No.:<?=$row2['SN']?></td>
  </tr>
  <tr>
    <td>Contact:<?=$row2['user_name']?></td>
  </tr>
  <tr>
    <td>Customer:<?=$info2['IName']?></td>
    <td>Shipping Date:<?=$row1['create_time']?></td>
  </tr>
  <tr>
    <td rowspan="2">Customer Addr:<?=$info2['IAddr']?></td>
    <td>Carrier:<?=$row1['name']?></td>
  </tr>
  <tr>
    <td>Per:<?=$info2['Per']?></td>
  </tr>
  <!--tr>
    <td colspan="2">

    <table class="table table-bordered">
      <tr>
        <th>Item</th>
        <th>Quantity</th>
        <th>Description</th>
        <!--<th>單價</th>
        <th>小記</th>-->
      <!--/tr>
      <? $tot = 0;
      while($row = mysql_fetch_assoc($rs)){
        if($row['count']>0){
          $scount = $row['count'] * $row['price'];
          $tot += $scount;
          ?>
      <tr>
        <th><?=$row['name']?></th>
        <th><?=$row['count']?></th>
        <th><?=$row['info']?></th>
        <? if (1==2){?>
        <th><?=$row['price']?></th>
        <th><?=$scount?></th>
        <? }?>
      </tr>
      <? }}?> 
    </table>
    </td>
  </tr-->
  <tr>
    <td rowspan="3">Remark:<?=$info1['info']?></td>
    <td></td>
  </tr>
  <? if(1==2){?>
  <tr>
    <td rowspan="3">Remark:<?=$info1['info']?></td>
    <td>Net Value:<?=$tot?></td>
  </tr>
  <tr>
    <td>Delivery charge:<?=$row1['Invoice']?></td></td>
  </tr>
  <tr>
    <td>Invoice Total USD:<?=$tot+$row1['Invoice']?></td>
  </tr>
  <? }?>
</table>
<br />
<?php 
  $mysql->table = 'PackBox';
  $box = $mysql->select("WHERE PID='$PID'");
  while($r1 = mysql_fetch_assoc($box)){
    ?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>CTN. NO.</th>
          <th>Item</th>
          <th>Description</th>
          <th>Quantity</th>
          <th>N.W.</th>
          <th>G.W.</th>
        </tr>
      </thead>
        <tbody>
            <?php
            $mysql->table = 'PackDetail';
            $detail = $mysql->select("LEFT JOIN product_data USING(product_id) WHERE PBID='{$r1['PBID']}'",'name,info,Quantity,NW,GW');
            $tmp = 0;
            while($r2 = mysql_fetch_assoc($detail)){
              if($tmp==0) echo '<td rowspan="'.count($r2).'">'.$r1['PNO'].'</td>';
              ?>
          <tr>
            <td><?=$r2['name']?></td>
            <td><?=$r2['info']?></td>
            <td><?=$r2['Quantity']?></td>
            <td><?=$r2['NW']?></td>
            <td><?=$r2['GW']?></td>
          </tr>
              <?php $tmp++;
            }
            ?>
        </tbody>
    </table>
    <br />
    <?php
  }
?>


<div class="clearfix"></div>
<script type='text/javascript'>
  	print();
</script>      
</body>
</html>
