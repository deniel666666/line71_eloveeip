<?php
namespace App\Repositories\Cms\Template;

use App\Repositories\Cms\Template\CmsTypeTemplateRepository;

class TemplateCmsLayoutTypeRepository extends CmsTypeTemplateRepository
{
	protected $cmsTypeModel;
	protected $cmsModel;
	protected $cmsLayoutModel;
	protected $cmsLayoutRelationModel;
    protected $type_primaryKey;
    protected $type_order_column;
    protected $cmsLayoutTypeModel;
    protected $layout_type_primaryKey;
	protected $layout_type_order_column;

	public function __construct(
		/*layout function*/
		$cmsTypeModel,
		$cmsModel,
		$cmsLayoutModel,
		$cmsLayoutRelationModel,
        $type_primaryKey,
        $type_order_column,

		/*type function*/
        $cmsLayoutTypeModel,
        $layout_type_primaryKey,
        $layout_type_order_column
    ){  
        /*type function*/
        parent::__construct(
            $cmsLayoutTypeModel,
            $layout_type_primaryKey,
            $layout_type_order_column
        );

        /*layout function*/
        $this->cmsTypeModel				= $cmsTypeModel;
        $this->cmsModel 				= $cmsModel;
        $this->cmsLayoutModel 			= $cmsLayoutModel;
        $this->cmsLayoutRelationModel 	= $cmsLayoutRelationModel;
        $this->type_primaryKey          = $type_primaryKey;
        $this->type_order_column        = $type_order_column;

        $this->cmsLayoutTypeModel       = $cmsLayoutTypeModel;
    }

    /*-----------------------------*/
    /*layout function--------------*/
    /*-----------------------------*/
    public function get_mother_template($cms_model_name,$cond){
        $cms_table_name = $this->$cms_model_name->getTable();
        $layout_table_name = $cms_table_name.'_layout';
        $layout_type_table_name = $cms_table_name.'_layout_type';
    	$cmsTypes = $this->cmsLayoutTypeModel->select(
                                                $layout_type_table_name.'.id',
                                                $layout_type_table_name.'.cont_type',
                                                $layout_type_table_name.'.cms_type_name',
                                                $layout_type_table_name.'.cate_order',
                                                $layout_type_table_name.'.lang_id',
                                                $layout_type_table_name.'.edit_view',
                                                $layout_type_table_name.'.view_view'
                                            )
                                            ->rightJoin($layout_table_name, $layout_table_name.'.cms_type_id', '=', $layout_type_table_name.'.id');

    	if(isset($cond['cms_type_id'])){
    		if($cond['cms_type_id']!=''){ $cmsTypes->where('id','=',$cond['cms_type_id']); }
    	}
    	if(isset($cond['selectLangItem'])){
    		if($cond['selectLangItem']!=''){ $cmsTypes->where('lang_id','=',$cond['selectLangItem']); }
    	}
        if(isset($cond['id'])){
            if($cond['id']!=''){ $cmsTypes->where('id','=',$cond['id']); }
        }

    	return $cmsTypes->orderBy('cate_order','asc')->orderBy('id','desc')
                ->groupBy($layout_type_table_name.'.id')
                ->groupBy($layout_type_table_name.'.cont_type')
                ->groupBy($layout_type_table_name.'.cms_type_name')
                ->groupBy($layout_type_table_name.'.cate_order')
                ->groupBy($layout_type_table_name.'.lang_id')
                ->groupBy($layout_type_table_name.'.edit_view')
                ->groupBy($layout_type_table_name.'.view_view')
                ->get()->toArray();
    }
    public function get_child_template($cond){
    	$cmsTypes = $this->cmsTypeModel::with(['layout_relation']);

    	if(isset($cond['cms_type_id'])){
    		if($cond['cms_type_id']!=''){ $cmsTypes->where($this->type_primaryKey,'=',$cond['cms_type_id']); }
    	}

    	return $cmsTypes->orderBy($this->type_order_column,'asc')->orderBy($this->type_primaryKey,'desc')->get()->toArray();
    }


