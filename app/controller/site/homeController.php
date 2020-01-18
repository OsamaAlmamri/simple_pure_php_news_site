<?php

/**
 *
 */
namespace site;

use Message;
use Controller;
use Hashing;
use Validation;
use Session;
class homeController extends Controller
{


//    public function index($id = '', $name = '')
//    {
//        echo 'i am in ' . __CLASS__ . '<br>method ' . __METHOD__ . '';
//        // echo 'i am is '.$id.' my name is '.$name;
////        $news = $this->model('News');
////        $category = $this->model('Category');
//
////        $this->view('home' . DIRECTORY_SEPARATOR . 'index', ['news' => 'news']);
////        $this->view->pageTitle = 'this page of index';
////
////        $this->view->render();
//    }


    public function index($id = '', $name = '')
    {
//        return var_dump( "hooooooooooo");
        $news = $this->model('News');
        $category = $this->model('Category');
//        $this->view('home' . DIRECTORY_SEPARATOR . 'index', ['news' => $news->all(), 'category' => $category->all()]);
        $this->view('home' . DIRECTORY_SEPARATOR . 'index', ['news' => $news->all(), 'category' => $category->all()]);
        $this->view->pageTitle = 'home';
        $this->view->render();
    }

    public function login()
    {

        $this->view('home' . DIRECTORY_SEPARATOR . 'login');
        $this->view->pageTitle = 'login';
        $this->view->render();
    }

    public function register()
    {

        $this->view('home' . DIRECTORY_SEPARATOR . 'register');
        $this->view->pageTitle = 'register';
        $this->view->render();
    }


    public function postLogin()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $validate = Validation::required(['', 'username', 'password']);

//            if ($validate['status'] == 0) {
//                $this->index();
//                return;
//            }

            $password = Hashing::init($_REQUEST['password'])->__toString();
            $userForm = array(':username' => $_REQUEST['username'], ':password' => $password);
            $this->model('Users');
            $user = $this->model->Login($userForm);

//return var_dump($user);
            if ($user == 0) {
                Message::setMessage('msgState', 0);
                Message::setMessage('main', 'لم يتم تسجيل الدخول بنجاح الرجاء المحاولة مرة اخرى');
                $this->index();
                return;
            }
            if ($user == 0 || $user['status'] == 0) {
                Message::setMessage('msgState', 0);
                Message::setMessage('main', 'لم يتم تسجيل الدخول بنجاح الرجاء المحاولة مرة اخرى');
                $this->index();
                return;
            }
            Session::loggIn($user);
            if (Session::logged()) {

                Message::setMessage('msgState', 1);
                Message::setMessage('main', 'لقد تم تسجيل الدخول بنجاح');
                if (Session::get('type') == 'Admin') {

                    $adminController = new adminController();
                    $adminController->index();
                    return;


                } else {

                    $this->index();
                    return;
                }

            } else {
                $this->index();
                return;
            }


        } else {
            $this->index();
            return;
        }


    }

    public function logout()
    {

        Session::destroy();
        $this->index();
    }


}

?>
