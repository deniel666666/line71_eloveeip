<?php
namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class CmsLayoutRelationModel extends Model
{
    protected $table        = 'cms_layout_relation';
    protected $primaryKey   = 'child_template_id';
    protected $fillable		= ['cms_type_id','name', 'edit_view', 'view_view'];
    protected $guarded      = ['created_at', 'updated_at'];
    public function cmsType()
    {
        return $this->belongsTo('App\Models\Cms\CmsLayoutTypeModel', 'cms_type_id', 'id');
    }
}
