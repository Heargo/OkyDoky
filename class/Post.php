<?php

class Post {

	/** DB connection */
	private $_id;

	/** ID of the post */
	private $_db;

	/** Post's infos */
	private $_publisher;
	private $_community;
	private $_date;
	private $_title;
	private $_description;
	private $_visible;


	/**
	 * Instanciate a post from an ID
	 *
	 * @throw InvalidID If the ID isn't in the DB or if there is more than one.
	 */
	public function __construct(mysqli $db, int $id) {
		$this->_db = $db;
		$this->_id = (int) $id;

		if (!is_id_correct($this->_db, Config::TABLE_POST, $this->id())) {
			throw new InvalidID('id "' . $this->id() . '" in table "' . Config::TABLE_POST . '" isn`t correct.');
		}
		$sql = "SELECT * FROM `%s` WHERE `id_%s` = %s";
		$sql = sprintf($sql, Config::TABLE_POST, Config::TABLE_POST, $id);
		$row = $db->query($sql)->fetch_assoc();
	
		$this->_publisher = $GLOBALS['users']->get_by_id($row['publisher']);
		$this->_community = $GLOBALS['communities']->get_by_id($row['community']);
		$this->_date = $row['date'];
		$this->_title = $row['title'];
		$this->_description = $row['description'];
		$this->_visible = $row['visible'];
	}
	/** Return the post's ID */
	public function id() { return $this->_id; }

	/** Return the post's publisher */
	public function publisher() { return $this->_publisher; }
	
	/** Return the post's community */
	public function community() { return $this->_community; }

	/** Return the post's creation date */
	public function date() { return $this->_date; }

	/** Return the post's title */
	public function title() { return $this->_title; }
	
	/** Return the post's description */
	public function description() { return $this->_description; }

	/** Return the post's visibility */
	public function is_visible() { return $this->_visible; }

	/** Return the post's comments */
	public function comments() { return $GLOBALS['comments']->get_by_post($this); }
	
	/**
	 * Sets the post title
	 *
	 * @param string $title is the new title of the post.
	 * @return bool True if successful
	 */
	public function set_title_to(string $title) {
		$sql = "UPDATE `%s` SET `title` = '%s' WHERE `id_%s` = %s";
		$sql = sprintf($sql, Config::TABLE_POST, sanitize_text($title), Config::TABLE_POST, $this->id());

		return $this->_db->query($sql);
	}

	/**
	 * Sets the post description
	 *
	 * @param string $description is the new description of the post.
	 * @return bool True if successful
	 */
	public function set_description_to(string $description) {
		$sql = "UPDATE `%s` SET `description` = '%s' WHERE `id_%s` = %s";
		$sql = sprintf($sql, Config::TABLE_POST, sanitize_text($description), Config::TABLE_POST, $this->id());

		return $this->_db->query($sql);
	}
	/**
	 * Sets the post related documents
	 *
	 * @param Document[] $documents are the new documents of the post.
	 * @return bool True if successful
	 */
	public function set_document_links(array $documents) {
		$all_docs_linked_ok = true;
		foreach ($documents as $doc) {
			$all_docs_linked_ok &= $doc->bound($this);
		}
		return $all_docs_linked_ok;
	}

	/**
	 * Gets how many upvotes are they for this post
	 *
	 * @return int number_of_votes
	 */
	public function get_nb_up_votes() {
		$sql = "SELECT COUNT(*) FROM `%s` WHERE `post` = '%d' AND `mark` = 'up'";
		$sql = sprintf($sql, Config::TABLE_VOTE, $this->id());
		return $this->_db->query($sql)->fetch_row()[0];
	}

	/**
	 * Gets how many downvotes are they for this post
	 *
	 * @return int number_of_votes
	 */
	public function get_nb_down_votes() {
		$sql = "SELECT COUNT(*) FROM `%s` WHERE `post` = '%d' AND `mark` = 'down'";
		$sql = sprintf($sql, Config::TABLE_VOTE, $this->id());
		return $this->_db->query($sql)->fetch_row()[0];
	}
	
	/**
	 * Gets a percentage of upvotes over the total number of votes
	 *
	 * @return float number_of_votes
	 */
	public function get_percent_up_down() {
		if (($this->get_nb_up_votes() + $this->get_nb_down_votes()) == 0) {
			return;
		}
		return round(100 * $this->get_nb_up_votes() / ($this->get_nb_up_votes() + $this->get_nb_down_votes()));
	}

