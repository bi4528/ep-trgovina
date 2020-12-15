<?php

require_once 'model/AbstractDB.php';

class izdelekNarocilaDB extends AbstractDB2 {

    public static function getAll() {
        
    }
    
    public static function delete(array $id) {
        
    }

    public static function get(array $id) {
        
    }

    public static function insert(array $params) {
        return parent::modify("INSERT INTO izdelekNarocila (narocilo_id, izdelek_id, steviloIzdelkov) "
                        . " VALUES (:narocilo_id, :izdelek_id, :steviloIzdelkov)", $params);
    }
    
    public static function getIzdelkiByNarocilo(array $params){
        return parent::query("SELECT * FROM izdelekNarocila WHERE izdelekNarocila.narocilo_id = :id", $params);
    }
    
    /*public static function getIzdelkiProdajalec(array $params) {
        return parent::query("select * from izdelki where prodajalec_id= :id", $params);
    }
    
    public static function changeAktiven(array $params) {
        return parent::modify("update izdelki set aktiven = :aktiven where id = :id", $params);
    }
    
    public static function changeAktivenProdajalec(array $params) {
        return parent::modify("update izdelki set aktiven = :aktiven where prodajalec_id = :id", $params);
    }
    
    public static function getAttributes(array $params) {
        return parent::query("select * from izdelki where id= :id", $params);
    }
    
    public static function updateAttributes(array $params) {
        return parent::modify("update izdelki set ime= :ime, opis= :opis, cena= :cena where id= :id", $params);
    }*/


    public static function update(array $params) {
        
    }
}

