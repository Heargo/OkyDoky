<?php
class NotificationManager {

    /** DB connection */
    private $_db;

    /**
     * Instaciate a manager for a DB connection
     */
    public function __construct(mysqli $db) {
        $this->_db = $db;
    }

    
    public function get_by_id(int $id){
        try {
            return new Notification($this->_db, $id);
        } catch (InvalidID $e) {
            return null;
       }
    }

    public function get_friend_notif_by_sender_and_receiver(User $u1, User $u2) {
        $sql = sprintf("SELECT `id_%s` FROM `%s` WHERE ( (`receiver` = %d AND `sender` = %d) || (`receiver` = %d AND `sender` = %d) ) AND `type` = 'friend'",  Config::TABLE_NOTIFICATION,  Config::TABLE_NOTIFICATION, $u1->id(), $u2->id(), $u2->id(), $u1->id());
        $res = $this->_db->query($sql);
        if ($res) {
            if($row = $res->fetch_row()) {
                $notif = new Notification($this->_db, $row[0]);
                return $notif;
            } else {
                return null;
            }
        }
        return null;
    }

    /**
     * Create a new notification in the db
     *
     * @param String $msg The notification sended. 
     */
    public function send_notif(String $type, User $receiver, ?Community $community = null, ?int $amount = 0, ?int $comment = 0) {
        if ($type == "don") {
            $sql = sprintf("INSERT INTO `%s` (`sender`,`receiver`,`type`,`community`,`amount`) VALUES ('%d','%d','%s','%d','%d');", Config::TABLE_NOTIFICATION, User::current()->id(), $receiver->id(), $type, $_SESSION["current_community"], $amount);
        } else if($type == "commentaire"){
            $sql = sprintf("INSERT INTO `%s` (`sender`,`receiver`,`type`,`community`,`comment`) VALUES ('%d','%d','%s','%d','%d');", Config::TABLE_NOTIFICATION, User::current()->id(), $receiver->id(), $type, $community->id(), $comment);
        }
         else {
            $sql = sprintf("INSERT INTO `%s` (`sender`,`receiver`,`type`) VALUES ('%d','%d','%s');", Config::TABLE_NOTIFICATION, User::current()->id(), $receiver->id(), $type);
        }
        if($this->_db->query($sql)){
            $id = (int) $this->_db->insert_id;
            return $id;
        }
        else{
            return null;
        }
    }


    /**
     * Load all notifications of the current user
     */
    public function load_all_notifs() {
        $sql = "SELECT `id_%s` FROM `%s` WHERE `receiver`= %d ORDER BY `creation_date` DESC";
        $sql = sprintf($sql, Config::TABLE_NOTIFICATION,Config::TABLE_NOTIFICATION,User::current()->id());
        $res = $this->_db->query($sql);
        if ($res) {
            for ($list = array();
                 $row = $res->fetch_row();
                 $list[] = new Notification($this->_db, $row[0]));
            return $list;
        }
        return array();
    }

    /**
     * Get number of notifications from current user
     */
    public function how_many_notifs() {
        $sql = "SELECT COUNT(1) FROM `%s` WHERE `receiver`= %d";
        $sql = sprintf($sql, Config::TABLE_NOTIFICATION,User::current()->id());
        $res = $this->_db->query($sql);
        if ($res) {
            $nb = $res->fetch_row()[0];
            return $nb > 99 ? 99 : $nb;
        }
        return array();
    }

    


    /**
     * Delete the given notification
     *
     * @param Notification $notif The notification to delete 
     */
    public function delete_notif(Notification $notif) {
        $sql = sprintf("DELETE FROM `%s` WHERE `id_%s` = %d",Config::TABLE_NOTIFICATION,Config::TABLE_NOTIFICATION,$notif->id());
        return $this->_db->query($sql);
    }
}