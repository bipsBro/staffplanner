<?php

namespace app\models;

use Yii;
use app\helpers\Slug;

/**
 * This is the model class for table "information".
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property int $show_in_menu
 * @property int $status
 * @property int $position
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Information extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'information';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'position'], 'required'],
            [['description'], 'string'],
            [['show_in_menu', 'status', 'position', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['slug', 'title'], 'string', 'max' => 255], 
            [['title'], 'unique'],
        ];
    }

    public function beforeSave($text)
    {
        if(parent::beforeSave($text))
        {  
            $this->slug=Slug::generateSlug($this->title);
            if($this->isNewRecord){
                $this->created_by = Yii::$app->user->identity->id; 
            } else {
                $this->updated_at = date('Y-m-d H:i:s');
                $this->updated_by = Yii::$app->user->identity->id; 
            }
            return parent::beforeSave($text);
        }
    }  
 

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'slug' => Yii::t('app', 'Slug'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'show_in_menu' => Yii::t('app', 'Show In Menu'),
            'status' => Yii::t('app', 'Status'),
            'position' => Yii::t('app', 'Position'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getCreatedDate()
    {
        $content = $this->created_at;
        $date = strtotime($content);
        return date("M d, Y H:i:s",$date);
    } 
    
    public function getUpdatedDate()
    {
        if($this->updated_at) {
            $date = strtotime($this->updated_at);
            return date("M d, Y H:i:s",$date);
        }
    } 

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
    public function getCreatedByName()
    {
        $content = $this->createdBy; 
        if(isset($content)) {
            return (Yii::$app->user->identity->id == $this->created_by) ? "You" : $content->username;
        }  
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
    public function getUpdatedByName()
    {
        
        $content = $this->updatedBy; 
        if(isset($content)) {
            return (Yii::$app->user->identity->id == $this->updated_by) ? "You" : $content->username;
        }    
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\InformationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\InformationQuery(get_called_class());
    }
}
