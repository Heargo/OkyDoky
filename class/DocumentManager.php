<?php

/**
 * Provide a way to manipulate documents
 */
class DocumentManager {
    /**
     * DB connection
     */
    private $_db;
    public static $authorized_mime = ["image/gif","image/jpeg","image/png","application/pdf",
        "text/css","text/html","application/javascript","text/x-c","text/x-java-source,java",
        "application/json","application/x-latex","application/x-lua","text/markdown","application/x-ocaml",
        "text/plain","application/x-python","application/x-php","application/x-swift"];

    /**
     * Instaciate a manager for a DB connection
     */
    public function __construct(mysqli $db) {
        $this->_db = $db;
    }

    /**
     * Get a document by its ID
     */
    public function get_by_id(int $id) : ?Document {
        try {
            return new Document($this->_db, $id);
        } catch (InvalidID $e) {
            return null;
       }
    }

    /**
     * Get document(s) bound to a post
     *
     * @return Document[] Array of documents.
     */
    public function get_by_post(Post $p) : ?array {
        $sql = "SELECT `id_%s` FROM `%s` WHERE `post` = %d";
        $sql = sprintf($sql, Config::TABLE_DOCUMENT, Config::TABLE_DOCUMENT, $p->id());
        $result = $this->_db->query($sql);

        if ($result) {
            for ($list = array();
                 $row = $result->fetch_row();
                 $list[] = new Document($this->_db, $row[0]));
            return $list;
        }
        return null;
    }


    /**
     * Get an array of documents
     *
     * @param bool|null $visible Filter if files are marked as visible or not. Null will return both.
     * @param int $limit Limits the number of document you want.
     * @param int $offset So you can get documents by slice of $limit. $offset should be a multiple of $limit.
     * @return Document[] An array of documents.
     */
    public function get_documents(?bool $visible = true, int $limit = 10, int $offset = 0) : array {
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
                 $list[] = new Document($this->_db, $row['id_' . Config::TABLE_DOCUMENT]));
            return $list;
        }
        return array();
    }

    /**
     * Add a document to the DB
     *
     * @param array $document A file from the global array $_FILES like $_FILES['profile_picture'].
     * @param bool $visible Should the document be visible by an average user.
     * @param int|null Return the ID of the document added. Null type means an error occured.
     * @throw NotWritable If Config::DIR_DOCUMENT is not writable.
     */
    public function add_document(array $document, bool $visible = true) : ?int {
        $visible = $visible ? 1 : 0;

        // @todo change size
        // if file isn't empty and not too large
        if ($document['size'] != 0 && $document['size'] < 50000000) {
            if (!is_writable(Config::DIR_DOCUMENT)) {
                throw new NotWritable('Directory ' . Config::DIR_DOCUMENT . ' is not writable');
            }
            
            $type = mime_content_type($document['tmp_name']);
            if(!in_array($type,DocumentManager::$authorized_mime)){
                $type = "autre";
            }
            // insert tmp path to DB
            $sql = "INSERT INTO `%s` (`type`, `path`, `visible`) VALUES ('%s', '%s', '%d')";
            $sql = sprintf($sql, Config::TABLE_DOCUMENT, $type,$document['tmp_name'], $visible);
            $this->_db->query($sql);

            // move tmp file to permanent path
            $id = (int) $this->_db->insert_id;
            $file_name = basename($id . '_' . $document['name']);
            $file_path = Config::DIR_DOCUMENT . $file_name;
            move_uploaded_file($document['tmp_name'], $file_path);

            // update DB with real path
            $file_url = 'http://' . Config::URL_ROOT() . 'data/document/' . $file_name;
            $sql = "UPDATE `%s` SET `url` = '%s', `path` = '%s' WHERE `id_%s` = '%d'";
            $sql = sprintf($sql, Config::TABLE_DOCUMENT, $file_url, $file_path, Config::TABLE_DOCUMENT, $id);
            $this->_db->query($sql);
        
            return $id;
        }
        return null;
    }

    /**
      * Delete a document based on its ID
      *
      * @todo We should pass a Document instance instead of ID.
      * @param int $id The ID of the document.
      * @return bool True if successful.
     */
    public function del_document(int $id) : bool {
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

