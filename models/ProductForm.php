<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ProductForm extends Model
{
    public $title;
    public $description;
    public $price;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title', 'description', 'price'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * Create new product.
     * @param string $params
     * @return boolean whether the model passes validation
     */
    public function createProduct($params)
    {
        if ($this->validate($params)) {
            $product = new Product();
            $product->attributes = $params;
            $product->save();
            return true;
        }
        return false;
    }
}
