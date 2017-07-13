<?php

namespace greeschenko\useractivitylog;

use Yii;

class Module extends \yii\base\Module
{
    const VER = '0.1-dev';

    public $i18n = [];
    public $userclass;

    public function init()
    {
        parent::init();

        if (!$this->userclass) {
            throw new \yii\web\HttpException(501, 'user class not specified in the config file');
        }

        $this->initI18N();

        $this->components = [
        ];
    }

    public function initI18N()
    {
        Yii::setAlias('@ulog', dirname(__FILE__));
        if (empty($this->i18n)) {
            $this->i18n = [
                'sourceLanguage' => 'en',
                'basePath' => '@ulog/messages',
                'class' => 'yii\i18n\PhpMessageSource',
            ];
        }
        Yii::$app->i18n->translations['ulog'] = $this->i18n;
    }
}
