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
  if ($_GET['sid']!= ''){
  $sid=$_GET['sid'];
  }
?>
<?
$sql = 'select * from shipments_detail_data';
$sql .='  WHERE group_id='.$sid;
$sql .='  ORDER BY create_time DESC';
$rs = mysql_query($sql)or die(mysql_error()); //sql查詢
?>	
<?
$sql = 'select * from shipments_data';
$sql .='  WHERE shipments_id='.$sid;
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
        	<h1>Create New Shipping & Packing</h1> <span>This is a sample description for form styles page...</span>
        </div><!--pagetitle-->
        <div class="maincontent">
        	<div class="contentinner">
            	<h4 class="widgettitle">Shipping & Packing View</h4>
                <div class="widgetcontent">
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
                            <th>Packing NO.</th>
                            <th>Customer</th>
                            <th>Shipping Address</th>
                            <th>Shipping Date</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                    <? while($row2 = mysql_fetch_assoc($rs2)){?>
                        <tr>
                            <td><?=$row2['number']; ?></td>
                            <td><?=$row2['client']; ?></td>
                            <td><?=$row2['location']; ?></td>
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
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>&nbsp;</th>
                        </tr>
                        <? while($row = mysql_fetch_assoc($rs)){?>
                        <tr>
                            <?
							$sql = 'select * from product_data';
							$sql .=' Where product_id ='.$row['product_id'];
							$rs3 = mysql_query($sql)or die(mysql_error()); //sql查詢
							?>
                            <? while($row3 = mysql_fetch_assoc($rs3)){?>
                            <th><?=$row3['number']; ?>(<?=$row3['name']; ?>)</th>
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
				$url="shipments_list.php";
				?>                
                <p class="stdformbutton">
                    <button onClick="location.href='<?=$url;?>'" class="btn">Back to list</button>
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
