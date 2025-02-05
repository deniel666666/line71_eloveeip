<?php

namespace App\Models\Gallery;

use Illuminate\Database\Eloquent\Model;

class MemberAssociateTypeGalleryTypeModel extends Model
{
	protected $table = 'member_associate_type_gallery_type';
	protected $fillable = [
		'gallery_modeule',
        'gallery_name'
	];
}

