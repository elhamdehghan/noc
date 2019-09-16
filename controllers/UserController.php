<?php

namespace app\controllers;

use dektrium\user\controllers\SecurityController;
use dektrium\user\models\LoginForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class UserController extends SecurityController
{
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            $this->goHome();
        }

        /** @var LoginForm $model */
        $model = \Yii::createObject(LoginForm::className());
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_LOGIN, $event);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {
            $this->trigger(self::EVENT_AFTER_LOGIN, $event);

            if (\Yii::$app->user->identity->is_admin == 1) {
                return $this->redirect(['/site/user-welcome']);
            }
            return $this->redirect(['/site/customer-welcome']);
        }

        return $this->render('//user/login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
}