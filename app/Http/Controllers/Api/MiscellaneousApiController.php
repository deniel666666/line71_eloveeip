<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\MiscellaneousRepository;

use App\Services\FileService;

class MiscellaneousApiController extends Controller
{
	private $miscellaneousRepository;
	public function __construct(MiscellaneousRepository $miscellaneousRepository)
	{
		$this->miscellaneousRepository = $miscellaneousRepository;
	}

	public function show(Request $request){
		$miscId 	= $request->input('miscId');
		$res = $this->miscellaneousRepository->show($miscId);
		$data = [
			'status'	=> '200',
			'consent' 	=> $res['misc_value']
		];
		return response()->json($data);
	}//public function show()

	public function update(Request $request){
		$miscId		= $request->input('miscId');
		$consent	= $request->input('consent');

		if(!empty($consent)){ /* 處理編輯器內容 */      
            // foreach($item as $cmsKey => $cmsValue){
                $dom = new \domdocument();
                $dom->loadHtml(mb_convert_encoding($consent,'HTML-ENTITIES','UTF-8'));
                // $dom->loadHtml(mb_convert_encoding($consent,'HTML-ENTITIES','UTF-8'),LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                $images = $dom->getelementsbytagname('img');
                foreach($images as $k => $img){
                    $base64file = $img->getattribute('src');
                    $fileName   = $img->getattribute('data-filename');

                    if ($fileName != ''){
                        $ext = explode('.', $fileName);
                        $ext = end($ext);
                        $fileName = sha1(uniqid(time(), true)) . '.' . $ext;
                        $file = FileService::base64Store($base64file, 'upload','miscellaneous/'.$miscId, $fileName);

                        $img->removeattribute('src');
                        $img->removeattribute('data-filename');
                        $img->setattribute('src', '/public/upload/miscellaneous/'.$miscId.'/'.$fileName);
                    }//if
                }//foreach

                $detail = $dom->savehtml($dom);
                $consent = $detail;
            // }//foreach
        }
        $updData['misc_value'] = $consent;

		$res = $this->miscellaneousRepository->update($miscId,$updData);
		$data = [
			'res'   => $res,
			'status'=> 200
		];
		return response()->json($data);
	}//public function update()
}

