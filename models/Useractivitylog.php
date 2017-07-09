<?php

namespace greeschenko\useractivitylog\models;

use Yii;

/**
 * This is the model class for table "{{%useractivitylog}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $ip
 * @property string $msg
 * @property int $created_at
 * @property int $type
 */
class Useractivitylog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%useractivitylog}}';
    }

    public function beforeSave($insert)
    {
        $this->created_at = time();
        $this->user_id = Yii::$app->user->identity->id;
        $this->ip = $this->getClientIP();

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'type'], 'integer'],
            [['msg'], 'string'],
            [['ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => Yii::t('ulog', 'User ID'),
            'ip' => Yii::t('ulog', 'Ip'),
            'msg' => Yii::t('ulog', 'Msg'),
            'created_at' => Yii::t('ulog', 'Created At'),
            'type' => Yii::t('ulog', 'Type'),
        ];
    }

    /**
     * add log record.
     */
    public static function Add($msg)
    {
        $model = new static();
        $model->msg = $msg;
        if ($model->save()) {
            return true;
        } else {
            echo Yii::$app->user->identity->id;
            print_r($model->errors);
            die;
        }

        return false;
    }

    // Function to get the client ip address
    public function getClientIP()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } elseif (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }
}
