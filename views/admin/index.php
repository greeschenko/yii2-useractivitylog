<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\daterange\DateRangePicker;

//use kartik\date\DatePicker;

$this->title = Yii::t('ulog', 'Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logs-index">

<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'user_id',
            [
                'attribute' => 'useremail',
                'content' => function ($data) {
                    return $data->user->email;
                },
            ],

            'ip',
            'msg',
            [
                'attribute' => 'created_at',
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at_period',
                    //'name' => 'testtest',
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => ['format' => 'Y-m-d'],
                        'opens' => 'left',
                    ],
                ]),
                'content' => function ($data) {
                    return date('d.m.Y H:i', $data->created_at);
                },
            ],
            //'type',
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
