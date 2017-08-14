<?
//載入共用的CSS 與 JQ
include("template_meta.php");
?>
<body>
<?
//判斷是否有抓到 id 如果有,把抓到的id 帶入變數中
  if ($_GET['pid']!= ''){
  $pid=$_GET['pid'];
  $pn=$_GET['pn'];
  $info=$_GET['info'];
  }
?>
<?
$sql = 'select * from purchase_detail_data';
$sql .='  WHERE group_id='.$pid;
$sql .='  ORDER BY create_time DESC';
$rs = mysql_query($sql)or die(mysql_error()); //sql查詢
?>	 	    
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td><br />
          <div class="contentinner">
            	<h4 class="widgettitle">進貨單列印</h4>
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
                            <th>進貨編號</th>
                            <th>備註</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><? echo $pn?></td>
                            <td><?=$info;?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="divider30"></div>
                <!--我是分隔線-->
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
				$url="addition_list.php";
				?>                
            </div><!--contentinner--></td>
    </tr>
  </table>
<div class="clearfix"></div>
<script language=javascript>
  	print()
</script>      
</body>
</html>
