<?php

namespace APP\Repositories;

use http\Env\Request;

class StatusRepository{

	public function __construct(){
	}

	public function account()
	{
		$label = [
			['id'=>0,'label'=>'停用'],
			['id'=>1,'label'=>'啟用'],
			['id'=>2,'label'=>'黑名單'],
		];

		foreach($label as $labelKey => $labelValue){
			$list[] = $labelValue['label'];
		}

		return ['label'=>$label,'list'=>$list];
	}//public function orderForm()

	public function userActive(){
		$label = [
			['id'=>0,'label'=>'未驗證'],
			['id'=>1,'label'=>'已驗證'],
		];

		foreach($label as $labelKey => $labelValue){
			$list[] = $labelValue['label'];
		}

		return ['label'=>$label,'list'=>$list];
	}//public function inquiry()
}