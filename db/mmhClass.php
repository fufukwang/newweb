<?

	//mysql物件

	class mysql{

		var $host = "localhost";	//mysql主機

		var $user;					//mysql帳號

		var $passwd;				//mysql密碼

		var $db;					//mysql資料庫

		var $CharSet = "utf8";		//編碼

		var $table; 				//資料表

		var $query;

		

		//連線方法

		function connect(){

			$link = mysql_connect($this->host,$this->user,$this->passwd)or die("資料庫連線異常,請稍後再試!!");

			mysql_query("SET NAMES $this->CharSet;"); 

			mysql_query("SET CHARACTER_SET_CLIENT=$this->CharSet;"); 

			mysql_query("SET CHARACTER_SET_RESULTS=$this->CharSet;");

			mysql_select_db($this->db,$link);

		}

		

		//選擇方法

		function select($where = "",$field = "*"){

			$queryStr = "select $field from $this->table $where";

			$rs = mysql_query($queryStr)or die(mysql_error());

			return $rs;

		}

		

		//新增方法

		function insert($arr){

			$fieldStr = "";

			$valueStr = "";

			foreach($arr as $key => $value){

				$fieldStr .= $key.",";

				$valueStr .= "'".$value."',";

			}

			if(strlen($fieldStr) > 0)$fieldStr = substr($fieldStr,0,strlen($fieldStr) - 1);

			if(strlen($valueStr) > 0)$valueStr = substr($valueStr,0,strlen($valueStr) - 1);

			

			$queryStr = "insert into $this->table ($fieldStr)values($valueStr)";

			mysql_query($queryStr)or die(mysql_error());

		}

		

		//更新方法

		function update($arr,$where){

			foreach($arr as $key => $value){

				$updateStr .= $key."='".$value."',";

			}

			if(strlen($updateStr) > 0)$updateStr = substr($updateStr,0,strlen($updateStr) - 1);

			

			$queryStr = "update $this->table set $updateStr $where";

			mysql_query($queryStr)or die(mysql_error());

		}

		

		//刪除方法

		function del($where){

			$queryStr = "delete from $this->table $where";

			mysql_query($queryStr)or die(mysql_error());

		}

		

		//欄位最大值

		function field_max($field,$group = ""){

			$rs = mysql_query("select MAX($field) as maxNo from $this->table $where")or die(mysql_error());

			if(mysql_num_rows($rs) > 0){			

				return mysql_result($rs,0,'maxNo');

			}else{

				return -1;

			}

		}

		

		//欄位最小值

		function field_min($field,$group = ""){

			$rs = mysql_query("select MIN($field) as minNo from $this->table $where")or die(mysql_error());

			if(mysql_num_rows($rs) > 0){

				return mysql_result($rs,0,'minNo');

			}else{

				return -1;

			}

		}

		

		//列移動

		function row_move($act,$fieldName,$id,$where = ""){

			$rs = $this->select("where $fieldName='$id' limit 1");

			if(mysql_num_rows($rs) == 0)alert("查無此筆欄位資料!!");

			$no = mysql_result($rs,0,'Sort');

					

			if($act == "up"){

				if(strlen($where) > 0){

					$where .= "&& Sort < '".$no."' order by Sort DESC";

				}else{

					$where = "where Sort < '".$no."' order by Sort DESC";

				}

				$rs = $this->select($where);

				if(mysql_num_rows($rs) == 0)alert("已經不能在上移了");

				$newNo = mysql_result($rs,0,'Sort');

			}else if($act == "down"){

				if(strlen($where) > 0){

					$where .= "&& Sort > '".$no."' order by Sort";

				}else{

					$where = "where Sort > '".$no."' order by Sort";

				}

				$rs = $this->select($where);

				if(mysql_num_rows($rs) == 0)alert("已經不能在下移了");

				$newNo = mysql_result($rs,0,'Sort');

			}

			$arrOld['Sort'] = $no;

			$arrNew['Sort'] = $newNo;

			$this->update($arrOld,"where Sort='$newNo' limit 1");

			$this->update($arrNew,"where $fieldName='$id' limit 1");

		}

		

		//fetch for smarty

		function fetch($rs){

			$sectionArr = array();

			while($sectionArr1 = mysql_fetch_array($rs)){

				$sectionArr[] = $sectionArr1;

			}

			return $sectionArr;

		}

		function count_row($where = '',$ID = '*'){

			$this->query = "SELECT COUNT({$ID}) FROM({$this->table}) $where";

			$AI = @mysql_query($this->query);

			$AC = @mysql_fetch_row($AI);

			return $AC[0];

		}

		

	}

	

	//檔案上傳物件

	class fileUpload extends mysql{

		var $allowType = "image/gif,image/pjpeg,image/jpeg,application/vnd.ms-excel,application/octet-stream";		//允許的檔案類型

		var $defaultType = "jpg";																					//當為任意二進位檔時

		var $allowSize = "200";																						//允許的檔案大小(K)

		var $foldPath = PicRoot;																					//上傳目錄

		

		//驗證方法

		function check($file,$i = -1){

			if($i == -1){

				//是否有寫入

				if(!file_exists($_FILES[$file]['tmp_name']))alert("檔案未被上傳,請檢查是否設定tmp");

				

				//檔案大小

				if($_FILES[$file]['size']/1024 > $this->allowSize)alert("檔案大小大於".$this->allowSize."K");

				

				//目錄權限

				if(!is_dir($this->foldPath) || !is_writeable($this->foldPath))alert("上傳目錄 ".$this->foldPath." 錯誤");

				

				//檔案類型

				$allowTypeArr = explode(",",$this->allowType);		

				if(!in_array($_FILES[$file]['type'],$allowTypeArr))alert("不支援 ".$_FILES[$file]['type']." 類型檔案");

				

				//錯誤訊息

				if($_FILES[$file]['error'] > 0){

					switch($_FILES[$file]['error']){

						case 1 : alert("檔案大小超出 php.ini:upload_max_filesize 限制");

						case 2 : alert("檔案大小超出 MAX_FILE_SIZE 限制");

						case 3 : alert("檔案僅被部分上傳");

						case 4 : alert("檔案未被上傳");

					}

				} 

			}else{

				//是否有寫入

				if(!file_exists($_FILES[$file]['tmp_name'][$i]))alert("檔案未被上傳,請檢查是否設定tmp");

				//檔案大小

				if($_FILES[$file]['size'][$i]/1024 > $this->allowSize)alert("檔案大小大於".$this->allowSize."K");

				//目錄權限

				if(!is_dir($this->foldPath) || !is_writeable($this->foldPath))alert("上傳目錄 ".$this->foldPath." 錯誤");

				//檔案類型

				$allowTypeArr = explode(",",$this->allowType);		

				if(!in_array($_FILES[$file]['type'][$i],$allowTypeArr))alert("不支援 ".$_FILES[$file]['type'][$i]." 類型檔案");

				

				//錯誤訊息

				if($_FILES[$file]['error'][$i] > 0){

					switch($_FILES[$file]['error'][$i]){

						case 1 : alert("檔案大小超出 php.ini:upload_max_filesize 限制");

						case 2 : alert("檔案大小超出 MAX_FILE_SIZE 限制");

						case 3 : alert("檔案僅被部分上傳");

						case 4 : alert("檔案未被上傳");

					}

				}

			}

			clearstatcache();

		}

		

		//檔案上傳方法

		function upload($file,$preName,$i = -1){		

			$file_name = "";

			if($i == -1){

				//檢查是否有要上傳

				if(!empty($_FILES[$file]['name'])){

					$this->check($file,$i);

					$file_name = "";

					if($_FILES[$file]['type'] == "image/pjpeg" || $_FILES[$file]['type'] == "image/jpeg"){

						$file_name = uniqid($preName).".jpg";

					}elseif($_FILES[$file]['type'] == "image/gif"){

						$file_name = uniqid($preName).".gif";

					}elseif($_FILES[$file]['type'] == "application/vnd.ms-excel"){

						$file_name = uniqid($preName).".xls";

					}elseif($_FILES[$file]['type'] == "application/octet-stream"){

						$file_name = uniqid($preName).".".$this->defaultType;

					}

					$dest = $this->foldPath."/".$file_name;

					move_uploaded_file($_FILES[$file]['tmp_name'],$dest);

				}

			}else{

				//檢查是否有要上傳

				if(!empty($_FILES[$file]['name'][$i])){

					$this->check($file,$i);

					$file_name = "";

					if($_FILES[$file]['type'][$i] == "image/pjpeg" || $_FILES[$file]['type'][$i] == "image/jpeg"){

						$file_name = uniqid($preName).".jpg";

					}elseif($_FILES[$file]['type'][$i] == "image/gif"){

						$file_name = uniqid($preName).".gif";

					}elseif($_FILES[$file]['type'][$i] == "application/vnd.ms-excel"){

						$file_name = uniqid($preName).".xls";

					}elseif($_FILES[$file]['type'][$i] == "application/octet-stream"){

						$file_name = uniqid($preName).".".$this->defaultType;

					}

					$dest = $this->foldPath."/".$file_name;

					move_uploaded_file($_FILES[$file]['tmp_name'][$i],$dest);

				}

			}

			return $file_name;

		}

		

		//刪除檔案

		function fileDel($file){

			if(!empty($file) && file_exists($this->foldPath."/".$file)){

				@unlink($this->foldPath."/".$file);

			}

		}

		

		//更新檔案

		function fileUpdate($oldFile,$newFile,$preName){

			if(!empty($_FILES[$newFile]['name'])){

				$this->fileDel($oldFile);		

				$file_name = $this->upload($newFile,$preName);

			}

			return $file_name;

		}

	}



	//回上一頁之警告

	function alert($str){

		header("content-type:text/html; charset=utf-8");

		echo "<script language = 'javascript' charset='utf-8'>";

		echo "alert(\"$str\");";

		echo "window.history.back();";

		echo "</script>";

		exit;

	}

	function alert_with_location($str,$location){

		header("content-type:text/html; charset=utf-8");

		echo "<script language = 'javascript' charset='utf-8'>";

		echo "alert(\"$str\");";

		echo $IsAll ? 'top.' : '' ;

		echo "location=\"$location\";";

		echo "</script>";

		exit;

	}

	function alert_with_session($str,$location){

		header("content-type:text/html; charset=utf-8");

		if($_POST && is_array($_POST))

		{

			$_SESSION['returnParams'] = safeArr($_POST);

		}

		echo "<script language = 'javascript' charset='utf-8'>";

		echo "alert(\"$str\");";

		echo "top.location=\"$location\";";

		echo "</script>";

		exit;

	}

	

	//$_GET

	function _get($str){

		$val = !empty($_GET[$str]) ? safeStr($_GET[$str]) : null;

		return $val;

	}

	

	//$_POST

	function _post($str){

		$val = !empty($_POST[$str]) ? safeStr($_POST[$str]) : null;

		return $val;

	}

	

	//文字處理

	function safeStr($text){

		$magic_quotes = get_magic_quotes_gpc();

		if($magic_quotes == 1){

			$text = stripslashes($text);

			$text = addslashes($text);

			$text = ereg_replace("\\\\","\\",$text);

		}else{

			$text = addslashes($text);

			$text = ereg_replace("\\\\","\\",$text);

		}

		return $text;

	}

	

	//處理文字陣列

	function safeArray($arr){

		$arr2 = array();

		if(is_array($arr)){	

			foreach($arr as $key => $value){

				if(!is_array($value))$arr2[$key] = safeStr($value);

			}

		}

		return $arr2;

	}

