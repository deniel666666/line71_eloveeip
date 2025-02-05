<?php
namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class CmsLayoutModel extends Model
{
    protected $table        = 'cms_layout';
    protected $primaryKey   = 'cms_id';
    protected $guarded      = ['created_at', 'updated_at'];

    public function cmsType()
    {
        return $this->belongsTo('App\Models\Cms\CmsLayoutTypeModel', 'cms_type_id', 'id');
    }
}
