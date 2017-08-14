<?

//===============================

//開啟緩衝區 && SESSION

//===============================

ob_start();

session_start();

//===============================

//主機 & 網站 設定

//===============================

ini_set('register_globals','off');

ini_set('display_errors','off');

ini_set('default_charset','utf-8');

date_default_timezone_set("Asia/Taipei");

$driname = dirname(__FILE__);

//===============================

//資料庫 設定

//===============================

require_once($driname."/mmhClass.php");

$mysql = new mysql();

//$mysql->user = "uxweeken_flower";
//
//$mysql->passwd = "Flower16**";
//
//$mysql->db = "uxweeken_flower";

$mysql->user = "fufuk_uxweekend";

$mysql->passwd = "uxweekend";

$mysql->db = "fufuk_uxweekend";

$mysql->connect();



//===============================j

//SMARTY樣板

//===============================
/*
require_once($driname."/smarty/Smarty.class.php");

$smarty = new Smarty;

//$smarty->template_dir = "html";

$smarty->compile_dir = $driname."/smarty/compile";

$smarty->config_dir = $driname."/smarty/config";

$smarty->cache_dir = $driname."/smarty/cache";

$smarty->caching = 1;//每一之程式個別設定cache_lefttime(set to 1 統一快取時間,2為個別設定時間)

$smarty->caching = false;

$smarty->use_sub_dirs = !ini_get('safe_mode');//compile cach目錄會開子目錄 效能好

$smarty->cache_lifetime = 15;

//$smarty->force_compile = 1;//強制compile

$smarty->compile_check = true;//樣板有變動才compile

$smarty->compile_id = $_SERVER['SERVER_NAME'];

$smarty->left_delimiter = '<{';

$smarty->right_delimiter = '}>';

#$smarty->assign("PHP_SELF",PHP_SELF);

//===============================

//圖片位置宣告

//===============================

define('MyPic','/pic/');

define('PicRoot',$driname.'/../../pic/');

?>
*/