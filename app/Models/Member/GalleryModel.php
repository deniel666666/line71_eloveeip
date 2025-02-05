<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class GalleryModel extends Model
{
    protected $table = 'member_gallery';
	protected $fillable = [
		'slider_id',
        'gallery_type_id',
        'img_name',
        'slider_order',
        'alt',
        'img_status',
        'gallery_cont',
        'lang_id',

        /*額外加入欄位------------*/
        /*下掛至會員*/
        'member_id',
        /*套用cms*/
        'child_template_id',
    ];

    public function lang(){
        return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');
    }

    /*套用cms & 無模板*/
    public function cms(){
        return $this->hasMany('App\Models\Member\GalleryCmsModel', 'cms_type_id', 'gallery_id')
                    ->orderBy('order_id', 'asc')
                    ->orderBy('cms_id', 'desc');
    }
}

