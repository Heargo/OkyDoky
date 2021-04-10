<?php

/**
 * Provide a way to manipulate a particular comment
 */
class Comment {
	/** DB connection */
	private $_id;

	/** ID of the comment */
	private $_db;

	/** Comment's author */
    private $_author;

	/** Comment's post */
    private $_post;

	/** Comment's text */
    private $_text;

    /**
     * Comment's date 
     * @return int Timestamp.
      */
    private $_date;

	/**
	 * Instanciate a post from an ID
	 *
     * @param mysqli $db Databse connection.
     * @param int $id The id of the comment.
	 * @throw InvalidID If the ID isn't in the DB or if there is more than one.
	 */
	public function __construct(mysqli $db, int $id) {
		$this->_db = $db;
		$this->_id = (int) $id;

		if (!is_id_correct($db, Config::TABLE_COMMENT, $this->id())) {
			throw new InvalidID('id "' . $this->id() . '" in table "' . Config::TABLE_COMMENT . '" isn`t correct.');
		}

		$sql = "SELECT * FROM `%s` WHERE `id_%s` = %d";
		$sql = sprintf($sql, Config::TABLE_COMMENT, Config::TABLE_COMMENT, $this->id());
		$row = $db->query($sql)->fetch_assoc();

        $this->_author = $GLOBALS['users']->get_by_id($row['author']);
        $this->_post = $GLOBALS['posts']->get_by_id($row['post']);
        $this->_text = $row['text'];
        $this->_date = strtotime($row['date']);
    }

    /** Get the id of the comment */
    public function id() : int { return $this->_id; }

    /**
     * Get the date of the comment
     *
     * @return string Date formated like DD/MM/YY H:M:S.
      */
    public function date() : string { return date('d/m/Y H:i', $this->_date); }

    /** Get the text of the comment */
    public function text() : string { return $this->_text; }

    /**
     * Get the author of the comment 
     *
     * @return User The author of the comment.
     * */
    public function author() : User { return $this->_author; }

    /**
     * Get the post where the comment was pulished on 
     *
     * @return Post The post.
     * */
    public function post() : Post { return $this->_post; }

    public function visible() : bool {
        $sql = "SELECT `visible` FROM `%s` WHERE `id_%s` = %d";
        $sql = sprintf($sql, Config::TABLE_COMMENT, Config::TABLE_COMMENT, $this->id());
        $result = $this->_db->query($sql);

        if ($result) {
            return $result->fetch_row()[0] == 1;
        }
        return false;
    }

    /**
     * Did a user liked this comment ?
     *
     * @param User $u The user we're concerned about.
     * @return bool True if the user $u liked the comment $this.
     */
    public function hasUserLiked(User $u) : bool {
        $sql = "SELECT COUNT(1) FROM `%s` WHERE `user` = %d AND `comment` = %d";
        $sql = sprintf($sql, Config::TABLE_LIKE, $u->id(), $this->id());
        $hasLiked = $this->_db->query($sql)->fetch_row()[0]; // COUNT always return something, isn't it ?
        return $hasLiked == 1;
    }

    /**
     * Toggle like of a user on a comment
     *
     * @param User $u The user we're concerned about.
     * @return bool True if successful.
     */
    public function like(User $u) : bool {
        $sql = "";
        if ($this->hasUserLiked($u)) {
            $sql = "DELETE FROM `%s` WHERE `user` = %d AND `comment` = %d";
            $sql = sprintf($sql, Config::TABLE_LIKE, $u->id(), $this->id());
        } else {
            $sql = "INSERT INTO `%s` (`comment`,`user`) VALUES (%d,%d)";
            $sql = sprintf($sql, Config::TABLE_LIKE, $this->id(), $u->id());
        }
        return (bool) $this->_db->query($sql);
    }

    /**
     * Return the number of likes
     *
     * @return int the number of user who liked the comment.
     */
    public function nb_likes() : int {
        $sql = "SELECT COUNT(1) FROM `%s` WHERE `comment` = %d";
        $sql = sprintf($sql, Config::TABLE_LIKE, $this->id());
        $nb = $this->_db->query($sql)->fetch_row()[0]; // COUNT returns something
        return $nb;
    }

    public function set_visible(bool $visible) : bool {
        $visible = $visible ? 1 : 0;
        $sql = "UPDATE `%s` SET `visible` = %d WHERE `id_%s` = %d";
        $sql = sprintf($sql, Config::TABLE_COMMENT, $visible, Config::TABLE_COMMENT, $this->id());
        return (bool) $this->_db->query($sql);
    }
}

