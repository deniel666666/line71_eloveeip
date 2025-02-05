<?php

namespace APP\Repositories;

use \App\Models\MailboxModel;

class MailboxRepository{

	public function __construct(){
	}

	//-------------------
	// MailboxModel
	//-------------------
	public function index(){
		return MailboxModel::all();
	}

	public function create($insData){
		$res =  MailboxModel::create($insData);
		return $res->id;
	}

	public function hasRecByMail($rxMail){
		return MailboxModel::where('rx_mail','=',$rxMail)->exists();
	}

	public function show($mbId){
		$res = MailboxModel::where('mb_id','=',$mbId)->first();
		return $res;
	}

	public function getAllMailbox(){
		$res = MailboxModel::all()->toArray();
		return $res;
	}

	public function update($mbId,$updData){
        $res = MailboxModel::where('mb_id','=',$mbId)->update($updData);
        return $res;
	}

    public function delete($mbId){
        $res = MailboxModel::where('mb_id','=',$mbId)->delete();
        return $res;
    }
}