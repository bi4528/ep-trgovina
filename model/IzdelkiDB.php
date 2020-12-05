<?php

require_once 'model/AbstractDB.php';

class IzdelkiDB extends AbstractDB2 {

    public static function getAll() {
        return parent::query("SELECT izdelki.id AS ID, izdelki.ime AS Ime, uporabniki.ime AS Uporabnik from izdelki, uporabniki");
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
