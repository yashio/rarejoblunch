<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		//新規追加のお店が先頭に来るようにセット
		$criteria = new EMongoCriteria;
		$criteria->sort('_id',EMongoCriteria::SORT_DESC);
		$shops = Shop::model()->findAll($criteria);
		$this->render('index',array('shops'=>$shops));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionAdd(){
		$shop = new Shop;
		$shop->name    = $_POST['name'] ;
		$shop->impression    = $_POST['impression'] ;
		$shop->address = $_POST['address'] ;
		$shop->lat     = $_POST['lat'];
		$shop->lng     = $_POST['lng'];
		$shop->kind     = $_POST['kind'];
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	//ajaxでお店の印象を変更
	public function actionUpdate(){
		$id = $_POST['id'];
		$value = $_POST['value'];	
		$shop = new Shop();
		$data = Shop::model()->findByPk($id);
		if($data){
			$data->impression=$value;
			$data->save();
		}
		echo $value;
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
