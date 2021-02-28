<?php

class Config {
    // DB
    public const DB_HOST = 'localhost';
    public const DB_USER = '<USER>';
    public const DB_PASSWORD = '<PASSWORD>';
    public const DB_NAME = '<BDD>';

    // Tables
    public const TABLE_DOCUMENT = 'document';
    public const TABLE_USER = 'user';

    // Files
    public const DIR_DOCUMENT = __DIR__ . '/data/document/';

    //URLs
    public const URL_ROOT = 'example.com/okydoky/';

    //DO NOT TOUCH
    public static function URL_ROOT(bool $trailing_slash = true){
        $root = self::URL_ROOT;
        $slash = substr($root, -1) === '/';
        return $slash ?
            ($trailing_slash ? $root : substr($root,0,-1)) 
            :
            ($trailing_slash ? $root . '/' : $root);
    }

    public static function URL_SUBDIR(bool $trailing_slash = true){
        $subdir = explode('/', self::URL_ROOT($trailing_slash), 2)[1] ?? '';
        $subdir = empty($subdir) ? $subdir : '/' . $subdir;  // add heading slash if needed
        return $subdir;
    }
}
