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
$mysql->table = 'Packing'; //指定table
//mysql_num_rows($mysql->select('','product_id'))  此段是抓table值 的數量
//$_SERVER['PHP_SELF'].'?' 抓目前檔案的名稱
$MyPage = GPage($PItem,$Page,mysql_num_rows($mysql->select('','PID')),$_SERVER['PHP_SELF'].'?',''); //抓頁數的Function 如果需要傳另外的值,可用最後一個欄位

$rs = $mysql->select("LEFT JOIN shipments_data USING(shipments_id) LEFT JOIN member_data ON member_data.member_id=Packing.member_id ORDER BY PackTime DESC LIMIT {$MyPage['Str']},{$PItem}","number,PID,user_name,PackTime,MailTime,AWB");

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
        	<h1>包裝管理</h1> 
        </div><!--pagetitle-->
        
        <div class="maincontent">
        	<div class="contentinner">
            	<h3 class="widgettitle"><span class="iconsweets-dropbox"></span> 包裝列表
                <a href="packing_new.php" title="編輯" class="btn btn-primary" style="float:right" ><span class="icon-plus"></span>新增包裝</a>&nbsp;
                </h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                        	<th class="centeralign"><div class="checker" id="uniform-undefined"><span><input type="checkbox" class="checkall" style="opacity: 0;"></span></div></th>
                            <th>需求單號</th>
                            <th>包裝人員</th>
                            <th>包裝時間</th>
                            <th>最後寄信時間</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody> 
                    <? while($row = mysql_fetch_assoc($rs)){?>
                        <tr <? if ($row['cancel']){?> style=" background-color:#FB7C66;"<? }?>>
                        	<td class="centeralign" ><div class="checker" id="uniform-undefined"><span><input type="checkbox" style="opacity: 0;"></span></div></td>
 							<td><?=$row['number']; ?></td>
                            <td><?=$row['user_name']?></td>
                            <td><?=date('Y/m/d H:i:s',$row['PackTime']) ?></td>
                            <th id="mail_<?=$row['PID']?>"><?=$row['MailTime']>0 ? date('Y/m/d H:i:s',$row['MailTime']) : '<span style="color:red;">未寄送</span>' ?></th>
                            <td class="centeralign"> 
                                <a href="packing_view.php?PID=<?=$row['PID'];?>" title="編輯" class="btn" ><span class="icon-pencil"></span>&nbsp;明細</a>
                                <a href="javascript:;" title="編輯" onClick="sent_mail_to_take('<?=$row['PID']?>');" class="btn" ><span class="icon-envelope"></span>&nbsp;寄送信件</a>
                                <a href="packing_print.php?PID=<?=$row['PID'];?>" title="列印" target="_blank" class="btn" ><span class="icon-print"></span>&nbsp;列印</a>
                                <a href="javascript:;" onclick="openawbdialog(<?=$row['PID']?>);" class="btn" id="awb_<?=$row['PID']?>">AWB:<?=$row['AWB'] ? $row['AWB'] : '尚未填寫'?></a>
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
<div id="awbdialog" title="AWB Number">
    <table class="table table-bordered">
      <tr>
        <th>AWB Number</th>
        <th><input type="text" id="awbinput" ></th>
      </tr>
    </table>
  </div>
    <div class="clearfix"></div>
    
<?
include("template_down.php");
?>   
<script>
var NowPID = 0;
jQuery(function(){
    jQuery( "#awbdialog" ).dialog({
      resizable: false,
      height:180,
      minWidth:500,
      autoOpen:false,
      buttons: {
        Save: function() {
            var ANum = jQuery("#awbinput").val();
            jQuery.post('business_save.php',{tag:'Write_Packing_AWB',PID:NowPID,AWB:ANum},function(data){
                jQuery("#awb_"+NowPID).text('AWB:'+ANum);
                jQuery("#awbdialog").dialog("close");
            });
        },
        Cancel: function() {
          jQuery( "#awbdialog" ).dialog( "close" );
        }
      }
    });
});
function openawbdialog(PID){
    NowPID = PID;
    jQuery.post('business_save.php',{tag:'Get_Packing_AWB',PID:PID},function(data){
        jQuery("#awbinput").val(data.AWB);
        jQuery("#awbdialog").dialog("open");
    },'json');
}
function sent_mail_to_take(PID){
    jQuery.post('business_save.php',{tag:'packing_sent_mail',PID:PID},function(data){
        if(data.success=='Y'){
            jQuery("#mail_"+PID).html(data.mt);
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
