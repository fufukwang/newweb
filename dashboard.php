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
$sql = 'select * from parts_data';
$sql .='  ORDER BY create_time DESC';
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
        </div><!--breadcrumbwidget-->
      <div class="pagetitle">
        	<h1>Inventory</h1> <span></span>
        </div><!--pagetitle-->
        
        <div class="maincontent">
        	<div class="contentinner content-dashboard">
            	<!--<div class="alert alert-info">
                	<button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Welcome!</strong> This alert needs your attention, but it's not super important.
                </div>--><!--alert-->
                
                <div class="row-fluid">
                	<div class="span8">
                        <!--<h4 class="widgettitle">Recent Articles</h4>-->
                        <div class="widgetcontent">
                            <div id="tabs">
                                <ul>
                                    <li><a href="#tabs-1"><span class="icon-forward"></span>&nbsp;Current Inventory</a></li>
                                    <!--<li><a href="#tabs-3"><span class="icon-leaf"></span> Fitness &amp; Health</a></li>-->
                                </ul>
                                <div id="tabs-1">
                                  <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Prduct Name</th>
                                                <? if ($_SESSION['super_power'] == 1 or $_SESSION['house_power'] == 1){ ?>
                                                <th>Quantity</th>
                                                <th>Pending Order</th>
                                                <? }?>
                                                <th>Current Q'ty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            // 未出貨完成需求產品數量
                                $mysql->table = 'BDataDetail';
                                $zrs = $mysql->select("LEFT JOIN Business_data USING(BID) WHERE End=0 AND Checked=1");
                                $Pro_List = array();
                                $BID = array();
                                $BID_str = '';
                                while($row = mysql_fetch_assoc($zrs)){
                                    $tmp = array(
                                        'product_id' => $row['product_id'],
                                        'count'      => $row['count']
                                    );
                                    $IsSome = false;
                                    for($i=0;$i<count($Pro_List);$i++){
                                        if($row['product_id']==$Pro_List[$i]['product_id']){
                                            $Pro_List[$i]['count'] = $tmp['count'] + $Pro_List[$i]['count'];
                                            $IsSome = true;
                                            break;
                                        }
                                    }
                                    if(!in_array( $row['BID'],$BID)){
                                        array_push($BID, $row['BID']);
                                        $BID_str .= $BID_str=='' ? $row['BID'] : ','.$row['BID'];
                                    }
                                    if(!$IsSome) array_push($Pro_List, $tmp);
                                }
                                
                                $shiparr = array();
                                $ship_str = '';
                                if($BID_str!=''){
                                    $mysql->table = 'BShipLink';
                                    $zrs = $mysql->select("WHERE BID IN ({$BID_str})");
                                    
                                    while($row = mysql_fetch_assoc($zrs)){
                                        if(!in_array( $row['shipments_id'],$shiparr)){
                                            array_push($shiparr, $row['shipments_id']);
                                            $ship_str .= $ship_str=='' ? $row['shipments_id'] : ','.$row['shipments_id'];
                                        }
                                    }
                                }
                                if($ship_str!=''){
                                    $mysql->table = 'shipments_detail_data';
                                    $zrs = $mysql->select("WHERE group_id IN ($ship_str)");
                                    while($row = mysql_fetch_assoc($zrs)){
                                        for($i=0;$i<count($Pro_List);$i++){
                                            if($row['product_id']==$Pro_List[$i]['product_id']){
                                                $Pro_List[$i]['count'] = $Pro_List[$i]['count'] - $row['count'];
                                                break;
                                            }
                                        }
                                    }
                                }
                            
                                            $mysql->table = 'product_data';
                                            $rsc = $mysql->select("",'name,(SELECT SUM(count) FROM(complete_detail_data) WHERE complete_detail_data.product_id=product_data.product_id) AS sumc,product_id');
                                            while($row = mysql_fetch_assoc($rsc)){
                                                
                                                $Out = 0;
                                            ?>
                                            <tr>
                                            	<td><?=$row['name']?></td>
                                            	<? if ($_SESSION['super_power'] == 1 or $_SESSION['house_power'] == 1){ ?>
                                                <td><?=$row['sumc']?></td>
                                                <td><?foreach($Pro_List as $P){ if($row['product_id']==$P['product_id']){ $Out = $P['count']; }}?><?=$Out?></td>
                                                <? }?>
                                                <td><?=$row['sumc'] - $Out?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!--<div id="tabs-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Submitted By</th>
                                                <th>Date Added</th>
                                                <th class="center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a href=""><strong>Quis autem vel eum iure reprehenderi...</strong></a></td>
                                                <td><a href="">amanda</a></td>
                                                <td>Jan 03, 2013</td>
                                                <td class="center"><a href="" class="btn"><span class="icon-edit"></span> Edit</a></td>
                                            </tr>
                                            <tr>
                                                <td><a href=""><strong>Nemo enim ipsam voluptatem quia</strong></a></td>
                                                <td><a href="">mandylane</a></td>
                                                <td>Dec 31, 2012</td>
                                                <td class="center"><a href="" class="btn"><span class="icon-edit"></span> Edit</a></td>
                                            </tr>
                                            <tr>
                                                <td><a href=""><strong>Excepteur sint occaecat cupidatat non...</strong></a></td>
                                                <td><a href="">admin</a></td>
                                                <td>Jan 02, 2013</td>
                                                <td class="center"><a href="" class="btn"><span class="icon-edit"></span> Edit</a></td>
                                            </tr>
                                            <tr>
                                                <td><a href=""><strong>Sed ut perspiciatis unde omnis iste natus...</strong></a></td>
                                                <td><a href="">themepixels</a></td>
                                                <td>Jan 02, 2013</td>
                                                <td class="center"><a href="" class="btn"><span class="icon-edit"></span> Edit</a></td>
                                            </tr>
                                            <tr>
                                                <td><a href=""><strong>Sed ut perspiciatis unde omnis iste natus</strong></a></td>
                                                <td><a href="">johndoe</a></td>
                                                <td>Jan 01, 2013</td>
                                                <td class="center"><a href="" class="btn"><span class="icon-edit"></span> Edit</a></td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                </div>-->
                            </div><!--#tabs-->
                            <p></p>
                            <? if (1==2) {?>
                            <div id="tabs">
                                <ul>
                                    <li><a href="#tabs-2"><span class="icon-eye-open"></span>&nbsp;零件庫存狀態</a></li>
                                    <!--<li><a href="#tabs-3"><span class="icon-leaf"></span> Fitness &amp; Health</a></li>-->
                                </ul>  
                                <div id="tabs-1">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>零件名稱</th>
                                                <th>目前庫存</th>
                                                <th></th>
                                                <th class="center">
                                                <?
												//不啟用
												if (1==2){
												?> 
                                                <? if ($_SESSION['ppower']!= 0){ ?>
                                                <a href="product_new.php" class="btn"><span class="iconsweets-dropbox"></span> 品項</a>
                                                <? }?>
                                                <? if ($_SESSION['apower']!= 0){ ?>
                                                <a href="addition_new.php" class="btn"><span class="iconsweets-cart"></span> 進貨</a>
                                                <? }?>
                                                <? if ($_SESSION['cpower']!= 0){ ?>
                                                <a href="complete_new.php" class="btn"><span class="iconsweets-robot"></span> 成品</a>
                                                <? }?>
                                                <? if ($_SESSION['spower']!= 0){ ?>
                                                <a href="parts_new.php" class="btn"><span class="iconsweets-track"></span> 出貨</a>
                                                <? }?>
                                                <?
												//不啟用
												} 
												?> 
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    <? while($row = mysql_fetch_assoc($rs)){?> 
                                    		<?
                                            //計算零件庫存
                                            $sql = 'select * from parts_inven_data';
                                            $sql .=' Where parts_id ='.$row['parts_id'];
                                            $rs4 = mysql_query($sql)or die(mysql_error()); //sql查詢
                                            $parts_count = 0;
                                            $parts_all = 0;
                                                while($row4 = mysql_fetch_assoc($rs4)){
                                                   $parts_count = intval($row4['count']); 
                                                   $parts_all = $parts_all + $parts_count;   
                                                } 
                                            ?>                                            

                                            <? 
                                            ?> 
 
                                            <tr>
                                                <td><a href=""><strong><?=$row['name']; ?></strong></a></td>
                                                <td><a href=""><?=$parts_all;?></a></td>
                                                <td></td>
                                                <td class="center">
                                                
                                                </td>
                                            </tr>
                                    <? }?>         
                                        </tbody>
                                    </table>
                                </div>
                                <!--<div id="tabs-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Submitted By</th>
                                                <th>Date Added</th>
                                                <th class="center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a href=""><strong>Quis autem vel eum iure reprehenderi...</strong></a></td>
                                                <td><a href="">amanda</a></td>
                                                <td>Jan 03, 2013</td>
                                                <td class="center"><a href="" class="btn"><span class="icon-edit"></span> Edit</a></td>
                                            </tr>
                                            <tr>
                                                <td><a href=""><strong>Nemo enim ipsam voluptatem quia</strong></a></td>
                                                <td><a href="">mandylane</a></td>
                                                <td>Dec 31, 2012</td>
                                                <td class="center"><a href="" class="btn"><span class="icon-edit"></span> Edit</a></td>
                                            </tr>
                                            <tr>
                                                <td><a href=""><strong>Excepteur sint occaecat cupidatat non...</strong></a></td>
                                                <td><a href="">admin</a></td>
                                                <td>Jan 02, 2013</td>
                                                <td class="center"><a href="" class="btn"><span class="icon-edit"></span> Edit</a></td>
                                            </tr>
                                            <tr>
                                                <td><a href=""><strong>Sed ut perspiciatis unde omnis iste natus...</strong></a></td>
                                                <td><a href="">themepixels</a></td>
                                                <td>Jan 02, 2013</td>
                                                <td class="center"><a href="" class="btn"><span class="icon-edit"></span> Edit</a></td>
                                            </tr>
                                            <tr>
                                                <td><a href=""><strong>Sed ut perspiciatis unde omnis iste natus</strong></a></td>
                                                <td><a href="">johndoe</a></td>
                                                <td>Jan 01, 2013</td>
                                                <td class="center"><a href="" class="btn"><span class="icon-edit"></span> Edit</a></td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                </div>-->
                            </div><!--#tabs-->
                            <? }?>
                        </div><!--widgetcontent-->
                        
                        
                    </div><!--span8-->
                    <div class="span4">
                        <? if (1==2) {?>
                        <div id="tabs">
                                <ul>
                                    <li><a href="#tabs-2"><span class="icon-eye-open"></span>&nbsp;零件庫存狀態</a></li>
                                    <!--<li><a href="#tabs-3"><span class="icon-leaf"></span> Fitness &amp; Health</a></li>-->
                                </ul>  
                                <div id="tabs-1">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>零件名稱</th>
                                                <th>目前庫存</th>
                                                <th></th>
                                                <th class="center">
                                                <?
												//不啟用
												if (1==2){
												?> 
                                                <? if ($_SESSION['ppower']!= 0){ ?>
                                                <a href="product_new.php" class="btn"><span class="iconsweets-dropbox"></span> 品項</a>
                                                <? }?>
                                                <? if ($_SESSION['apower']!= 0){ ?>
                                                <a href="addition_new.php" class="btn"><span class="iconsweets-cart"></span> 進貨</a>
                                                <? }?>
                                                <? if ($_SESSION['cpower']!= 0){ ?>
                                                <a href="complete_new.php" class="btn"><span class="iconsweets-robot"></span> 成品</a>
                                                <? }?>
                                                <? if ($_SESSION['spower']!= 0){ ?>
                                                <a href="parts_new.php" class="btn"><span class="iconsweets-track"></span> 出貨</a>
                                                <? }?>
                                                <?
												//不啟用
												} 
												?> 
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    <? while($row = mysql_fetch_assoc($rs)){?> 
                                    		<?
                                            //計算零件庫存
                                            $sql = 'select * from parts_inven_data';
                                            $sql .=' Where parts_id ='.$row['parts_id'];
                                            $rs4 = mysql_query($sql)or die(mysql_error()); //sql查詢
                                            $parts_count = 0;
                                            $parts_all = 0;
                                                while($row4 = mysql_fetch_assoc($rs4)){
                                                   $parts_count = intval($row4['count']); 
                                                   $parts_all = $parts_all + $parts_count;   
                                                } 
                                            ?>                                            

                                            <? 
                                            ?> 
 
                                            <tr>
                                                <td><a href=""><strong><?=$row['name']; ?></strong></a></td>
                                                <td><a href=""><?=$parts_all;?></a></td>
                                                <td></td>
                                                <td class="center">
                                                
                                                </td>
                                            </tr>
                                    <? }?>         
                                        </tbody>
                                    </table>
                                </div>
                                <!--<div id="tabs-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Submitted By</th>
                                                <th>Date Added</th>
                                                <th class="center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a href=""><strong>Quis autem vel eum iure reprehenderi...</strong></a></td>
                                                <td><a href="">amanda</a></td>
                                                <td>Jan 03, 2013</td>
                                                <td class="center"><a href="" class="btn"><span class="icon-edit"></span> Edit</a></td>
                                            </tr>
                                            <tr>
                                                <td><a href=""><strong>Nemo enim ipsam voluptatem quia</strong></a></td>
                                                <td><a href="">mandylane</a></td>
                                                <td>Dec 31, 2012</td>
                                                <td class="center"><a href="" class="btn"><span class="icon-edit"></span> Edit</a></td>
                                            </tr>
                                            <tr>
                                                <td><a href=""><strong>Excepteur sint occaecat cupidatat non...</strong></a></td>
                                                <td><a href="">admin</a></td>
                                                <td>Jan 02, 2013</td>
                                                <td class="center"><a href="" class="btn"><span class="icon-edit"></span> Edit</a></td>
                                            </tr>
                                            <tr>
                                                <td><a href=""><strong>Sed ut perspiciatis unde omnis iste natus...</strong></a></td>
                                                <td><a href="">themepixels</a></td>
                                                <td>Jan 02, 2013</td>
                                                <td class="center"><a href="" class="btn"><span class="icon-edit"></span> Edit</a></td>
                                            </tr>
                                            <tr>
                                                <td><a href=""><strong>Sed ut perspiciatis unde omnis iste natus</strong></a></td>
                                                <td><a href="">johndoe</a></td>
                                                <td>Jan 01, 2013</td>
                                                <td class="center"><a href="" class="btn"><span class="icon-edit"></span> Edit</a></td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                </div>-->
                            </div><!--#tabs-->
                        <? }?>    
                    	<!--<h4 class="widgettitle nomargin">重要事項公告</h4>
                        <div class="widgetcontent bordered">
                        	本系統正在測試中
                        </div>--><!--widgetcontent-->
                    </div><!--span4-->
                </div><!--row-fluid-->
            </div><!--contentinner-->
        </div><!--maincontent-->
        
    </div><!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
    
<?
include("template_down.php");
?> 

    
</div><!--mainwrapper-->
<script type="text/javascript">
jQuery(document).ready(function(){
								
		// basic chart
		var flash = [[0, 2], [1, 6], [2,3], [3, 8], [4, 5], [5, 13], [6, 8]];
		var html5 = [[0, 5], [1, 4], [2,4], [3, 1], [4, 9], [5, 10], [6, 13]];
			
		function showTooltip(x, y, contents) {
			jQuery('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5
			}).appendTo("body").fadeIn(200);
		}
	
			
		var plot = jQuery.plot(jQuery("#chartplace2"),
			   [ { data: flash, label: "Flash(x)", color: "#fb6409"}, { data: html5, label: "HTML5(x)", color: "#096afb"} ], {
				   series: {
					   lines: { show: true, fill: true, fillColor: { colors: [ { opacity: 0.05 }, { opacity: 0.15 } ] } },
					   points: { show: true }
				   },
				   legend: { position: 'nw'},
				   grid: { hoverable: true, clickable: true, borderColor: '#ccc', borderWidth: 1, labelMargin: 10 },
				   yaxis: { min: 0, max: 15 }
				 });
		
		var previousPoint = null;
		jQuery("#chartplace2").bind("plothover", function (event, pos, item) {
			jQuery("#x").text(pos.x.toFixed(2));
			jQuery("#y").text(pos.y.toFixed(2));
			
			if(item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
						
					jQuery("#tooltip").remove();
					var x = item.datapoint[0].toFixed(2),
					y = item.datapoint[1].toFixed(2);
						
					showTooltip(item.pageX, item.pageY,
									item.series.label + " of " + x + " = " + y);
				}
			
			} else {
			   jQuery("#tooltip").remove();
			   previousPoint = null;            
			}
		
		});
		
		jQuery("#chartplace2").bind("plotclick", function (event, pos, item) {
			if (item) {
				jQuery("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
				plot.highlight(item.series, item.datapoint);
			}
		});


		// bar graph
		var d2 = [];
		for (var i = 0; i <= 10; i += 1)
			d2.push([i, parseInt(Math.random() * 30)]);
			
		var stack = 0, bars = true, lines = false, steps = false;
		jQuery.plot(jQuery("#bargraph2"), [ d2 ], {
			series: {
				stack: stack,
				lines: { show: lines, fill: true, steps: steps },
				bars: { show: bars, barWidth: 0.6 }
			},
			grid: { hoverable: true, clickable: true, borderColor: '#bbb', borderWidth: 1, labelMargin: 10 },
			colors: ["#06c"]
		});
		
		// calendar
		jQuery('#calendar').datepicker();


});
</script>
</body>
</html>
