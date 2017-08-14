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
$mysql->table = 'product_data'; //指定table
//mysql_num_rows($mysql->select('','product_id'))  此段是抓table值 的數量
//$_SERVER['PHP_SELF'].'?' 抓目前檔案的名稱
$MyPage = GPage($PItem,$Page,mysql_num_rows($mysql->select('','product_id')),$_SERVER['PHP_SELF'].'?',''); //抓頁數的Function 如果需要傳另外的值,可用最後一個欄位

//LIMIT 設定sql撈出資料的開始位置與筆數 
$sql = 'select * from product_data';
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
        	<h1>品項管理</h1> <span>This is a sample description for form styles page...</span>
        </div><!--pagetitle-->
        
        <div class="maincontent">
        	<div class="contentinner">
            	<h4 class="widgettitle"><span class="iconsweets-dropbox"></span> 品項列表<a href="product_new.php" title="編輯" class="btn btn-primary" style="float:right" ><span class="icon-plus"></span>新增</a></h4>
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
                            <th>品項名稱</th>
                            <th>描述</th>
                            <th>建立人員</th>
                            <th>建立時間</th>
                        </tr>
                    </thead>
                    <tbody> 

                    <? while($row = mysql_fetch_assoc($rs)){?>
                    <script type="text/javascript">
					// delete row in a table
					jQuery(document).ready(function(){
						jQuery('#deleter<?=$row['product_id'];?>').click(function(){
						   var conf = confirm('是否確定刪除?');
						   if(conf)
							  window.location.href='product_del.php?pid=<?=$row['product_id'];?>';
						   return false;
						}); 
					});   
					</script>	
                        <tr>
                        	<td class="centeralign"><div class="checker" id="uniform-undefined"><span><input type="checkbox" style="opacity: 0;"></span></div></td>
                            <td><?=$row['name']; ?></td>
                            <td><?=$row['info']; ?></td>
                            <td><?=$row['create_user']; ?></td>
                            <td><?=$row['create_time']; ?></td>
                            <td class="centeralign"> 
                            <a href="product_view.php?pid=<?=$row['product_id'];?>" title="編輯" class="btn" ><span class="icon-edit"></span>編輯</a>
                            &nbsp;
                            <a title="刪除" id="deleter<?=$row['product_id'];?>" style="cursor: pointer;" class="btn"><span class="icon-trash"></span>刪除</a>
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
