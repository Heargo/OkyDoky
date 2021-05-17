<?php

/**
 * Represent permission of a user on a community
 *
 * Why is it using bitwise operators, masks... ?
 * Because then, the permission can be stored as a single number in a database.
 *
 * The permission nodes are used like binary masks.
 * One node = `1<<X` with X an offset.
 * 
 * So the permissions of a user is represented on one number,
 * that we compare and extend with bitwise operators.
 */
class Permission {

    /** Can the user view the community */
    const VIEW = 1<<0;
    /**
     * Can the user interact with the community
     * That is, vote and like
     */
    const INTERACT = 1<<1;
    /** Can the user comment on the community */
    const COMMENT = 1<<2;
    /** Can the user upload on the community */
    const UPLOAD = 1<<3;

    /** Can the user toggle visibility of a post */
    const TOGGLE_VISIBLE_POST = 1<<4;
    /** Can the user toogle visibility of a document */
    const TOGGLE_VISIBLE_DOC = 1<<5;
    /** Can the user toogle visibility of a document */
    const TOGGLE_VISIBLE_COMMENT = 1<<6;

    /** Can the user delete a post */
    const DELETE_POST = 1<<7;
    /** Can the user delete a document */
    const DELETE_DOC = 1<<8;
    /** Can the user delete a comment */
    const DELETE_COMMENT = 1<<9;

    /** Can the user remove AVERAGE nodes */
    const MOD_AVERAGE_NODES = 1<<10;
    /** Can the user remove AVERAGE nodes */
    const MOD_MODERATOR_NODES = 1<<11;
    /** Can the user modify the highlight post */
    const MOD_HIGHLIGHT_POST = 1<<12;

    // Only the OWNER can modify admin's permission nodes

    /** Can do anything, regardless of the other permissions */
    const OWNER = 1<<13;

    // Quick way to set multiple nodes
    // THOSE ARE NORE ROLES, AND DOEST NOT INHERIT
    const AVERAGE = self::VIEW | self::INTERACT | self::COMMENT | self::UPLOAD;
    const MODERATOR = self::TOGGLE_VISIBLE_POST | self::TOGGLE_VISIBLE_DOC | self::TOGGLE_VISIBLE_COMMENT | self::MOD_AVERAGE_NODES;
    const ADMIN = self::DELETE_POST | self::DELETE_DOC | self::DELETE_COMMENT | self::MOD_MODERATOR_NODES;

    private $_perm_number;

    /**
     * Instantiate a permission. A permission is a right for a user to act on a community 
     * in a certain way
     * 
     * @param $perm_number int from DB, a flag or group of flags
     * 
     * eg: Permission(3), Permission(P::VIEW | P::INTERACT), Permission(P::ADMIN)
     */
    public function __construct(int $perm_number) {
        $this->_perm_number = $perm_number;
    }

    /**
     * Check whenever the user has all permission $flags (nodes).
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
        if (($this->_perm_number & self::OWNER) == self::OWNER) {
            return true;
        }
        // PN and MASK == MASK
        return ($this->_perm_number & $flags) == $flags;
    }

    /**
     * Check if the user if AVERAGE, MODERATOR, ADMIN or OWNER.
     * That's just an alias of `can()` to be read more easily
     */
    public function is(int $flag) : bool { return $this->can($flag); }


    /**
     * Add one or more $flags (nodes)
     *
     * @return Permission The Permission object, so it is easy to chain add/del methods.
     */
    public function add(int $flags) : Permission {
        // PN or MASK
        $this->_perm_number |= $flags;
        return $this;
    }

    /**
     * Remove one or more $flags (nodes)
     */
    public function del(int $flags) : Permission {
        // PN and (not MASK)
        $this->_perm_number &= ~$flags;
        return $this;
    }

    /**
     * Return the number of the permission nodes
     * @return int Representing the user permission nodes
     */
    public function get() : int {
        return $this->_perm_number;
    }


    /**
     * Show a resume of what the permission number permit
     */
    public function debug() {
        $oClass = new ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();

        $toDisplay = array(
            ["Permission number", (string) $this->_perm_number],
            ["...in binary", (string) decbin($this->_perm_number)]
        );
        foreach($constants as $node => $value) {
            $has = $this->can($value) ? "ALLOWED" : "FORBIDDEN";
            $toDisplay[] = [$node, $has];
        }

        $max = max(
                array_map('strlen',
                    array_column($toDisplay, 0)
                )
        );

        foreach ($toDisplay as list($node,$has)) {
            echo str_pad($node, $max+1) . ": $has\n";
        }
    }

}
