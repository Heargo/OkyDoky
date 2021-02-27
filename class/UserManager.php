<?php

class UserManager {
    /**
     * DB link
     */
    private $_db;

    /**
     * Get a user based on his ID.
     *
     * @return User|null Depends if a user exists with the $id.
     */
    public function get_by_id(int $id) : ?User;

    /**
     * Get a user based on his nickname.
     *
     * @return User|null Depends if a user exists with the $nickname.
     */
    public function get_by_nickname(string $nickname) : ?User;

    /**
     * Get a user based on his email.
     *
     * @return User|null Depends if a user exists with the $email.
     */
    public function get_by_email(string $email) : ?User;

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
    public function add_user(string $email, string $nickname, string $pwd) : bool;

    /**
     * Delete a user
     *
     * @return bool True if successful.
     */
    public function del_user(User $user) : bool;
}