/*

//自訂身證檢查函數

function check_id($id) {

	$flag = false;

	$id = strtoupper($id);

	$d0 = strlen($id);

	$qd="";

	if($d0 <= 0)$qd=$qd."請填寫身分證 !\n";

	if($d0 > 10)$qd=$qd."身分證字數超過 !\n";

	if($d0 < 10 && $d0 > 0)$qd=$qd."身分證字數不足 !\n";

	$d1 = substr($id,0,1);

	$ds = ord($d1);

	if($ds > 90 || $ds < 65)$qd=$qd."身分證第一碼必須是大寫的英文字母 !\n";

	$d2 = substr($id,1,1);

	if($d2!="1" && $d2!="2")$qd=$qd."身分證第二碼有問題 !\n";

	for($i=1;$i<10;$i++){

		$d3=substr($id,$i,1);

		$ds=ord($d3);

		if($ds > 57 || $ds < 48){

			$n = $i+1;$qd=$qd."身分證第二到十碼有問題 !\n";

			break;

		}

	}

	$num = array("A" => "10","B" => "11","C" => "12","D" => "13","E" => "14",

	"F" => "15","G" => "16","H" => "17","J" => "18","K" => "19","L" => "20",

	"M" => "21","N" => "22","P" => "23","Q" => "24","R" => "25","S" => "26",

	"T" => "27","U" => "28","V" => "29","X" => "30","Y" => "31","W" => "32",

	"Z" => "33","I" => "34","O" => "35");

	$n1 = substr($num[$d1],0,1)+(substr($num[$d1],1,1)*9);

	$n2=0;

	for($j = 1;$j < 9;$j++){

		$d4 = substr($id,$j,1);

		$n2 = $n2+$d4*(9-$j);

	}

	$n3 = $n1+$n2+substr($id,9,1);

	if(($n3 % 10)!=0)$qd = $qd."不通過 !\n";

	if($qd == "")$flag = true;

	return $flag;

}

*/

	function desEncrypt($input, $key_seed){

	  //clean up input

	  $input = trim($input);

		

	  // generate a 24 byte key from the md5 of the seed

	  $key = substr(md5($key_seed),0,24);

	

	  // use 3DES and ECB mode, although ECB is not very secure

	  $iv_size = mcrypt_get_iv_size(MCRYPT_TRIPLEDES, MCRYPT_MODE_ECB);

	  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

	  

	  // encrypt

	  $encrypted_data = mcrypt_encrypt(MCRYPT_TRIPLEDES, $key, $input, MCRYPT_MODE_ECB, $iv);

	  

	  // clean up output and return base64 encoded

	  return base64_encode($encrypted_data);

	}

	function ecstart_convert_jpeg($src_file,$dst_file,$text_type,$text_image,$watermark_type,$watermark_image,$pic_width,$pic_height){

		//$src_file 來源圖片路徑

		//$dst_file 存檔圖片路徑

		//$text_type 是否插入文字

		//$text_image 插入的文字內容

		//$watermark_type 是否插入浮水印

		//$watermark_image 圖水印圖片路徑

		//$pic_width 存檔圖片寬度

		//$pic_height 存檔圖片高度

		$image = imagecreatefromjpeg($src_file) ;

		$s_width = imagesx($image);

		$s_height = imagesy($image);

	

	

		// 縮圖大小

		$thumb = imagecreatetruecolor($pic_width, $pic_height);

		// 自動縮圖

		imagecopyresized($thumb, $image, 0, 0, 0, 0, $pic_width, $pic_height, $s_width, $s_height);

		//imagejpeg($thumb,"/tmp/tmpfile.jpg","100");

		//$thumbimage = imagecreatefromjpeg("/tmp/tmpfile.jpg") ;

	

	

		// 取得寬度

		$i_width = imagesx($thumb);

		$i_height = imagesy($thumb);

	

		//imagejpeg($image,"/home/www/ecstart.com/public_html/cart/test.jpg","100");

		//imagejpeg($image);

	

		// 計算 插入文字出現位置

		$ywpos = $i_height - 35 ;

		// 設定 插入文字

		$textcolor = imagecolorallocate($thumb, 250, 250, 250);

	

		// 插入文字

		if($text_type == "Y"){

			imagestring($thumb, 5, 25, $ywpos, $text_image, $textcolor);

		}

		/*

		if($text_type == "Y"){

			$font = 'MINGLIU.TTC';//字型檔位置

			$black = imagecolorallocate($thumb, 0, 0, 0);//字型顏色

			imagettftext($thumb, 10, 0, 25, $ywpos, $black, $font ,$text_image);//產生字型 

		}	

		*/

		// 載入浮水印圖

		$w_image = imagecreatefromjpeg($watermark_image) ;

		// 取出浮水印圖 寬 與 高

		$w_width = imagesx($w_image);

		$w_height = imagesy($w_image);

		// 計算 浮水印出現位置

		$xpos = $i_width - $w_width -20 ;

		$ypos = $i_height - $w_height-20 ;

	

		//結合浮水印

		if($watermark_type == "Y"){

		imagecopy($thumb,$w_image,$xpos,$ypos,0,0,$w_width,$w_height);

		}

	

		imagejpeg($thumb,$dst_file,"100");

	

	

		imagedestroy($thumb);

		imagedestroy($image);

		imagedestroy($w_image);

	}
	
	function GPage($PItem,$Page,$AItem,$bURL,$PSS,$F='',$L=''){ #分頁FUNCTION   $PItem筆數   $Page目前頁面  $AItem所有總數量 

		$APage = intval($AItem/$PItem);if($AItem%$PItem){$APage++;}if($Page>$APage){$Page=$APage;}

		if($Page=='' || !is_numeric($Page) || $Page<=0){$Page=1;}$PageL = '';

		if($F==''&&$L==''){

			$F = "{$bURL}&Page=";

			$L = "&{$PSS}";

		}

		if($AItem>$PItem){

			$tmp = $Page - 1;

			$Page!=1?$PageL="<li><a href='{$F}{$tmp}{$L}'> < </a></li>":$PageL="<li class='disabled'><a> < </a></li>";

			$i=((int)(($Page-1)/20)*20)+1;

			if($Page>20){

				$tmp = $Page + 20;

				$PageL.="<a href='{$F}{$tmp}{$L}'> << </a>";

			}

			while($i<=$APage && $i<=((int)(($Page-1)/20)+1)*20){

				$Page==$i?$PageL.='<li class="active"><a>'.$i.'</a></li>':$PageL=$PageL." <li><a href='{$F}{$i}{$L}'>".$i."</a></li>";

				$PPage[$i] = $i;

				$i++;

			}

			if(($i+1)<$APage){

				$tmp = 1;

				$PageL.="<a href='{$F}{$tmp}{$L}'> >> </a>";

			}

			$tmp = $Page + 1;

			$PageL.="<li><a href='{$F}{$tmp}{$L}'> > </a></li>";

		}

		$Page>=$APage?$Page=$APage:$Page=$Page;if($Page==0){$Page=1;}$Str=($Page-1)*$PItem;

		return array('Str'=>$Str,'PageL'=>$PageL);

	}



?>
                						