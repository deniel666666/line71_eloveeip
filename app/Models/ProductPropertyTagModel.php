<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class ProductPropertyTagModel extends Model

{

    protected $table = 'productproperty';

    protected $primaryKey = 'prod_cate_id';

    protected $guarded = ['created_at', 'updated_at'];



    public function lang()

    {

        return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');

    }



    public function propduct()

    {

        return $this->hasMany('App\Models\ProductModel', 'property_tag', 'property_tag');

    }

}

