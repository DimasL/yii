<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class CountryForm extends Model
{
    public $title;
    public $slug;
    public $sort_order;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title', 'slug', 'sort_order'], 'required'],
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
     * Create new country.
     * @param string $params
     * @return boolean whether the model passes validation
     */
    public function createCountry($params)
    {
        if ($this->validate($params)) {
            $country = new Country();
            $country->attributes = $params;
            $country->save();
            return true;
        }
        return false;
    }
}
