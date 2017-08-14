<ul class="breadcrumb">
    <li><a href="dashboard.php">Home</a> <span class="divider">/</span></li>
    <?
	$url = $_SERVER['PHP_SELF'];
	if (strpos ($url, "dashboard")){
		 echo "<li class='active'>Inventory List</li>";
	} 
	elseif (strpos ($url, "product")) 
	{
		 $first = "品項";
		 $last = "product";
	}
	elseif (strpos ($url, "addition")) 
	{
		 $first = "進貨";
		 $last = "addition";
	}
	elseif (strpos ($url, "complete")) 
	{
		 $first = "成品";
		 $last = "complete";
	}
	elseif (strpos($url,"business")){
		$first = "Order ";
		$last = "business";
	}
	elseif (strpos ($url, "shipments")) 
	{
		 $first = "Shipping & Packing ";
		 $last = "shipments";
	}
	elseif (strpos ($url, "vendors")) 
	{
		 $first = "零件廠商";
		 $last = "vendors";
	}
	elseif (strpos ($url, "parts_needs")) 
	{
		 $first = "零件進貨";
		 $last = "parts_needs";
	}
	elseif (strpos ($url, "parts")) 
	{
		 $first = "零件";
		 $last = "parts";
	}
	elseif (strpos ($url, "mail")) 
	{
		 $bb=$_SERVER['QUERY_STRING'];
		 if(strpos ($bb, "1"))
		 {
			$first = "客戶Email";
		 	$last = "mail";
			$kid ="1"; 
		 }
		 else
		 {
			$first = "貨運Email";
		 	$last = "mail";
			$kid =2; 
	     }	 
		 
	}
	elseif (strpos ($url, "member")) 
	{
		 $first = "會員";
		 $last = "member";
	}
	
	
	if (strpos ($url, "list")){
		 echo "<li class='active'>".$first."List</li>";
	}
	if (strpos ($url, "new") || strpos ($url, "add")) 
	{
		 if ($kid <> 0)
		 {
		 echo "<li><a href='".$last."_list.php?key=".$kid."'>".$first."List</a> <span class='divider'>/</span></li>";	 
			 }
		 else
		 {
	     echo "<li><a href='".$last."_list.php'>".$first."List</a> <span class='divider'>/</span></li>";
			 }	 
		 echo "<li class='active'>新增".$first."</li>";
	}
	if (strpos ($url, "view")) 
	{   
		 if ($kid <> 0)
		 {
		 echo "<li><a href='".$last."_list.php?key=".$kid."'>".$first."List</a> <span class='divider'>/</span></li>";	 
			 }
		 else
		 {
	     echo "<li><a href='".$last."_list.php'>".$first."List</a> <span class='divider'>/</span></li>";
			 }
		echo "<li class='active'>".$first."View</li>";
	}  
	?>
</ul>
