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
//判斷是否有抓到 id 如果有,把抓到的id 帶入變數中
  if ($_GET['cid']!= ''){
  $cid=$_GET['cid'];
  $pn=$_GET['pn'];
  $info=$_GET['info'];
  }
?>
<?
$sql = 'select * from complete_detail_data';
$sql .='  WHERE group_id='.$cid;
$sql .='  ORDER BY create_time DESC';
$rs = mysql_query($sql)or die(mysql_error()); //sql查詢
?>
<?
$sql = 'select * from complete_data';
$sql .='  WHERE complete_id='.$cid;
$sql .='  ORDER BY create_time DESC';
$rs2 = mysql_query($sql)or die(mysql_error()); //sql查詢
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
        	<h1>進出貨管理</h1> <span>This is a sample description for form styles page...</span>
        </div><!--pagetitle-->
        <div class="maincontent">
        	<div class="contentinner">
            	<h4 class="widgettitle">成品檢視</h4>
                <table class="table table-bordered">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th>成品建立編號</th>
                            <th>成品建立時間</th>
                            <th>預計完成時間</th>
                            <th>備註</th>
                        </tr>
                    </thead>
                    <tbody>
                    <? while($row2 = mysql_fetch_assoc($rs2)){?>
                        <tr>
                            <td><?=$row2['number']; ?></td>
                            <td><?=date("Y-m-d H:i:s",$row2['ATime']); ?></td>
                            <td><?=$row2['create_time']; ?></td>
                            <td><?=$row2['info']; ?></td>
                        </tr>
                    <? }?>     
                    </tbody>
                </table>
                <div class="divider30"></div>
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
                            <th>商品型號</th>
                            <th>數量</th>
                            <th>&nbsp;</th>
                        </tr>
                        <? while($row = mysql_fetch_assoc($rs)){?>
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
                            <th></th>
                        </tr>
                        <? }?> 
                    </thead>
                    <tbody id="test"> 
                        
                    </tbody>
                </table> 
                <p>&nbsp;</p> 
                <?
				$url="complete_list.php";
				?>                
                <p class="stdformbutton">
                    <button onClick="location.href='<?=$url;?>'" class="btn">返回列表</button>
                </p>
                  
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
