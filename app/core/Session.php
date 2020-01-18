<?php

abstract class Session
{
    /**
     * @param $key
     * @param $value
     */


    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;

    }


    public static function loggIn(array $user)
    {
        $_SESSION['userID'] = $user['id'];
        $_SESSION['userName'] = $user['username'];
        $_SESSION['role'] = $user['role'];


    }

    public static function logged()
    {

        if (self::has('userID')) {
            return $_SESSION['userID'];
        }
        return null;
    }

    /**
     * @param $key
     * @return null
     */
    public static function get($key)
    {
        if (self::has($key)) {
            return $_SESSION[$key];
        }
        return null;
    }

    /**
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @param $key
     */
    public static function delete($key)
    {

        unset($_SESSION[$key]);
    }

    /**
     * destroy
     */
    public static function destroy()
    {
        session_destroy();
    }
}
