<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Katniss Premium Admin Template</title>
<?
//載入共用的CSS 與 JQ
include("template_meta.php");
?>
</head>

<body>

<div class="mainwrapper">
	
<?
//載入共用的TOP
include("template_left.php");
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
        	<ul class="breadcrumb">
                <li><a href="dashboard.html">Home</a> <span class="divider">/</span></li>
                <li class="active">Page Not Found</li>
            </ul>
        </div><!--breadcrumbs-->
        <?
        $msg=$_GET['msg'];
		$url=$_GET['url'];
		?>
        <div class="pagetitle">
        	<h1><?=$msg;?></h1> <span></span>
        </div><!--pagetitle-->
        
        <div class="maincontent">
        	<div class="contentinner wrapper404">
            	<p><!--The page you are looking for is not found. This could be for several reasons...--></p>
                <div class="alert alert-success">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <strong><?=$msg;?>!</strong> <!--You successfully read this important alert message.-->
                </div>
                <br />
                <button class="btn btn-primary" onClick="history.back()">繼續編輯</button> &nbsp; 
                <button onclick="location.href='<?=$url;?>'" class="btn">返回列表</button>
                <!--<button onClick="location.href='dashboard.html'" class="btn">Go Back to Dashboard</button>-->
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
