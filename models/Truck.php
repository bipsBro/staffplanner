<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "truck".
 *
 * @property int $id
 * @property string $name
 * @property string $details
 * @property string $truck_no
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_on
 * @property string $updated_on
 */
class Truck extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'truck';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'details', 'truck_no'], 'required'],
            [['details'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['name', 'truck_no'], 'string', 'max' => 255],
            [['truck_no'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'details' => Yii::t('app', 'Details'),
            'truck_no' => Yii::t('app', 'Truck No'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated On'),
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
     * @return \app\models\activeQuery\TruckQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\TruckQuery(get_called_class());
    }
}
