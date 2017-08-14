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
<?
//$PItem筆數   $Page目前頁面  $AItem所有總數量
$Page = _get('Page'); //抓回傳的頁數
$Page = $Page ? $Page : 0; //Ture and False 的短判斷 判斷有沒有值 如果有值是Ture 則顯示$Page 沒有值就是False 則顯示0
$PItem = 5; //一頁顯示的筆數
$mysql->table = 'shipments_data'; //指定table
//mysql_num_rows($mysql->select('','product_id'))  此段是抓table值 的數量
//$_SERVER['PHP_SELF'].'?' 抓目前檔案的名稱
$MyPage = GPage($PItem,$Page,mysql_num_rows($mysql->select('','shipments_id')),$_SERVER['PHP_SELF'].'?',''); //抓頁數的Function 如果需要傳另外的值,可用最後一個欄位

$rs = $mysql->select("LEFT JOIN BShipLink USING(shipments_id) ORDER BY create_time DESC LIMIT {$MyPage['Str']},{$PItem}","BID,BShipLink.shipments_id,create_time,cancel,number,(SELECT user_name FROM(member_data) WHERE shipments_data.member_id=member_data.member_id) AS Name,(SELECT SN FROM(Business_data) WHERE Business_data.BID=BShipLink.BID) AS SN");

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
?> 
        </div><!--breadcrumbs-->
        <div class="pagetitle">
        	<h1>進出貨管理</h1> 
        </div><!--pagetitle-->
        
        <div class="maincontent">
        	<div class="contentinner">
            	<h3 class="widgettitle"><span class="iconsweets-track"></span> 出貨紀錄
                <a href="shipments_new.php" title="編輯" class="btn btn-primary" style="float:right" ><span class="icon-plus"></span>出貨</a>&nbsp;
                <a href="shipments_cancel.php" title="客戶退貨" class="btn btn-danger" style="float:right" ><span class="icon-minus-sign"></span>&nbsp;退貨</a>
                </h3>
                <table class="table table-bordered">
                    <colgroup>
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                        <col class="con1">
                    </colgroup>
                    <thead>
                        <tr>
                        	<th class="centeralign"><div class="checker" id="uniform-undefined"><span><input type="checkbox" class="checkall" style="opacity: 0;"></span></div></th>
                            <th>出貨編號</th>
                            <th>需求單號</th>
                            <th>出貨人員</th>
                            <th>出貨時間</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody> 
                    <? while($row = mysql_fetch_assoc($rs)){?>
                        <tr <? if ($row['cancel']){?> style=" background-color:#FB7C66;"<? }?>>
                        	<td class="centeralign" ><div class="checker" id="uniform-undefined"><span><input type="checkbox" style="opacity: 0;"></span></div></td>
 							<td><?=$row['number']; ?></td>
                            <td><a href="javascript:;"<?php if($row['SN']!=''){?> onclick="openbusdata('<?=$row['BID']?>');"><?=$row['SN']?><?php } else {?> onclick="openshipdata('<?=$row['shipments_id']?>');"><?=$row['number']?><?php }?></a></td>
                            <td><?=$row['Name']?></td>
                            <td><?=date('Y/m/d H:i:s',$row['create_time']) ?></td>
                            <td class="centeralign"> 
                                <a href="javascript:;" title="編輯" onclick="openshipdata('<?=$row['shipments_id']?>');" class="btn" ><span class="icon-pencil"></span>&nbsp;明細</a>
                                <a href="shipments_print.php?shipments_id=<?=$row['shipments_id'];?>" title="列印" target="_blank" class="btn" ><span class="icon-print"></span>&nbsp;列印</a>
                            </td>
                        </tr>
                    <? }?>    
                    </tbody>
                </table>
                <!--顯示分頁-->
                <div class="pagination">
                    <ul>
                    <?=$MyPage['PageL']?> 
                    </ul>
                </div>
                <!--顯示結束-->
            </div><!--contentinner-->
             	
        </div><!--maincontent-->
 		    	     
    </div><!--mainright-->
    <!-- END OF RIGHT PANEL -->
<div id="dialog1" title="需求單明細">
                <table class="table table-bordered">
                    <tr>
                        <th colspan="4">需求內容</th>
                    </tr>
                    <tr>
                        <th>客戶名稱</th>
                        <th id="d1_name"></th>
                        <th>需求單編號</th>
                        <th id="d1_SN"></th>
                    </tr>
                    <tr>
                        <th>客戶地址</th>
                        <th colspan="3" id="d1_Site"></th>
                    </tr>
                    <tr>
                        <th>備註</th>
                        <th colspan="3" id="d1_Notes"></th>
                    </tr>
                </table>
                <div class="divider30"></div>
                <table class="table table-bordered">
                        <tr>
                            <th colspan="2">需求商品列表</th>
                        </tr>
                        <tr>
                            <th>商品型號</th>
                            <th>數量</th>
                            <th>小記</th>
                        </tr>
                        <tbody id="d1_pro"></tbody>
                        <tr>
                            <td colspan="2" rowspan="3"></td>
                            <td colspan="2">總價:<span id="d1p_1"></span></td>
                        </tr>
                        <tr>
                            <td colspan="2">運費:<span id="d1p_2"></span></td>
                        </tr>
                        <tr>
                            <td colspan="2">含運總價:<span id="d1p_3"></span></td>
                        </tr>
                </table> 
               
    </div>
    <div id="dialog2" title="出貨單明細">
