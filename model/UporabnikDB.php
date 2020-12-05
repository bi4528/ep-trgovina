<?php

require_once 'model/AbstractDB2.php';

class UprabnikDB extends AbstractDB2 {
    
    public static function getAll() {
        return parent::query("SELECT * from uporabniki");
    }
    
    public static function getAdmin() {
        return parent::query("SELECT * from uporabniki WHERE vloga='admin' limit 1");
    }
    
    public static function getProdajalci() {
        return parent::query("select * from uporabniki where vloga='prodajalec'");
    }
    
    public static function getStranke() {
        return parent::query("select * from uporabniki where vloga='stranka'");
    }

    public static function delete(array $id) {
        
    }

    public static function get(array $id) {
        
    }

    public static function insert(array $params) {
        
    }

    public static function update(array $params) {
        
    }

}
