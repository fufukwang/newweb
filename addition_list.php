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
$PItem = 10; //一頁顯示的筆數
$mysql->table = 'purchase_data'; //指定table
//mysql_num_rows($mysql->select('','product_id'))  此段是抓table值 的數量
//$_SERVER['PHP_SELF'].'?' 抓目前檔案的名稱
$MyPage = GPage($PItem,$Page,mysql_num_rows($mysql->select('','purchase_id')),$_SERVER['PHP_SELF'].'?',''); //抓頁數的Function 如果需要傳另外的值,可用最後一個欄位

//LIMIT 設定sql撈出資料的開始位置與筆數 
$sql = 'select * from purchase_data';
$sql .='  ORDER BY create_time DESC  LIMIT '.$MyPage['Str'].','.$PItem; //LIMIT '.$MyPage['Str'].','.$PItem 他會回傳兩個值  Str 是目前頁數的開始 另一個是PageL 回傳的列表(Html)
$rs = mysql_query($sql)or die(mysql_error()); //sql查詢
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
            	<h4 class="widgettitle"><span class="iconsweets-cart"></span> 進貨紀錄
                <a href="addition_new.php" title="進貨" class="btn btn-primary" style="float:right" ><span class="icon-plus"></span>&nbsp;進貨</a>&nbsp;
                <a href="addition_cancel.php" title="退貨" class="btn btn-danger" style="float:right" ><span class="icon-minus-sign"></span>&nbsp;退貨</a>
                </h4>
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
                            <th>進貨編號</th>
                            <th>備註</th>
                            <th>進貨時間</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody> 
                    <? while($row = mysql_fetch_assoc($rs)){?>
                        <tr <? if ($row['cancel']==1){?> style=" background-color:#FB7C66;"<? }?>>
                        	<td class="centeralign" ><div class="checker" id="uniform-undefined"><span><input type="checkbox" style="opacity: 0;"></span></div></td>
 							<td><?=$row['number']; ?></td>
                            <td><?=$row['info']; ?></td>
                            <td><?=$row['create_time']; ?></td>
                            <td class="centeralign"> 
                                <a href="addition_view.php?pid=<?=$row['purchase_id'];?>&pn=<?=$row['number'];?>&info=<?=$row['info'];?>" title="編輯" class="btn" ><span class="icon-pencil"></span>&nbsp;明細</a>
                                <a href="addition_print.php?pid=<?=$row['purchase_id'];?>&pn=<?=$row['number'];?>&info=<?=$row['info'];?>" title="列印"  target="_blank" class="btn" ><span class="icon-print"></span>&nbsp;列印</a>
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

    <div class="clearfix"></div>
    
<?
include("template_down.php");
?>   

    
</div><!--mainwrapper-->
</body>
</html>
