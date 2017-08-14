<?
//載入共用的CSS 與 JQ
include("template_meta.php");
?>
<body>
<div class="mainwrapper">
<?
//載入共用的TOP
include("template_left.php");
?>  
    <!-- START OF RIGHT PANEL -->
    <div class="rightpanel">
        <div class="headerpanel">
            <a href="" class="showmenu"></a>
            
<?
//載入共用的TOP
include("template_top.php");
?> 
        </div><!--headerpanel-->
        <div class="breadcrumbwidget">
            <ul class="skins">
                <li><a href="default" class="skin-color default"></a></li>
                <li><a href="orange" class="skin-color orange"></a></li>
                <li><a href="dark" class="skin-color dark"></a></li>
                <li>&nbsp;</li>
                <li class="fixed"><a href="" class="skin-layout fixed"></a></li>
                <li class="wide"><a href="" class="skin-layout wide"></a></li>
            </ul><!--skins-->
<?
//載入共用的麵包屑
include("template_bread.php");
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
    $rs = $mysql->select("LEFT JOIN product_data USING(product_id) WHERE group_id='$shipments_id'","count,info,name,price,(SELECT COUNT(Quantity) FROM(PackDetail) WHERE PackDetail.product_id=shipments_detail_data.product_id AND ship_id='$shipments_id') AS pack,product_data.product_id");
    $jslist = $mysql->fetch($mysql->select("LEFT JOIN product_data USING(product_id) WHERE group_id='$shipments_id'","count,info,name,price,(SELECT COUNT(Quantity) FROM(PackDetail) WHERE PackDetail.product_id=shipments_detail_data.product_id AND ship_id='$shipments_id') AS pack,product_data.product_id"));
} else {
    alert('連結錯誤!');
}
?> 
        </div><!--breadcrumbs-->
        <div class="pagetitle">
            <h1>Change Packing</h1> <span></span>
        </div><!--pagetitle-->
        <form action="business_save.php" method="post"  name="formx" id="formx" >
        <input type="hidden" id="tag" name="tag" value="packing_update" />
        <input type="hidden" id="PID" name="PID" value="<?=$PID?>" />
        <div class="maincontent">
            <div class="contentinner">
                <h4 class="widgettitle">Change Packing</h4>
                <div class="widgetcontent">                         
                                <!--table style="margin-left:auto;margin-right:auto;">
<tr ><td><img src="img/sys_img/logo2.png" style="display:block; margin:auto;" /></td></tr>
<tr ><td>3rd FL, No. 140, Lane 531, Chong Kang Rd.</td></tr>
<tr ><td>Hsin-Chuang City, Taipei, Taiwan, R.O.C.</td></tr>
<tr ><td>TEL: 886-2-2993-3383  FAX: 886-2-2992-0836 </td></tr>
<tr ><td>&nbsp;</td></tr>
<tr ><td style="font-family:'Times New Roman', Times, serif; text-align:center; font-size:24px;"><b><u>PACKING LIST</u></b></td></tr>
<tr ><td>&nbsp;</td></tr>
<tr ><td>&nbsp;</td></tr>
</table-->        
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
  <tr>
    <td colspan="2">

    <table class="table table-bordered">
      <tr>
        <th>Item</th>
        <th>Quantity</th>
        <th>Description</th>
      </tr>
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
      </tr>
      <? }}?> 
    </table>
    </td>
  </tr>
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

                <p></p>
                <p></p>
                <h3 class="widgettitle">Packing List <a href="javascript:;" onclick="addnewbox();" class="btn btn-rounded" style="float:right"><i class="iconsweets-dropbox"></i> Add Box</a></h3>
                <div id="BoxList">
<?php 
  $mysql->table = 'PackBox';
  $box = $mysql->select("WHERE PID='$PID'");
  $i=1;
  while($r1 = mysql_fetch_assoc($box)){
    $phpboxnum = count($r1)-1;
    $j=1;
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
        <tbody id="rbox_<?=$i?>">
            <?php
            $mysql->table = 'PackDetail';
            $detail = $mysql->select("LEFT JOIN product_data USING(product_id) WHERE PBID='{$r1['PBID']}'",'name,info,Quantity,NW,GW,product_data.product_id,PDID');
            $tmp = 0;
            while($r2 = mysql_fetch_assoc($detail)){
              if($tmp==0){
                echo '<td id="rno_'.$i.'" rowspan="'.count($r2).'"><input type="text" style="width:30px" name="PNO[]" value="'.$r1['PNO'].'" required /></td>';
                echo '<input type="hidden" name="PBID[]" value="'.$r1['PBID'].'" />';
              } 
              ?>
          <tr>
            <td><select name="product_id_<?=$i?>[]" id="select_<?=$i?>_1" onchange="showinfo(<?=$i?>,1);" data-box="<?=$i?>" class="uniformselect" style="opacity: 0;" required>
                    <option value="" data-info="">Please select Item</option><?php
                    foreach($jslist as $jr){
                        $sel = '';
                        if($jr['product_id'] == $r2['product_id']) $sel = ' selected';
                        echo '<option value="'.$jr['product_id'].'" data-info="'.$jr['info'].'"'.$sel.'>'.$jr['name'].'</option>';
                    }
                    ?>
                </select><input type="hidden" name="PDID_<?=$i?>[]" value="<?=$r2['PDID']?>" /></td>
            <td id="des_<?=$i?>_1"><?=$r2['info']?></td>
            <td><input type="text" style="width:30px" name="Quantity_<?=$i?>[]" id="q_<?=$i?>_1" value="<?=$r2['Quantity']?>" data-proid="<?=$r2['product_id']?>" number required min="0" max="" /></td>
            <td><input type="text" style="width:30px" name="NW_<?=$i?>[]" value="<?=$r2['NW']?>" number required /></td>
            <td><input type="text" style="width:30px" name="GW_<?=$i?>[]" value="<?=$r2['GW']?>" number required /></td>
          </tr>
              <?php $tmp++;
              $j++;
            }
            ?>
        </tbody>
    </table><div><a href="javascript:;" onclick="addnewrow('<?=$i?>');" class="btn btn-rounded" style="float:right;margin:7px"><i class="icon-plus"></i> Add Item</a></div>
    <br />
    <?php
    $i++;
  }
