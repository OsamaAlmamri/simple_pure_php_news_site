<?php

/**
 *
 */
namespace admin;

class adminController extends \Controller
{


    public function index()
    {
        \Helper::viewAdminFile();
        $this->model('News');
        $this->view('admin' . DIRECTORY_SEPARATOR . 'index', ['news' => $this->model->all()]);
//    return var_dump('xxxxxxxxx0');
        $this->view->pageTitle = 'admin index';
        $this->view->render();

    }


    public function register()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $validate = \Validation::required(['', 'password', 'email', 'username']); //sure that first element in array most be null


            if ($validate['status'] == 1) {
                $post = array(
                    ':email' => htmlentities($_REQUEST['email']),
                    ':name' => htmlentities($_REQUEST['name']),
                    ':username' => htmlentities($_REQUEST['username']),
                    ':password' => \Hashing::init($_REQUEST['password']),
                    ':phone' => htmlentities($_REQUEST['phone']),
                    ':role' => 'user',
                    ':status' => isset($_REQUEST['status']) ? htmlentities($_REQUEST['status']) : 1,
                );

                $this->model('Users');


                if ($this->model->add($post)) {
                    \Message::setMessage('msgState', 1);
                    \Message::setMessage('main', 'تم اضافة المستخدم بنجاح');
                }
            }

        }

        # show form view  to add new
        $this->view('home' . DIRECTORY_SEPARATOR . 'register');

        $this->view->pageTitle = 'Add New User';
        $this->view->render();

    }

}


?>
