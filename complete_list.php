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
$mysql->table = 'complete_data'; //指定table
//mysql_num_rows($mysql->select('','product_id'))  此段是抓table值 的數量
//$_SERVER['PHP_SELF'].'?' 抓目前檔案的名稱
$MyPage = GPage($PItem,$Page,mysql_num_rows($mysql->select('','complete_id')),$_SERVER['PHP_SELF'].'?',''); //抓頁數的Function 如果需要傳另外的值,可用最後一個欄位

//LIMIT 設定sql撈出資料的開始位置與筆數 
$sql = 'select * from complete_data';
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
            	<h3 class="widgettitle"><span class="iconsweets-robot"></span> 成品紀錄
                <a href="complete_new.php" title="編輯" class="btn btn-primary" style="float:right" ><span class="icon-plus"></span>新增成品</a> &nbsp;
                <a href="complete_cancel.php" title="取消成品" class="btn btn-danger" style="float:right" ><span class="icon-minus-sign"></span>&nbsp;取消成品</a>
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
                            <th>成品單編號</th>
                            <th>備註</th>
                            <th>建立時間</th>
                            <th>預計完成時間</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody> 
                    <? while($row = mysql_fetch_assoc($rs)){?>
                        <tr <? if ($row['cancel']==1){?> style=" background-color:#FB7C66;"<? }?>>
                        	<td class="centeralign" ><div class="checker" id="uniform-undefined"><span><input type="checkbox" style="opacity: 0;"></span></div></td>
 							<td><?=$row['number']; ?></td>
                            <td><?=$row['info']; ?></td>
                            <td><?=date("Y-m-d H:i:s",$row['ATime']) ?></td>
                            <td><?=$row['create_time']; ?></td>
                            <td class="centeralign"> 
                                <a href="complete_view.php?cid=<?=$row['complete_id'];?>&pn=<?=$row['number'];?>&info=<?=$row['info'];?>" title="編輯" class="btn" ><span class="icon-pencil"></span>&nbsp;明細</a>
                                <a href="complete_print.php?cid=<?=$row['complete_id'];?>&pn=<?=$row['number'];?>&info=<?=$row['info'];?>" title="列印"  target="_blank" class="btn" ><span class="icon-print"></span>&nbsp;列印</a>
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
