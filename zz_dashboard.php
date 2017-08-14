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
$sql = 'select * from product_data';
$sql .='  ORDER BY inx DESC';
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
        	<h1>庫存列表</h1> <span></span>
        </div><!--pagetitle-->
        
        <div class="maincontent">
        	<div class="contentinner content-dashboard">
            	<div class="alert alert-info">
                	<button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Welcome!</strong> This alert needs your attention, but it's not super important.
                </div><!--alert-->
                
                <div class="row-fluid">
                	<div class="span8">
                        <!--<h4 class="widgettitle">Recent Articles</h4>-->
                        <div class="widgetcontent">
                            <div id="tabs">
                                <ul>
                                    <!--<li><a href="#tabs-1"><span class="icon-forward"></span> Technology</a></li>-->
                                    <li><a href="#tabs-2"><span class="icon-eye-open"></span> 庫存狀態</a></li>
                                    <!--<li><a href="#tabs-3"><span class="icon-leaf"></span> Fitness &amp; Health</a></li>-->
                                </ul>
                                <!--<div id="tabs-1">
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
                                            <tr>
                                                <td><a href=""><strong>Quis autem vel eum iure reprehenderi...</strong></a></td>
                                                <td><a href="">amanda</a></td>
                                                <td>Jan 01, 2013</td>
                                                <td class="center"><a href="" class="btn"><span class="icon-edit"></span> Edit</a></td>
                                            </tr>
                                            <tr>
                                                <td><a href=""><strong>Nemo enim ipsam voluptatem quia</strong></a></td>
                                                <td><a href="">mandylane</a></td>
                                                <td>Dec 31, 2012</td>
                                                <td class="center"><a href="" class="btn"><span class="icon-edit"></span> Edit</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>-->
                                  
                                <div id="tabs-2">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>品項</th>
                                                <th>庫存</th>
                                                <th>成品</th>
                                                <th class="center">
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
                                                <a href="shipments_new.php" class="btn"><span class="iconsweets-track"></span> 出貨</a>
                                                <? }?>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    <? while($row = mysql_fetch_assoc($rs)){?> 
                                    		<?
                                            //計算出貨總量
                                            $sql = 'select * from shipments_detail_data';
                                            $sql .=' Where product_id ='.$row['product_id'];
                                            $rs4 = mysql_query($sql)or die(mysql_error()); //sql查詢
                                            $shipments_count = 0;
                                            $shipments_all = 0;
                                                while($row4 = mysql_fetch_assoc($rs4)){
                                                   $shipments_count = intval($row4['count']); 
                                                   $shipments_all = $shipments_all + $shipments_count;   
                                                } 
                                            ?>
											<?
                                            //計算進貨總量
                                            $sql = 'select * from purchase_detail_data';
                                            $sql .=' Where product_id ='.$row['product_id'];
                                            $rs2 = mysql_query($sql)or die(mysql_error()); //sql查詢
                                            $purchase_count = 0;
                                            $purchase_all = 0;
                                                while($row2 = mysql_fetch_assoc($rs2)){
                                                   $purchase_count = intval($row2['count']); 
                                                   $purchase_all = $purchase_all+ intval($purchase_count);   
                                                } 
                                            ?>
                                            <?
                                            //計算成品總量
                                            $sql = 'select * from complete_detail_data';
                                            $sql .=' Where product_id ='.$row['product_id'];
                                            $rs3 = mysql_query($sql)or die(mysql_error()); //sql查詢
                                            $complete_count = 0;
                                            $complete_all = 0;
                                                while($row3 = mysql_fetch_assoc($rs3)){
                                                   $complete_count = intval($row3['count']); 
                                                   $complete_all = $complete_all+ intval($complete_count);   
                                                } 
                                            ?>
                                            

                                            <? 
                                            $ture_purchase_all = intval($purchase_all)-intval($shipments_all);
                                            $ture_complete_all = intval($complete_all)-intval($shipments_all);
                                            ?> 
 
                                            <tr>
                                                <td><a href=""><strong><?=$row['number']; ?>(<?=$row['name']; ?>)</strong></a></td>
                                                <td><a href=""><?=$ture_purchase_all;?></a></td>
                                                <td><?=$ture_complete_all;?></td>
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
                        </div><!--widgetcontent-->
                        
                        
                    </div><!--span8-->
                    <div class="span4">
                    	<h4 class="widgettitle nomargin">重要事項公告</h4>
                        <div class="widgetcontent bordered">
                        	本系統正在測試中
                        </div><!--widgetcontent-->
                    </div><!--span4-->
                </div><!--row-fluid-->
            </div><!--contentinner-->
        </div><!--maincontent-->
        
    </div><!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
    
    <div class="footer">
    	<div class="footerleft">Katniss Premium Admin Template v1.0</div>
    	<div class="footerright">&copy; ThemePixels - <a href="http://twitter.com/themepixels">Follow me on Twitter</a> - <a href="http://dribbble.com/themepixels">Follow me on Dribbble</a></div>
    </div><!--footer-->

    
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
