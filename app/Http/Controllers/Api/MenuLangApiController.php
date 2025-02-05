<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repositories\MenuLangRepository;
use App\Helpers\AppHelper;

class MenuLangApiController extends Controller
{
    protected $menuLangRepository;

	public function __construct(MenuLangRepository $menuLangRepository){
		$this->menuLangRepository = $menuLangRepository;
    }
    public function show(Request $request){
        $selectLangItem = $request->get('selectLangItem');
        $searchByText = $request->get('searchByText');
		$currentPage	= $request->get('currentPage');
        $countLangOfPage	= $request->get('countLangOfPage');
        $lang = $this->menuLangRepository->getLang();
        if($selectLangItem == 0){
            $countLangOfPage =  $countLangOfPage *count($lang);
          
        } 
          $startIndex = $currentPage * $countLangOfPage - $countLangOfPage;


        
        $getMenuCode = $this->menuLangRepository->searchMenuCodeByName($searchByText);
        $menuLang = $this->menuLangRepository->getMenuLang($getMenuCode,$startIndex,$countLangOfPage, $selectLangItem);
        $menuLangCount = $this->menuLangRepository->count($getMenuCode);

        
        if($selectLangItem == 0){
            $pageCount = (int)($menuLangCount/$countLangOfPage);

        }else{
            $pageCount = (int)($menuLangCount/$countLangOfPage/count($lang));

        }
        
		if($menuLangCount%$countLangOfPage != 0){
			$pageCount +=1;
        }
        $langs = AppHelper::instance()->getAllLangs();
		$data = [
            'status'=> 200,
            'itemsCount' => $menuLangCount,
            'pageCount' => $pageCount,
            'lang' => $lang,
            'langs'=>$langs,
            'items' => $menuLang,
		];
		return $data;
    }
    
    public function add(Request $request){
        $menuLang = $request->get('menuLang');
        $menuLangOrder = $request->get('order');
        $menuLangColor = $request->get('color');
        $getLastMenuCode = $this->menuLangRepository->getLastMuneCode();
        $menuCode =  (int)($getLastMenuCode['menu_code']);
        $menuCode ++;
		$this->menuLangRepository->add($menuLang,$menuLangColor,$menuLangOrder,$menuCode );
		$data = [
			'status'=> 200,
		];
		return $data;
    }

    public function edit(Request $request){
        $menu_lang_id = $request->input('menu_lang_id');
        $updDataOne['menu_name'] = $request->input('menu_name');
        $this->menuLangRepository->editMenuName($menu_lang_id,$updDataOne);

        $menu_code = $request->input('menu_code');
        $updDataAll['menu_color'] = $request->input('menu_color');
        $updDataAll['menu_lang_order'] = $request->input('menu_lang_order');
         $this->menuLangRepository->editMenuColorNOrder($menu_code,$updDataAll);

		$data = [
			'status'=> 200,
		];
		return $data;
    }

    public function delete(Request $request){
        $menu_code = $request->input('code');
        $this->menuLangRepository->delete($menu_code);
		$data = [
			'status'=> 200,
		];
		return $data;
    }
    
    public function test(Request $request){
        $getMenuCode = $this->menuLangRepository->searchMenuCodeByName('');
        $menuLangCount = $this->menuLangRepository->getMenuLang($getMenuCode,0,6);
        $data = [
            'status'=> 200,
            'aa' =>$menuLangCount 
		];
		return $data;
    }
}
