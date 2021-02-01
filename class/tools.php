<?php

class InvalidID extends Exception {}

function is_id_correct(mysqli $db, string $table, int $id) {
    $sql = "SELECT COUNT(`id_$table`) FROM $table WHERE id_$table = $id";
    $result = $db->query($sql);
    if ($result) {
        return $result->fetch_row()[0] == 1;
    }
    return false;
}

function get_field_with_id(mysqli $db, string $col, string $table, int $id) {
        $sql = "SELECT %s FROM `%s` WHERE `id_%s` = %d";
        $sql = sprintf($sql, $col, Config::TABLE_DOCUMENT, Config::TABLE_DOCUMENT, $id);
        $result = $db->query($sql);
        
        if ($result) { return $result->fetch_row()[0]; }
        return null;
}
