<?php

namespace app\modules\user\models;

use Yii;

/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property integer $user_id
 * @property integer $gender
 * @property string $birthdate
 * @property string $signature
 * @property string $address
 * @property string $description
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gender',], 'required'],
            [['user_id', 'gender'], 'integer'],
            [['birthdate'], 'safe'],
            [['address', 'description'], 'string'],
            [['signature'], 'string', 'max' => 120]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'gender' => Yii::t('app', 'Gender'),
            'birthdate' => Yii::t('app', 'Birthdate'),
            'signature' => Yii::t('app', 'Signature'),
            'address' => Yii::t('app', 'Position'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
