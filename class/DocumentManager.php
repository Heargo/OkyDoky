<?php

require_once(__DIR__ . '/tools.php');
require_once(__DIR__ . '/../config.php');

require_once(__DIR__ . '/Document.php');


class DocumentManager {
    private $_db;

    public function __construct(mysqli $db) {
        $this->_db = $db;
    }

    public function get_by_id(int $id){
        try {
            return new Document($this->_db, $id);
        } catch (InvalidID $e) {
            return null;
       }
    }
    //public get_by_post(Post $p);

    // For moderation purpose
    public function get_documents(?bool $visible = true, int $limit = 10, int $offset = 0) {
        if (isset($visible)) {
            $visible = $visible ? 1 : 0;
            $sql = "SELECT `id_%s` FROM `%s` WHERE `visible` = %d AND `url` IS NOT NULL LIMIT %d OFFSET %d";
            $sql = sprintf($sql, Config::TABLE_DOCUMENT, Config::TABLE_DOCUMENT, $visible, $limit, $offset);
        } else {
            $sql = "SELECT `id_%s` FROM `%s` LIMIT %d OFFSET %d";
            $sql = sprintf($sql, Config::TABLE_DOCUMENT, Config::TABLE_DOCUMENT, $limit, $offset);
        }
        $result = $this->_db->query($sql);
        if($result) {
            for ($list = array();
                 $row = $result->fetch_assoc();
                 $list[] = new Document($this->_db, $row['id_document']));
            return $list;
        }
        return array();
    }

    public function add_document(array $document, bool $visible = true) : ?int {
        $visible = $visible ? 1 : 0;

        // if file isn't empty and not too large
        if ($document['size'] != 0 && $document['size'] < 50000000) {
            // insert tmp path to DB
            $sql = "INSERT INTO `%s` (`type`, `path`, `visible`) VALUES ('image', '%s', '%d')";
            $sql = sprintf($sql, Config::TABLE_DOCUMENT, $document['tmp_name'], $visible);
            $this->_db->query($sql);

            // move tmp file to permanent path
            $id = (int) $this->_db->insert_id;
            $file_name = basename($id . '_' . $document['name']);
            $file_path = Config::DIR_DOCUMENT . $file_name;
            move_uploaded_file($document['tmp_name'], $file_path);

            // update DB with real path
            $file_url = Config::URL_ROOT . 'doc/' . $file_name;
            $sql = "UPDATE `%s` SET `url` = '%s', `path` = '%s' WHERE `id_document` = '%d'";
            $sql = sprintf($sql, Config::TABLE_DOCUMENT, $file_url, $file_path, $id);
            $this->_db->query($sql);

            return $id;
        }
        return null;
    }

    public function del_document(int $id) {
        if (is_id_correct($this->_db, Config::TABLE_DOCUMENT, $id)) {
            $doc = $this->get_by_id($id);

            // File itself
            if (file_exists($doc->path())) { unlink($doc->path()); }

            // Visibility
            $doc->set_visible(false);
            
            // Path
            $sql = "UPDATE `%s` SET `path` = NULL WHERE `id_%s` = %d";
            $sql = sprintf($sql, Config::TABLE_DOCUMENT, Config::TABLE_DOCUMENT, $id);
            $this->_db->query($sql);
        }
    }
}

