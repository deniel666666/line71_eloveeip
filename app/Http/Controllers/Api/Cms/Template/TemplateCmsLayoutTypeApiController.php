<?php
namespace App\Http\Controllers\Api\Cms\Template;

use Illuminate\Http\Request;
use File;
use \DB;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Api\Cms\Template\TemplateCmsTypeApiController;

class TemplateCmsLayoutTypeApiController extends TemplateCmsTypeApiController
{	
	protected $cms_model_name;
	protected $cms_layout_model_name;
	protected $cms_type_id_column;
	protected $use_layout_file;
	protected $cmsLayoutTypeRepository;
	protected $public_file_target;

	public function __construct(
		/*layout function*/
		$cms_model_name,
		$cms_layout_model_name,
		$cms_type_id_column,
		$use_layout_file,
		/*type function*/
        $cmsLayoutTypeRepository,
        $public_file_target
    ){
        parent::__construct(
            $cmsLayoutTypeRepository,
            $public_file_target
        );
        $this->cms_model_name 			= $cms_model_name;
        $this->cms_layout_model_name 	= $cms_layout_model_name;
        $this->cms_type_id_column		= $cms_type_id_column;
        $this->use_layout_file 			= $use_layout_file;
        $this->cmsLayoutTypeRepository 	= $cmsLayoutTypeRepository;
        $this->public_file_target 		= $public_file_target;
    }

    public function show_mother_template(Request $request){
    	$request_obj = $request->all();
    	$cmsLayoutType = $this->cmsLayoutTypeRepository->get_mother_template($this->cms_model_name,$request_obj);

		return $cmsLayoutType;
    }

    public function show_child_template(Request $request){
    	$request_obj = $request->all();
    	$cmsLayoutType = $this->cmsLayoutTypeRepository->get_child_template($request_obj);
    	$child_templates = $cmsLayoutType[0]['layout_relation'];
    	// dump($child_template);

    	return $child_templates;
    }

    public function add_mother_template(Request $request){
    	$request_obj = $request->all();

    	DB::beginTransaction();
    	try{
	    	$result = parent::typeAdd($request); /*add layout_type*/
	    	$result = (array)$result->getData();
	    	$layout_type_id = $result['id'];

	    	/*add cms to layout_type*/
	    	/*copy data*/
	    	$this->cmsLayoutTypeRepository->copy_cms_data(	
	    										$from_model			= $this->cms_model_name,
												$from_where			= [ 
																		'cms_type_id'		=> $request_obj['cms_type_id'] ,
																		'child_template_id'	=> $request_obj['child_template_id']
																	 ], 
												$to_model			= $this->cms_layout_model_name,
												$to_update			= [ 
																		'cms_type_id' => $layout_type_id,
																		'child_template_id'	=> 0 
																	],
												$child_template_id 	= 0
											);
	        /*copy img*/
	    	$origin_path = '/cms/'.$this->use_layout_file.'/'.$request_obj['cms_type_id'].'/';
	        $target_path = '/cms/'.$this->public_file_target.'/'.$layout_type_id.'/';

	        $this->copyImg($origin_path, $target_path, $child_template_id=0);

    	}catch (Exception $e){
    		DB::rollback();
    		return [ 'status' => 500, 'msg'=> $e];
    	}
    	
    	// DB::rollback();
    	DB::commit();
    	return [ 'status' => 200 ];
    }

