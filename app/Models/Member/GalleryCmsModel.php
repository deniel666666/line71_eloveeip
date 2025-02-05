<?php
namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class GalleryCmsModel extends Model
{
    protected $table        = 'member_gallery_cms';
    protected $primaryKey   = 'cms_id';
    protected $guarded      = ['created_at', 'updated_at'];

    public function cmsType()
    {
        return $this->belongsTo('App\Models\Member\GalleryModel', 'cms_type_id', 'gallery_id');
    }
}
