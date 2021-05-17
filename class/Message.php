<?php
class Message{

    private $_db;
    private $_id;
    private $_sender;
    private $_msg;
    private $_send_date;
    private $_community;

    public function __construct(mysqli $db, int $id){
        $this->_id = $id;
        $this->_db = $db;
        if (!is_id_correct($this->_db, Config::TABLE_MESSAGE, $this->id())) {
            throw new InvalidID('id "' . $this->id() . '" in table "' . Config::TABLE_MESSAGE . '" isn`t correct.');
        }
        $sql = "SELECT * FROM `%s` WHERE `id_%s` = $id";
        $sql = sprintf($sql, Config::TABLE_MESSAGE, Config::TABLE_MESSAGE, $id);

        $row = $db->query($sql)->fetch_assoc();
        $this->_sender = $GLOBALS['users']->get_by_id($row["sender"]);
        $this->_msg = $row["msg"];
        $this->_send_date = strtotime($row["send_date"]);
        $this->_community = $GLOBALS['communities']->get_by_id($row['community']);
    }

    /** Get the id of the message */
    public function id() : int { return $this->_id; }

    /**
     * Get the date of the message
     *
     * @return string Date formated like DD/MM/YY H:M:S.
      */
    public function send_date() : string { return date("Y-m-d H:i:s", $this->_send_date); }

    /** Get the text of the message */
    public function msg() : string { return $this->_msg; }

    /**
     * Get the sender of the message 
     *
     * @return User The sender of the message.
     * */
    public function sender() : User { return $this->_sender; }

    /**
     * Get the community of the message 
     *
     * @return Community The community of the message.
     * */
    public function community() : Community { return $this->_community; }
}