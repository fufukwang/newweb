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
$mysql->table = 'Business_data'; //指定table
//mysql_num_rows($mysql->select('','product_id'))  此段是抓table值 的數量
//$_SERVER['PHP_SELF'].'?' 抓目前檔案的名稱
$MyPage = GPage($PItem,$Page,mysql_num_rows($mysql->select('WHERE checked=1','BID')),$_SERVER['PHP_SELF'].'?',''); //抓頁數的Function 如果需要傳另外的值,可用最後一個欄位
$rs = $mysql->select("WHERE checked=1 ORDER BY ATime DESC LIMIT ".$MyPage['Str'].','.$PItem,'*,(SELECT user_name FROM(member_data) WHERE member_data.member_id=Business_data.member_id) AS Name');
?>
  <!-- START OF RIGHT PANEL -->
  <div class="rightpanel">
    <div class="headerpanel"> <a href="" class="showmenu"></a>
      <?
//載入共用的TOP
include("template_top.php");
?>
    </div>
    <!--headerpanel-->
    <div class="breadcrumbwidget">
      <ul class="skins">
        <li><a href="default" class="skin-color default"></a></li>
        <li><a href="orange" class="skin-color orange"></a></li>
        <li><a href="dark" class="skin-color dark"></a></li>
        <li>&nbsp;</li>
        <li class="fixed"><a href="" class="skin-layout fixed"></a></li>
        <li class="wide"><a href="" class="skin-layout wide"></a></li>
      </ul>
      <!--skins-->
      <?
