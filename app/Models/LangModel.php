<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LangModel extends Model
{
    protected $table = 'lang';
    protected $primaryKey = 'lang_id';
    protected $guarded = ['created_at', 'updated_at'];

    public function menuLang()
    {
        return $this->hasMany('App\Models\MenuLangModel', 'lang_id', 'lang_id');
    }

    public function gallery()
    {
        return $this->hasMany('App\Models\GalleryModel', 'lang_id', 'lang_id');
    }

    public function hireItem()
    {
        return $this->hasMany('App\Models\HireItemModel', 'lang_id', 'lang_id');
    }

    public function hire()
    {
        return $this->hasMany('App\Models\HireModel', 'lang_id', 'lang_id');
    }

    public function contactItem()
    {
        return $this->hasMany('App\Models\ContactItemModel', 'lang_id', 'lang_id');
    }

    public function contact()
    {
        return $this->hasMany('App\Models\ContactModel', 'lang_id', 'lang_id');
    }

    public function cms()
    {
        return $this->hasMany('App\Models\CmsModel', 'lang_id', 'lang_id');
    }

    public function categoryTag()
    {
        return $this->hasMany('App\Models\CategoryTagModel', 'lang_id', 'lang_id');
    }

    public function propertyTag()
    {
        return $this->hasMany('App\Models\PropertyTagModel', 'lang_id', 'lang_id');
    }

    public function product()
    {
        return $this->hasMany('App\Models\ProductModel', 'lang_id', 'lang_id');
    }

    public function productType()
    {
        return $this->hasMany('App\Models\ProductTypeModel', 'lang_id', 'lang_id');
    }

    public function productDescribe()
    {
        return $this->hasMany('App\Models\ProductDescribeModel', 'lang_id', 'lang_id');
    }

    public function productProperty()
    {
        return $this->hasMany('App\Models\ProductPropertyModel', 'lang_id', 'lang_id');
    }

    public function productImg()
    {
        return $this->hasMany('App\Models\ProductImgModel', 'lang_id', 'lang_id');
    }
    
    public function prodSpecification()
    {
        return $this->hasMany('App\Models\ProdSpecificationModel', 'lang_id', 'lang_id');
    }

    public function prodContent()
    {
        return $this->hasMany('App\Models\ProdContentModel', 'lang_id', 'lang_id');
    }

    public function fare()
    {
        return $this->hasMany('App\Models\FareModel', 'lang_id', 'lang_id');
    }

    public function seo()
    {
        return $this->hasMany('App\Models\SeoModel', 'lang_id', 'lang_id');
    }
    
}
