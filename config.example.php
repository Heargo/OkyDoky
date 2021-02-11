<?php

class Config {
    // DB
    public const DB_HOST = 'localhost';
    public const DB_USER = '<USER>';
    public const DB_PASSWORD = '<PASSWORD>';
    public const DB_NAME = '<BDD>';

    // Tables
    public const TABLE_DOCUMENT = 'document';

    // Files
    public const DIR_DOCUMENT = __DIR__ . '/data/document/';

    //URLs
    public const URL_ROOT = 'example.com/okydoky/';

    //DO NOT TOUCH
    public static function URL_ROOT(bool $trailing_slash = true){
        $root = self::URL_ROOT;
        $slash = str_ends_with($root, '/');
        return $slash ?
            ($trailing_slash ? root : substr($root,0,-1)) 
            :
            ($trailing_slash ? $root . '/' : $root);
    }
}
