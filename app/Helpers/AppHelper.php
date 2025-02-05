<?php
namespace App\Helpers;

use App\Models\LangModel;
use App\Models\Member\MemberTypeRelationModel;
use App\Repositories\SeoRepository;

use \DB;
use Illuminate\Support\Facades\File;

class AppHelper
{
    protected $seoRepository;
    public function __construct(SeoRepository $seoRepository)
    {
        $this->seoRepository = $seoRepository;
    }

    public static function instance(){
        $seoRepository = new SeoRepository();
        return new AppHelper($seoRepository);
    }

    public  function getAllLangs(){
        return LangModel::where('lang_status','=',1)->orderBy('lang_order', 'asc')->get();
    }

    public  function getAllLangsByOrder(){
        return LangModel::orderBy('lang_order', 'asc')->get();
    }

    public  function geraHash($qtd){
        $Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
        $QuantidadeCaracteres = strlen($Caracteres);
        $QuantidadeCaracteres--;
        $Hash=NULL;
        for($x=1;$x<=$qtd;$x++){
            $Posicao = rand(0,$QuantidadeCaracteres);
            $Hash .= substr($Caracteres,$Posicao,1);
        }
        return $Hash;
    }

    public function renameFile($file, $fileName=""){
        $t=time();
        $gethash = $this->geraHash(8);
        $getType = explode(";",$file)[0];
        $getType = explode("/",$getType)[1];
        $ext = explode('.', $getType);
        $ext = end($ext);
        if($ext=='sheet'){
            $ext = 'xlsx';
        }elseif($ext=='document'){
            $ext = 'docx';
        }else{
            $ext = $getType;
        }
        $fileName = $fileName=="" ? $t.$gethash.'.'.$ext : $fileName.'_'.$t.$gethash.'.'.$ext;
        return $fileName;
    }

    public function uploadFile($path, $fileName, $file){
        $filePath = base_path().$path.'/'.$fileName;
        $fileData = substr($file,strpos($file,",") + 1);
        $decodedData = base64_decode($fileData);
		file_put_contents($filePath, $decodedData);
    }

