<?php
namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class CmsTypeModel extends Model
{
    protected $table = 'cms_type';
    protected $primaryKey = 'id';
    protected $guarded = ['created_at', 'updated_at'];
    public function lang()
    {
        return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');/* belongsTo:對應模型, 自己的外鍵, 對應模型的主鍵 */
    }

    /*layout_function*/
    public function layout_relation()
    {
        return $this->hasMany('App\Models\Cms\cmsLayoutRelationModel', 'cms_type_id', 'id');
    }
}