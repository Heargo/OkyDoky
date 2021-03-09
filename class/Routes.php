<?php

/**
 * A proper way to handle URLs
 */
class Routes {

    /** An array containing GET URLs as regex */
    private $_regex_get = array();

    /** An array containing GET URLs as regex */
    private $_regex_post = array();

    /** 
     * Bound a URL to a view page
     *
     * eg : lier /community à liste_communities.php (celles visible par l'utilisateur courrant) 
     * et /community/uneCommunauté à display_community.php : 
     * $ROUTES->bound_get("/community", "liste_communities.php")
     *        ->bound_get("/community/(\w+)", "display_community.php");
     *
     * @param string $regex A regular expression representing the URL.
     * @param string $filename The name of the file to include.
     * @param callable $before An optional function to call before including $filename.
     *        This funtion should take an **optional** array, reprensenting matching groups of $regex.
     * @return $this So you can easily chain URL registration.
     */
    public function bound_get(string $regex, string $filename, ?callable $before = null) {
        $this->_regex_get['#^' . $regex . '/?$#'] = array($filename, $before);
        return $this;
    }

    /** 
     * Lier une URL à une action
     *
     * eg : lier /document/new à la fonction upload_document (voir action/documents.php)
     * et /document/del à la fonction delete_document : 
     * $ROUTES->bound_post("/document/new", 'upload_document', ['file'] )
     *        ->bound_post("/document/del", 'delete_document', ['id'] );
     *
     * @param string $regex A regular expression representing the URL.
     * @param callable $func Name of the function to call, as string.
     *        This funtion should take an **optional** array, reprensenting matching groups of $regex.
     * @param string[] $required_fields An **optional** array of string representing the name of field
     *        from $_POST that are required by your $func. If a field is missing in $_POST, $func won't be called.
     *        This is **not** a sanitizing/validating tool.
     * @return $this So you can easily chain URL registration.
     */
    public function bound_post(string $regex, callable $func, ?array $required_fields = null){
        $this->_regex_post['#^' . $regex . '/?$#'] = array($func, $required_fields);
        return $this;
    }

    /**
     * Process the request
     */
    public function execute(){
        $method = $_SERVER['REQUEST_METHOD'];

        $match = null;
        if ($method === "GET") {
            $this->_execute_get();
        } else if ($method === "POST") {
            $this->_execute_post();
        }
    }

    /**
     * Process GET requests
     */
    private function _execute_get() {
        foreach ($this->_regex_get as $regex => list($filename, $before)) {
            if (preg_match($regex, self::get_url(), $match)){
                if ($before) $before($match);
                $GLOBALS['page']['url'] = self::get_url();
                $GLOBALS['page']['match'] = $match;
                include $filename;
            }
        }
    }

    /**
     * Process POST requests
     */
    private function _execute_post() {
        foreach ($this->_regex_post as $regex => list($func, $req_fields)) {
            if (preg_match($regex, self::get_url(), $match)){
                if (!isset($req_fields) || self::are_fields_valid($req_fields, $_POST)) $func($match);
            }
        }
    }

    /**
     * Get the URL the user requested
     *
     * @return string If the URL is example.com/okydoky/community, /community is returned.
     */
    public static function get_url() : string {
        // Pourquoi ne pas utiliser directement la ligne 1 de cette fonction ?
        // Parceque le chemin retourner ne serait pas le bon s'il se situe dans un sous-répertoire.
        //          monsupersiteamoi.com    /truc/bidule/machin/chouette
        $full_url = $_SERVER['HTTP_HOST'] . explode('?', $_SERVER['REQUEST_URI'])[0];
        preg_match('#' . Config::URL_ROOT(false) . '(.*)#', $full_url, $match);
        return $match[1]; // /truc/bidule/machin/chouette

    }

    /**
     * Check whenever all files have been filled
     *
     * @param array $required_filds A list of string, reprensenting the fields to be present in $post.
     * @param array $post Usualy $_POST.
     */
    public static function are_fields_valid(array $required_fields, array $post) : bool {
        $res = true;
        foreach($required_fields as $field){
            if (!isset($post[$field])) {
                $res = false; 
                break; // Don't iterate over the whole array
            }
        }
        return $res;
    }

    /** Convinient way to get the true URL in view if your instance is in a subdirectory */
    public static function url_for(string $ressource_path) {
        return Config::URL_SUBDIR(false) . $ressource_path;
    }
}

