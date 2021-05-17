<?php
class Notification{

    private $_db;
    private $_id;
    private $_type;
    private $_receiver;
    private $_sender;
    private $_creation_date;
    
    private $_community;
    private $_amount;
    private $_comment;

    public function __construct(mysqli $db, int $id){
        $this->_id = $id;
        $this->_db = $db;
        if (!is_id_correct($this->_db, Config::TABLE_NOTIFICATION, $this->id())) {
            throw new InvalidID('id "' . $this->id() . '" in table "' . Config::TABLE_NOTIFICATION . '" isn`t correct.');
        }
        $sql = "SELECT * FROM `%s` WHERE `id_%s` = $id";
        $sql = sprintf($sql, Config::TABLE_NOTIFICATION, Config::TABLE_NOTIFICATION, $id);

        $row = $db->query($sql)->fetch_assoc();
        $this->_type = $row["type"];
        $this->_receiver = $GLOBALS['users']->get_by_id($row["receiver"]);
        $this->_sender = $GLOBALS['users']->get_by_id($row["sender"]);
        $this->_creation_date = strtotime($row["creation_date"]);
        // type values : "don" / "friend"
        if($this->_type == "don") {
            $this->_community = $GLOBALS['communities']->get_by_id($row['community']);
            $this->_amount = $row['amount'];
        }
        else if( $this->_type == "commentaire"){
            $this->_community = $GLOBALS['communities']->get_by_id($row['community']);
            $this->_comment = $GLOBALS['comments']->get_by_id($row['comment']);
        }
    }

    /** Get the id of the notificaiton */
    public function id() : int { return $this->_id; }

    /**
     * Get the date of the notificaiton
     *
     * @return string Date formated like DD/MM/YY H:M:S.
      */
    public function creation_date() : string { return date("Y-m-d H:i:s", $this->_send_date); }

    /** Get the type of the notificaiton */
    public function type() : string { return $this->_type; }

    /**
     * Get the sender of the notificaiton 
     *
     * @return User The sender of the notificaiton.
     * */
    public function sender() : User { return $this->_sender; }

    /**
     * Get the receiver of the notificaiton 
     *
     * @return User The receiver of the notificaiton.
     * */
    public function receiver() : User { return $this->_sender; }

    /**
     * Get the community of the notificaiton (type === "don")
     *
     * @return Community The community of the notificaiton.
     * */
    public function community() : Community { return $this->_community; }

    /**
     * Get the amount of the notificaiton (type === "don")
     *
     * @return Community The community of the notificaiton.
     * */
    public function amount() : int { return $this->_amount; }
    
    /**
     * Get the comment text of the notification (type === "commentaire")
     * 
     * @return string Part of the comment
     */
    public function comment_post() : Post {
        return $this->_comment->post();
    }
    /**
     * Get the comment text of the notification (type === "commentaire")
     * 
     * @return string Part of the comment
     */
    public function comment_text() : string {
        return substr($this->_comment->text(), 0, 30);
    }
}