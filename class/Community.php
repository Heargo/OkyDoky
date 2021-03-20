<?php

class Community{

    private $_db;
    private $_id;
    private $_name;
    private $_display_name;
    private $_cover;
    private $_description;
    private $_highlight_post;

    public function _construct(mysqli $db, int $id){
        $sql = "SELECT * FROM `%s` WHERE `id_%s` = $id";
        $sql = sprintf($sql, Config::TABLE_COMMUNITY, Config::TABLE_COMMUNITY, $id);

        $result = $this->_db->query($sql);
        if($result) {
            $row = $result->fetch_assoc();
            $this->$_id = $row["id_community"];
            $this->$_name = $row["name"];
            $this->$_display_name = $row["display_name"];
            $this->$_cover = $row["cover"];
            $this->$_description = $row["description"];
            $this->$_highlight_post = $row["highlight_post"]; 
        }
    }


    /**
     * Get the unique name of the community
     */
    public function id(){
        return $_id;
    }
    public function get_name(){
        return $_name;
    }

    /**
     * Set the display name of the community
     */
    public function set_display_name(String $display_name){
        $_display_name = $display_name;
        $sql = "UPDATE `%s` SET `display_name` = '$display_name' WHERE `%s`.`id_%s` = $_id;";
        $sql = sprintf($sql,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY);
        return $_db->query($sql);
    }
    /**
     * Get the display name of the community
     */
    public function get_display_name(){
        return $_display_name;
    }

    public function set_description(String $description){
        $_description = $description;
        $sql = "UPDATE `%s` SET `description` = '$description' WHERE `%s`.`id_%s` = $_id;";
        $sql = sprintf($sql,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY);
        return $_db->query($sql);
    }
    /**
     * Get a community's description
     */
    public function get_description(){
        return $_description;
    }

    /**
     * Get a community's highlight post (A refaire, récupérer le post dans la bdd)
     */
    // public function get_highlight_post() : Post {
    //     Post $post = new Post($_db,$_highlight_post);
    //     return $post;
    // }

    /**
     * Function to add an user to a communtity
     */
    public function recruit(User $user) : bool {
        $average_nb = (new P(P::AVERAGE))->get();
        $sql = "INSERT INTO `%s` (`id_%s`, `id_%s`, `join_date`, `permissions`, `certified`) VALUES ('%s', '%s',NOW(),'%s','%s');";
        $sql = sprintf($sql, Config::TABLE_USER_COMMUNITY,Config::TABLE_USER,Config::TABLE_COMMUNITY,$user->id(),$_id,$average_nb, $user->is_certified($this));
        return $this->_db->query($sql);
    }

    /**
     * Function to remove an user from a community
     */
    public function leave(User $user) : bool {
        $sql = "DELETE FROM `%s` WHERE `id_%s` = %s;";
        $sql = sprintf($sql, Config::TABLE_USER_COMMUNITY, Config::TABLE_USER, $user->id());
        return $this->_db->query($sql);
    }

    /**
     * Set cover for a community
     */
    public function set_cover(array $document){
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
            $success = $this->_db->query($sql);

            $_cover = $id;
            return $success;
        }
        else{
            //if the image can't be used -> use default one
            $file_url = 'http://' . Config::URL_ROOT() . 'data/cover/default.png';
            $file_path = Config::DIR_COVER . 'default.png';
            $sql = "INSERT INTO `%s` (`url`,`path`) VALUES ('%s';'%s')";
            $sql = sprintf($sql, Config::TABLE_RESOURCE, $file_url, $file_path);
            $success = $this->_db->query($sql);
            $_cover =(int) $this->_db->insert_id;
            return $success;
        }
    } 


    public function set_owner($user){
        if($user->add_perm(P::OWNER, $this)){
            return true;
        }
        return false;        
    }
    /**
     * Find members with permissions in that community
     */
    public function get_members(?int $flags = null) : array{
        return null;
    }
    

    /**
     * Get the posts of a community
     */
    public function get_posts(int $limit = 10, int $offset = 0 ) : array{
        return null;
    }

    public function get_cover() : string{
        return "";
    }

    public function get_nb_members(int $flags = null) : int{
        return 0;
    }

    public function ban(User $user) : bool{return false;}

    public function unban(User $user) : bool{return false;}

    public function get_certified_members() : array{return null;}

    public function get_active_members(?int $days) : array{return null;}
}