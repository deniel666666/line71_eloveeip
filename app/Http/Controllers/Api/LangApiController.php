<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repositories\LangRepository;

class LangApiController extends Controller
{
    protected $langRepository;

	public function __construct(LangRepository $langRepository){
		$this->langRepository = $langRepository;
	}
    
    public function index(Request $request){
        $lang = $this->langRepository->getLang();
        $data = [
            'status' => '200',
            'langs' => $lang
        ];
        return response()->json($data);
    }

    public function update(Request $request){
        $getId = $request->input('lang_id');
        $updData['lang_status'] = $request->input('lang_status');
        $lang = $this->langRepository->update($getId,$updData);
        $data = [
            'status' => '200'
        ];
        return response()->json($data);
    }
    public function add(Request $request){
        $type= $request->get('type');
        $word= $request->get('word');
        $color= $request->get('color');
        $order= $request->get('order');

        
        $lang = $this->langRepository->add($type,$word,$color,$order);
        $data = [
            'status' => '200'
        ];
        return response()->json($data);
    }
}
