<?php

/**
 * Class to manipulate a specific user
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

    /**
     * Used by view to know wich page to see on feed
     *
     * This attribute is bound to instance, not to DB.
     */
    public $current_community;


    //// METHODS

    // GETTERS

    /**
     * Instantiate user from an id
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
     * Get url to profile pic
     */
    public function profile_pic() : string { return $this->_profile_picture_url; }
    
    // COMMUNITY INTERACTIONS

    /**
     * Get array of communities followed by user.
     * 
     * @param $flags int|null representing a Permission. 
     *        Will return only communities matching the flag(s)
     * 
     * eg: $myuser->get_communities(P::OWNER); // will return communities where user is the owner
     *     $myuser->get_communities(P::VIEW); // will return communities where user is not banned from
     */
    //public function get_communities(?int $flags=null) : array;

    /**
     * Make the user join a community
     */
    //public function join(Community $comm) : bool;

    // AUTHENTIFICATION & PROFILE

    /**
     * Send an email to verify its authenticity
     */
    //private function _verify_email() : bool;

    /**
     * Change user email.
     *
     * TODO : This email must be confirmed.
     * @return bool True if successful
     */
    public function set_email_to(string $new_email) : bool {
        $sanitized_email = filter_var($new_email, FILTER_SANITIZE_EMAIL);
        if (filter_var($sanitized_email, FILTER_VALIDATE_EMAIL)) {
            $sql = "UPDATE `%s` SET `email` = '%s', `email_verified` = 0 WHERE `id_%s` = %s";
            $sql = sprintf($sql, Config::TABLE_USER, $sanitized_email, Config::TABLE_USER, $this->id());
            $update_ok = $this->_db->query($sql);

            if ($update_ok) {
                $this->_email = $sanitized_email; //only if confirmed. So we need to stock old and new. Fix it
            }

            //$this->_verify_email();

            return $update_ok;
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
     * @return bool True if successfull.
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
        $_SESSION['user'] = $is_correct ? $this : $_SESSION['user'];
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
     */
    //public function add_perm(int $flags, Community $comm);

    /**
     * Delete a permission (or several) for a user on a community
     */
    //public function del_perm(int $flags, Community $comm);

    /**
     * Set a permission (or several) for a user on a community
     */
    //public function set_perm(int $flags, Community $comm);


    //// STATIC

    /**
     * Return true whenever a user is connected
     */
    public static function is_connected() : bool {
        return isset($_SESSION['user']) ? get_class($_SESSION['user']) == self::class : false;
    }

    /**
     * Get current logged in user
     *
     * @return User|null Depending if a user is connected for this session or not
     */
    public static function current() : ?User {
        // Do not return session var directly, it may not be User|null if overwritten
        return self::is_connected() ? $_SESSION['user'] : null; 
    }
}
