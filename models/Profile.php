<?php 
namespace app\models;

use dektrium\user\models\Profile as BaseProfile; 

class Profile extends BaseProfile
{ 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules(); 
        $rules[] = ['gender','required'];
        $rules[] = ['gender', 'string', 'max' => 255];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['gender'] = \Yii::t('user', 'Gender');
        return $labels;
    } 
}