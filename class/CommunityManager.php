<?php
class CommunityManager {

    private $_db;

    public function __construct(mysqli $db) {
        $this->_db = $db;
    }

    /**
     * Get a community by its id
     */
    public function get_by_id(int $id){
        try {
            return new Community($this->_db, $id);
        } catch (InvalidID $e) {
            return null;
       }
    }
    /** 
     * Add a community to the db
    */
    public function add_community(string $name, string $disp_name, string $description, User $user, array $document, bool $is_private = false) : ?int {
        $sql = "INSERT INTO `%s` (`name`,`is_private`) VALUES ('%s','%d');";
        $sql = sprintf($sql, Config::TABLE_COMMUNITY,$name,$is_private = $is_private ? 1 : 0;);
        if($this->_db->query($sql)){
            $id = (int) $this->_db->insert_id;
            
            $tmp_community = new Community($_db, $id);
            $tmp_community->set_display_name($disp_name);
            $tmp_community->set_description($description);
            $tmp_community->set_cover($document);
            $tmp_community->recruit($user);
            $tmp_community->set_owner($user);


            return $id;
        }
        else{
            return null;
        }

    }

    
}