?>
                </div>
                
                </div><!--widgetcontent-->
                <p></p>                                          
                <p class="stdformbutton">
                    <button type="submit" class="btn btn-primary" id="subbutton">Submit</button>
                </p>                
            </div><!--contentinner-->
        </div><!--maincontent--></form>      
    </div><!--mainright-->
    <!-- END OF RIGHT PANEL -->
    <div class="clearfix"></div>
    
<?
include("template_down.php");
?>   
<script language="javascript">
var nowboxnum = <?=$phpboxnum?>;
var itemlist = jQuery.parseJSON('<?=json_encode($jslist)?>');
var packingnum = '';
jQuery(function(){
    jQuery("#formx").validate({
      submitHandler: function(form) {
        // 所有product 跑一次 看有沒有超過數量
        var IsOver = false;
        for(i=0;i<itemlist.length;i++){
            var co = 0;
            jQuery("input").each(function(){
                if(jQuery(this).data("proid")==itemlist[i].product_id){
                    co += parseInt(jQuery(this).val());
                }
            });
            var needpack = parseInt(itemlist[i].count);
            if(needpack!=co){
                IsOver = true;
            }
        }

        if(IsOver){
            alert('Quantity is over (包裝數量不等於出貨數量)');
        } else {
            form.submit();
        }
      }
     });
    
});
function addnewbox(){
    if(itemlist.length<1){
        alert('Please select Invoice No.');
        return false;
    }
    nowboxnum++;
    var selectlist = getselectitemlist();
    console.log(selectlist);
    var tablist = '<table class="table table-bordered"><thead><tr><th>CTN. NO.</th><th>Item</th><th>Description</th><th>Quantity</th><th>N.W.</th><th>G.W.</th></tr></thead>' +
                    '<tbody id="rbox_'+nowboxnum+'"><tr><td id="rno_'+nowboxnum+'" rowspan="1"><input type="text" style="width:30px" name="PNO[]" value="'+nowboxnum+'A" required /></td>' +
                            '<td><select name="product_id_'+nowboxnum+'[]" id="select_'+nowboxnum+'_1" onchange="showinfo('+nowboxnum+',1);" data-box="'+nowboxnum+'" class="uniformselect" style="opacity: 0;" required>' +
                            '<option value="" data-info="">Please select Item</option>'+selectlist+'</select></td>' +
                            '<td id="des_'+nowboxnum+'_1">&nbsp;</td><td><input type="text" style="width:30px" name="Quantity_'+nowboxnum+'[]" id="q_'+nowboxnum+'_1" number required min="0" max="" /></td>' +
                            '<td><input type="text" style="width:30px" name="NW_'+nowboxnum+'[]" value="" number required /></td>' +
                            '<td><input type="text" style="width:30px" name="GW_'+nowboxnum+'[]" value="" number required /></td>' +
                        '</tr></tbody></table><div><a href="javascript:;" onclick="addnewrow('+nowboxnum+');" class="btn btn-rounded" style="float:right;margin:7px"><i class="icon-plus"></i> Add Item</a></div>';
    jQuery("#BoxList").append(tablist);
    jQuery("#select_"+nowboxnum+'_1').uniform();
}
function addnewrow(boxnum){
    var rownum = parseInt(jQuery("#rno_"+boxnum).attr("rowspan"))+1; //取得目前列數
    var selectlist = getselectitemlist();
    var rowlist = '<tr><td><select name="product_id_'+boxnum+'[]" id="select_'+boxnum+'_'+rownum+'" class="uniformselect" onchange="showinfo('+boxnum+','+rownum+');" style="opacity: 0;" required>' +
                            '<option value="" data-info="">Please select Item</option>'+selectlist+'</select></td>' +
                            '<td id="des_'+boxnum+'_'+rownum+'">&nbsp;</td><td><input type="text" style="width:30px" name="Quantity_'+boxnum+'[]" id="q_'+boxnum+'_'+rownum+'" number required min="0" max="" /></td>' +
                            '<td><input type="text" style="width:30px" name="NW_'+boxnum+'[]" value="" number required /></td>' +
                            '<td><input type="text" style="width:30px" name="GW_'+boxnum+'[]" value="" number required /></td></tr>';
    jQuery("#rno_"+boxnum).attr("rowspan",rownum);
    jQuery("#rbox_"+boxnum).append(rowlist);
    jQuery("#select_"+boxnum+'_'+rownum).uniform();
}
function getselectitemlist(){
    var list = '';
    for(i=0;i<itemlist.length;i++){
        list += '<option value="'+itemlist[i].product_id+'" data-info="'+itemlist[i].info+'">'+itemlist[i].name+'</option>'
    }
    return list;
}
function showinfo(boxnum,rownum){
    var product_id = jQuery("#select_"+boxnum+'_'+rownum+' :selected').val();
    jQuery("#q_"+boxnum+'_'+rownum).data("proid",product_id);
    jQuery("#q_"+boxnum+'_'+rownum).attr("max",jQuery("#pq_"+product_id).text());
    jQuery("#des_"+boxnum+'_'+rownum).text(jQuery("#select_"+boxnum+'_'+rownum+' :selected').data('info'));
}
</script>
    
</div><!--mainwrapper-->
</body>
</html>