	/**
	 * Check if the post is voted by a given user
	 *
	 * @param User $u the user who upvote
	 * @return int : 0 if no vote, -1 if downvote, 1 if upvote
	 */
	public function hasUserVoted(User $u) {
		$sql = "SELECT `mark` FROM `%s` WHERE `post` = '%d' AND `user` = '%d'";
		$sql = sprintf($sql, Config::TABLE_VOTE, $this->id(), $u->id());
		if ($row = $this->_db->query($sql)->fetch_assoc()) {
			return $row['mark'] == 'up' ? 1 : -1;
		}
		return 0;
	}

	/**
	 * Upvotes the post by a given user
	 *
	 * @param User $u the user who upvote
	 * @return bool True if successful
	 */
	public function upvote(User $u) {
		switch ($this->hasUservoted($u)) {
			case -1:
				$sql = "DELETE FROM `%s` WHERE `post` = '%d' AND `user` = '%d'";
				$sql = sprintf($sql, Config::TABLE_VOTE, $this->id(), $u->id());
				return $this->_db->query($sql) && $this->upvote($u);
			case 0:
				$sql = "INSERT INTO `%s` (`post`, `user`, `mark`) VALUES ('%d','%d','up')";
				$sql = sprintf($sql, Config::TABLE_VOTE, $this->id(), $u->id());
				return $this->_db->query($sql);
			case 1:
				$sql = "DELETE FROM `%s` WHERE `post` = '%d' AND `user` = '%d'";
				$sql = sprintf($sql, Config::TABLE_VOTE, $this->id(), $u->id());
				return $this->_db->query($sql);
			default:
				return 0;
		}
	}

	/**
	 * Downvotes the post by a given user
	 *
	 * @param User $u the user who downvote
	 * @return bool True if successful
	 */
	public function downvote(User $u) {
		switch ($this->hasUservoted($u)) {
			case 1:
				$sql = "DELETE FROM `%s` WHERE `post` = '%d' AND `user` = '%d'";
				$sql = sprintf($sql, Config::TABLE_VOTE, $this->id(), $u->id());
				return $this->_db->query($sql) && $this->downvote($u);
			case 0:
				$sql = "INSERT INTO `%s` (`post`, `user`, `mark`) VALUES ('%d','%d','down')";
				$sql = sprintf($sql, Config::TABLE_VOTE, $this->id(), $u->id());
				return $this->_db->query($sql);
			case -1:
				$sql = "DELETE FROM `%s` WHERE `post` = '%d' AND `user` = '%d'";
				$sql = sprintf($sql, Config::TABLE_VOTE, $this->id(), $u->id());
				return $this->_db->query($sql);
			default:
				return 1;
		}
	}

	/**
	 * Gets all documents related to the post
	 *
	 * @return Document[] documents
	 */
	public function get_documents() : ?array {
		return $GLOBALS['docs']->get_by_post($this);
	}

	/**
	 * Deletes a given document related to the post
	 *
	 * @throw InvalidDocument If the given document isn't in the post document list
	 * @return bool True if successful
	 */

    public function del_document(Document $document) {
		if (in_array($document, $this->get_documents())) {
			return $GLOBALS['docs']->del_document($document->id());
		} else {
			throw new InvalidDocument('You can\'t delete the document "' . $document->id() . '" from that post!');
		}
	}
    
	/**
	 * Deletes all documents related to the post
	 *
	 * @return bool True if successful
	 */

	public function del_all_docs() {
		$operationValid = true;
		foreach ($this->get_documents() as $document) {
			$operationValid &= $this->del_document($document);
		}
		return $operationValid;
	}
    

	/**
	 * Sets the visibility of the post
	 *
	 * @param bool $visib the new visibility
	 * @return bool True if successful
	 */
	public function set_visible(bool $visib) : bool {
		$sql = "UPDATE `%s` SET `visible` = '%s' WHERE `id_%s` = %s";
		$sql = sprintf($sql, Config::TABLE_POST, $visib ? 1 : 0, Config::TABLE_POST, $this->id());
		return $this->_db->query($sql);
	}

	/**
	 * Show up a post in his community
	 *
	 * @param User $whoTryTo who tries to show up a post
	 * @return bool True if successful
	 */
	public function showup(User $whoTryTo) : bool {
		$commu = new Community($this->_db,$this->community());
		$perm = $whoTryTo->perm($this->$commu);
		if ($perm->can(MOD_HIGHLIGHT_POST)) {
			$sql = "UPDATE `%s` SET `highlight_post` = %d WHERE `id_%s` = %s";
			$sql = sprintf($sql, Config::TABLE_COMMUNITY, $this->id(), Config::TABLE_COMMUNITY, $commu->id());
			return $this->_db->query($sql);
		}
		return false;
	}

}
