<?php

class Community{

    private $_db;
    private $_id;
    private $_name;
    private $_display_name;
    private $_cover;
    private $_description;
    private $_highlight_post;

    public function __construct(mysqli $db, int $id){
        $this->_id = $id;
        $this->_db = $db;
        if (!is_id_correct($this->_db, Config::TABLE_COMMUNITY, $this->id())) {
            throw new InvalidID('id "' . $this->id() . '" in table "' . Config::TABLE_COMMUNITY . '" isn`t correct.');
        }
        $sql = "SELECT * FROM `%s` WHERE `id_%s` = $id";
        $sql = sprintf($sql, Config::TABLE_COMMUNITY, Config::TABLE_COMMUNITY, $id);

        $row = $db->query($sql)->fetch_assoc();
        $this->_name = $row["name"];
        $this->_display_name = $row["display_name"];
        $this->_cover = $row["cover"];
        $this->_description = $row["description"];
        $this->_highlight_post = $row['highlight_post'];
    }


    /**
     * Get the unique name of the community
     */
    public function id(){
        return $this->_id;
    }
  
    public function get_name(){
        return $this->_name;
    }

    /**
     * Set the display name of the community
     */
    public function set_display_name(String $display_name){
        $_display_name = $display_name;
        $sql = "UPDATE `%s` SET `display_name` = '$display_name' WHERE `%s`.`id_%s` = $this->_id ;";
        $sql = sprintf($sql,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY);
        return $this->_db->query($sql);
    }
  
    /**
     * Get the display name of the community
     */
    public function get_display_name(){
        return $this->_display_name;
    }

    public function set_description(String $description){
        $this->_description = $description;
        $sql = "UPDATE `%s` SET `description` = '$description' WHERE `%s`.`id_%s` = $this->_id;";
        $sql = sprintf($sql,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY);
        return $this->_db->query($sql);
    }

    /**
     * Get a community's description
     */
    public function get_description(?int $length = null){
        return substr($this->_description,0,$length);
    }

    /**
     * Get a community's highlight post (A refaire, récupérer le post dans la bdd)
     * @todo Si hp = NULL dans la bdd -> get_by_most_votes sinon hp
     */
    public function get_highlight_post() : ?Post {
        if($this->_highlight_post != null){
            $post = new Post($this->_db,$this->_highlight_post);
            return $post;
        }
        else{
            $posts = $GLOBALS['posts']->get_by_most_votes($this);
            if(sizeof($posts) != 0){
                return $posts[0];
            }
        }
        return null;
    }

    public function set_highlight_post(int $id = 0){
        if($this->_highlight_post == NULL && $id == 0){
            $higherPost = $GLOBALS['posts']->get_by_most_votes($this);
            if(sizeof($higherPost) != 0){
                $highlight_id = $higherPost[0]->id();
                $sql = "UPDATE `%s` SET `highlight_post` = '$highlight_id' WHERE `%s`.`id_%s` = %d";
                $sql = sprintf($sql, Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY,$this->id());
                return $this->_db->query($sql);
            }
        }
        else{
            $sql = "UPDATE `%s` SET `highlight_post` = '$id' WHERE `%s`.`id_%s` = $this->_id;";
            $sql = sprintf($sql,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY);
            return $this->_db->query($sql);

        }
        
        return NULL;
    }

    public function remove_highlight_post(){
        $sql = "UPDATE `%s` SET `highlight_post` = NULL WHERE `%s`.`id_%s` = %d";
        $sql = sprintf($sql, Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY,$this->id());
        return $this->_db->query($sql);
    }

    /**
     * Function to add an user to a communtity
     */
    public function recruit(User $user, bool $owner = false) : bool {
        $average_nb = (new Permission(P::AVERAGE));
        if ($owner) {
            $average_nb->add(P::OWNER);
        }
        $sql = "INSERT INTO `%s` (`user`, `community`, `join_date`, `permission`, `certified`) VALUES ('%s', '%s',NOW(),'%d','%s');";
        $sql = sprintf($sql, Config::TABLE_USER_COMMUNITY, $user->id(),$this->_id, $average_nb->get(), 0);
        return $this->_db->query($sql);
    }

