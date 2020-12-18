<?php

require_once 'model/AbstractDB2.php';

class IzdelkiDB extends AbstractDB2 {

    public static function getAll() {
        return parent::query("SELECT CONCAT(u.ime, \" \" ,u.priimek) AS prodajalec, i.ime AS ime, i.opis AS opis, i.cena AS cena, i.id AS id "
                . "FROM uporabniki u, izdelki i "
                . "WHERE u.id = i.prodajalec_id and i.aktiven = 1;");
    }
    
    public static function delete(array $id) {
        return parent::modify("DELETE FROM izdelki WHERE id= :id", $id);
    }

    public static function get(array $params) {
        return parent::query("SELECT * FROM izdelki WHERE izdelki.id = :izdelek_id", $params);
    }

    public static function insert(array $params) {
        return parent::modify("INSERT INTO izdelki (ime, opis, cena, prodajalec_id, aktiven) "
                        . " VALUES (:ime, :opis, :cena, :prodajalec_id, :aktiven)", $params);
    }
    
    public static function update(array $params) {
        return parent::modify("UPDATE izdelki SET ime= :ime, opis= :opis, cena= :cena WHERE id= :id", $params);
    }
    
    public static function getAllAtributes() {
        return parent::query("SELECT * FROM  izdelki;");
    }
    
    public static function getIzdelkiProdajalec() {
        return parent::query("select * from izdelki");
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
    }
    
    public static function getIsci(array $params) {
        return parent::query("select * "
                            . "from (select *, match(ime, opis) against(concat('*',:isc,'*') in boolean mode) as score from izdelki) "
                            . "as dt where score <> 0 order by score desc", $params);
    }
    
}
