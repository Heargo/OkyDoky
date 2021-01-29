<?php

include(__DIR__ . '/tools.php');

class Document {

    private $_id;
    private $_db;
    private $_type;
    private $_path;
    private $_visible;
    private $_table_name;

    public function __construct(mysqli $db, string $table, int $id) {
        $this->_db = $db;
        $this->_id = (int) $id;
        $this->_table_name = $table;
        $this->_load_infos();
    }

    public function id() { return $this->_id;}
    public function type() { return $this->_type;}
    public function path() { return $this->_path;}
    public function visible() { return $this->_visible;}

    public function setVisible(bool $bool) {
        $this->_visible = $bool;
        $bool = $bool ? 1 : 0;
        $sql = 'UPDATE `' . $this->_table_name . "` SET `visible` = '$bool' WHERE `id` = " . $this->_id;
        $this->_db->query($sql);
    }

    private function _load_infos() {

        if (!is_id_correct($this->_db, $this->_table_name, $this->_id)) {
            throw new InvalidID('id "' . $this->_id . '" in table "' . $this->_table_name . '" isn`t correct.');
        }

        $sql = 'SELECT type, path, visible FROM' . $this->_table_name . 'WHERE id = ' . $this->_id;
        $result = $this->_db->query($sql);
        $row = $result->fetch_assoc();

        $this->_visible = ((int) $row['visible']) == 1; 
        $this->_type = $row['type'];
        $this->_path = $row['path'];
    }
}
