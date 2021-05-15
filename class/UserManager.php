<?php

/**
 * Provide a way to manipulate users
 */
class UserManager {
    /**
     * DB link
     */
    private $_db;

    /**
     * Instantiation a user manager
     */
    public function __construct(mysqli $db) {
        $this->_db = $db;
    }
    /**
     * Get a user based on his ID.
     *
     * @return User|null Depends if a user exists with the $id.
     */
    public function get_by_id(int $id) : ?User {
        try {
            return new User($this->_db, $id);
        } catch (InvalidID $e) {
            return null;
        }
    }

    /**
     * Get a user based on his nickname.
     *
     * @return User|null Depends if a user exists with the $nickname.
     */
    public function get_by_nickname(string $nickname) : ?User {
        $sql = "SELECT `id_%s`, `nickname` FROM `%s` WHERE `nickname` = '%s'";
        $sql = sprintf($sql, Config::TABLE_USER, Config::TABLE_USER, $nickname);
        $result = $this->_db->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            return isset($row['id_'.Config::TABLE_USER]) ? new User($this->_db, (int) $row['id_'.Config::TABLE_USER]) : null;
        }
        return null;
    }

    /**
     * Get a user based on his email.
     *
     * @return User|null Depends if a user exists with the $email.
     */
    public function get_by_email(string $email) : ?User {
        $sql = "SELECT `id_%s`, `email` FROM `%s` WHERE `email` = '%s'";
        $sql = sprintf($sql, Config::TABLE_USER, Config::TABLE_USER, $email);
        $result = $this->_db->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            return isset($row['id_'.Config::TABLE_USER]) ? new User($this->_db, (int) $row['id_'.Config::TABLE_USER]) : null;
        }
        return null;
    }

    /**
     * Know if nickname if free or already used
     *
     * @return bool True if the nickname can be used.
     */
    public function is_nickname_free(string $nickname) : bool {
        $sql = "SELECT COUNT(`nickname`) FROM `%s` WHERE `nickname` = '%s'";
        $sql = sprintf($sql, Config::TABLE_USER, $nickname);
        $result = $this->_db->query($sql);
        return $result ? $result->fetch_row()[0] == 0 : true;
    }

    /**
     * Know if email if free or already used
     *
     * @return bool True if the email can be used.
     */
    public function is_email_free(string $email) : bool {
        $sql = "SELECT COUNT(`email`) FROM `%s` WHERE `email` = '%s'";
        $sql = sprintf($sql, Config::TABLE_USER, $email);
        $result = $this->_db->query($sql);
        return $result ? $result->fetch_row()[0] == 0 : true;
    }

    /**
     * Register a user
     *
     * @param $email string must be a valid and sanitised email.
     *        Raise NotUniqueEmail if already used.
     * @param $nickname string must be sanitized.
     *        Raise NotUniqueNickname if already used.
     * @param $pwd string of the password the user want to use.
     *
     * @return bool True if successful.
     */
    public function add_user(string $email, string $nickname, string $pwd) : bool {
        if (!$this->is_email_free($email)) { throw new NotUniqueEmail("Email $email is already used!"); }
        if (!$this->is_nickname_free($nickname)) { throw new NotUniqueNickname("Nickname $nickname is already used!"); }

        $sql = "INSERT INTO `%s` (`nickname`) VALUES ('%s')";
        $sql = sprintf($sql, Config::TABLE_USER, $nickname);
        $creation_ok = $this->_db->query($sql);

        $email_ok = false;
        $pwd_ok = false;
        if ($creation_ok) {
            // the user we are creating
            $user = new User($this->_db, $this->_db->insert_id);
            $email_ok = $user->set_email_to($email);
            $pwd_ok = $user->set_pwd($pwd);
        }
        
        return $creation_ok & $email_ok & $pwd_ok;
    }

    /**
     * Get an array of users by the search value
     *
     * @param String $researh the string to find in user nicknames
     * @return User[] An array of users.
     */
    public function search_user_by_nickname_or_display_name(String $research){
        $sql = "SELECT `id_%s` FROM `%s` WHERE nickname LIKE '%%$research%%' OR display_name LIKE '%%$research%%'";
        $sql = sprintf($sql, Config::TABLE_USER,Config::TABLE_USER);
        $res = $this->_db->query($sql);
        if ($res) {
            for ($list = array();
                 $row = $res->fetch_row();
                 $list[] = new User($this->_db, $row[0]));
            return $list;
        }
        return array();
    }

    /**
     * Get an array of users by the search value in a community
     *
     * @param String $researh the string to find in user nicknames
     * @param Community $c the community we are searching in
     * @return User[] An array of users.
     */
    public function search_user_by_nickname_or_display_name_in_community(String $research, Community $c){
        $sql = "SELECT `id_%s` FROM `%s` u JOIN `%s` uc ON u.`id_%s` = uc.user WHERE uc.community = %d AND (u.nickname LIKE '%%%s%%' OR u.display_name LIKE '%%%s%%') AND uc.permission != 0";
        $sql = sprintf($sql, Config::TABLE_USER, Config::TABLE_USER, Config::TABLE_USER_COMMUNITY, Config::TABLE_USER, $c->id(), $research, $research);
        $res = $this->_db->query($sql);
        if ($res) {
            for ($list = array();
                 $row = $res->fetch_row();
                 $list[] = new User($this->_db, $row[0]));
            return $list;
        }
        return array();
    }

    /**
     * Get an array of users by community by ancienty
     *
     * @param Community $community The community where we are searching in
     * @param bool|null $visible Filter if user are marked as visible or not. Null will return both.
     * @param int $limit Limits the number of users you want.
     * @param int $offset So you can get documents by slice of $limit. $offset should be a multiple of $limit.
     * @return User[] An array of users.
     */
    public function get_by_ancienty_community(Community $c, int $limit = 10, bool $visible = true, int $offset = 0) {
        $sql = 'SELECT u.id_%1$s FROM `%1$s` u JOIN `%2$s` uc ON u.id_%1$s = uc.user WHERE uc.community = %3$d AND DATEDIFF(CURRENT_TIMESTAMP, uc.last_collect) < 30 AND uc.permission != 0 ORDER BY uc.join_date LIMIT %4$d OFFSET %5$d';
        $sql = sprintf($sql, Config::TABLE_USER, Config::TABLE_USER_COMMUNITY, $c->id(), $limit, $offset);
        $result = $this->_db->query($sql);
        if($result) {
            for ($list = array();
                 $row = $result->fetch_assoc();
                 $list[] = new User($this->_db, $row['id_' . Config::TABLE_USER]));
            return $list;
        }
        return array();
    }

    /**
     * Get an array of users by community by richness
     *
     * @param Community $community The community where we are searching in
     * @param bool|null $visible Filter if user are marked as visible or not. Null will return both.
     * @param int $limit Limits the number of users you want.
     * @param int $offset So you can get documents by slice of $limit. $offset should be a multiple of $limit.
     * @return User[] An array of users.
     */
    public function get_by_richness_community(Community $c, int $limit = 10, bool $visible = true, int $offset = 0) {
        $sql = 'SELECT u.id_%1$s FROM `%1$s` u JOIN `%2$s` uc ON u.id_%1$s = uc.user WHERE uc.community = %3$d AND uc.permission != 0 ORDER BY uc.coins DESC LIMIT %4$d OFFSET %5$d';
        $sql = sprintf($sql, Config::TABLE_USER, Config::TABLE_USER_COMMUNITY, $c->id(), $limit, $offset);
        $result = $this->_db->query($sql);
        if($result) {
            for ($list = array();
                 $row = $result->fetch_assoc();
                 $list[] = new User($this->_db, $row['id_' . Config::TABLE_USER]));
            return $list;
        }
        return array();
    }

    /**
     * Get an array of users by community by levelness
     *
     * @param Community $community The community where we are searching in
     * @param bool|null $visible Filter if user are marked as visible or not. Null will return both.
     * @param int $limit Limits the number of users you want.
     * @param int $offset So you can get documents by slice of $limit. $offset should be a multiple of $limit.
     * @return User[] An array of users.
     */
    public function get_by_levelness_community(Community $c, int $limit = 10, bool $visible = true, int $offset = 0) {
        $sql = 'SELECT u.id_%1$s FROM `%1$s` u JOIN `%2$s` uc ON u.id_%1$s = uc.user WHERE uc.community = %3$d AND uc.permission != 0 ORDER BY uc.level DESC, uc.xpoints DESC LIMIT %4$d OFFSET %5$d';
        $sql = sprintf($sql, Config::TABLE_USER, Config::TABLE_USER_COMMUNITY, $c->id(), $limit, $offset);
        $result = $this->_db->query($sql);
        if($result) {
            for ($list = array();
                 $row = $result->fetch_assoc();
                 $list[] = new User($this->_db, $row['id_' . Config::TABLE_USER]));
            return $list;
        }
        return array();
    }

    

    /**
     * Get an array of users by community by most likes
     *
     * @param Community $community The community where we are searching in
     * @param bool|null $visible Filter if user are marked as visible or not. Null will return both.
     * @param int $limit Limits the number of users you want.
     * @param int $offset So you can get documents by slice of $limit. $offset should be a multiple of $limit.
     * @return User[] An array of users.
     */
    public function get_user_by_most_likes_in_community(Community $c, int $limit = 10, bool $visible = true, int $offset = 0) {
        $sql = 'SELECT p.publisher, vPlus.c, vMinus.c
                FROM `%1$s` p 
                LEFT OUTER JOIN 
                    (SELECT p1.publisher, COUNT(v1.mark) AS c
                        FROM `%1$s` p1
                        JOIN `%2$s` v1 ON v1.post = p1.id_%1$s 
                        WHERE p1.visible = %3$d 
                        AND p1.community = %4$d
                        AND v1.mark = "%5$s" 
                        GROUP BY p1.publisher) 
                    vPlus
                ON vPlus.publisher = p.publisher
                LEFT OUTER JOIN 
                    (SELECT p2.publisher, COUNT(v2.mark) AS c
                        FROM `%1$s` p2 
                        JOIN `%2$s` v2 ON v2.post = p2.id_%1$s
                        WHERE p2.visible = %3$d
                        AND p2.community = %4$d 
                        AND v2.mark = "%6$s" 
                        GROUP BY p2.publisher)
                    vMinus
                ON vMinus.publisher = p.publisher
                JOIN `%9$s` uc ON uc.user = p.publisher
                WHERE p.visible = %3$d 
                AND p.community = %4$d
                AND uc.permission != 0
                GROUP BY p.publisher
                ORDER BY (IFNULL(vPlus.c, 0) - IFNULL(vMinus.c, 0)) DESC, vPlus.c DESC, p.date DESC
                LIMIT %7$d OFFSET %8$d';
        $sql = sprintf($sql, Config::TABLE_POST, Config::TABLE_VOTE, $visible, $c->id(),"up", "down", $limit, $offset, Config::TABLE_USER_COMMUNITY);
        $result = $this->_db->query($sql);
        if($result) {
            for ($list = array();
                 $row = $result->fetch_assoc();
                 $list[] = new User($this->_db, $row['publisher']));
            return $list;
        }
        return array();
    }

    /**
     * Delete a user
     *
     * @return bool True if successful.
     */
    //public function del_user(User $user) : bool;
}
