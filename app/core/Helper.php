<?php

use site\homeController;

/**
 *
 */
class Helper
{


    public static function getMainMenu($type)
    {
        if ($type == 'main') {
            $c = DB::init()->query("SELECT *  FROM categories WHERE parent =0 and isMain=1 order by sort");


        } else
            $c = DB::init()->query("SELECT *  FROM categories WHERE parent =0 and isMain=0 order by sort ");
//            $c = Category::all()->where('parent', '')->where('isMain', 0)->sortBy('sort');
        return ($c);
    }


    public static function getCategories()
    {

        $c = DB::init()->query("SELECT *  FROM categories order by sort ");
        return ($c);
    }

    public static function countChild($id)
    {
        $counter = DB::init()->query("SELECT COUNT(*) AS count FROM categories WHERE parent= $id ");

        return $counter[0]['count'];

    }

    public static function countAlsoMenu()
    {
        $counter = DB::init()->query("SELECT COUNT(*) AS count FROM categories WHERE parent =0 and isMain=0   ");

        return $counter[0]['count'];

    }

    public static function returnChild($id)
    {
        $c = DB::init()->query("SELECT *  FROM categories WHERE parent =$id order by sort");
        return ($c);
//        $c = Category::all()->where('parent', $id)->sortBy('sort');

    }

    public static function userName($id)
    {

        $username = DB::init()->query("SELECT *  FROM users WHERE id = $id ");
        if (!empty($username)) {
            return $username[0]['username'];
        }

    }

    public static function isAdmin()
    {
        if (isset($_SESSION['role']) and $_SESSION['role'] == 'admin')
            return true;
        else
            return false;

    }

    public static function viewAdminFile()
    {
        if (Helper::isAdmin())
            return true;

        $h = new homeController;
        $h->index();

    }

    public static function Names($ids, $type)
    {
        $ids = json_decode($ids);
        $t = '(';
        foreach ($ids as $k => $id) {
            if ($type == 'Category') {
                $cat_name = DB::init()->query("SELECT *  FROM categories WHERE id = $id ");
                if($cat_name)
                $t .= $cat_name[0]['name_ar'];
            }
            if ($k < count($ids) - 1 and $k % 2 == 1)
                $t .= ' <br> ';
            if ($k < count($ids) - 1 and $k % 2 == 0)
                $t .= ' , ';

        }
        $t .= ')';
        return $t;

    }

    public static function getCategoryName($id)
    {

        $cat_name = DB::init()->query("SELECT *  FROM categories WHERE id = $id ");
        if (!empty($cat_name)) {
            return $cat_name[0]['name_ar'];
        }

    }


}


?>