    /**
     * Function to remove an user from a community
     */
    public function leave(User $user) : bool {
        $sql = "DELETE FROM `%s` WHERE `%s` = %s AND `%s` = %s;";
        $sql = sprintf($sql, Config::TABLE_USER_COMMUNITY, Config::TABLE_USER, $user->id(),Config::TABLE_COMMUNITY,$this->_id);
        return $this->_db->query($sql);
    }
    public function update_cover(int $id_cover){
        $sql = "UPDATE `%s` SET `cover` = '$id_cover' WHERE `%s`.`id_%s` = $this->_id;";
        $sql = sprintf($sql,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY);
        return (bool) $this->_db->query($sql);
    }
    /**
     * Set cover for a community
     */
    public function user_in(User $user){
        $sql = "SELECT COUNT(1) FROM %s WHERE `community` = %d AND `user` = %d";
        $sql = sprintf($sql, Config::TABLE_USER_COMMUNITY, $this->id(), $user->id());
        $result = $this->_db->query($sql);
        $is_in = ((int) $result->fetch_row()[0]) >= 1;
        return $is_in;
    }
    public function set_cover(array $document){
        // if file isn't empty and not too large
        var_dump($document['size']);
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

            $this->_cover = $id;
            //$success = update_cover($id);

            //Update de la cover
            $sql = "UPDATE `%s` SET `cover` = '$this->_cover' WHERE `%s`.`id_%s` = $this->_id;";
            $sql = sprintf($sql,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY);
            $success =  $this->_db->query($sql);
            return $success;
        }
        else{
            //if the image can't be used -> use default one
            $file_url = 'http://' . Config::URL_ROOT() . 'img/default_community.png';
            $file_path = 'img/default_community.png';
            $sql = "INSERT INTO `%s` (`url`,`path`) VALUES ('%s','%s')";
            $sql = sprintf($sql, Config::TABLE_RESOURCE, $file_url, $file_path);
            $success = $this->_db->query($sql);
            $this->_cover =(int) $this->_db->insert_id;
            //$success = update_cover($id);

            //update de la cover
            $sql = "UPDATE `%s` SET `cover` = '$this->_cover' WHERE `%s`.`id_%s` = $this->_id;";
            $sql = sprintf($sql,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY,Config::TABLE_COMMUNITY);
            $success =  $this->_db->query($sql);
            return $success;
        }

    }

    public function set_owner($user){
        if($user->add_perm(P::OWNER, $this)){
            return true;
        }
        return false;        
    }
    public function promote(User $user,Permission $p){
        return $user->set_perm($this,$p);
    }
    public function get_owner(){
        $sql = "SELECT * FROM `%s` WHERE `permission` = %d AND `community` = %d";
        $sql = sprintf($sql, Config::TABLE_USER_COMMUNITY,8207,$this->id());
        $res = $this->_db->query($sql)->fetch_assoc();
        return $GLOBALS['users']->get_by_id((int)$res['user']);
    }
    /**
     * Find members with permissions in that community
     */
    public function get_members(){
        $sql = "SELECT * FROM `%s` WHERE `%s` = %d";
        $sql = sprintf($sql,Config::TABLE_USER_COMMUNITY,Config::TABLE_COMMUNITY,$this->_id);
        $res = $this->_db->query($sql);
        if ($res) {
			for ($list = array();
				 $row = $res->fetch_assoc();
				 $list[] = new User($this->_db, $row['user']));
			return $list;
		}
		return array();

    }

    public function get_team(Permission $perm){
        $sql = "SELECT * FROM `%s` WHERE `%s` = %d AND `%s` = %d";
        $sql = sprintf($sql,Config::TABLE_USER_COMMUNITY,Config::TABLE_COMMUNITY,$this->_id,"permission",$perm->get());
        $res = $this->_db->query($sql);
        if ($res) {
			for ($list = array();
				 $row = $res->fetch_assoc();
				 $list[] = new User($this->_db, $row['user']));
			return $list;
		}
		return array();

    }

    
    

    /**
     * Get the posts of a community
     */
    public function get_posts(int $limit = 10, int $offset = 0 ) : array{
        return $GLOBALS['posts']->get_by_community($this);
    }

    public function get_cover() : string{
        $sql = "SELECT `url` FROM `%s` WHERE `id_%s` = %d";
        $sql = sprintf($sql, Config::TABLE_RESOURCE, Config::TABLE_RESOURCE, $this->_cover);
        $result = $this->_db->query($sql);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function get_nb_members(int $flags = null) : int{
        $sql = "SELECT COUNT(*) FROM `%s` WHERE `%s` = %d";
        $sql = sprintf($sql, Config::TABLE_USER_COMMUNITY, Config::TABLE_COMMUNITY, $this->_id);
        $result = $this->_db->query($sql);
        $row = mysqli_fetch_row($result);
        return $row[0];
        
    }
    

    public function ban(User $user) : bool{return false;}

    public function unban(User $user) : bool{return false;}

    public function get_certified_members() : array{
        $members = array();
        $sql = "SELECT %s FROM `%s` WHERE `%s` = %d AND `%s` = %d";
        $sql = sprintf($sql, Config::TABLE_USER, Config::TABLE_USER_COMMUNITY, Config::TABLE_COMMUNITY,$this->id(),"certified", 1);
        $res = $this->_db->query($sql);
        if ($res) {
			for ($list = array();
				 $row = $res->fetch_assoc();
				 $list[] = new User($this->_db, $row['user']));
			return $list;
		}
		return array();
    }

    public function get_active_members() : array{
        $members = $this->get_members();
        $sorted_members = array();
        foreach($members as $m){
            $mid = $m->id();
            $sql = "SELECT COUNT(*) FROM `%s` WHERE `%s` = %d AND `publisher` = %d LIMIT 5";
            $sql = sprintf($sql, Config::TABLE_POST, Config::TABLE_COMMUNITY, $this->_id,$mid);
            $result = $this->_db->query($sql);
            $row = mysqli_fetch_row($result);
            if ($row[0] != 0){
                $sorted_members[$mid] = $row[0];
            }
            

        }
        arsort($sorted_members);
        return $sorted_members;
    }

    public function certify_user(User $user){
        $sql = "UPDATE `%s` SET `certified` = '%s' WHERE `%s` = %s AND `%s` = %s ";
        $sql = sprintf($sql,Config::TABLE_USER_COMMUNITY,1,Config::TABLE_COMMUNITY, $this->id(),Config::TABLE_USER,$user->id());
        return $this->_db->query($sql);
    }

    public function uncertify_user(User $user){
        $sql = "UPDATE `%s` SET `certified` = '%s' WHERE `%s` = %s AND `%s` = %s ";
        $sql = sprintf($sql,Config::TABLE_USER_COMMUNITY,0,Config::TABLE_COMMUNITY, $this->id(),Config::TABLE_USER,$user->id());
        return $this->_db->query($sql);
    }

    public function set_label(User $user, string $label_text, string $color){
        $sql = "INSERT INTO `%s` (`user`,`community`,`label_name`,`color`) VALUES ('%s','%s','%s','%s');";
        $sql = sprintf($sql,Config::TABLE_LABEL,$user->id(),$this->id(),$label_text,$color);
        return $this->_db->query($sql);
    }
    
    public function delete_label(int $id_label){
        $sql = "DELETE FROM `%s` WHERE `id_%s` = %s ";
        $sql = sprintf($sql, Config::TABLE_LABEL,Config::TABLE_LABEL, $id_label);
        return $this->_db->query($sql);
    }


    /**
     * Get all label of the user in the community
     * 
     * @param User the user you want the label from
     * @return array associative array : id_label, label_name, color
     */
    public function get_label(User $user){
        $sql = "SELECT `id_label`,`label_name`,`color` FROM `%s` WHERE `%s` = %s AND `%s` = %s ";
        $sql = sprintf($sql, Config::TABLE_LABEL, Config::TABLE_COMMUNITY, $this->id(), Config::TABLE_USER, $user->id());
        $res = $this->_db->query($sql);
        if ($res) {
            $list=array();
            while ($row = $res->fetch_assoc()) {
                $list[] = $row;
            }
            return $list;
		}
		return array();
    } 
}
