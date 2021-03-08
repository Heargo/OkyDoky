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
    public function add_community(string $name, string $disp_name, string $description, User $user, array $document, bool $private = false) : ?int {
        $sql = "INSERT INTO `%s` (`name`,`display_name`,`cover`,`description`,`date`,`is_private`) VALUES ('%s','%s','%s','%s',NOW(),'%s');";
        $sql = sprintf($sql, Config::TABLE_COMMUNITY,$name,$disp_name,$this->_upload_cover($document),$description,null,$private);
        if($this->_db->query($sql)){
            $id = (int) $this->_db->insert_id;
            return $id;
        }
        else{
            return null;
        }

    }

    private function _upload_cover(array $document){
        // if file isn't empty and not too large
        if ($document['size'] != 0 && $document['size'] < 50000000) {
            if (!is_writable(Config::DIR_COVER)) {
                throw new NotWritable('Directory ' . Config::DIR_COVER . ' is not writable');
            }
            // insert tmp path to DB
            $sql = "INSERT INTO `%s` (`path`) VALUES ('%s')";
            $sql = sprintf($sql, Config::TABLE_RESOURCE, $document['tmp_name']);
            $this->_db->query($sql);

            // move tmp file to permanent path
            $id = (int) $this->_db->insert_id;
            $file_name = basename($id . '_' . $document['name']);
            $file_path = Config::DIR_COVER . $file_name;
            move_uploaded_file($document['tmp_name'], $file_path);

            // update DB with real path
            $file_url = 'http://' . Config::URL_ROOT() . 'data/cover/' . $file_name;
            $sql = "UPDATE `%s` SET `url` = '%s', `path` = '%s' WHERE `id_%s` = '%d'";
            $sql = sprintf($sql, Config::TABLE_RESOURCE, $file_url, $file_path, Config::TABLE_RESOURCE, $id);
            $this->_db->query($sql);

            return $id;
        }
        return null;
    } 
}