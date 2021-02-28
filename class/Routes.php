<?php

class Routes {

    private $_regex_get = array();
    private $_regex_post = array();

    public function __construct(){
    }

    /** 
     * Lier une URL à une vue
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

    /** 
     * Lier une URL à une action
     *
     * eg : lier /document/new à la fonction upload_document (voir action/documents.php)
     * et /document/del à la fonction delete_document : 
     * $ROUTES->bound_post("/document/new", 'upload_document', ['file'] )
     *        ->bound_post("/document/del", 'delete_document', ['id'] );
     *
     * @param $regex une expression régulière représentant une URL
     * @param $func le nom de la fonction à appeler, sous forme de string.
     *        Cette fonction est appelé en passant en paramètre le groupe capturé par
     *        $regex, si il y un catching group dans la regex.
     * @param $required_fields string[] (optionnel) est un tableau de string,
     *        qui représente les champs requis par votre fonction $func.
     *        Cette dernière n'est pas pas appeller si tout les champs passé
     *        ne sont pas renseigné. Ceci dit, la validité des champs n'est
     *        pas vérifiés, le soin vous est laissez.
     */
    public function bound_post(string $regex, callable $func, ?array $required_fields=null){
        $this->_regex_post['#^' . $regex . '/?$#'] = array($func, $required_fields);
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
            foreach ($this->_regex_post as $regex => list($func, $req_fields)) {
                if (preg_match($regex, self::get_url(), $match)){
                    if (!isset($req_fields) || self::are_fields_valid($req_fields, $_POST)) $func($match);
                }
            }
        }
    }

    /**
     * Renvoie le chemin demandé par l'utilisateur
     *
     * Si l'URL est sb.sinux.sh/leonards/okydoky/community
     *   => /community est retourné
     */
    public static function get_url() {
        // Pourquoi ne pas utiliser directement la ligne 1 de cette fonction ?
        // Parceque le chemin retourner ne serait pas le bon s'il se situe dans un sous-répertoire.
        //          monsupersiteamoi.com    /truc/bidule/machin/chouette
        $full_url = $_SERVER['HTTP_HOST'] . explode('?', $_SERVER['REQUEST_URI'])[0];
        preg_match('#' . Config::URL_ROOT(false) . '(.*)#', $full_url, $match);
        return $match[1]; // /truc/bidule/machin/chouette

    }

    public static function are_fields_valid(array $required_fields, array $post){
        $res = true;
        foreach($required_fields as $field){
            if (!isset($post[$field])) {
                $res = false; 
                break; // Don't iterate over the whole array
            }
        }
        return $res;
    }

    public static function url_for(string $ressource_path) {
        return Config::URL_SUBDIR(false) . $ressource_path;
    }
}

