<?php

require_once 'model/AbstractDB.php';

class IzdelkiDB extends AbstractDB2 {

    public static function getAll() {
        return parent::query("SELECT CONCAT(u.ime, \" \" ,u.priimek) AS prodajalec, i.ime AS ime, i.opis AS opis, i.cena AS cena "
                . "FROM uporabniki u, izdelki i "
                . "WHERE u.id = i.prodajalec_id;");
    }
    
    public static function delete(array $id) {
        
    }

    public static function get(array $id) {
        
    }

    public static function insert(array $params) {
        return parent::modify("INSERT INTO izdelki (ime, opis, cena, prodajalec_id, aktiven) "
                        . " VALUES (:ime, :opis, :cena, :prodajalec_id, :aktiven)", $params);
    }
    
    public static function getIzdelkiProdajalec(array $params) {
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


    public static function update(array $params) {
        
    }
}
