<?php
class MessageManager {

    /** DB connection */
    private $_db;

    public function __construct(mysqli $db) {
        $this->_db = $db;
    }

    /**
     * Instaciate a manager for a DB connection
     */
    public function get_by_id(int $id){
        try {
            return new Message($this->_db, $id);
        } catch (InvalidID $e) {
            return null;
       }
    }

    /**
     * Create a new message in the db
     *
     * @param String $msg The message sended. 
     */
    public function sendMsg(String $msg) {
        $sql = "INSERT INTO `%s` (`sender`,`msg`,`community`) VALUES ('%d','%s','%d');";
        $sql = sprintf($sql, Config::TABLE_MESSAGE,User::current()->id(),sanitize_text($msg),$_SESSION["current_community"]);
        if($this->_db->query($sql)){
            $id = (int) $this->_db->insert_id;
            return $id;
        }
        else{
            return null;
        }
    }


    /**
     * Load last 100 messages from the current community
     */
    public function load_last_100() {
        $sql = "SELECT `id_%s` FROM `%s` WHERE `community`=%d ORDER BY `send_date` ASC LIMIT 100";
        $sql = sprintf($sql, Config::TABLE_MESSAGE,Config::TABLE_MESSAGE,$_SESSION["current_community"]);
        $res = $this->_db->query($sql);
        if ($res) {
            for ($list = array();
                 $row = $res->fetch_row();
                 $list[] = new Message($this->_db, $row[0]));
            return $list;
        }
        return array();
    }


    /**
     * Load messages since the given date from the current community
     *
     * @param Date $d Since when we need messages 
     */
    public function load_last_since(String $d) {
        $sql = "SELECT `id_%s` FROM `%s` WHERE `community`=%d AND `send_date` > '%s' ORDER BY `send_date` DESC";
        $sql = sprintf($sql, Config::TABLE_MESSAGE,Config::TABLE_MESSAGE,$_SESSION["current_community"], $d);
        $res = $this->_db->query($sql);
        if ($res) {
            for ($list = array();
                 $row = $res->fetch_row();
                 $list[] = new Message($this->_db, $row[0]));
            return $list;
        }
        return array();
    }

    public function del_msg(Message $m) {
        $sql = sprintf("UPDATE `%s` SET `msg` = 'Message supprimé' WHERE `id_%s` = %d;", Config::TABLE_MESSAGE, Config::TABLE_MESSAGE, $m->id());
        return (bool) ($res = $this->_db->query($sql));
    }
}