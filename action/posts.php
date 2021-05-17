<?php
function upload_post(?array $match) {
	if (User::is_connected() && $_FILES['file']['size'] != 0) {

		$id_doc = $GLOBALS["docs"]->add_document($_FILES["file"]);
		$doc = $GLOBALS["docs"]->get_by_id($id_doc);
		$commu = $GLOBALS["communities"]->get_by_id((int)$_POST["community"]);
		if (isset($commu) && isset($doc)) {
			$id_post = $GLOBALS["posts"]->add_post(User::current(),$commu,$_POST["title"],$_POST["description"],[$doc]);
			/*give xp*/
        	User::current()->add_points_in_community($commu, 10);
		}
		$root = Config::URL_SUBDIR(false);
    	header("Location: $root/feed");
	}
	else{
		$root = Config::URL_SUBDIR(false);
    	header("Location: $root/post");
	}
	
}