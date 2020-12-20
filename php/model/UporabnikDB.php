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
    
    public static function getPassword(array $params) {
        return parent::query("select geslo from uporabniki where id= :id", $params);
    }
    
    public static function changePassword(array $params) {
        return parent::modify("update uporabniki set geslo = :geslo where id = :id", $params);
    }
    
    public static function changeAktiven(array $params) {
        return parent::modify("update uporabniki set aktiven = :aktiven where id = :id", $params);
    }
    
    public static function getAttributes(array $params) {
        return parent::query("select * from uporabniki where id= :id", $params);
    }
    public static function getAttributesEmail(array $params) {
        return parent::query("select * from uporabniki where email= :email", $params);
    }
    
    public static function updateAttributes(array $params) {
        return parent::modify("update uporabniki set ime= :ime, priimek= :priimek, email= :email, naslov= nullif(:naslov, '') where id= :id", $params);
    }
    
    public static function getVloga(array $params) {
        return parent::query("select vloga from uporabniki where id= :id", $params);
    }

    public static function delete(array $id) {
        return parent::modify("DELETE FROM uporabniki WHERE id= :id", $id);
    }

    public static function get(array $id) {
        
    }

    public static function insert(array $params) {
        return parent::modify("insert into `uporabniki` (ime, priimek, naslov, email, geslo, vloga, aktiven) "
                        . " values (:ime, :priimek, nullif(:naslov, ''), :email, :geslo, :vloga, :aktiven)", $params);
    }
    
    public static function getup(array $params) {
        return parent::query("select id, ime, geslo, aktiven, vloga from uporabniki where email = :email", $params);
    }

    public static function update(array $params) {
        return parent::modify("update uporabniki set ime= :ime, priimek= :priimek, email= :email, naslov= nullif(:naslov, '') where id= :id", $params);
    }

}
