<?php


namespace Service;


class BusyContactManager extends DbManager
{
    public function setClient(\stdClass $contact)
    {
        $query = "insert into busy_contact values(null, {$contact->id})";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute();
    }

    public function removeContact(\stdClass $contact)
    {
        $query = "delete from busy_contact
                  WHERE contact = {$contact->id}";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute();
    }
}