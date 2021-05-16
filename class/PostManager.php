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
	public function add_post(User $publisher, Community $commu, string $title, string $description, array $documents, bool $visible = true) : ?int {
		/* TODO if (!$publisher->can(P::INTERACT, $community)) {
			throw new UserCantInteract("User ".$publisher->nickname()." cannot interact with ".$community->get_name()."'s community!");
		} TODO */
		$sql = "INSERT INTO `%s` (`publisher`, `community`, `title`) VALUES ('%d','%d','%s')";
		$sql = sprintf($sql, Config::TABLE_POST, $publisher->id(), $commu->id(), sanitize_text($title));
		$creation_ok = $this->_db->query($sql);
		$description_ok = false;
		$documents_ok = false;
		$id_post = $this->_db->insert_id;
		if ($creation_ok) {
			// the post we are creating
			$post = new Post($this->_db, $id_post);
			$description_ok = $post->set_description_to($description);
			$documents_ok = $post->set_document_links($documents);
			$post->set_visible($visible);
			return $id_post;
		}
		return null;
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
	public function get_by_community(Community $community, bool $visible = true, int $limit = 10, int $offset = 0) {
		$visible = $visible ? 1 : 0;
		$sql = "SELECT `id_%s` FROM `%s` WHERE `visible` = %d AND `community` = %d ORDER BY `date` DESC LIMIT %d OFFSET %d";
		$sql = sprintf($sql, Config::TABLE_POST, Config::TABLE_POST, $visible, $community->id(), $limit, $offset);
		$result = $this->_db->query($sql);
		if ($result) {
			for ($list = array();
				 $row = $result->fetch_assoc();
				 $list[] = new Post($this->_db, $row['id_' . Config::TABLE_POST]));
			return $list;
		}
		return array();
	}

	public function get_by_communities_and_friends(int $limit = 10, int $offset = 0) {
		$u = User::current()->id();
		$sql = "
			SELECT DISTINCT p.id_%s FROM `%s` p
			LEFT JOIN `%s` f1 ON p.publisher = f1.user1
			LEFT JOIN `%s` f2 ON p.publisher = f2.user2 
			LEFT JOIN `%s` uc ON p.community = uc.community 
			WHERE p.visible = 1 
			AND (
				uc.user  = %d OR 
				((f1.user1 = %d OR 
				f1.user2 = %d OR 
				f2.user1 = %d OR 
				f2.user2 = %d) AND (f1.hasAccepted = 1 OR f2.hasAccepted = 1)) 
			) 
			ORDER BY YEAR(p.date) DESC, 
					MONTH(p.date) DESC, 
					DAY(p.date) DESC, 
					REPLACE(f1.user1,%d,null) DESC, 
					REPLACE(f2.user2,%d,null) DESC,
					REPLACE(f1.user2,%d,null) DESC, 
					REPLACE(f2.user1,%d,null) DESC,
					p.date DESC
			LIMIT %d OFFSET %d";
		$sql = sprintf($sql, Config::TABLE_POST, Config::TABLE_POST, Config::TABLE_FRIEND, Config::TABLE_FRIEND, Config::TABLE_USER_COMMUNITY, $u, $u, $u, $u, $u, $u, $u, $u, $u, $limit, $offset);
		$result = $this->_db->query($sql);
		if ($result) {
			$list = array();
			while ($row = $result->fetch_assoc()) {
				$tmpP = new Post($this->_db, (int) ($row['id_' . Config::TABLE_POST]));
				$c = $tmpP->community();
				if ($c->user_in(User::current())){
					if (User::current()->perm($c)->get() != 0) {
						$list[] = $tmpP;
					}
				} else {
					$list[] = $tmpP;
				}
			}
			return $list;
		}
		return array();
	}

	

	/**
	 * Get number of posts by community
	 *
	 * @param bool|null $visible Filter if posts are marked as visible or not. Null will return both.
	 * @param Community $community The community where we are searching in
	 * @return int Number of posts.
	 */
	public function get_num_by_community(Community $community, bool $visible = true) {
		$visible = $visible ? 1 : 0;
		$sql = "SELECT COUNT(1) as c FROM `%s` WHERE `visible` = %d AND `community` = %d";
		$sql = sprintf($sql, Config::TABLE_POST, $visible, $community->id());
		$result = $this->_db->query($sql);
		if ($result) {
			$row = $result->fetch_assoc();
			return $row["c"];
		}
		return 0;
	}

	/**
	 * Get an array of posts by community and user
	 *
	 * @param bool|null $visible Filter if posts are marked as visible or not. Null will return both.
	 * @param Community $community The community where we are searching in
	 * @param int $limit Limits the number of posts you want.
	 * @param int $offset So you can get documents by slice of $limit. $offset should be a multiple of $limit.
	 * @return Posts[] An array of posts.
	 */
	public function get_by_user_and_community(User $user, Community $community, bool $visible = true, int $limit = 10, int $offset = 0) {
		$visible = $visible ? 1 : 0;
		$sql = "SELECT `id_%s` FROM `%s` WHERE `visible` = %d AND `community` = %d AND `publisher` = %d ORDER BY `date` DESC LIMIT %d OFFSET %d";
		$sql = sprintf($sql, Config::TABLE_POST, Config::TABLE_POST, $visible, $community->id(), $user->id(), $limit, $offset);
		$result = $this->_db->query($sql);
		if ($result) {
			for ($list = array();
				 $row = $result->fetch_assoc();
				 $list[] = new Post($this->_db, $row['id_' . Config::TABLE_POST]));
			return $list;
		}
		return array();
	}



	/**
	 * Get an array of posts by publisher
	 *
	 * @param bool|null $visible Filter if posts are marked as visible or not. Null will return both.
	 * @param User $publisher The user we are searching for
	 * @param int $limit Limits the number of posts you want.
	 * @param int $offset So you can get documents by slice of $limit. $offset should be a multiple of $limit.
	 * @return Posts[] An array of posts.
	 */
	public function get_by_publisher(User $publisher, bool $visible = true, int $limit = 10, int $offset = 0) : array {
		$visible = $visible ? 1 : 0;
		$sql = "SELECT `id_%s` FROM `%s` WHERE `visible` = %d AND `publisher` = %d LIMIT %d OFFSET %d";
		$sql = sprintf($sql, Config::TABLE_POST, Config::TABLE_POST, $visible, $publisher->id(), $limit, $offset);
		$result = $this->_db->query($sql);
		if($result) {
			for ($list = array();
				 $row = $result->fetch_assoc();
				 $list[] = new Post($this->_db, $row['id_' . Config::TABLE_POST]));
			return $list;
		}
		return array();
	}

	/**
	 * Get number of posts by publisher
	 *
	 * @param bool|null $visible Filter if posts are marked as visible or not. Null will return both.
	 * @param Publisher $publisher The publisher where we are searching in
	 * @return int Number of posts.
	 */
	public function get_num_by_publisher(User $publisher, bool $visible = true) {
		$visible = $visible ? 1 : 0;
		$sql = "SELECT COUNT(1) as c FROM `%s` WHERE `visible` = %d AND `publisher` = %d";
		$sql = sprintf($sql, Config::TABLE_POST, $visible, $publisher->id());
		$result = $this->_db->query($sql);
		if($result) {
			$row = $result->fetch_assoc();
			return $row["c"];
		}
		return 0;
	}

	/**
	 * Get an array of posts by most votes
	 *
	 * @param bool|null $visible Filter if posts are marked as visible or not. Null will return both.
	 * @param Community $c The community we are in
	 * @param int $limit Limits the number of posts you want.
	 * @param int $offset So you can get documents by slice of $limit. $offset should be a multiple of $limit.
	 * @return Posts[] An array of posts.
	 */
	public function get_by_most_votes(Community $c, bool $visible = true, int $limit = 1, int $offset = 0) : array {
		$visible = $visible ? 1 : 0;
		$sql = 'SELECT p.id_%1$s, vPlus.c, vMinus.c
				FROM `%1$s` p 
				LEFT OUTER JOIN 
					(SELECT id_%1$s, COUNT(v1.mark) AS c
						FROM `%1$s` p1
						JOIN `%2$s` v1 ON v1.post = p1.id_%1$s 
						WHERE p1.visible = %3$d 
						AND p1.community = %4$d
						AND v1.mark = "%5$s" 
						GROUP BY v1.post) 
					vPlus
				ON vPlus.id_%1$s = p.id_%1$s
				LEFT OUTER JOIN 
					(SELECT id_%1$s, COUNT(v2.mark) AS c
						FROM `%1$s` p2 
						JOIN `%2$s` v2 ON v2.post = p2.id_%1$s
						WHERE p2.visible = %3$d
						AND p2.community = %4$d 
						AND v2.mark = "%6$s" 
						GROUP BY v2.post)
					vMinus
				ON vMinus.id_%1$s = p.id_%1$s
				WHERE p.visible = %3$d 
				AND p.community = %4$d
				ORDER BY (IFNULL(vPlus.c, 0) - IFNULL(vMinus.c, 0)) DESC, vPlus.c DESC, p.date DESC 
				LIMIT %7$d OFFSET %8$d';
		$sql = sprintf($sql, Config::TABLE_POST, Config::TABLE_VOTE, $visible, $c->id(),"up", "down", $limit, $offset);
		$result = $this->_db->query($sql);
		if($result) {
			for ($list = array();
				 $row = $result->fetch_assoc();
				 $list[] = new Post($this->_db, $row['id_' . Config::TABLE_POST]));
			return $list;
		}
		return array();
	}
	/**
	 * Get an array of posts by the search value
	 *
	 * @param String $researh the string to find in post titles
	 * @return Posts[] An array of posts.
	 */
	public function search_post_by_title(String $research){
		$sql = "SELECT p.`id_%s` FROM `%s` p JOIN `%s` uc ON uc.community = p.community WHERE p.title LIKE '%%$research%%' AND uc.user = %d AND p.visible = 1";
		$sql = sprintf($sql, Config::TABLE_POST,Config::TABLE_POST,Config::TABLE_USER_COMMUNITY, User::current()->id());
		$res = $this->_db->query($sql);
		if ($res) {
			for ($list = array();
				 $row = $res->fetch_row();
				 $list[] = new Post($this->_db, $row[0]));
			return $list;
		}
		return array();
	}

	/**
	  * Delete a post based on its ID
	  *
	  * @param Post $post The new deleted post.
	  * @return bool True if successful.
	 */
	public function del_post(Post $post) : bool {
        $sql = sprintf("DELETE FROM `%s` WHERE `id_%s` = %d", Config::TABLE_POST, Config::TABLE_POST, $post->id());
        return $this->_db->query($sql);
	}


	public function delete_posts_from(User $u, Community $c) {
		$posts = $this->get_by_user_and_community($u, $c, true, 9999999999);
		$hasAllWorked = true;
		foreach ($posts as $p) {
			$hasAllWorked = $hasAllWorked && $this->del_post($p);
		}
		return $hasAllWorked;
	}
}