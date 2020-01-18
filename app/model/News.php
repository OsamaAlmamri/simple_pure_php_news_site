<?php
/**
 *
 */

class News
{

    protected $db;

    function __construct()
    {
        $this->db = new Model();
    }

// return all row of table of news
    public function all()
    {
        return $this->db->query("select * from news");
    }

    public function page($id)
    {
        return $this->db->query("select * from news where categories like '%\"$id\"%' ");
    }

    public function find($id)
    {
//        $oStmt = $this->db->preparation('SELECT * FROM news WHERE id =$id');
        return $this->db->query("select * from news WHERE id =$id");
//        $oStmt->execute($aData);
//        return $oStmt->fetch();

    }


    public function add(array $aData)
    {

        $oStmt = $this->db->preparation('INSERT INTO news (  categories, editor, title, introduction, logo,sort,  has_comment,
                                                 status, created_by, updates, created_at, updated_at)
                                                  VALUES (  :categories, :editor, :title, :introduction, :logo,:sort, :has_comment, 
                                                  :status,:created_by, :updates, :created_at, :updated_at)');
        return $oStmt->execute($aData);

    }


    public function update(array $aData)
    {

        $oStmt = $this->db->preparation('update  news set categories =:categories, editor=:editor, title=:title, introduction=:introduction, logo=:logo,sort=:sort,  has_comment=:has_comment,
                                                 status=:status, updates=:updates, updated_at=:updated_at where id=:id
                                                  ');
        return $oStmt->execute($aData);

    }


    public function findCategory($aData)
    {
        $oStmt = $this->db->preparation('SELECT * FROM news WHERE category =?');
        $oStmt->execute($aData);
        return $oStmt->fetchAll();

    }

//add new row to news table

    public function delete($id)
    {

        $oStmt = $this->db->preparation('delete from  news  WHERE id LIKE  ? ');
        return $oStmt->execute(array(0 => $id));
//        return $oStmt->execute($aData);

    }
}


?>