    public function add_child_template(Request $request){
    	$request_obj = $request->all();
    	// dump($request_obj);

    	DB::beginTransaction();
    	try{
    		/*get mother template(record edit view)*/
    		$mother_template = $this->cmsLayoutTypeRepository->get_mother_template($this->cms_model_name, ['id'=>$request_obj['mother_template_id']]);
    		$edit_view = $mother_template ? $mother_template[0]['edit_view'] : "";
    		$view_view = $mother_template ? $mother_template[0]['view_view'] : "";

	    	/*add cms from layout_type*/
	    	$result = $this->cmsLayoutTypeRepository->add_layout_relation([
												'cms_type_id'	=> $request_obj['cms_type_id'], 
												'name'			=> $request_obj['name'],
												'edit_view'		=> $edit_view,
												'view_view'		=> $view_view,
	    									]);
	    	/*get child_template_id*/
	    	$child_template_id = $result['child_template_id'];

	    	/*update type child_template_id*/
	    	$request_array = [
			    'cms_type_id' 		=> $request_obj['cms_type_id'],
			    'child_template_id' => $child_template_id
			];
			$request_change = new Request($request_array);
	    	$this->switch_child_template($request_change);

	    	/*copy data*/
	    	$this->cmsLayoutTypeRepository->copy_cms_data(	
    										$from_model			= $this->cms_layout_model_name,
											$from_where			= [ 
																	'cms_type_id'		=> $request_obj['mother_template_id'],
																	'child_template_id'	=> 0
																 ], 
											$to_model			= $this->cms_model_name,
											$to_update			= [ 
																	'cms_type_id'		=> $request_obj['cms_type_id'],
																	'child_template_id' => $child_template_id,
																],
											$child_template_id 	= $child_template_id
										);
	        /*copy img*/
	    	$origin_path = '/cms/'.$this->public_file_target.'/'.$request_obj['mother_template_id'].'/';
	        $target_path = '/cms/'.$this->use_layout_file.'/'.$request_obj['cms_type_id'].'/';

	        $this->copyImg($origin_path, $target_path, $child_template_id);

    	}catch (Exception $e){
    		DB::rollback();
    		return [ 'status' => 500, 'msg'=> $e];
    	}
    	
    	// DB::rollback();
    	DB::commit();
    	return [ 'status' => 200 ];
    }

    public function switch_child_template(Request $request){
    	$cms_type_id = $request->get('cms_type_id');
    	$update['child_template_id'] = $request->get('child_template_id');
    	$this->cmsLayoutTypeRepository->update_cmstype($this->cms_type_id_column, $cms_type_id, $update);

    	return [ 'status' => 200 ];
    }

    public function delete_child_tmplate(Request $request){
    	$cms_type_id = $request->get('cms_type_id');
    	$delete_child_template_id = $request->get('child_template_id');

    	if($delete_child_template_id!=0){
    		DB::beginTransaction();

	    	/*刪除子模板紀錄*/
	    	$this->cmsLayoutTypeRepository->delete_layout_relation($cms_type_id, $delete_child_template_id);

	    	/*取得此cms type當前的子模板id*/    	
	    	$cmsType = $this->cmsLayoutTypeRepository->get_cmstype([$this->cms_type_id_column=>$cms_type_id]);
	    	$current_child_template_id = $cmsType[0]['child_template_id'];

	    	/*判斷當前子模板id是否為本次要刪除的id*/
	    	if($current_child_template_id == $delete_child_template_id){
		    	/*更新此模板的子模板id成0(預設)*/
		    	$update['child_template_id'] = 0;
		    	$this->cmsLayoutTypeRepository->update_cmstype( $this->cms_type_id_column, $cms_type_id, $update);
	    	}

	    	DB::commit();
	    	return ['status'=> 200];

	    }else{
	    	return ['status'=> 500, 'msg'=>'無法刪除預設模板'];
	    }
    }

    public function copyImg($origin_path, $target_path, $child_template_id){
    	$disk  = Storage::disk('upload');
    	$files = $disk->allFiles($origin_path);

        if (!$disk->exists($target_path)) {
            $disk->makeDirectory($target_path);
            chmod($disk->path($target_path), 0755);
        }

        foreach ($files as $key => $file) {
    		$file_explode = explode('/', $file);
    		$file_name = end($file_explode);
    		$disk->copy( $origin_path.'/'.$file_name, $target_path.'/'.$child_template_id.'_'.$file_name);
    	}

        
    }
}