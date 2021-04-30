<?php

/**
 * Provide a way to manipulate a particular document.
 */
class Document {

    /** DB connection */
    private $_db;

    /** ID of the document */
    private $_id;

    /**
     * Instanciate a document from an ID
     *
     * @throw InvalidID If the ID isn't in the DB or if there is more than one.
     */
    public function __construct(mysqli $db, int $id) {
        $this->_db = $db;
        $this->_id = (int) $id;

        if (!is_id_correct($this->_db, Config::TABLE_DOCUMENT, $this->id())) {
            throw new InvalidID('id "' . $this->id() . '" in table "' . Config::TABLE_DOCUMENT . '" isn`t correct.');
        }
    }


    /** Return the ID of the document */
    public function id() : int { return $this->_id;}

    /** Return the type of the document */
    public function type() : ?string {
        $res = get_field_with_id($this->_db, 'type', Config::TABLE_DOCUMENT, $this->id());
        if($res != null){
            $tab = explode("/",$res);
            if($tab[0] == "application"){
                if($tab[1]=="pdf"){
                    return "pdf";
                }
                elseif($tab[1]=="javascript" ||$tab[1]=="json" ||
                        $tab[1]=="x-latex" ||$tab[1]=="x-lua" ||
                        $tab[1]=="x-ocaml" ||$tab[1]=="x-python" ||
                        $tab[1]=="x-swift" ||$tab[1]=="x-php"){
                            return "code";
                        }
                }
            elseif($tab[0]=="text"){
                return "code";
            }
            elseif($tab[0]=="image"){
                return "image";
            }
            else{return "autre";}
        }
        else{return null;}
    }

    /** Return the url of the document */
    public function url() : string {
        return get_field_with_id($this->_db, 'url', Config::TABLE_DOCUMENT, $this->id());
        
    }

    /** Return the path of the document server-side */
    public function path() : string {
        return get_field_with_id($this->_db, 'path', Config::TABLE_DOCUMENT, $this->id());
    }

    /** Return true if the document should the visible by average users */
    public function is_visible() : bool { 
        $int = (int) get_field_with_id($this->_db, 'visible', Config::TABLE_DOCUMENT, $this->id());
        return $int === 1;
    }

    /**
     * Sets the visibility of the document
     *
     * @param bool $visible if the document should be visible by an average user.
     * @return bool True if successful
     */
    public function set_visible(bool $visible) : bool {
        $visible = $visible ? 1 : 0;
        $sql = "UPDATE `%s` SET `visible` = %d WHERE `id_%s` = %d";
        $sql = sprintf($sql, Config::TABLE_DOCUMENT, $visible, Config::TABLE_DOCUMENT, $this->id());
        return (bool) $this->_db->query($sql);
    }

    /**
     * Bound a document to a post
     *
     * @param Post $p the post that own the document.
     * @return bool True if successful.
     */
    public function bound(Post $p) : bool {
        $id = $p->id();
        $sql = "UPDATE `%s` SET `post` = %d WHERE `id_%s` = %d";
        $sql = sprintf($sql, Config::TABLE_DOCUMENT, $id, Config::TABLE_DOCUMENT, $this->id());
        $ok = $this->_db->query($sql);
        return (bool) $ok;
    }
    /**
     * Is the document deleted
     *
     * @return bool True if it's deleted.
     */
    public function is_deleted() : bool { return $this->path() == null; }
}
