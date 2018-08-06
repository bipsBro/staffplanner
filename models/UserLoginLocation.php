<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_login_location".
 *
 * @property int $id
 * @property int $user_id
 * @property string $location
 * @property string $login_date
 *
 * @property User $user
 */
class UserLoginLocation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_login_location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'location'], 'required'],
            [['user_id'], 'integer'],
            [['login_date'], 'safe'],
            [['location'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'location' => Yii::t('app', 'Location'),
            'login_date' => Yii::t('app', 'Login Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\UserLoginLocationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\UserLoginLocationQuery(get_called_class());
    }
}
