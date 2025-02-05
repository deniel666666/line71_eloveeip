<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductModel extends Model
{
	use SoftDeletes;
    protected $table = 'product';
    protected $primaryKey = 'prod_id';
    protected $guarded = ['created_at', 'updated_at'];
	protected $dates = ['deleted_at'];
 
    public function productType()
    {
        return $this->hasMany('App\Models\ProductTypeModel', 'prod_id', 'prod_id')
                    ->orderBy('order_id','ASC')->orderBy('prod_type_id','DESC');
    }

    public function productDescribe()
    {
        return $this->hasMany('App\Models\ProductDescribeModel', 'prod_id', 'prod_id');
    }

    public function productProperty()
    {
        return $this->hasMany('App\Models\ProductPropertyModel', 'prod_id', 'prod_id')
                    ->join('property_tag', 'product_property.prop_tag_id', '=', 'property_tag.prop_tag_id')
                    ->orderBy('property_tag.prop_tag_order', 'asc');
    }

    public function productImg()
    {
        return $this->hasMany('App\Models\ProductImgModel', 'prod_id', 'prod_id');
    }

    public function prodSpecification()
    {
        return $this->hasMany('App\Models\ProdSpecificationModel', 'prod_id', 'prod_id');
    }

    public function productCategory()
    {
        return $this->hasMany('App\Models\ProductCategoryModel', 'prod_id', 'prod_id');
    }

    public function lang()
    {
        return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');
    }

    public function categoryTag(){
		return $this->belongsToMany ('App\Models\CategoryTagModel',
									'product_category',
			 						'prod_id',
							   		'cate_tag_id')->orderBy('cate_order','asc')
					->orderBy('cate_order','asc')->orderBy('created_at','asc');
	}

	public function propertyTag(){
		return $this->belongsToMany ('App\Models\PropertyTagModel',
									'product_property',
									'prod_id',
									'prop_tag_id')
					->orderBy('prop_tag_order','asc')->orderBy('created_at','asc');
	}

    /*layout_function*/
    public function layout_relation()
    {
        return $this->hasMany('App\Models\Cms\Product\cmsLayoutRelationModel', 'cms_type_id', 'prod_id');
    }
}

