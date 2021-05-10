<?php
class Favoris{

    private $_db;
    private $_id;
    private $_post;
    private $_user;
    private $_date_fav
    
    public function __construct(mysqli $db, int $id){
        $this->_id = $id;
        $this->_db = $db;
        if (!is_id_correct($this->_db, Config::TABLE_FAVORIS, $this->id())) {
            throw new InvalidID('id "' . $this->id() . '" in table "' . Config::TABLE_FAVORIS . '" isn`t correct.');
        }
        $sql = "SELECT * FROM `%s` WHERE `id_%s` = $id";
        $sql = sprintf($sql, Config::TABLE_FAVORIS, Config::TABLE_FAVORIS, $id);

        $row = $db->query($sql)->fetch_assoc();
        $this->_post = $GLOBALS['posts']->get_by_id($row["post"]);
        $this->_user = $GLOBALS['users']->get_by_id($row['user']);
        $this->_date_fav = strtotime($row["date_fav"]);
    }

    /** Get the id of the favoris */
    public function id() : int { return $this->_id; }

    /**
     * Get the post of the favoris
      */
    public function post() : string { return $this->_post; }

    /** 
     * Get the user of the favoris 
     */
    public function user() : string { return $this->_user; }

    /**
     * Get the date of the favoris
     *
     * @return string Date formated like DD/MM/YY H:M:S.
      */
    public function date_fav() : string { return date("Y-m-d H:i:s", $this->_date_fav); }
}