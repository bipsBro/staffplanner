<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $likes
 * @property string $expired_date
 * @property string $created_on
 * @property int $created_by
 * @property string $updated_on
 * @property int $updated_by
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'expired_date'], 'required'],
            [['description'], 'string'],
            [['likes', 'created_by', 'updated_by'], 'integer'],
            [['expired_date', 'created_on', 'updated_on'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'likes' => Yii::t('app', 'Likes'),
            'expired_date' => Yii::t('app', 'Expired Date'),
            'created_on' => Yii::t('app', 'Created On'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }


    public function beforeSave($text)
    { 
        if($this->isNewRecord)
        {
            $this->created_by = Yii::$app->user->identity->id;
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_on = date("Y-m-d H:i:s");
        }
        else
        {
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_on = date("Y-m-d H:i:s");
        }
        return parent::beforeSave($text);
    }


    public function getCreatedOn()
    {
        $date = strtotime($this->created_on);
        return date("M d, Y H:i:s", $date);
    }

    public function getUpdatedOn()
    {
        $date = strtotime($this->updated_on);
        return date("M d, Y H:i:s", $date);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getCreatedByName()
    {
        $content = $this->createdBy; 
        if(isset($content))
        {
            return (Yii::$app->user->identity->id == $this->created_by) ? "You" : $content->email;
        }
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
    public function getUpdatedByName()
    {
        $content = $this->updatedBy; 
        if(isset($content))
        {
            return (Yii::$app->user->identity->id == $this->updated_by) ? "You" : $content->email; 
        }
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\NewsQuery(get_called_class());
    }
}
