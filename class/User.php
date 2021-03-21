<?php

/**
 * Provide a way to manipulate a particular user
 */
class User {

    //// ATTRIBUTES

    /**
     * DB link
     */
    private $_db;

    private $_id;
    private $_nickname;
    private $_display_name;
    private $_description;
    private $_profile_picture_url;
    private $_email;
    /** not yet confirmed email */
    private $_new_email;


    //// METHODS

    // GETTERS

    /**
     * Instantiate user from an ID
     */
    public function __construct(mysqli $db, int $id) {
        $this->_db = $db;
        $this->_id = $id;
                
        if (!is_id_correct($this->_db, Config::TABLE_USER, $id)) {
            throw new InvalidID('id "' . $id . '" in table "' . Config::TABLE_USER . '" isn`t correct.');
        }

        $sql = "SELECT * FROM `%s` WHERE `id_%s` = %s";
        $sql = sprintf($sql, Config::TABLE_USER, Config::TABLE_USER, $id);
        $row = $db->query($sql)->fetch_assoc();
    
        $this->_nickname = $row['nickname'];
        $this->_display_name = $row['display_name'];
        $this->_description = $row['description'];
        $this->_profile_picture_url = $row['profile_picture'];
        $this->_email = $row['email'];
        $this->_new_email = $row['new_email'];
    }

    /**
     * Get id
     */
    public function id() : int { return $this->_id; }

    /**
     * Get nickname
     */
    public function nickname() : string { return $this->_nickname; }

    /**
     * Get display name
     */
    public function display_name() : ?string { return $this->_display_name; }

    /**
     * Get description
     */
    public function description() : ?string { return $this->_description; }

    /**
     * Get email
     */
    public function email() : ?string { return $this->_email; }

    /**
     * Get new email
     */
    public function new_email() : ?string { return $this->_new_email; }

    /**
     * Get url to profile pic
     */
    public function profile_pic() : string {
        if (isset($this->_profile_picture_url)) {
            $url = $this->_profile_picture_url;
            $url = "/img/" . $url;
            return Routes::url_for($url);
        }
        return Routes::url_for("/img/img1.jpg");
    }
    
    // COMMUNITY INTERACTIONS

    /**
     * Get array of communities followed by user.
     * 
     * @param $flags int|null representing a Permission. 
     *        Will return only communities matching the flag(s) if specified.
     * @return Community[] Array of communities.
     * @todo limit request ?
     * 
     * eg: $myuser->get_communities(P::OWNER); // will return communities where user is the owner
     *     $myuser->get_communities(P::VIEW); // will return communities where user is not banned from
     */
    public function get_communities(?int $flags=null) : array {
        $sql = "SELECT `community` FROM `%s` WHERE `user` = %d";
        $sql = sprintf($sql, Config::TABLE_USER_COMMUNITY, $this->id());
        $result = $this->_db->query($sql);

        if ($result) {
            for ($list = array();
                 $row = $result->fetch_row();
                 $list[] = new Community($this->_db, $row[0]));
            return $list;
        }
        return array();
    }

    /**
     * Make the user join a community
     */
    //public function join(Community $comm) : bool;

    // AUTHENTIFICATION & PROFILE

    /**
     * Send an email to verify its authenticity
     *
     * @return bool True if successfule
     */
    private function _send_verify_email() : bool {
        $token = bin2hex(random_bytes(50));
        $url = 'https://' . Config::URL_ROOT(false) . "/verify/" . $this->nickname() . "/$token";

        $sql = "UPDATE %s SET `email_token` = '%s' WHERE `id_%s` = %d";
        $sql = sprintf($sql, Config::TABLE_USER, $token, Config::TABLE_USER, $this->id());
        $result = $this->_db->query($sql);

        if ($result) {
            $sender = new MailSender($this);
            $sender->verify($url);
            return true;
        }
        return false;
    }

    /**
     * Change the email if the token is valid
     *
     * @param string $token The token sent by email.
     * @return bool True if successful.
     */
    public function validate_email_token(string $token) : bool {
        $sql = 'SELECT `new_email`,`email_token` FROM %s WHERE `id_%s` = %d';
        $sql = sprintf($sql, Config::TABLE_USER, Config::TABLE_USER, $this->id());
        $result = $this->_db->query($sql);

        $token_match = false;
        $update_ok = false;
        if ($result) {
            $row = $result->fetch_assoc();
            $token_match = $token == $row['email_token'];
            if ($token_match) {
                $sql = "UPDATE %s SET `new_email` = NULL, `email_token` = NULL, `email` = '%s', `email_verified` = 1 WHERE `id_%s` = %d";
                $sql = sprintf($sql, Config::TABLE_USER, $row['new_email'], Config::TABLE_USER, $this->id());
                echo $sql . PHP_EOL;
                $update_ok = $this->_db->query($sql);

                if ($update_ok) {
                    $this->_email = $row['new_email'];
                    $this->_new_email = null;
                }
            }
        }
        return $token_match && $update_ok;
    }

