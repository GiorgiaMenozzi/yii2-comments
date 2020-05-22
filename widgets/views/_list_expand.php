<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii2mod\editable\Editable;
use yii2mod\comments\models\CommentModel;

/* @var $this \yii\web\View */
/* @var $model \yii2mod\comments\models\CommentModel */
/* @var $maxLevel null|integer comments max level */
?>
<li class="comment" id="comment-<?php echo $model->id; ?>"  >
    <?php if ( $model->level==1 ){
        $ids = [];
        $ids = CommentModel::recursiveArchive($model->id,$ids);
        echo Yii::t('yii2mod.comments', 'Show replies ({0})', count($ids));
        echo '<botton data-toggle="collapse" data-target="#children-'.$model->id.'"><span class="glyphicon glyphicon-chevron-right"></span></botton>';
    }
    ?>
    <div class="comment-content" data-comment-content-id="<?php echo $model->id; ?>">
        <div class="comment-author-avatar">
            <?php echo Html::img($model->getAvatar(), ['alt' => $model->getAuthorName()]); ?>
        </div>
        <div class="comment-details">
            <div class="comment-action-buttons">
                <?php 
                if (Yii::$app->getUser()->can(Yii::$app->getModule('comment')->admin_permission)) : 
                    ?>
                    <?php 
                        echo Html::a('<span class="glyphicon glyphicon-trash"></span> ' .
                            Yii::t('yii2mod.comments', 'Delete'), '#', [   
                                'class' => 'delete-comment-btn', 
                                'data' => [
                                    'action' => 'delete', 
                                    'url' => Url::to(['/comment/default/delete', 'id' => $model->id]),
                                    'comment-id' => $model->id
                                ]
                            ]);
                        if ( $model->level==1 && Yii::$app->getModule('comment')->add_archive_action){
                            echo Html::a('<span class="'. ($model->archived==0 ? "glyphicon glyphicon-hdd":"glyphicon glyphicon-refresh").'"></span> ' .
                                Yii::t('yii2mod.comments', ($model->archived==0 ? "Archive":"Restore")), '#', [   
                                    'class' => 'archive-comment-btn', 
                                    'data' => [
                                        'action' => 'archive',
                                        'url' => Url::to(['/comment/default/change-archived', 'id' => $model->id]),
                                        'comment-id' => $model->id
                                    ]
                                ]);
                            
                            
                            
                        }
                    ?>
                <?php endif; ?>
                <?php if (!Yii::$app->user->isGuest && $model->addReply($maxLevel)) : ?>
                    <?php echo Html::a("<span class='glyphicon glyphicon-share-alt'></span> " .
                            Yii::t('yii2mod.comments', 'Reply'), '#', [
                                'class' => 'reply-comment-btn', 
                                'data' => ['action' => 'reply', 'comment-id' => $model->id]
                            ]
                            ); ?>
                <?php endif; ?>
            </div>
            <div class="comment-author-name">
                <span><?php echo $model->getAuthorName(); ?></span>
                <?php echo Html::a($model->getPostedDate(), $model->getAnchorUrl(), ['class' => 'comment-date']); ?>
            </div>
            <div class="comment-body">
                <?php if (Yii::$app->getModule('comment')->enableInlineEdit && Yii::$app->getUser()->can('admin')): ?>
                    <?php echo Editable::widget([
                        'model' => $model,
                        'attribute' => 'content',
                        'url' => Url::to(['/comment/default/quick-edit']),
                        'options' => [
                            'id' => 'editable-comment-' . $model->id,
                        ],
                    ]); ?>
                <?php else: ?>
                    <?php echo $model->getContent(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</li>

<?php if ($model->hasChildren()) : ?>
    <ul class="children collapse" id="children-<?php echo $model->id; ?>">
        <?php foreach ($model->getChildren() as $children) : ?>
            <?php echo $this->render('_list', ['model' => $children, 'maxLevel' => $maxLevel]); ?>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
