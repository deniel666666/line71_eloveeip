<?php

namespace App\Models\Gallery;

use Illuminate\Database\Eloquent\Model;

class MemberAssociateTypeGalleryModel extends Model
{
    protected $table = 'member_associate_type_gallery';
	protected $fillable = [
		'slider_id',
        'gallery_type_id',
        'img_name',
        'slider_order',
        'alt',
        'img_status',
        'gallery_cont',
        'lang_id',
    ];
  
    public function lang()
    {
        return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');
    }
}