<table width="100%" class="table table-bordered">
  <tr>
    <td colspan="2" rowspan="3"><img src="img/sys_img/test.png" /></td>
    <td>發單日:<span id="d2_1"></span></td>
  </tr>
  <tr>
    <td>單號:<span id="d2_2"></span></td>
  </tr>
  <tr>
    <td>業務:<span id="d2_3"></span></td>
  </tr>
  <tr>
    <td rowspan="3">出貨地址:<span id="d2_4"></span></td>
    <td rowspan="3">客戶名稱:<span id="d2_5"></span></td>
    <td>日期:<span id="d2_6"></span></td>
  </tr>
  <tr>
    <td>貨運:<span id="d2_7"></span></td>
  </tr>
  <tr>
    <td>Per:<span id="d2_8"></span></td>
  </tr>
  <tr>
    <td colspan="3">

    <table class="table table-bordered">
      <tr>
        <th>商品型號</th>
        <th>數量</th>
        <th>說明</th>
        <th>單價</th>
        <th>小記</th>
      </tr><tbody id="d2_pro_list"></tbody>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="2" rowspan="3">備註:<span id="d2_9"></span></td>
    <td>Net Value (總價):<span id="NetValue"></span></td>
  </tr>
  <tr>
    <td>運費:<span id="Invoice"></span></td>
  </tr>
  <tr>
    <td>Invoice Total USD (含運總價):<span id="Tot"></span></td>
  </tr>
</table>
    </div>
    <div class="clearfix"></div>
    
<?
include("template_down.php");
?>   
<script type="text/javascript">
jQuery(function(){
    jQuery("#dialog1,#dialog2").dialog({
        autoOpen:false,
        minWidth:760,
        resizable:true,
        show: {
          effect: "blind",
          duration: 1000
        },
        hide: {
          effect: "explode",
          duration: 1000
        }
    });
});
function openbusdata(BID){
    jQuery.post('business_save.php',{tag:'ajax_bus_info',BID:BID},function(data){
        jQuery('#d1_name').text(data.info.IName);
        jQuery('#d1_SN').text(data.SN);
        jQuery('#d1_Site').text(data.info.ISite);
        jQuery('#d1_Notes').text(data.info.INotes);
        var list = '';
        var tot = 0;
        for(i=0;i<data.list.length;i++){
            var scount = parseInt(data.list[i].count) * parseInt(data.list[i].price);
            list += '<tr><th>'+data.list[i].name+'</th><th>'+data.list[i].count+'</th><th>'+data.list[i].price+'</th><th>'+scount+'</th></tr>'
            tot += scount;
        }
        jQuery("#d1p_1").text(tot);
        jQuery("#d1p_2").text(data.Freight);
        jQuery("#d1p_3").text(parseInt(data.Freight)+parseInt(tot));
        jQuery("#d1_pro").html(list);
        jQuery("#dialog1").dialog("open");
    },'json');
}
function openshipdata(ship_id){
    jQuery.post('business_save.php',{tag:'ajax_ship_info',ship_id:ship_id},function(data){
        jQuery("#d2_1").text(data.info.d2_1);
        jQuery("#d2_2").text(data.info.d2_2);
        jQuery("#d2_3").text(data.info.d2_3);
        jQuery("#d2_4").text(data.info.d2_4 ? data.info.d2_4 : '');
        jQuery("#d2_5").text(data.info.d2_5);
        jQuery("#d2_6").text(data.info.d2_6);
        jQuery("#d2_7").text(data.info.d2_7);
        jQuery("#d2_8").text(data.info.d2_8);
        jQuery("#d2_9").text(data.info.d2_9);
        var list = '';
        var Tot = 0;
        for(i=0;i<data.list.length;i++){
            var scount = parseInt(data.list[i].price)*parseInt(data.list[i].count);
            Tot += scount;
            list += '<tr><th>'+data.list[i].name+'</th><th>'+data.list[i].count+'</th><th>'+data.list[i].info+'</th><th>'+data.list[i].price+'</th><th>'+scount+'</th></tr>'
        }
        jQuery("#d2_pro_list").html(list);
        jQuery("#NetValue").text(Tot);
        jQuery("#Invoice").text(data.info.Invoice);
        jQuery("#Tot").text(Tot+parseInt(data.info.Invoice));
        jQuery("#dialog2").dialog("open");
    },'json');
}
</script>
    
</div><!--mainwrapper-->
</body>
</html>
