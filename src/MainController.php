<?php

namespace Itb;

class MainController{

    private $twig;

    public function __construct($twig){
        $this->twig = $twig;
    }

    public function indexAction(){
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();

        $template = 'index.html.twig';
        $argsArray = ['title' => 'ISAAC CAFÉ | HOME','sessname'=> $_SESSION["username"]];
        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function isLoggedInFromSession()
    {
        $isLoggedIn = false;
        if(isset($_SESSION['username'])){
            $isLoggedIn = true;
        }
        return $isLoggedIn;
    }


    public function usernameFromSession()
    {
        $username = '';

        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
        }
        return $username;
    }

      public function setUsernameAction($username)
      {
          $_SESSION['username'] = $username;

          print 'username was set';
      }

      public function logoutAction()
      {
          $this->killSession();
          $template = 'logout.html.twig';
          $argsArray = ['title' => 'ISAAC CAFÉ | LOGOUT','sessname'=> $_SESSION["username"]];
          $html = $this->twig->render($template, $argsArray);
          print $html;
      }

      public function killSession()
      {
          $_SESSION = [];

          if (ini_get('session.use_cookies')){
              $params = session_get_cookie_params();
              setcookie(	session_name(),
                  '', time() - 42000,
                  $params['path'], $params['domain'],
                  $params['secure'], $params['httponly']
              );
          }
          session_destroy();
      }

    public function loginAction()
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();

        $template = 'login.html.twig';
        $argsArray = ['title' => 'ISAAC CAFÉ | LOGIN','sessname'=> $_SESSION["username"]];
        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function processLoginAction($username,$password)
    {
        //$isLoggedIn = false;
        //$hashedCorrectPassword = password_hash($password, PASSWORD_DEFAULT);

        $userRepository = new User();
        $abc = $userRepository->verifyAction($username,$password);
        //('admin' == $username) && password_verify($password, $hashedCorrectPassword)

        if(('admin' == $username) & ('admin' == $password)){
            $_SESSION['username'] = $username;
            $this->adminAction();
            //$isLoggedIn = true;
        }
        elseif (('staff' == $username) & ('staff' == $password)){
            $_SESSION['username'] = $username;
            $this->staffAction();
        }
        elseif ($abc)
        {
            $this->indexAction();
            $_SESSION['username'] = $username;
        }
        else
        {
            $this->errorAction();
        }
    }

    public function signUpAction(){
        $template = 'signup.html.twig';
        $argsArray = ['title' => 'ISAAC CAFÉ | SIGNUP','sessname'=> $_SESSION["username"]];
        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function signUpCreateAction($username,$password){
        $uR = new UserRepository();
        $uR->insert($username,$password);


        $template = 'signupConfirm.html.twig';
        $argsArray = ['title' => 'ISAAC CAFÉ | SIGNUP','sessname'=> $_SESSION["username"]];
        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function errorAction(){
        $template = 'loginError.html.twig';
        $argsArray = ['title' => 'ISAAC CAFÉ | ERROR','sessname'=> $_SESSION["username"]];
        $html = $this->twig->render($template, $argsArray);
        print $html;
    }
    //-----------------------------------------------------------------------------------------------------

    public function staffAction(){

        if (('staff' == $_SESSION['username'])){
            $template = 'staff.html.twig';
            $argsArray = ['title' => 'ISAAC CAFÉ | STAFF','sessname'=> $_SESSION["username"]];
            $html = $this->twig->render($template, $argsArray);
            print $html;
        } else {
            $template = 'noPermissions.html.twig';
            $argsArray = ['title' => 'ISAAC CAFÉ | ERROR','sessname'=> $_SESSION["username"]];
            $html = $this->twig->render($template, $argsArray);
            print $html;
        }
    }

    public function listProductAction()
    {
        $productRepository = new ProductRepository();
        $products = $productRepository->getAll();

        $argsArray = ['products' => $products,'title' => 'ISAAC CAFÉ | STAFF'];

        $template = 'listProduct.html.twig';
        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function updateProductProgress($id,$description,$price)
    {
        $productRepository = new ProductRepository();
        $productRepository->update($id,$description,$price);
        $this->listProductAction();
    }

    public function updateListProductAction()
    {
        $template = 'updateListProduct.html.twig';
        $argsArray = ['title' => 'ISAAC CAFÉ | UPDATE','sessname'=> $_SESSION["username"]];
        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function deleteListProductAction()
    {
        $productRepository = new ProductRepository();
        $productRepository->deleteAll();
        $this->listProductAction();
    }

    //-------------------------------------------------------------------------------------------------------------
    public function adminAction(){

        if (('admin' == $_SESSION['username'])){
            $template = 'admin.html.twig';
            $argsArray = ['title' => 'ISAAC CAFÉ | ADMIN','sessname'=> $_SESSION["username"]];
            $html = $this->twig->render($template, $argsArray);
            print $html;
        } else {
            $template = 'noPermissions.html.twig';
            $argsArray = ['title' => 'ISAAC CAFÉ | ERROR','sessname'=> $_SESSION["username"]];
            $html = $this->twig->render($template, $argsArray);
            print $html;
        }
    }

    public function listUserAction()
    {
        $uR = new UserRepository();
        $users = $uR->getAll();

        $argsArray = ['users' => $users,'title' => 'ISAAC CAFÉ | ADMIN','sessname'=> $_SESSION["username"]];

        $template = 'listUser.html.twig';
        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function updateUserProgress($id,$username,$password)
    {
        $user = new User();
        $user->update($id,$username,$password);
        $this->listUserAction();
    }

    public function updateListUserAction()
    {
        $template = 'updateListUser.html.twig';
        $argsArray = ['title' => 'ISAAC CAFÉ | UPDATE','sessname'=> $_SESSION["username"]];
        $html = $this->twig->render($template,$argsArray);
        print $html;
    }

    public function deleteListUserAction()
    {
        $uR = new UserRepository();
        $uR->deleteAll();
        $this->listUserAction();
    }
    //----------------------------------------------------------------------------------------
}