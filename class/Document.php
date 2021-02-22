<?php

require_once(__DIR__ . '/tools.php');

class Document {

    private $_id;
    private $_db;

    public function __construct(mysqli $db, int $id) {
        $this->_db = $db;
        $this->_id = (int) $id;

        if (!is_id_correct($this->_db, Config::TABLE_DOCUMENT, $this->id())) {
            throw new InvalidID('id "' . $this->id() . '" in table "' . Config::TABLE_DOCUMENT . '" isn`t correct.');
        }
    }

    public function id() { return $this->_id;}

    public function type() {
        return get_field_with_id($this->_db, 'type', Config::TABLE_DOCUMENT, $this->id());
    }

    public function url() {
        return get_field_with_id($this->_db, 'url', Config::TABLE_DOCUMENT, $this->id());
    }

    public function path() {
        return get_field_with_id($this->_db, 'path', Config::TABLE_DOCUMENT, $this->id());
    }

    public function is_visible() { 
        $int = (int) get_field_with_id($this->_db, 'visible', Config::TABLE_DOCUMENT, $this->id());
        return $int === 1;
    }

    public function set_visible(bool $bool) {
        $bool = $bool ? 1 : 0;
        $sql = "UPDATE `%s` SET `visible` = '%d' WHERE `id_%s` = %d";
        $sql = sprintf($sql, Config::TABLE_DOCUMENT, $bool, Config::TABLE_DOCUMENT, $this->_id);
        $this->_db->query($sql);
    }

    public function is_deleted() { return $this->path() == null; }
}
