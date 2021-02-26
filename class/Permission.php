<?php

/**
 * Represent permission of a user on a community
 */
class P {

    const VIEW = 1<<0;
    const INTERACT = 1<<1;

    const TOGGLE_VISIBLE_POST = 1<<2;
    const TOGGLE_VISIBLE_DOC = 1<<3;

    const DELETE_POST = 1<<4;
    const DELETE_DOC = 1<<5;

    const OWNER = 1<<6;

    // Types d'utilisateurs par défaut. Devra être modifiable dans le future
    const AVERAGE = self::VIEW | self::INTERACT;
    const MODERATOR = self::AVERAGE | self::TOGGLE_VISIBLE_POST | self::TOGGLE_VISIBLE_DOC;
    const ADMIN = self::MODERATOR | self::DELETE_POST | self::DELETE_DOC;

    private $_perm_number;

    /**
     * Instantiate a permission. A permission is a right for a user to act on a community 
     * in a certain way
     * 
     * @param $perm_number int from DB, a flag or group of flags
     * 
     * eg: P(3), P(P::VIEW | P::INTERACT), P(P::ADMIN)
     */
    public function __construct(int $perm_number) {
        $this->_perm_number = $perm_number;
    }

    /**
     * Check whenever the permission number includes one or more $flags
     *
     * eg:
     * $user = new P(P::AVERAGE);
     * $modo = new P(P::MODERATOR);
     * $user->can(P::DELETE_POST); // false
     * $modo->can(P::INTERACT | P::TOGGLE_VISIBLE_POST); // true, he can do both but :
     * $modo->can(P::INTERACT | P::DELETE_DOC); // false, one permission is missing
     *
     */
    public function can(int $flags) : bool {
        return $this->_perm_number & $flags == $flags;
    }


    public function add(int $flags) : P;
    public function del(int $flags) : P;
    public function get() : int;

}
