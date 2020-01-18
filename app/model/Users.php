<?php
/**
 *
 */

class Users
{
    protected $data_file;
    protected $db;
    protected $inventory = [];

    function __construct()
    {
        $this->db = new Model();
    }

// return all row of table of users
    public function all()
    {
        return $this->db->query("select * from users");
    }

//add new row to users table
    public function add(array $aData)
    {
//return var_dump($aData);
        $oStmt = $this->db->preparation('INSERT INTO users ( email,name, username, password, role,phone, status)
                                                  VALUES ( :email,:name, :username, :password, :role,:phone ,:status)');

        return $oStmt->execute($aData);

    }

    // find user by ID
    public function Login(array $aData)
    {
        $oStmt = $this->db->preparation('SELECT * FROM users WHERE username =:username AND password =:password ');
        $oStmt->execute($aData);
        return $oStmt->fetch();

    }

}


?>
