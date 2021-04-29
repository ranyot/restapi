<?php

namespace app\controllers;

use app\models\MasterUsers;

use yii\web\Response;

class UserController extends \yii\rest\Controller
{

    public $enableCsrfValidation = false;

    public function init()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
    }


    public function actionIndex()
    {
        $masterUser = MasterUsers::find()->all();
        $response = \Yii::$app->response;

        $response->format = Response::FORMAT_JSON;

        if ($masterUser == null) {
            $response->statusCode = 404;
        }else {
            $response->statusCode = 200;
        }

        $response->data = ['data'=>$masterUser];
        return $response->data; 
    }

    public function actionGetUser()
    {
        $request = \Yii::$app->request;

        $id = $request->getBodyParam('id');
        
        $masterUser = MasterUsers::findOne(['id'=>$id]);

        // $firstname = $request->getBodyParam('firstname');
        // $masterUser = MasterUsers::findAll(['id'=>$id, 'firstname'=>$firstname]);
        $response = \Yii::$app->response;

        $response->format = Response::FORMAT_JSON;

        if ($masterUser == null) {
            $response->statusCode = 404;
        }else {
            $response->statusCode = 200;
        }

        $response->data = ['data'=>$masterUser];
        return $response->data;
    }



    public function actionAddUser()
    {
        $request = \Yii::$app->request;

        $response = \Yii::$app->response;

        $response->format = Response::FORMAT_JSON;

        $result = "";
        $statusCode = 0;


        if ($request->isPost) {
            $fristname = $request->post('firstname');
            $lastname = $request->post('lastname');

            $mastUserModel = new MasterUsers();
            $mastUserModel->firstname = $fristname;
            $mastUserModel->lastname = $lastname;
            
            if ($mastUserModel->validate()) {
                $mastUserModel->save();

                $result = "Malumot saqlandi";
                $statusCode = 200;
            }
            else {
                $statusCode=400;
                $result = $mastUserModel->errors;
            }

        }
        else {
            $statusCode=400;

            $result="Ushbu usul boshqa post usullarini qo'llab-quvvatlay olmaydi, chunki postdan tashqari";
        }

        $response->data = ['data'=>$result];
        $response->statusCode =$statusCode;

        // return array('data'=>$result);
        return $response->data;
    }


    public function actionUpdateUser(){
        $request = \Yii::$app->request;
        $response = \Yii::$app->response;

        $response->format = Response::FORMAT_JSON;

        $result = "";
        $statusCode = 0;

        if ($request->isPost) {
            $id = $request->post('id');
            $firstname = $request->post('firstname');
            $lastname = $request->post('lastname');


            $mastUserModel = MasterUsers::findOne(['id'=>$id]);

            if ($mastUserModel !=null) {
                $mastUserModel->firstname = $firstname;
                $mastUserModel->lastname = $lastname;

                if ($mastUserModel->validate()) {
                    $mastUserModel->save();

                    $result = "Malumot almashtirildi";
                    $statusCode = 200;

                }
                else {
                    $statusCode = 400;

                    $result = $mastUserModel->errors;
                }
            }
            else {
                $statusCode = 404;

                $result="Not found date.";    
            }
        }
        else {
            $statusCode = 400;

            $result = "Ushbu usul boshqa post usullarini qo'llab-quvvatlay olmaydi, chunki postdan tashqari";
        }

        $response->data = ['data'=>$result];
        $response->statusCode = $statusCode;

        return $response->data;

        // return array('date'=>$result);
    }


}


