//載入共用的麵包屑
include("template_bread.php");
?>
    </div>
    <!--breadcrumbs-->
    <div class="pagetitle">
      <h1>Order List</h1>
    </div>
    <!--pagetitle-->
    
    <div class="maincontent">
      <div class="contentinner">
        <h3 class="widgettitle"><span class="icon-shopping-cart"></span> Order List <a href="business_add.php" title="Create New Order" class="btn btn-primary" style="float:right" >&nbsp;Create New Order</a> </h3>
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
              <th class="centeralign"><div class="checker" id="uniform-undefined"><span>
                  <input type="checkbox" class="checkall" style="opacity: 0;">
                  </span></div></th>
              <th>Invoice No.</th>
              <th>Contact</th>
              <th>Customer</th>
              <th>The progress</th>
              <th>Date</th>
              <th>Packing NO.</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <? while($row = mysql_fetch_assoc($rs)){
                        $info = unserialize($row['Info']);
                        ?>
            <tr id="tr_<?=$row['BID']?>" <? if ($row['cancel']==1){?> style=" background-color:#FB7C66;"<? }?>>
              <td class="centeralign" ><div class="checker" id="uniform-undefined"><span>
                  <input type="checkbox" style="opacity: 0;">
                  </span></div></td>
              <td><?=$row['SN']; ?></td>
              <td><?=$row['Name']; ?></td>
              <td><?=$info['IName']; ?></td>
              <td><?php if($row['Checked']){ echo $row['End'] ? '<span style="color:#6C0">Shipment is completed</span>' : 'No shipments'; } else { echo '<span style="color:#F00">待審核</span>'; }?></td>
              <td><?=date("Y/m/d H:i:s",$row['ATime'])?></td>
              <td><?php 
                                $mysql->table = 'BShipLink';
                                $out = $mysql->select("LEFT JOIN shipments_data USING(shipments_id) WHERE BID='".$row['BID']."'",'BShipLink.shipments_id,number');
                                while($r = mysql_fetch_assoc($out)){
                                    echo '<div><a href="javascript:;" onclick="opendialog2('.$r['shipments_id'].');">'.$r['number'].'</a></div>';
                                }
                                ?></td>
              <td class="centeralign"><?php if($row['Checked']){?>
                <a href="javascript:;" onClick="opendialog1('<?=$row['BID']?>');" title="Details" class="btn" ><span class="icon-pencil"></span>&nbsp;Details</a> <a href="business_print.php?BID=<?=$row['BID']?>&house=1" title="Print" target="_blank" class="btn" ><span class="icon-print"></span>&nbsp;Print </a>
                <?php } else {?>
                <a href="business_add.php?BID=<?=$row['BID'];?>" class="btn" ><span class="icon-edit"></span>Edit</a>
                <? if ($_SESSION['super_power'] == 1){ ?> 
                <a href="javascript:;" onClick="open_dialog_check('<?=$row['BID']?>');" class="btn" ><span class="icon-edit"></span>Audited</a>
                <? }?> 
                <a href="javascript:;" onClick="open_dialog_del('<?=$row['BID']?>');" class="btn"><span class="icon-trash"></span>Delete</a>
                <?php }?></td>
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
      </div>
      <!--contentinner--> 
      
    </div>
    <!--maincontent--> 
    
  </div>
  <!--mainright--> 
  <!-- END OF RIGHT PANEL -->
  <div id="dialog1" title="Demand Details">
    <table class="table table-bordered">
      <tr>
        <th colspan="4">Demand content</th>
      </tr>
      <tr>
        <th>Date</th>
        <th colspan="3" id="d1_Atime"></th>
      </tr>
      <tr>
        <th>Customer</th>
        <th id="d1_name"></th>
        <th>Invoice No.</th>
        <th id="d1_SN"></th>
      </tr>
      <tr>
        <th>Customer Address</th>
        <th colspan="3" id="d1_Site"></th>
      </tr>
      <tr>
        <th>Shipping Address</th>
        <th colspan="3" id="d1_Addr"></th>
      </tr>
      <tr>
        <th>Per</th>
        <th colspan="3" id="d1_Per"></th>
      </tr>
      <tr>
        <th>Remark</th>
        <th colspan="3" id="d1_Notes"></th>
      </tr>
    </table>
    <div class="divider30"></div>
    <table class="table table-bordered">
      <tr>
        <th colspan="4">Product List</th>
      </tr>
      <tr>
        <th>Item</th>
        <th>Quantity</th>
        <!--<th>Unit Price USD</th>
        <th>Value USD</th>-->
      </tr>
      <tbody id="d1_pro">
      </tbody>
<!--      <tr>
        <td colspan="2" rowspan="3"></td>
        <td colspan="2">Net Value:<span id="d1p_1"></span></td>
      </tr>
      <tr>
        <td colspan="2">Delivery charge:<span id="d1p_2"></span></td>
      </tr>
      <tr>
        <td colspan="2">Invoice Total USD:<span id="d1p_3"></span></td>
      </tr>-->
    </table>
  </div>
  <div id="dialog2" title="Shipping Details">
    <table width="100%" class="table table-bordered">
      <tr>
        <td rowspan="4"><img src="img/sys_img/test.png" /></td>
        <td>Order Date:<span id="d2_1"></span></td>
      </tr>
      <tr>
        <td>Packing NO.:<span id="d2_8"></span></td>
      </tr>
      <tr>
        <td>Invoice No.:<span id="d2_2"></span></td>
      </tr>
      <tr>
        <td>Contact:<span id="d2_3"></span></td>
      </tr>
      <tr>
        <td>Shipping Address:<span id="d2_4"></span></td>
        <td>Shipping Date:<span id="d2_6"></span></td>
      </tr>
      <tr>
        <td>Customer:<span id="d2_5"></span></td>
        <td>Carrier:<span id="d2_7"></span></td>
      </tr>
      <tr>
        <td>Customer Addr:<span id="d2_Addr"></span></td>
        <td>Per:<span id="d2_Par"></span></td>
      </tr>
      <!--tr>
    <td>Per:<span id="d2_8"></span></td>
  </tr-->
      <tr>
        <td colspan="3"><table class="table table-bordered">
            <tr>
              <th>Item</th>
              <th>Quantity</th>
              <th>Description</th>
              <th>Unit Price USD</th>
              <th>Value USD</th>
            </tr>
            <tbody id="d2_pro_list">
            </tbody>
          </table></td>
      </tr>
      <? if ($_SESSION['super_power'] == 1 or $_SESSION['busin_power'] == 1){ ?>
      <tr>
        <td rowspan="3">Remark:<span id="d2_9"></span></td>
        <td>Net Value:<span id="NetValue"></span></td>
      </tr>
      <tr>
        <td>Delivery charge:<span id="Invoice"></span></td>
      </tr>
      <tr>
        <td>Invoice Total USD:<span id="Tot"></span></td>
      </tr>
      <? }else{?>
      <tr>
        <td rowspan="3">Remark:<span id="d2_9"></span></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
      </tr>
      <tr>
        <td></td>
      </tr>
      <? }?>
    </table>
  </div>
  <div id="dialog_check" title="Audited">
    <table class="table table-bordered">
      <tr>
        <th colspan="4">Demand content</th>
      </tr>
      <tr>
        <th>Date</th>
        <th colspan="3" id="d3_Atime"></th>
      </tr>
      <tr>
        <th>Customer</th>
        <th id="d3_name"></th>
        <th>Invoice No.</th>
        <th id="d3_SN"></th>
      </tr>
      <tr>
        <th>Customer Address</th>
        <th colspan="3" id="d3_cou"></th>
      </tr>
      <tr>
        <th>Shipping Address</th>
        <th colspan="3" id="d3_Site"></th>
      </tr>
      <tr>
        <th>Per</th>
        <th colspan="3" id="d3_Per"></th>
      </tr>
      <tr>
        <th>Remark</th>
        <th colspan="3" id="d3_Notes"></th>
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
        <th>Unit Price USD</th>
        <th>Value USD</th>
      </tr>
      <tbody id="d3_pro">
      </tbody>
      <tr>
        <td colspan="2" rowspan="3"></td>
        <td colspan="2">Net Value:<span id="d3p_1"></span></td>
      </tr>
      <tr>
        <td colspan="2">Delivery charge:<span id="d3p_2"></span></td>
      </tr>
      <tr>
        <td colspan="2">Invoice Total USD:<span id="d3p_3"></span></td>
      </tr>
    </table>
  </div>
  <div id="dialog_del" title="You sure you want to delete this data"> You sure you want to delete this data?! </div>
  <div class="clearfix"></div>
  <?
include("template_down.php");
?>
</div>
<!--mainwrapper--> 
<script type="text/javascript">
var checkid = 0;
var delid = 0;
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
    jQuery("#dialog_check").dialog({
        autoOpen:false,
        minWidth:760,
        show: {
          effect: "blind",
          duration: 1000
        },
        hide: {
          effect: "explode",
          duration: 1000
        },
        buttons: {
            "Audited passed": function() {
                jQuery.post('business_save.php',{'tag':'Bus_Checked','BID':checkid},function(){
                    window.location.reload();
                });
            },
            "Cancel": function() {
              jQuery( this ).dialog( "close" );
            }
        }
    });
    jQuery("#dialog_del").dialog({
        autoOpen:false,
        minWidth:600,
        show: {
          effect: "blind",
          duration: 1000
        },
        hide: {
          effect: "explode",
          duration: 1000
        },
        buttons: {
            "OK to delete ": function() {
                jQuery.post('business_save.php',{'tag':'Bus_Del','BID':delid},function(){
                    jQuery("#tr_"+delid).remove();
                    delid = 0;
                    jQuery("#dialog_del").dialog( "close" );
                });
            },
            "Undelete": function() {
              delid = 0;
              jQuery( this ).dialog( "close" );
            }
        }
    });
});
function opendialog1(BID){
    jQuery.post('business_save.php',{tag:'ajax_bus_info',BID:BID},function(data){
        jQuery('#d1_name').text(data.info.IName);
        jQuery('#d1_SN').text(data.SN);
        jQuery('#d1_Atime').text(data.ATime);
        jQuery('#d1_Addr').text(data.info.ISite);
        jQuery('#d1_Site').text(data.info.IAddr);
        jQuery('#d1_Notes').text(data.info.INotes);
        jQuery('#d1_Per').text(data.info.Per);
        var list = '';
        var tot = 0;
        for(i=0;i<data.list.length;i++){
            var scount = parseInt(data.list[i].count) * parseInt(data.list[i].price);
            list += '<tr><th>'+data.list[i].name+'</th><th>'+data.list[i].count+'</th></tr>';
        }
        jQuery("#d1p_1").text(tot);
        jQuery("#d1p_2").text(data.Freight);
        jQuery("#d1p_3").text(parseInt(data.Freight)+parseInt(tot));
        jQuery("#d1_pro").html(list);
        jQuery("#dialog1").dialog("open");
    },'json');
}
function opendialog2(ship_id){
    jQuery.post('business_save.php',{tag:'ajax_ship_info',ship_id:ship_id},function(data){
        jQuery("#d2_1").text(data.info.d2_1 ? data.info.d2_1 : '');
        jQuery("#d2_2").text(data.info.d2_2 ? data.info.d2_2 : '');
        jQuery("#d2_3").text(data.info.d2_3 ? data.info.d2_3 : '');
        jQuery("#d2_4").text(data.info.d2_4 ? data.info.d2_4 : '');
        jQuery("#d2_5").text(data.info.d2_5 ? data.info.d2_5 : '');
        jQuery("#d2_6").text(data.info.d2_6 ? data.info.d2_6 : '');
        jQuery("#d2_7").text(data.info.d2_7 ? data.info.d2_7 : '');
        jQuery("#d2_8").text(data.info.d2_8 ? data.info.d2_8 : '');
        jQuery("#d2_9").text(data.info.d2_9 ? data.info.d2_9 : '');
        jQuery("#d2_Addr").text(data.info.d2_Addr ? data.info.d2_Addr : '');
        jQuery("#d2_Par").text(data.info.d2_Par ? data.info.d2_Par : '');
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
function open_dialog_check(BID){
    checkid = BID;
    jQuery.post('business_save.php',{tag:'ajax_bus_info',BID:BID},function(data){
        jQuery('#d3_name').text(data.info.IName);
        jQuery('#d3_SN').text(data.SN);
        jQuery('#d3_Atime').text(data.ATime);
        jQuery('#d3_Site').text(data.info.ISite);
        jQuery('#d3_cou').text(data.info.IAddr);
        jQuery('#d3_Notes').text(data.info.INotes);
        jQuery('#d3_Per').text(data.info.Per);
        var list = '';
        var tot = 0;
        for(i=0;i<data.list.length;i++){
            var scount = parseInt(data.list[i].count) * parseInt(data.list[i].price);
            list += '<tr><th>'+data.list[i].name+'</th><th>'+data.list[i].count+'</th><th>'+data.list[i].price+'</th><th>'+scount+'</th></tr>'
            tot += scount;
        }
        jQuery("#d3p_1").text(tot);
        jQuery("#d3p_2").text(data.Freight);
        jQuery("#d3p_3").text(parseInt(data.Freight)+parseInt(tot));
        jQuery("#d3_pro").html(list);
        jQuery("#dialog_check").dialog("open");
    },'json');   
}
function open_dialog_del(BID){
    delid = BID;
    jQuery("#dialog_del").dialog("open");
}
</script>
</body>
</html>