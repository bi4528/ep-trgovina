<?php

require_once 'model/AbstractDB2.php';

class SlikeDB extends AbstractDB2 {

    public static function getAll() {
        return parent::query("SELECT * FROM slike");
    }
    
    public static function delete(array $id) {
        return parent::modify("DELETE FROM slike WHERE id= :id", $id);
    }

    public static function get(array $params) {
        return parent::query("SELECT * FROM slike WHERE slike.id = :id", $params);
    }

    public static function insert(array $params) {
        return parent::modify("INSERT INTO slike (slika, izdelek_id) "
                        . " VALUES (:slika, :izdelek_id)", $params);
    }
    
    public static function update(array $params) {
        return parent::modify("UPDATE slike SET izdelek_id = :izdelek_id, slika= :slika, WHERE id= :id", $params);
    }
    
    public static function getSlikaByIzdelek(array $params) {
        return parent::query("SELECT * FROM slike WHERE slike.izdelek_id = :izdelek_id", $params);
    }
}