    public function deleteImg($path){
        $file = explode('/', $path);
        $file = end($file);
        if(!$file){
            return;
        }
		if (file_exists($path)) {
			unlink($path);
		}
	}
    public function clean_cms_img_with_id($cms_table, $cms_type, $cms_type_id){
        $cms_dir = $_SERVER['DOCUMENT_ROOT'].'/public/upload/cms/'.$cms_type;

        $datas = DB::table($cms_table)->where('cms_type_id', '=', $cms_type_id)->get()->toArray();
        $in_use_img = [];
        foreach ($datas as $k => $v) {
            if($v->cms_img){
                array_push($in_use_img, $v->cms_img);
            }
            $item = json_decode($v->content, true);
            // dump($item);
            if($item['cont']['text']){
                $dom = new \domdocument();
                $dom->loadHtml(mb_convert_encoding($item['cont']['text'],'HTML-ENTITIES','UTF-8'));
                $images = $dom->getelementsbytagname('img');
                foreach($images as $k => $img){
                    $url    = $img->getattribute('src');
                    $img_name = explode('/', $url);
                    $img_name = end($img_name);
                    array_push($in_use_img, $img_name);
                }//foreach
            }
            if(isset($item['template'])){
                $template_keys = array_keys($item['template']);
                // dump($template_keys);
                foreach ($template_keys as $key) {
                    if( preg_match("/^pic_/", $key) ) { // 處理圖片
                        array_push($in_use_img, $item['template'][$key]);
                    }
                }
            }
            if(isset($item['pics'])){
                $in_use_img = array_merge($in_use_img, $item['pics']);
            }
        }
        // dump($in_use_img);
        $dir = $cms_dir.'/'.$cms_type_id;
        if (is_dir($dir)){
            $myfiles = scandir($dir);
            $myfiles = array_slice($myfiles, 2);
            foreach ($myfiles as $key => $filename) {
                if(!in_array($filename, $in_use_img)){
                    $path = $dir.'/'.$filename;
                    unlink($path);
                }
            }
        }
    }
    public function rrmdir($dir){
        if (is_dir($dir)){
            $objects = scandir($dir);
            foreach ($objects as $object){
                if ($object != '.' && $object != '..'){
                    if (filetype($dir.'/'.$object) == 'dir') {rrmdir($dir.'/'.$object);}
                    else {unlink($dir.'/'.$object);}
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public function arrange_date_time($date){
        // dump($date);
        preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}:[0-9]{2}/', $date, $date_time);
        preg_match('/\.[0-9]{3}Z/', $date, $time_zon);
        // dump($date_time,$time_zon);
        if ($date_time && $time_zon) { /* 2020-11-02T16:00:00.000Z */
            if($time_zon[0]=='.000Z'){
                $date_time = str_replace('T', ' ', $date_time[0]);
                $date = strtotime( $date_time.' + 8hours');
                $date = date('Y-m-d',$date);
            }
        }
        return $date;
    }

    /*取得SEO內容*/
    public function get_seo_data(){
        $routeData = app('request')->route()->getAction();
        // dump($routeData);
        $langId = isset($routeData['langeId']) ? $routeData['langeId'] : 1;
        $seo = $this->seoRepository->getOne($langId)->toArray();
        $seo['host_url'] = $_SERVER['HTTP_HOST'];
        return $seo;
    }

    /*發送請求*/
    public function http_request($url, $data=null, $headers=null){
        $curl = curl_init();  
        curl_setopt($curl, CURLOPT_URL, $url);  
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (! empty($data)) {  
            curl_setopt($curl, CURLOPT_POST, 1);  
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);
        }  
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        if($headers){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /*取得連線ip*/
    public function get_clinet_ip(){
        $ips = [];
        if (!empty($_SERVER["HTTP_CLIENT_IP"])){
            array_push($ips,$_SERVER["HTTP_CLIENT_IP"]);
        }else{
            if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
                array_push($ips,$_SERVER["HTTP_X_FORWARDED_FOR"]);
            }else{
                if(!empty($_SERVER["HTTP_X_FORWARDED"])){
                    array_push($ips,$_SERVER["HTTP_X_FORWARDED"]);
                }else{
                    if(!empty($_SERVER["HTTP_X_CLUSTER_CLIENT_IP"])){
                        array_push($ips,$_SERVER["HTTP_X_CLUSTER_CLIENT_IP"]);
                    }else{
                        if(!empty($_SERVER["HTTP_FORWARDED_FOR"])){
                            array_push($ips,$_SERVER["HTTP_FORWARDED_FOR"]);
                        }else{
                            if(!empty($_SERVER["HTTP_FORWARDED"])){
                                array_push($ips,$_SERVER["HTTP_FORWARDED"]);
                            }else{
                                if(!empty($_SERVER["REMOTE_ADDR"])){ /*(真實 IP 或是 Proxy IP)*/
                                    array_push($ips,$_SERVER["REMOTE_ADDR"]);
                                }else{
                                    if(!empty($_SERVER["HTTP_VIA"])){ /*(參考經過的 Proxy)*/
                                        array_push($ips,$_SERVER["HTTP_VIA"]);
                                    }else{
                                        array_push($ips,'');
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $ip = join('/', $ips);
        return $ip;
    }

    /*文字星號隱藏*/
    public function hidestr($string, $start = 0, $length = 0, $re = '*') {
        if (empty($string)) return false;
        $strarr = array();
        $mb_strlen = mb_strlen($string);
        while ($mb_strlen) {//循环把字符串变为数组
            $strarr[] = mb_substr($string, 0, 1, 'utf8');
            $string = mb_substr($string, 1, $mb_strlen, 'utf8');
            $mb_strlen = mb_strlen($string);
        }
        $strlen = count($strarr);
        $begin  = $start >= 0 ? $start : ($strlen - abs($start));
        $end    = $last   = $strlen - 1;
        if ($length > 0) {
            $end  = $begin + $length - 1;
        } elseif ($length < 0) {
            $end -= abs($length);
        }
        if($end > $last){
            $end = $last;
        }
        for ($i=$begin; $i<=$end; $i++) {
            $strarr[$i] = $re;
        }

        // if ($begin >= $last || $end > $last) return false;
        return implode('', $strarr);
    }

    /*取得會員購買方案*/
    public function getMemberTypes($memberId, $timeToStr=true) {
        $memberTypes = MemberTypeRelationModel::where('user_id', '=', $memberId)
                        ->where('online', '=', '1')
                        ->orderBy('start_time', 'desc') // 最晚開始
                        ->orderBy('end_time', 'desc')   // 最晚結束
                        ->get()->toArray();
        if($timeToStr){
            array_walk($memberTypes, function($item,$key)use(&$memberTypes){
                $memberTypes[$key]['days'] = date_diff( date_create($item['start_time']), date_create($item['end_time']))->days + 1;
            });
        }
        return $memberTypes;
    }
    /*依方案找出當前適用的方案並回傳會員資料*/
    public function getArrangedMemberTypes($member, $memberTypes){
        $current = time();
        foreach ($memberTypes as $value) { // 最晚開始、最晚結束的順序逐個方案檢查
            $start_time = strtotime($value['start_time']);
            $end_time   = strtotime($value['end_time'].' +1Day');
            if( $start_time<= $current && $current< $end_time){ //如果目前適用此方案
                $member['type'] = $value['type'];
                if($value['type']=="A"){
                    $member['show_shop_link'] = ""; // 方案是A則一律把顯示購物車連結設為空
                }else{
                    $member['show_shop_link'] = $member['shop_link']; // 其他方案則依設定顯示購物車連結
                }
                break;
            }
        }
        if(!isset($member['type'])){
            $member['type'] = "";
            $member['show_shop_link'] = "";
        }
        return $member;
    }

    /*複製檔案*/
    static public function copyFolder($source, $destination)
    {
        $source = base_path().$source;
        if (!is_dir($source)) {
            throw new Exception("來源資料夾不存在：{$source}");
        }

        // 如果目標資料夾不存在，建立它
        $destination = base_path().$destination;
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        // 遍歷來源資料夾
        foreach (scandir($source) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $srcPath = $source . DIRECTORY_SEPARATOR . $file;
            $destPath = $destination . DIRECTORY_SEPARATOR . $file;

            if (is_dir($srcPath)) {
                // 遞迴處理子資料夾
                copyFolder($srcPath, $destPath);
            } else {
                // 複製檔案
                copy($srcPath, $destPath);
            }
        }
    }
}