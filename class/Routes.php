<?php

class Routes {

    private $_regex_get = array();
    private $_regex_post = array();

    public function __construct(){
    }

    /** 
     * Lier une URL à une page
     *
     * eg : lier /community à liste_communities.php (celles visible par l'utilisateur courrant) 
     * et /community/uneCommunauté à display_community.php : 
     * $ROUTES->bound_get("/community", "liste_communities.php")
     *        ->bound_get("/community/(.+)", "display_community.php");
     *
     * @param $regex une expression régulière représentant une URL
     * @param $filename le nom de la vue à inclure
     */
    public function bound_get(string $regex, string $filename){
        $this->_regex_get['#^' . $regex . '/?$#'] = $filename;
        return $this;
    }

    // Pour les actions
    public function bound_post(string $regex, callable $func, ?string $action){
        $this->_regex_post['#^' . $regex . '/?$#'] = array($func, $action);
        return $this;
    }

    public function execute(){
        $method = $_SERVER['REQUEST_METHOD'];

        $match = null;
        if ($method === "GET") {
            foreach ($this->_regex_get as $regex => $filename) {
                if (preg_match($regex, self::get_url(), $match)){
                    global $PAGE;
                    isset($PAGE) ? : $PAGE = array();
                    $PAGE["url"] = self::get_url();
                    $PAGE["match"] = $match;
                    include $filename;
                }
            }
        } else if ($method === "POST") {
            foreach ($this->_regex_post as $regex => list($func, $action)) {
                if (preg_match($regex, self::get_url(), $match)){
                    if (!isset($action) || isset($_POST['action']) && $_POST['action'] == $action)
                        $func($match);
                        header("Location: .");
                }
            }
        }
    }

    public static function get_url() {
        //          monsupersiteamoi.com    /truc/bidule/machin/chouette
        $full_url = $_SERVER['HTTP_HOST'] . explode('?', $_SERVER['REQUEST_URI'])[0];
        $match = "/";
        preg_match('#' . Config::URL_ROOT(false) . '(.*)#', $full_url, $match);
        return $match[1]; // /truc/bidule/machin/chouette

    }
}

