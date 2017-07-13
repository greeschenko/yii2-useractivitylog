<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

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
            'created_at:datetime',
            //'type',
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
