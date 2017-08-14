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
$mysql->table = 'Inquiry'; //指定table
//mysql_num_rows($mysql->select('','product_id'))  此段是抓table值 的數量
//$_SERVER['PHP_SELF'].'?' 抓目前檔案的名稱
$MyPage = GPage($PItem,$Page,mysql_num_rows($mysql->select('','IID')),$_SERVER['PHP_SELF'].'?',''); //抓頁數的Function 如果需要傳另外的值,可用最後一個欄位

$rs = $mysql->select("LEFT JOIN mail_data USING(mail_id) ORDER BY ATime DESC LIMIT {$MyPage['Str']},{$PItem}","*");

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
        	<h1>詢價系統</h1> 
        </div><!--pagetitle-->
        
        <div class="maincontent">
        	<div class="contentinner">
            	<h3 class="widgettitle"><span class="iconsweets-dropbox"></span> 運費詢價列表
                <a href="javascript:;" title="編輯" onClick="opendetaildialog(0);" class="btn btn-primary" style="float:right" ><span class="icon-plus"></span>新增詢價內容</a>&nbsp;
                </h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                        	<th class="centeralign"><div class="checker" id="uniform-undefined"><span><input type="checkbox" class="checkall" style="opacity: 0;"></span></div></th>
                            <th>貨運公司</th>
                            <th>運送地點</th>
                            <th>新增時間</th>
                            <th>最後寄信時間</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody> 
                    <? while($row = mysql_fetch_assoc($rs)){?>
                        <tr>
                        	<td class="centeralign" ><div class="checker" id="uniform-undefined"><span><input type="checkbox" style="opacity: 0;"></span></div></td>
 							<td id="name_<?=$row['IID']?>"><?=$row['name']?></td>
                            <td id="ToW_<?=$row['IID']?>"><?=$row['ToW']?></td>
                            <td><?=date('Y/m/d H:i:s',$row['ATime']) ?></td>
                            <th id="mail_<?=$row['IID']?>"><?=$row['MailTime']>0 ? date('Y/m/d H:i:s',$row['MailTime']) : '<span style="color:red;">未寄送</span>' ?></th>
                            <td class="centeralign"> 
                            <? if ($_SESSION['super_power'] == 1 or $_SESSION['busin_power'] == 1){ ?>
                                <a href="javascript:;" onClick="opendetaildialog(<?=$row['IID']?>);" title="編輯" class="btn" ><span class="icon-pencil"></span>&nbsp;明細</a>
                            <? } ?>
                                <a href="javascript:;" title="編輯" onClick="sent_mail_to_take('<?=$row['IID']?>');" class="btn" ><span class="icon-envelope"></span>&nbsp;寄送信件</a>
                            <? if ($_SESSION['super_power'] == 1 or $_SESSION['house_power'] == 1){ ?>
                                <a href="javascript:;" onClick="openweightdialog(<?=$row['IID']?>);" class="btn" id="weight_<?=$row['IID']?>">重量:<?=$row['Weight'] ? $row['Weight'] : '尚未填寫'?></a>
                            <? } ?>
                            <? if ($_SESSION['super_power'] == 1 ){ ?>
                                <a href="javascript:;" onClick="openmondialog(<?=$row['IID']?>);" class="btn" id="mon_<?=$row['IID']?>">金額:<?=$row['Mon'] ? $row['Mon'] : '尚未填寫'?></a>
                                <a href="javascript:;" onClick="openkey(<?=$row['IID']?>);" class="btn">人員</a>
                            <? } ?>
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
  <div id="detaildialog" title="詢價表單">
    <table class="table table-bordered">
      <tr>
        <th>貨運公司</th>
        <th><select id="mail_id"><option value="">請選擇貨運公司</option>
<?php 
        $mysql->table = 'mail_data';
        $query = $mysql->select("WHERE tag=2");
        while($row = mysql_fetch_assoc($query)){
            echo '<option value="'.$row['mail_id'].'">'.$row['name'].'</option>';
        }
         ?>
        </select></th>
      </tr>
      <tr>
        <th>運送地點</th>
        <th><input type="text" id="ToW" style="width:98%;"></th>
      </tr>
      <tr>
        <th>詢價內容</th>
        <th><textarea name="Inq" id="Inq" style="width:98%;height:150px;"></textarea></th>
      </tr>
    </table>
  </div>
  <div id="weightdialog" title="詢價表單">
    <table class="table table-bordered">
      <tr>
        <th>貨運公司</th>
        <th id="mail_id2"></th>
      </tr>
      <tr>
        <th>運送地點</th>
        <th id="ToW2"></th>
      </tr>
      <tr>
        <th>詢價內容</th>
        <th><textarea id="Inq2" style="width:98%;height:150px;" readonly></textarea></th>
      </tr>
      <tr>
        <th>重量</th>
        <th><input type="text" id="Weight" style="width:98%;"></th>
      </tr>
    </table>
  </div>
  <div id="mondialog" title="詢價表單">
    <table class="table table-bordered">
      <tr>
        <th>貨運公司</th>
        <th id="mail_id3"></th>
      </tr>
      <tr>
        <th>運送地點</th>
        <th id="ToW3"></th>
      </tr>
      <tr>
        <th>詢價內容</th>
        <th><textarea id="Inq3" style="width:98%;height:150px;" readonly></textarea></th>
      </tr>
      <tr>
        <th>重量</th>
        <th id="Weight3"></th>
      </tr>
      <tr>
        <th>金額</th>
        <th><input type="text" id="Mon" style="width:98%;"></th>
      </tr>
    </table>
  </div>
  <div id="keydialog" title="Key 單人員">
    <table class="table table-bordered">
      <tr>
        <th>業務</th>
        <th id="MeM1"></th>
      </tr>
      <tr>
        <th>倉儲</th>
        <th id="MeM2"></th>
      </tr>
      <tr>
        <th>管理者</th>
        <th id="MeM3"></th>
      </tr>
    </table>
  </div>




  
    <div class="clearfix"></div>
    
<?
include("template_down.php");
?>   
<script>
var NowIID = 0;
jQuery(function(){
    jQuery( "#detaildialog" ).dialog({
      resizable:true,
      height:400,
      minWidth:600,
      autoOpen:false,
      buttons: {
        Save: function() {
            var Inq     = jQuery("#Inq").val();
            var mail_id = jQuery("#mail_id").val();
            var ToW     = jQuery("#ToW").val();
            jQuery.post('business_save.php',{tag:'Inquiry_Step_1',IID:NowIID,Inq:Inq,mail_id:mail_id,ToW:ToW},function(data){
                if(parseInt(NowIID)>0){
                    jQuery("#name_"+NowIID).text(data.name);
                    jQuery("#ToW_"+NowIID).text(data.ToW);
                    jQuery("#detaildialog").dialog("close");
                } else {
                    window.location.reload();
                }
            },'json');
        },
        Cancel: function() { jQuery( "#detaildialog" ).dialog( "close" ); }
      }
    });
    jQuery( "#weightdialog" ).dialog({
      resizable:true,
      height:500,
      minWidth:600,
      autoOpen:false,
      buttons: {
        Save: function() {
            var Weight = jQuery("#Weight").val();
            jQuery.post('business_save.php',{tag:'Inquiry_Step_2',IID:NowIID,Weight:Weight},function(data){
                jQuery("#weight_"+NowIID).text("重量:"+Weight);
                jQuery("#weightdialog").dialog("close");
            },'json');
        },
        Cancel: function() { jQuery( "#weightdialog" ).dialog( "close" ); }
      }
    });
    jQuery( "#mondialog" ).dialog({
      resizable:true,
      height:500,
      minWidth:600,
      autoOpen:false,
      buttons: {
        Save: function() {
            var Mon = jQuery("#Mon").val();
            jQuery.post('business_save.php',{tag:'Inquiry_Step_3',IID:NowIID,Mon:Mon},function(data){
                jQuery("#mon_"+NowIID).text("金額:"+Mon);
                jQuery("#mondialog").dialog("close");
            },'json');
        },
        Cancel: function() { jQuery( "#mondialog" ).dialog( "close" ); }
      }
    });
    jQuery("#keydialog").dialog({
        autoOpen:false,
        minWidth:300,
        resizable:true
    });
});
function opendetaildialog(IID){
    NowIID = IID;
    if(IID>0){
        jQuery.post('business_save.php',{tag:'Get_Inquiry_Detail',IID:IID},function(data){
            jQuery("#Inq").val(data.Inq);
            jQuery("#mail_id").val(data.mail_id);
            jQuery("#ToW").val(data.ToW);
            jQuery("#detaildialog").dialog("open");
        },'json');
    } else {
        jQuery("#Inq").val('');
        jQuery("#mail_id").val('');
        jQuery("#ToW").val('');
        jQuery("#detaildialog").dialog("open");
    }
}
function openweightdialog(IID){
    NowIID = IID;
    jQuery.post('business_save.php',{tag:'Get_Inquiry_Detail',IID:IID},function(data){
        jQuery("#Inq2").val(data.Inq);
        jQuery("#mail_id2").text(data.name);
        jQuery("#ToW2").text(data.ToW);
        jQuery("#Weight").val(data.Weight);
        jQuery("#weightdialog").dialog("open");
    },'json');
}
function openmondialog(IID){
    NowIID = IID;
    jQuery.post('business_save.php',{tag:'Get_Inquiry_Detail',IID:IID},function(data){
        jQuery("#Inq3").val(data.Inq);
        jQuery("#mail_id3").text(data.name);
        jQuery("#ToW3").text(data.ToW);
        jQuery("#Weight3").text(data.Weight);
        jQuery("#Mon").val(data.Mon);
        jQuery("#mondialog").dialog("open");
    },'json');
}
function openkey(IID){
    jQuery.post('business_save.php',{tag:'Get_Inquiry_Mem',IID:IID},function(data){
        jQuery("#MeM1").text(data.Mem1);
        jQuery("#MeM2").text(data.Mem2);
        jQuery("#MeM3").text(data.Mem3);
        jQuery("#keydialog").dialog("open");
    },'json');
}
function sent_mail_to_take(IID){
    jQuery.post('business_save.php',{tag:'inquiry_sent_mail',IID:IID},function(data){
        if(data.success=='Y'){
            jQuery("#mail_"+IID).html(data.mt);
            alert("信件已成功寄送");
        } else {
            alert("信件寄送失敗");
        }
    },'json');
}
</script>
    
</div><!--mainwrapper-->
</body>
</html>
