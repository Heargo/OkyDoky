<?php

/**
 * Represent permission of a user on a community
 */
class Permission {

    /** Can the user view the community */
    const VIEW = 1<<0;
    /** Can the user interact with the community */
    const INTERACT = 1<<1;

    /** Can the user toggle visibility of a post */
    const TOGGLE_VISIBLE_POST = 1<<2;
    /** Can the user toogle visibility of a document */
    const TOGGLE_VISIBLE_DOC = 1<<3;

    /** Can the user delete a post */
    const DELETE_POST = 1<<4;
    /** Can the user delete a document */
    const DELETE_DOC = 1<<5;

    /** Is the user the owner of the community */
    const OWNER = 1<<6;

    // Types d'utilisateurs par défaut. Devra être modifiable dans le future
    /** Defines an average user's permissions */
    const AVERAGE = self::VIEW | self::INTERACT;
    /** Defines a moderator's permissions */
    const MODERATOR = self::AVERAGE | self::TOGGLE_VISIBLE_POST | self::TOGGLE_VISIBLE_DOC;
    /** Defines a admin's permissions */
    const ADMIN = self::MODERATOR | self::DELETE_POST | self::DELETE_DOC;

    /** The permission number you're working with */
    private $_perm_number;

    /**
     * Instantiate a permission. A permission is a right for a user to act on a community in a certain way
     * eg: P(3), P(P::VIEW | P::INTERACT), P(P::ADMIN)
     *
     * @param $perm_number int A number from the DB, a flag or group of flags.
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
     * @param int $flags A flag or group of flags (like P::AVERAGE).
     * @return bool True if ALL permissions specified are checked.
     *
     */
    public function can(int $flags) : bool {
        return $this->_perm_number & $flags == $flags;
    }


    //public function add(int $flags) : P;
    //public function del(int $flags) : P;
    //public function get() : int;

}
