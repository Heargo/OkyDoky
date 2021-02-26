<?php

/**
 * Class to manipulate a specific user
 */
class User {

    // ATTRIBUTES

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


    // METHODS

    /**
     * Instantiate user from $id
     */
    public function __construct(mysqli $db, int $id);

    /**
     * Get nickname
     */
    public function nickname() : string;

    /**
     * Get display name
     */
    public function display_name() : string;

    /**
     * Get description
     */
    public function description() : string;

    /**
     * Get email
     */
    public function email() : string;


    /**
     * Get url to profile pic
     */
    public function profile_pic() : string;

    /**
     * Check whenever a user email is confirmed
     */
    public function is_email_confirmed() : bool;

    /**
     * Change user email.
     *
     * This email must be confirmed.
     * @return bool True if successful
     */
    public function set_email_to(string $new_email) : bool;

    /**
     * Check if used password hash match $pwd_hash
     *
     * @return bool True if valid.
     */
    public function verify_email() : bool;

    /**
     * Check if used password hash match $pwd_hash
     *
     * @return bool True if valid.
     */
    public function is_pwd_valid(string $pwd_hash) : bool;

    /**
     * 
     */
    public function set_pwd(string $pwd) : bool;

    public function retrieve_pwd() : bool;

    /**
     * Change profile picture
     *
     * @param $pic array is a picture from $_FILES.
     * @return bool True if valid.
     */
    public function set_profile_picture(array $pic) : bool;

    /**
     * Connect user if password hash is correct
     *
     * If passeword is correct, the user is stored in $_SESSION['user'].
     * To check if the user is connected, use User::is_connected().
     * To access the user, use User::current().
     *
     * @return bool True if successful
     */
    public function connect(string $pwd_hash) : bool;

    /**
     * Disconnect user
     *
     * $_SESSION['user'] will be null.
     */
    public function disconnect();

    /**
     * User giving a good evaluation for a post
     */
    public function up_vote(Post $post);

    /**
     * User giving a bad evaluation for a post
     */
    public function down_vote(Post $post);

    /**
     * Check if a user has a certain permission
     *
     * @param $flags a constant from class P or a group of constant joined by a "|" (pipe)
     * @return bool True if user has ALL permissions specified in $flags
     */
    public function can(int $flags, Community $comm) : bool;

    /**
     * Add a permission (or several) for a user on a community
     */
    public function add_perm(int $flags, Community $comm);

    /**
     * Delete a permission (or several) for a user on a community
     */
    public function del_perm(int $flags, Community $comm);

    /**
     * Set a permission (or several) for a user on a community
     */
    public function set_perm(int $flags);

    // STATIC

    /**
     * Return true whenever a user is connected
     */
    public static function is_connected() : bool;

    /**
     * Get current logged in user
     *
     * @return User|null Depending if a user is connected for this session or not
     */
    public static function current() : ?User;
}
