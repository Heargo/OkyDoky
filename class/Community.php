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
    public function get_name(){
        return $_name;
    }

    /**
     * Get the display name of the community
     */
    public function get_display_name(){
        return $_display_name;
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
    
    public function set_cover(array $cover) : bool{return false;}

    public function get_nb_members(int $flags = null) : int{
        return 0;
    }

    public function ban(User $user) : bool{return false;}

    public function unban(User $user) : bool{return false;}

    public function get_certified_members() : array{return null;}

    public function get_active_members(?int $days) : array{return null;}
}