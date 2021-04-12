<?php

/** The specified ID was invalid. Perhaps not in the DB? */
class InvalidID extends Exception {}

/** The location you tried to write in is protected by filesystem */
class NotWritable extends Exception {}

/** The specified email is already used */
class NotUniqueEmail extends Exception {}

/** The specified nickname is already used */
class NotUniqueNickname extends Exception {}

/** The user's email is missing */
class MissingEmail extends Exception {}

/**
 * Is the ID unique in DB
 *
 * @param mysqli $db The DB connection.
 * @param string $table The table name.
 * @param int $id The ID you want to check.
 * @return bool True if the ID is unique.
 */
function is_id_correct(mysqli $db, string $table, int $id) : bool {
    $sql = "SELECT COUNT(`id_$table`) FROM $table WHERE id_$table = $id";
    $result = $db->query($sql);
    if ($result) {
        return $result->fetch_row()[0] == 1;
    }
    return false;
}

/**
 * If you just want the value of a col at a certain id.
 * 
 * @param mysqli $db The DB connection.
 * @param string $col The field you want.
 * @param string $table The table to look in.
 * @param int $id The ID you're looking for.
 *
 * @return string|null The value requested if it exists, null otherwise.
 */
function get_field_with_id(mysqli $db, string $col, string $table, int $id) : ?string {
        $sql = "SELECT `%s` FROM `%s` WHERE `id_%s` = %d";
        $sql = sprintf($sql, $col, $table, $table, $id);
        $result = $db->query($sql);
        
        if ($result) { return $result->fetch_row()[0]; }
        return null;
}
