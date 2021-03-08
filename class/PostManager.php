<?php

class PostManager {

    /** DB connection */
    private $_db;
    
    /**
     * Instaciate a manager for a DB connection
     */
    public function __construct(mysqli $db) {
        $this->_db = $db;
    }
    /**
     * Create a new post in the db
     *
     * @throw UserCantInteract If the user cannot create a post for this community
     * @param Document[] $documents Array of documents coming from $_FILES. 
     */
    public function add_post(User $publisher = null, Community $community = null, string $title, string $description, array $documents = null) : bool {
        /*if (!$publisher->can(P::INTERACT, $community)) {
            throw new UserCantInteract("User ".$publisher->nickname()." cannot interact with ".$community->name()."'s community!");
        }*/
        $sql = "INSERT INTO `%s` (`publisher`, `id_community`) VALUES ('%d','%d')";
        $sql = sprintf($sql, Config::TABLE_POST, $publisher::id(), $community::id());
        $creation_ok = $this->_db->query($sql);

        $title_ok = false;
        $description_ok = false;
        $documents_ok = false;
        if ($creation_ok) {
            // the post we are creating
            $post = new Post($this->_db, $this->_db->insert_id);
            $title_ok = $post->set_title_to($title);
            $description_ok = $post->set_description_to($description);
            $documents_ok = $post->set_document_links($documents);
        }
        
        return $creation_ok & $title_ok & $description_ok & $documents_ok;
    }

    /**
     * Get a post by its ID
     */
    public function get_by_id(int $id){
        try {
            return new Post($this->_db, $id);
        } catch (InvalidID $e) {
            return null;
       }
    }
    /**
     * Get an array of posts by community
     *
     * @param bool|null $visible Filter if posts are marked as visible or not. Null will return both.
     * @param Community $community The community where we are searching in
     * @param int $limit Limits the number of posts you want.
     * @param int $offset So you can get documents by slice of $limit. $offset should be a multiple of $limit.
     * @return Posts[] An array of posts.
     */
    // public function get_by_community(?bool $visible = true, Community $community, int $limit = 10, int $offset = 0) : array {
    //     if (isset($visible)) {
    //         $visible = $visible ? 1 : 0;
    //         $sql = "SELECT `id_%s` FROM `%s` WHERE `visible` = %d AND `community` = %d LIMIT %d OFFSET %d";
    //         $sql = sprintf($sql, Config::TABLE_POST, Config::TABLE_POST, $visible, $community->id(), $limit, $offset);
    //     } else {
    //         $sql = "SELECT `id_%s` FROM `%s` WHERE `visible` = %d AND `community` = %d LIMIT %d OFFSET %d";
    //         $sql = sprintf($sql, Config::TABLE_POST, Config::TABLE_POST, $community->id(), $limit, $offset);
    //     }
    //     $result = $this->_db->query($sql);
    //     if($result) {
    //         for ($list = array();
    //              $row = $result->fetch_assoc();
    //              $list[] = new Post($this->_db, $row['id_' . Config::TABLE_POST]));
    //         return $list;
    //     }
    //     return array();
    // }

    /**
     * Get an array of posts by publisher
     *
     * @param bool|null $visible Filter if posts are marked as visible or not. Null will return both.
     * @param User $publisher The user we are searching for
     * @param int $limit Limits the number of posts you want.
     * @param int $offset So you can get documents by slice of $limit. $offset should be a multiple of $limit.
     * @return Posts[] An array of posts.
     */
    // public function get_by_publisher(?bool $visible = true, User $publisher, int $limit = 10, int $offset = 0) : array {
    //     if (isset($visible)) {
    //         $visible = $visible ? 1 : 0;
    //         $sql = "SELECT `id_%s` FROM `%s` WHERE `visible` = %d AND `publisher` = %d LIMIT %d OFFSET %d";
    //         $sql = sprintf($sql, Config::TABLE_POST, Config::TABLE_POST, $visible, $publisher->id(), $limit, $offset);
    //     } else {
    //         $sql = "SELECT `id_%s` FROM `%s` WHERE `visible` = %d AND `publisher` = %d LIMIT %d OFFSET %d";
    //         $sql = sprintf($sql, Config::TABLE_POST, Config::TABLE_POST, $publisher->id(), $limit, $offset);
    //     }
    //     $result = $this->_db->query($sql);
    //     if($result) {
    //         for ($list = array();
    //              $row = $result->fetch_assoc();
    //              $list[] = new Post($this->_db, $row['id_' . Config::TABLE_POST]));
    //         return $list;
    //     }
    //     return array();
    // }

    /**
      * Delete a post based on its ID
      *
      * @param Post $post The new deleted post.
      * @return bool True if successful.
     */
    public function del_post(Post $post) : bool {
        
        // Visibility
        $visib_ok = $post->set_visible(false);
        
        // Title
        $title_ok = $post->set_title_to("");
        
        // Description
        $desc_ok = $post->set_description_to("");

        // Documents
        // $docs_ok = $post->del_all_docs();
        return $visib_ok & $title_ok & $desc_ok & $docs_ok;
    }
}