    public function copy_cms_data($from_model, $from_where, $to_model, $to_update, $child_template_id){
        $cms = $this->$from_model;
        $from_model_table = $cms->getTable();
        $to_model_table = $this->$to_model->getTable();
        foreach ($from_where as $key => $value) {
            $cms = $cms->where($key,'=',$value);
        }
    	$cms = $cms->get()->toArray();

		foreach($cms as $k => $v){
			unset($v['cms_id']);
			unset($v['created_at']);
			unset($v['updated_at']);

            /*避免圖片檔名加上子模板id 避免檔名重複*/
            $v['cms_img'] = $v['cms_img'] ?  $child_template_id.'_'.$v['cms_img'] : $v['cms_img'];
            $v['content'] = json_decode($v['content'], true);

            /* 處理編輯器內容 */
            $text = $v['content']['cont']['text'];
            if(!empty($text)){ 
                $dom = new \domdocument();
                $dom->loadHtml(mb_convert_encoding($text,'HTML-ENTITIES','UTF-8'));
                // $dom->loadHtml(mb_convert_encoding($text,'HTML-ENTITIES','UTF-8'),LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                $images = $dom->getelementsbytagname('img');
                foreach($images as $k => $img){
                    $fileName = $img->getattribute('src');
                    if ($fileName != ''){
                        $paths = explode('/', $fileName);
                        $pre_path = array_slice($paths, 0, -1);
                        $pre_path = implode('/', $pre_path);
                        $fileName = end($paths);
                        $fileName = $pre_path.'/'.$child_template_id.'_'.$fileName;
                        $fileName = str_replace($from_model_table, $to_model_table, $fileName);
                        $img->removeattribute('src');
                        $img->setattribute('src', $fileName);
                    }//if
                }//foreach

                $detail = $dom->savehtml($dom);
                $v['content']['cont']['text'] = $detail;
            }

            // 處理 template的參數
            if(isset($v['content']['template'])){
                $template = $v['content']['template'];
                $template_keys = array_keys($template);
                foreach ($template_keys as $key) {
                    if( preg_match("/^pic_/", $key) ) { // 處理圖片
                        $fileName = $template[$key];
                        if ($fileName != ''){
                            $template[$key] = $child_template_id.'_'.$fileName;
                        }//if
                    }

                    if( preg_match("/^content_/", $key) ){ // 處理編輯器
                        if(!empty($template[$key])){ /* 處理編輯器內容 */
                            $dom = new \domdocument();
                            $dom->loadHtml(mb_convert_encoding($template[$key],'HTML-ENTITIES','UTF-8'));
                            // $dom->loadHtml(mb_convert_encoding($template[$key],'HTML-ENTITIES','UTF-8'),LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                            $images = $dom->getelementsbytagname('img');
                            foreach($images as $k => $img){
                                $fileName = $img->getattribute('src');
                                if ($fileName != ''){
                                    $paths = explode('/', $fileName);
                                    $pre_path = array_slice($paths, 0, -1);
                                    $pre_path = implode('/', $pre_path);
                                    $fileName = end($paths);
                                    $fileName = $pre_path.'/'.$child_template_id.'_'.$fileName;
                                    $fileName = str_replace($from_model_table, $to_model_table, $fileName);
                                    $img->removeattribute('src');
                                    $img->setattribute('src', $fileName);
                                }//if
                            }//foreach
                            $detail = $dom->savehtml($dom);
                            $template[$key] = $detail;
                        }
                    }
                }

                $v['content']['template'] = $template;
            }

			foreach ($to_update as $key => $value) {
				$v[ $key ] = $value;
			}
            $v['content'] = json_encode($v['content'], JSON_UNESCAPED_UNICODE);
			$this->$to_model->create($v);
        }
    }


    public function add_layout_relation($data){
    	return $this->cmsLayoutRelationModel->create($data);
    }


    public function update_cmstype($type_id_column, $type_id, $update){
    	$this->cmsTypeModel->where($type_id_column, '=', $type_id)->update($update);
    }


    public function get_cmstype($cond){
        $res = $this->cmsTypeModel->where($this->type_primaryKey, '=', $cond[$this->type_primaryKey]);
        return $res->get()->toArray();
    }
    public function delete_layout_relation($cms_type_id, $child_template_id){
        $this->cmsLayoutRelationModel->where('cms_type_id', '=', $cms_type_id)
                                    ->where('child_template_id', '=', $child_template_id)
                                    ->delete();
    }
}