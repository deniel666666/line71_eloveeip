<?php
namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class CmsModel extends Model
{
    protected $table        = 'cms';
    protected $primaryKey   = 'cms_id';
    protected $guarded      = ['created_at', 'updated_at'];

    public function cmsType()
    {
        return $this->belongsTo('App\Models\Cms\CmsTypeModel', 'cms_type_id', 'id');
    }
}
