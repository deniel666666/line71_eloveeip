<?php

namespace App\Models\Gallery;

use Illuminate\Database\Eloquent\Model;

class GalleryTypeModel extends Model
{
	protected $table = 'gallery_type';
	protected $fillable = [
		'gallery_modeule',
        'gallery_name'
	];
}

