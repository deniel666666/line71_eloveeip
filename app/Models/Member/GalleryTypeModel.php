<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class GalleryTypeModel extends Model
{
	protected $table = 'member_gallery_type';
	protected $fillable = [
		'gallery_modeule',
        'gallery_name'
	];
}

