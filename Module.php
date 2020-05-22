<?php

namespace yii2mod\comments;

use Yii;

/**
 * Class Module
 *
 * @package yii2mod\comments
 */
class Module extends \yii\base\Module
{
    /**
     * @var string the class name of the [[identity]] object
     */
    public $userIdentityClass;

    /**
     * @var string the class name of the comment model object, by default its yii2mod\comments\models\CommentModel
     */
    public $commentModelClass = 'yii2mod\comments\models\CommentModel';

    /**
     * @var string the namespace that controller classes are in
     */
    public $controllerNamespace = 'yii2mod\comments\controllers';

    /**
     * @var bool when admin can edit comments on frontend
     */
    public $enableInlineEdit = FALSE;
    
    
    /**
     *
     * @var boolean, set TRUE if you use the archived attribute
     */
    public $add_archive_action = TRUE;
    
    public $admin_permission = "admin";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (null === $this->userIdentityClass) {
            $this->userIdentityClass = Yii::$app->getUser()->identityClass;
        }
    }
}
