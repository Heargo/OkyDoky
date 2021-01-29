<?php

class InvalidID extends Exception {}

function is_id_correct(mysqli $db, string $table, int $id) {
    $sql = "SELECT COUNT(`id`) FROM $table WHERE id = $id";
    $result = $db->query($sql);
    return $result->fetch_row()[0] == 1;
}
