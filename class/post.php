<?php

require_once(__DIR__ . '/tools.php');

class Post {

    private $_id;
    private $_db;

    private $_publisher;
    private $_id_community;
    private $_date;
    private $_title;
    private $_description;
    private $_visible;

    public function __construct(mysqli $db, int $id) {
        $this->_db = $db;
        $this->_id = (int) $id;

        if (!is_id_correct($this->_db, Config::TABLE_POST, $this->id())) {
            throw new InvalidID('id "' . $this->id() . '" in table "' . Config::TABLE_POST . '" isn`t correct.');
        }
    }

    public function id() { return $this->_id;}

    public function publisher() : int;
    public function id_community() : int;
	public function date() : datetime;
	public function title() : string;
	public function description() : string;
	public function is_visible() : bool;
	
	public function get_nb_up_votes() : int;
	public function get_nb_down_votes() : int;
	
	public function upvote(User $u) : bool;
	public function downvote(User $u) : bool;

	public function get_documents() : array;

	public function set_visible(bool $visib) : bool;

	public function delete_post() : bool;
}