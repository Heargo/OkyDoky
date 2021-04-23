<?php

/**
 * Provide a way to manipulate comments
 */
class CommentManager {

    /**
     * DB connection
     */
    private $_db;

    /**
     * Instaciate a manager for a DB connection
     */
    public function __construct(mysqli $db) {
        $this->_db = $db;
    }
    
    /**
     * Get a comment by its ID
     */
    public function get_by_id(int $id) : ?Comment {
        try {
            return new Comment($this->_db, $id);
        } catch (InvalidID $e) {
            return null;
       }
    }

    /**
     * Get comment(s) bound to a post
     *
     * @return Comment[] Array of comment.
     */
    public function get_by_post(Post $p, bool $visible = true) : ?array {
        $sql = "SELECT `id_%s` FROM `%s` WHERE `post` = %d AND `visible` = %d";
        $sql = sprintf($sql, Config::TABLE_COMMENT, Config::TABLE_COMMENT, $p->id(), $visible);
        $result = $this->_db->query($sql);

        if ($result) {
            for ($list = array();
                 $row = $result->fetch_row();
                 $list[] = new Comment($this->_db, $row[0]));
            return $list;
        }
        return null;
    }

    /**
     * Add a comment to a post
     *
     * @param User $author The user that wrote the comment.
     * @param Post $p The post the comment was written on.
     * @param string $text The comment itself.
     * @param bool $visible if the comment should be visible by average user.
     *
     * @return null|int Return the id of the comment if successful, null otherwise.
     */
    public function add_comment(User $author, Post $p, string $text, bool $visible = true) : ?int {
        $visible = $visible ? 1 : 0;
        $text = filter_var($text, FILTER_SANITIZE_SPECIAL_CHARS);
		$sql = "INSERT INTO `%s` (`author`, `post`, `text`, `visible`) VALUES (%d,%d,'%s',%d)";
		$sql = sprintf($sql, Config::TABLE_COMMENT, $author->id(), $p->id(), $text, $visible);
        $result = $this->_db->query($sql);

        if ($result) {
            return $this->_db->insert_id;
        }
        return null;
    }

    public function deleteComment(Comment $c) : bool {
        return $c->set_visible(false);
    }

}
