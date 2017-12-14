<?php

namespace Itb;

class WebApplication{

    const PATH_TO_TEMPLATES = __DIR__ . '/../views';

    private $mainController;

    public function __construct(){
        $twig = new \Twig\Environment(new \Twig_Loader_Filesystem(self::PATH_TO_TEMPLATES));
        $this->mainController = new MainController($twig);
    }

    public function run(){
        $action = filter_input(INPUT_GET,'action');

        if (empty($action)){
            $action = filter_input(INPUT_POST,'action');
        }

        switch($action){
            case 'listProduct':
                $this->mainController->listProductAction();
                break;

            case 'updateProductProcess':
                $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
                $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING);
                $this->mainController->updateProductProgress($id,$description,$price);
                break;

            case 'updateListProduct':
                $this->mainController->updateListProductAction();
                break;

            case 'deleteListProduct':
                $this->mainController->deleteListProductAction();
                break;

            case 'listUser':
                $this->mainController->listUserAction();
                break;

            case 'updateUserProcess':
                $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                $this->mainController->updateUserProgress($id,$username,$password);
                break;

            case 'updateListUser':
                $this->mainController->updateListUserAction();
                break;

            case 'deleteListUser':
                $this->mainController->deleteListUserAction();
                break;

            case 'admin':
                $this->mainController->adminAction();
                break;

            case 'staff':
                $this->mainController->staffAction();
                break;

            case 'logout':
                $this->mainController->logoutAction();
                break;

            case 'login':
                $this->mainController->loginAction();
                break;

            case 'processLogin':
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                $this->mainController->processLoginAction($username,$password);
                break;

            case 'signUp':
                $this->mainController->signUpAction();
                break;

            case 'signUpConfirm':
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                $this->mainController->signUpCreateAction($username,$password);
                break;

            default:
                $this->mainController->indexAction();
        }
    }
}