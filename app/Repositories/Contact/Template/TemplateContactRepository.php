<?php

namespace App\Repositories\Contact\Template;

class TemplateContactRepository
{
	protected $contactItemModel;
	protected $contactModel;
	protected $contactTypeModel;
	protected $memberId;

	public function __construct(
		$contactItemModel,
		$contactModel,
		$contactTypeModel,
		$memberId
	){
		$this->contactItemModel = $contactItemModel;
		$this->contactModel 	= $contactModel;
		$this->contactTypeModel = $contactTypeModel;

		/*套用會員功能*/
		$this->memberId 		= $memberId;
	}

	public function getContactType(){
		$contactType = $this->contactTypeModel->get();
		return $contactType->toArray();
	}

	public function getContactTypeByTypeId($contactTypeId){
		$contactType = $this->contactTypeModel->where('conta_type_id','=',$contactTypeId)->first();
		if($contactType){
			return $contactType->toArray();
		}else{
			return $contactType;
		}
	}

	public function getContactItem($contactTypeId,$langId,$contaItemId=false, $request=false){
		$contactItems = $this->contactItemModel->with(['lang']);

		if($contactTypeId){
			$contactItems = $contactItems->where('conta_type_id','=',$contactTypeId);
		}
		if($contaItemId){
			$contactItems = $contactItems->where('conta_item_id','=',$contaItemId);
		}
		if($langId){
			$contactItems = $contactItems->where('lang_id','=',$langId);
		}

		/*套用會員功能*/
		if($this->memberId){
			$contactItems = $contactItems->where('member_id','=',$this->memberId);
		}
		if($request){
			if($request->get('memberId')){
				$contactItems = $contactItems->where('member_id','=',$request->get('memberId'));
			}
		}

		return $contactItems->get()->toArray();
	}

	public function getContact($cond){
		$res = $this->contactModel->with(['contactItem']);
		$res = $this->deal_where_sql($res, $cond);

		if(isset($cond['countOfPage'])){
			if($cond['countOfPage']!='' && $cond['countOfPage']!=0){
				$res->offset($cond['startIndex']);
				$res->limit($cond['countOfPage']); 
			}
		}
		return $res->orderBy('conta_id','desc')->get();
	}
	public function count($cond){
		$res = $this->contactModel->with([]);
		$res = $this->deal_where_sql($res, $cond);
		return $res->count();
	}
	public function deal_where_sql($use_model,$cond){
		if(isset($cond['contactTypeId'])){
			if($cond['contactTypeId'] !=''){ $use_model->where('conta_type_id', '=', $cond['contactTypeId']); }
		}
		if(isset($cond['langId'])){
			if($cond['langId'] !=''){ $use_model->where('lang_id', '=', $cond['langId']); }
		}
		if(isset($cond['contactStatus'])){
			if($cond['contactStatus'] ==5){ /*只顯示 打開以後&不在垃圾筒的*/
				$use_model->where('contact_status', '!=', 3)
						->where('contact_status', '!=', 0); 
			}else if($cond['contactStatus'] ==4){ $use_model->where('contact_status', '!=', 3); } /*全部 排除垃圾桶*/
			else if($cond['contactStatus'] !=''){ $use_model->where('contact_status', '=', $cond['contactStatus']); }
		}
		if(isset($cond['searchByContaItemId'])){
			if($cond['searchByContaItemId'] !=''){ $use_model->where('conta_item_id', '=', $cond['searchByContaItemId']); }
		}
		if(isset($cond['searchByText'])){
			if($cond['searchByText'] !=''){ 
				$use_model->where(function ($query) use ($cond) {
					$query->orWhere('conta_name', 'like', '%'.$cond['searchByText'].'%')
						->orWhere('conta_phone', 'like', '%'.$cond['searchByText'].'%')
						->orWhere('conta_email', 'like', '%'.$cond['searchByText'].'%')
						->orWhere('conta_cont', 'like', '%'.$cond['searchByText'].'%');
				}); 
			}
		}

		if(isset($cond['searchonline_class'])){
			if($cond['searchonline_class'] !=''){ $use_model->where('online_class', 'like', '%'.$cond['searchonline_class'].'%'); }
		}
		if(isset($cond['searchonline_type'])){
			if($cond['searchonline_type'] !=''){ $use_model->where('online_type', 'like', '%'.$cond['searchonline_type'].'%'); }
		}
		if(isset($cond['searchonline_text'])){
			if($cond['searchonline_text'] !=''){ $use_model->where('online_text', 'like', '%'.$cond['searchonline_text'].'%'); }
		}
		if(isset($cond['searchonline_date_s'])){
			if($cond['searchonline_date_s']){
				$cond['searchonline_date_s'] = str_replace('/', '-', $cond['searchonline_date_s']);
				$cond['searchonline_date_s'] = explode('T', $cond['searchonline_date_s'])[0].' 00:00:00';
				if($cond['searchonline_date_s'] !=''){ $use_model->where('conta_datetime', '>=', $cond['searchonline_date_s']); }
			}
		}
		if(isset($cond['searchonline_date_e'])){
			if($cond['searchonline_date_e']){
				$cond['searchonline_date_e'] = str_replace('/', '-', $cond['searchonline_date_e']);
				$cond['searchonline_date_e'] = explode('T', $cond['searchonline_date_e'])[0].' 23:59:59';
				if($cond['searchonline_date_e'] !=''){ $use_model->where('conta_datetime', '<=', $cond['searchonline_date_e']); }
			}
		}

		/*套用會員功能*/
		if($this->memberId){
			$use_model = $use_model->where('member_id','=',$this->memberId);
		}
		if(isset($cond['memberId'])){
			$use_model = $use_model->where('member_id','=',$cond['memberId']);
		}

		return $use_model;
	}

