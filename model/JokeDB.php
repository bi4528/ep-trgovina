<?php

require_once 'model/AbstractDB.php';

class BookDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("insert into jokes (joke_text, joke_date) "
                        . " values (:joke_text, :joke_date)", $params);
    }

    public static function update(array $params) {
        return parent::modify("update jokes set joke_text= :joke_text, joke_date= :joke_date where id= :id", $params);
    }

    public static function delete(array $id) {
        return parent::modify("DELETE FROM jokes WHERE id = :id", $id);
    }

    public static function get(array $id) {
        $books = parent::query("SELECT id, joke_text, joke_date FROM jokes WHERE id = :id", $id);
        
        if (count($books) == 1) {
            return $books[0];
        } else {
            throw new InvalidArgumentException("No such book");
        }
    }

    public static function getAll() {
        return parent::query("SELECT id, joke_text, joke_date FROM jokes");
    }

}
