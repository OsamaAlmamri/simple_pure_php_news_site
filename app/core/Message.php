<?php

/**
 *
 */
abstract class Message

{
    function __construct()
    {

    }

    /**
     * @param $msg
     * @return null
     */

    public static function getMessage($msg)
    {
        if (Session::has($msg)) {
            $message = Session::get($msg);
            if ($msg != 'msgState') {
                Session::delete($msg);
            }

            return $message;
        } else {
            return '';
        }

    }


    /**
     * @param $key
     * @param $msg
     */
    public static function setMessage($key, $msg)
    {

        Session::set($key, $msg);

    }

    /**
     * @param $key
     * @return $view
     */
    public static function check($key)
    {
        $view = '';
        #check if state of Message is exit or return null
        if (!Session::has('msgState')) {

            return '';
        }
        #check if state of Message is exit or return null
        if (!Session::has($key)) {

            return '';
        }

        switch (Message::getMessage('msgState')) {
            case 0:
                if ($key == 'main') {
                    $view = '<h3 class="text-danger text-center"> <strong>عذرا ! : </strong>' . Message::getMessage($key) . '</h3>';
                } else {
                    $view = '<h4 class="text-danger"> <strong>عذرا ! : </strong>' . Message::getMessage($key) . '</h4>';
                }

                break;

            case 1:
                if ($key = 'main') {
                    $view = '<h3 class="text-success text-center"> <strong>OK ! : </strong>' . Message::getMessage($key) . '</h3>';
                }

                break;

        }
        return $view;

    }


}


?>