    /**
     * Change user email.
     *
     * @return bool True if successful.
     */
    public function set_email_to(string $new_email) : bool {
        $sanitized_email = filter_var($new_email, FILTER_SANITIZE_EMAIL);
        if (filter_var($sanitized_email, FILTER_VALIDATE_EMAIL)) {
            $sql = "UPDATE `%s` SET `new_email` = '%s', `email_verified` = 0 WHERE `id_%s` = %s";
            $sql = sprintf($sql, Config::TABLE_USER, $sanitized_email, Config::TABLE_USER, $this->id());
            $update_ok = $this->_db->query($sql);

            if ($update_ok) {
                $this->_new_email = $sanitized_email;
            }
            $mail_ok = $this->_send_verify_email();

            return $update_ok && $mail_ok;
        }
        return false;
    }

    /**
     * Check whenever the user email is verified
     */
    public function is_email_verified() : bool {
        $sql = "SELECT `email_verified` FROM `%s` WHERE `id_%s` = %s";
        $sql = sprintf($sql, Config::TABLE_USER, Config::TABLE_USER, $this->id());

        $result = $this->_db->query($sql);

        if ($result) {
            $is_verified = $result->fetch_assoc()['email_verified'];
            $is_verified = $is_verified == 1;
            return $is_verified;
        }

        return false;
    }

    /**
     * Check if $pwd is indeed the user's password
     *
     * @return bool True if valid.
     */
    public function is_pwd_correct(string $pwd) : bool {
        $sql = "SELECT `pwd_hash` FROM `%s` WHERE `id_%s` = %s";
        $sql = sprintf($sql, Config::TABLE_USER, Config::TABLE_USER, $this->id());
        $result = $this->_db->query($sql);

        if (!$result) { return false; } // No hash of password in DB.

        $hash = $result->fetch_assoc()['pwd_hash'];

        return password_verify($pwd, $hash);
    }

    /**
     * Change password of user
     *
     * @return bool True if successful.
     */
    public function set_pwd(string $pwd) : bool {
        $pwd_hash = password_hash($pwd, PASSWORD_DEFAULT);

        $sql = "UPDATE `%s` SET `pwd_hash` = '%s' WHERE `id_%s` = %s";
        $sql = sprintf($sql, Config::TABLE_USER, $pwd_hash, Config::TABLE_USER, $this->id());

        return $this->_db->query($sql);
    }

    /**
     * Send a link to user to reset password
     */
    //public function retrieve_pwd() : bool;

    /**
     * Change profile picture
     *
     * @param $pic array is a picture from $_FILES.
     * @return bool True if successful.
     */
    //public function set_profile_picture(array $pic) : bool;

    /**
     * Change the display name
     *
     * @return bool True if successful.
     */
    //public function set_display_name(string $nickname) : bool;

    /**
     * Connect user if password is correct
     *
     * If passeword is correct, the user is stored in $_SESSION['user'].
     * To check if the user is connected, use User::is_connected().
     * To access the user, use User::current().
     *
     * @return bool True if successful
     */
    public function connect(string $pwd) : bool {
        $is_correct = $this->is_pwd_correct($pwd);
        $_SESSION['user'] = $is_correct ? $this->id() : $_SESSION['user'];
        return $is_correct;
    }

    /**
     * Disconnect user
     *
     * $_SESSION['user'] will be null.
     */
    public function disconnect() : void {
        unset($_SESSION['user']);
    }

    // POSTS INTERACTIONS

    /**
     * Get array of posts written by user
     * 
     * @param $comm Community|null if you want posts from a specific community
     */
    //public function get_posts(?Community $comm) : array;

    /**
     * User giving a good evaluation for a post
     */
    //public function up_vote(Post $post);

    /**
     * User giving a bad evaluation for a post
     */
    //public function down_vote(Post $post);

    /**
     * Check if a user has a certain permission
     *
     * @param $flags a constant from class P or a group of constant joined by a "|" (pipe)
     * @return bool True if user has ALL permissions specified in $flags
     */
    //public function can(int $flags, Community $comm) : bool;

    /**
     * Add a permission (or several) for a user on a community
     *
     * @param bool True if successful.
     */
    //public function add_perm(int $flags, Community $comm) : bool;

    /**
     * Delete a permission (or several) for a user on a community
     *
     * @param bool True if successful.
     */
    //public function del_perm(int $flags, Community $comm) : bool;

    /**
     * Set a permission (or several) for a user on a community
     *
     * @param bool True if successful.
     */
    //public function set_perm(int $flags, Community $comm) : bool;

    public function __toString() : string {
        return '('.$this->id().') '. $this->nickname();
    }


    //// STATIC

    /**
     * Return true whenever a user is connected
     */
    public static function is_connected() : bool {
        return isset($_SESSION['user']) ? gettype($_SESSION['user']) == "integer" : false;
    }

    /**
     * Get current logged in user
     *
     * @return User|null Depending if a user is connected for this session or not
     */
    public static function current() : ?User {
        // Do not return session var directly, it may not be User|null if overwritten
        return self::is_connected() ? new User($GLOBALS['db'], $_SESSION['user']) : null; 
    }
}