	public function getOneContact($contactId){
		$res = $this->contactModel->with(['contactType','contactItem','lang'])->where('conta_id','=',$contactId)->first();
		if($res->contact_status == 0){
			$res1 = $this->contactModel->where('conta_id','=',$contactId)->update(	['contact_status' => 1]);
		}
		return $res;
	}

	public function addContact($insertData){
		$new = $this->contactModel->create($insertData);
		return $new;
	}

	public function update($contactId,$updData){
		$res = $this->contactModel->where('conta_id','=',$contactId);

		/*套用會員功能*/
		if($this->memberId){
			$res = $res->where('member_id','=',$this->memberId);
		}
		return $res->update($updData);
	}

	public function updateNomalToTrash($contactIds){
		$res = $this->contactModel->whereIn('conta_id',$contactIds);

		/*套用會員功能*/
		if($this->memberId){
			$res = $res->where('member_id','=',$this->memberId);
		}
		return $res->update( ['contact_status' => 3] );
	}

	public function delete($contactIds){
		$res = $this->contactModel->whereIn('conta_id',$contactIds);
		
		/*套用會員功能*/
		if($this->memberId){
			$res = $res->where('member_id','=',$this->memberId);
		}
		return $res->delete();
	}

	public function addContactItem($contactTypeId, $contactItemName,$langId){
		$createData = [
			'conta_type_id'			=> $contactTypeId,
			'conta_item_name' 		=> $contactItemName,
			'lang_id' 				=> $langId,
			'conta_item_status' 	=> '1',
		];
		/*套用會員功能*/
		if($this->memberId){
			$createData['member_id'] = $this->memberId;
		}
		// dump($createData);
		$this->contactItemModel->create($createData);

		$contactItems = $this->getContactItem($contactTypeId,$langId=false);
		return $contactItems;
	}

	public function updateContactItem($contactTypeId,$contaItemId, $updateItem){
		$res = $this->contactItemModel->where('conta_item_id','=',$contaItemId);
		/*套用會員功能*/
		if($this->memberId){
			$res = $res->where('member_id','=',$this->memberId);
		}
		$res->update($updateItem);

		$contactItems = $this->getContactItem($contactTypeId,$langId=false);
		return $contactItems;
	}

	public function deleteContactItem($contactTypeId, $contactItemIds){
		$this->contactItemModel->whereIn('conta_item_id',$contactItemIds)->delete();
		$contactItems = $this->getContactItem($contactTypeId,$langId=false);
		return $contactItems;
	}

	public function getContactStatusCount($contactTypeId, $status){
		$res = $this->contactModel->where('conta_type_id','=',$contactTypeId)->where('contact_status','=',$status);

		/*套用會員功能*/
		if($this->memberId){
			$res = $res->where('member_id','=',$this->memberId);
		}

		return $res->count();
	}
}