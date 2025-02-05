<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\CategoryTagApiController;




class AllPagesController extends Controller{

    public function __construct(
		CategoryTagApiController	$categoryTagApiController
	){
		$this->categoryTagApiController		= $categoryTagApiController;		
    }
    
    public function menu($product_num){
		$showMaxNum =10000;// page show num
		$stratPage =1;// start page
        return  $this->categoryTagApiController->ClientShowId_phpAPI( $product_num,1,null,$stratPage,$showMaxNum , 1); 
        
	}

	
	public function prodNextPrevious($prodId ,$prodAllArr){
        $proKey = 0; 
        $nextProId=null; $previousProId=null; 
        foreach ($prodAllArr['items'] as $key => $prod ){
            if($prod['prod_id']== $prodId){
                $proKey =$key;
            }
        }
        if( !empty($prodAllArr['items'][$proKey-1])   ){
            $previousProId  = $prodAllArr['items'][$proKey-1];
        }
        if( !empty($prodAllArr['items'][$proKey+1])   ){
            $nextProId      = $prodAllArr['items'][$proKey+1];
        }
        $data=[
            'previousPro'       =>$previousProId,
            'nextPro'           =>$nextProId,
        ];
        return $data;
    }
}

