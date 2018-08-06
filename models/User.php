<?php

namespace app\models;

use dektrium\user\models\User as BaseUser;
use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $user_id
 * @property string $name
 * @property string $public_email
 * @property string $gravatar_email
 * @property string $gravatar_id
 * @property string $location
 * @property string $website
 * @property string $bio
 * @property string $timezone
 *
 * @property Packages[] $packages
 * @property Packages[] $packages0
 * @property User $user
 */
class User extends BaseUser
{  
	
}
