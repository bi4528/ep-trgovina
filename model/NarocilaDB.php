<?php

require_once 'model/AbstractDB2.php';

class NarocilaDB extends AbstractDB2 {

    public static function getAll() {
        return parent::query("SELECT * FROM narocila");
    }
    
    public static function delete(array $id) {
        
    }
    
    public static function get(array $id) {
        
    }

    public static function getNarociloByKupec(array $params) {
        return parent::query("SELECT narocila.id FROM narocila WHERE narocila.kupec_id = :kupec_id", $params);
    }

    public static function insert(array $params) {
        return parent::modify("INSERT INTO narocila (kupec_id, stanje, cas) "
                        . " VALUES (:kupec_id, 'neobdelano', CURRENT_TIMESTAMP())", $params);
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
    
    public static function lastInsertId(){
        return parent::lastInsertId();
    }
}

