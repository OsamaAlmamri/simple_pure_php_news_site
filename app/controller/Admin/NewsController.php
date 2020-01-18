<?php

/**
 *
 */
namespace admin;

use Controller;
use Helper;
use Message;
use Validation;
use Session;

class NewsController extends Controller
{
    public function index()
    {
        Helper::viewAdminFile();


        $news = $this->model('News');
        $this->view('admin' . DIRECTORY_SEPARATOR . 'news' . DIRECTORY_SEPARATOR . 'index', ['news' => $news->all(), 'deleted' => false]);
        $this->view->pageTitle = 'الاخبار';
        $this->view->render();
    }

    public function create()
    {

        Helper::viewAdminFile();

        $new = $this->model('News');
        $this->view('admin' . DIRECTORY_SEPARATOR . 'news' . DIRECTORY_SEPARATOR . 'create');
        $this->view->pageTitle = 'الاخبار';
        $this->view->render();
    }

    public function edit($id)
    {

        Helper::viewAdminFile();

        $newsModel = $this->model('News');
        $news = $newsModel->find($id)[0];
//        return var_dump($news);
        $this->view('admin' . DIRECTORY_SEPARATOR . 'news' . DIRECTORY_SEPARATOR . 'create', ['news' => $news, 'type' => 'create']);

//        $this->view('admin' . DIRECTORY_SEPARATOR . 'news' . DIRECTORY_SEPARATOR . 'create', ['news' => $news]);
        $this->view->pageTitle = 'الاخبار';
        $this->view->render();
    }

    public function delete($id)
    {
        Helper::viewAdminFile();
        $this->model('News');
        $c = $this->model->delete($id);
        Message::setMessage('msgState', 1);
        Message::setMessage('main', 'تم حذف الخبر بنجاح');
        $new = $this->model;
        $this->view('admin' . DIRECTORY_SEPARATOR . 'news' . DIRECTORY_SEPARATOR . 'index', ['news' => $new->all(), 'deleted' => false]);
        $this->view->pageTitle = 'الاخبار';
        $this->view->render();
    }


    private function saveImage($file, $folder)
    {
        $time = time();

        $logo = $_FILES[$file] ['name'];
        $f_type = $_FILES[$file] ['type'];
        $file_tmp = $_FILES[$file] ['tmp_name'];
        $types = array('image/jpeg', 'image/gif', 'image/png');
//        $logo = '/images/news/deafult.png';

        if ($logo != "") {
            if (in_array($f_type, $types)) {
                if (move_uploaded_file($file_tmp, $folder . $time . $logo))
                    $logo = '/' . $folder . $time . $logo;
                return $logo;
            }
        }
        return '/' . $folder . 'deafult.png';
    }


    public function store()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $validate = Validation::required(['', 'categories', 'editor', 'title', 'introduction', 'sort',]); //sure that first element in array most be null
            if ($validate['status'] == 1) {
                $time = date("D- y/m/j  h-i-s ");
                $logo = $this->saveImage('logo', 'images/news/');
                $categories = json_encode(($_REQUEST['categories']));
                $news = array(
                    ':categories' => $categories,
                    ':editor' => htmlentities($_REQUEST['editor']),
                    ':title' => htmlentities($_REQUEST['title']),
                    ':introduction' => htmlentities($_REQUEST['introduction']),
                    ':sort' => htmlentities($_REQUEST['sort']),
                    ':logo' => $logo,
                    ':has_comment' => (isset($_REQUEST['has_comment']) ? 1 : 0),
                    ':status' => (isset($_REQUEST['status']) ? 1 : 0),
                    ':created_by' => Session::logged(),
                    ':updates' => '',
                    ':created_at' => $time,
                    ':updated_at' => $time,
                );

                $this->model('News');
                if ($this->model->add($news)) {
                    Message::setMessage('msgState', 1);
                    Message::setMessage('main', 'تم اضافة الخبر بنجاح');
//                    $news = $this->model('News');
                    $this->view('admin' . DIRECTORY_SEPARATOR . 'news' . DIRECTORY_SEPARATOR . 'index', ['news' => $this->model->all(), 'deleted' => false]);
                    $this->view->pageTitle = 'الاخبار';
                    $this->view->render();

                }
            } else {
                if ($this->model == "News")
                    $news = $this->model;
                else
                    $news = $this->model('News');
                $this->view('admin' . DIRECTORY_SEPARATOR . 'news' . DIRECTORY_SEPARATOR . 'index', ['news' => $news->all(), 'deleted' => false]);
                $this->view->pageTitle = 'الاخبار';
                $this->view->render();
            }
        }


    }


    public function update()
    {


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $validate = Validation::required(['', 'categories', 'editor', 'title', 'introduction', 'sort',]); //sure that first element in array most be null
            if ($validate['status'] == 1) {
                $time = date("D- y/m/j  h-i-s ");
//                return var_dump($_FILES['name']);
                if (($_FILES['logo']['name']))
                    $logo = $this->saveImage('logo', 'images/news/');
                else
                    $logo = $_REQUEST['_logo'];
                $categories = json_encode(($_REQUEST['categories']));
                $u = (['update_by' => Session::logged(), 'update_date' => $time]);
                $uArray = json_decode($_REQUEST['_updates']);
                $uArray[] = $u;

                $news = array(
                    ':categories' => $categories,
                    ':id' => htmlentities($_REQUEST['_id']),
                    ':editor' => htmlentities($_REQUEST['editor']),
                    ':title' => htmlentities($_REQUEST['title']),
                    ':introduction' => htmlentities($_REQUEST['introduction']),
                    ':sort' => htmlentities($_REQUEST['sort']),
                    ':logo' => $logo,
                    ':has_comment' => (isset($_REQUEST['has_comment']) ? 1 : 0),
                    ':status' => (isset($_REQUEST['status']) ? 1 : 0),
                    ':updates' => json_encode($uArray),
                    ':updated_at' => $time,
                );
//                return var_dump($news);


                $this->model('News');
                if ($this->model->update($news)) {
                    Message::setMessage('msgState', 1);
                    Message::setMessage('main', 'تم تعديل الخبر بنجاح');
//                    $news = $this->model('News');
                    $this->view('admin' . DIRECTORY_SEPARATOR . 'news' . DIRECTORY_SEPARATOR . 'index', ['news' => $this->model->all(), 'deleted' => false]);
                    $this->view->pageTitle = 'الاخبار';
                    $this->view->render();

                }
            } else {
                if ($this->model == "News")
                    $news = $this->model;
                else
                    $news = $this->model('News');
                $this->view('admin' . DIRECTORY_SEPARATOR . 'news' . DIRECTORY_SEPARATOR . 'index', ['news' => $news->all(), 'deleted' => false]);
                $this->view->pageTitle = 'الاخبار';
                $this->view->render();
            }


        }


    }

}

?>
