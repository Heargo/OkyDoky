<?php

class PostManager {

    /** DB connection */
    private $_db;

    public function __construct(mysqli $db) {
        $this->_db = $db;
    }
    /**
     * create a new post in the db
     *
     * @param Document[] $documents Array of documents coming from $_FILES. 
     */
    public function add_post(User $publisher, Community $community, string $title, string $description, Document[] $documents) : bool {
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
}