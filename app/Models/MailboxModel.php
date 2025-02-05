<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailboxModel extends Model
{

	protected $table = 'mailbox';

	protected $fillable = [
		'mb_id',
		'rx_mail',
		'line_id',
		'line_id_message',
		'rx_name',
		'mb_status'
	];

}
