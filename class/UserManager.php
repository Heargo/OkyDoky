<?php

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
    //public function get_by_nickname(string $nickname) : ?User;

    /**
     * Get a user based on his email.
     *
     * @return User|null Depends if a user exists with the $email.
     */
    //public function get_by_email(string $email) : ?User;

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
     * Delete a user
     *
     * @return bool True if successful.
     */
    //public function del_user(User $user) : bool;
}
