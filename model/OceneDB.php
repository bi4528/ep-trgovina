<?php

require_once 'model/AbstractDB2.php';

class OceneDB extends AbstractDB2 {

    public static function getAll() {
        return parent::query("SELECT * FROM ocene");
    }
    
    public static function delete(array $id) {
        return parent::modify("DELETE FROM ocene WHERE id= :id", $id);
    }

    public static function get(array $params) {
        return parent::query("SELECT * FROM ocene WHERE slike.id = :id", $params);
    }
    
    public static function getPovprecna(array $params) {
        return parent::query("SELECT AVG(ocena) FROM ocene WHERE izdelek_id = :id", $params);
    }

    public static function insert(array $params) {
        return parent::modify("INSERT INTO ocene (kupec_id, izdelek_id, ocena) "
                        . " VALUES (:kupec_id, :izdelek_id, :ocena)", $params);
    }
    
    public static function update(array $params) {
        return parent::modify("UPDATE slike SET kupec_id = :kupec_id, izdelek_id = :izdelek_id, ocena= :ocena, WHERE id= :id", $params);
    }
    
    public static function getOcenaByIzdelek(array $params) {
        return parent::query("SELECT * FROM ocene WHERE ocene.izdelek_id = :izdelek_id", $params);
    }
}

