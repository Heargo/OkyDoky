<?php
class FavorisManager {

    /** DB connection */
    private $_db;

    /**
     * Instaciate a manager for a DB connection
     */
    public function __construct(mysqli $db) {
        $this->_db = $db;
    }

    public function get_by_id(int $id){
        try {
            return new Favoris($this->_db, $id);
        } catch (InvalidID $e) {
            return null;
       }
    }

    /**
     * Create a new favoris in the db
     *
     * @param Post $p The post to clip. 
     */
    public function createFavoris(Post $p) {
        $sql = "INSERT INTO `%s` (`user`,`post`) VALUES ('%d','%d');";
        $sql = sprintf($sql, Config::TABLE_FAVORIS,User::current()->id(),$p->id());
        if($this->_db->query($sql)){
            $id = (int) $this->_db->insert_id;
            return $id;
        }
        else{
            return null;
        }
    }


    /**
     * Load all favoris from the current user
     */
    public function load_all_favs() {
        $sql = "SELECT `id_%s` FROM `%s` WHERE `user`=%d ORDER BY `date_fav` ASC";
        $sql = sprintf($sql, Config::TABLE_FAVORIS,Config::TABLE_FAVORIS,User::current());
        $res = $this->_db->query($sql);
        if ($res) {
            for ($list = array();
                 $row = $res->fetch_row();
                 $list[] = new Favoris($this->_db, $row[0]));
            return $list;
        }
        return array();
    }


    /**
     * Delete the given favoris
     *
     * @param Favoris $fav The favoris to delete 
     */
    public function delete_fav(Favoris $fav) {
        $sql = sprintf("DELETE FROM `%s` WHERE `id_%s` = %d",Config::TABLE_FAVORIS,Config::TABLE_FAVORIS,$fav->id());
        return $this->_db->query($sql);
    }
}