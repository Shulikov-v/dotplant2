<?php

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\backgroundtasks\models\Task $searchModel
 */

use kartik\dynagrid\DynaGrid;
use kartik\helpers\Html;

$this->title = Yii::t('app', 'Product reviews');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="reviews-index">
    <?=
    DynaGrid::widget(
        [
            'options' => [
                'id' => 'reviews-grid',
            ],
            'theme' => 'panel-default',
            'gridOptions' => [
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'hover' => true,
                'panel' => [
                    'heading' => Html::tag('h3', $this->title, ['class' => 'panel-title']),
                ],
            ],
            'columns' => [
                'text:truncated',
                [
                    'class' => yii\grid\DataColumn::className(),
                    'attribute' => 'username',
                    'value' => function ($data) {
                        return isset($data->user) ? $data->user->username : 'not registered';
                    },
                ],
                'author_name',
                'author_email',
                'author_phone',
                [
                    'class' => yii\grid\DataColumn::className(),
                    'attribute' => 'name',
                    'value' => function ($data) {
                        return isset($data->product) ? $data->product->name : null;
                    },
                ],
                [
                    'class' => yii\grid\DataColumn::className(),
                    'attribute' => 'slug',
                    'value' => function ($data) {
                        return isset($data->product) ? $data->product->slug : null;
                    },
                ],
                [
                    'attribute' => 'status',
                    'class' => \kartik\grid\EditableColumn::className(),
                    'editableOptions' => [
                        'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                        'placement' => \kartik\popover\PopoverX::ALIGN_LEFT,
                        'data' => \app\reviews\models\Review::getStatuses(),
                        'formOptions' => [
                            'action' => 'update-status',
                        ],
                    ],
                    'filter' => \app\reviews\models\Review::getStatuses(),
                    'format' => 'raw',
                ],
                'rate',
                [
                    'class' => 'app\backend\components\ActionColumn',
                    'buttons' => function($model, $key, $index, $parent) {
                        return [
                            [
                                'url' => 'delete',
                                'icon' => 'trash-o',
                                'class' => 'btn-danger',
                                'label' => 'Delete',
                            ],
                        ];
                    }
                ],
            ],
        ]
    );
    ?>
</div>