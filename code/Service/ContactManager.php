<?php


namespace Service;


class ContactManager extends DbManager
{
    const HAVE_NOT_CALLED = 'этому контакту мы еще не звонили';
    const CLOSED = 'контакт закрыт';
    const BUSY = 'занято';
    const NO_ANSWER = 'нет ответа';
    const ASKED_CALL_BACK = 'просили перезвонить';
    const REFUSE_TO_SPEAK = 'отказ от разговора';

    /**
     * @return \stdClass
     */
    public function findFreeContact()
    {
        $query = "select * 
                from test.contacts
                where status in (
                select id 
                from test.status
                where s_name in (
                '".self::ASKED_CALL_BACK."',
                '".self::NO_ANSWER."',
                '".self::HAVE_NOT_CALLED."', 
                '".self::BUSY."' 
                ))
                and id not in (
                select contact 
                from test.busy_contact
                )
                limit 1
                ";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS);

        if (count($result) > 0) {

            return $result[0];
        }

        return false;

    }


    public function setNewStatus(\stdClass $contact, $status)
    {
        $query = "select id from status where s_name = '{$status}'";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute();
        $status = $stmt->fetchColumn();
        $query = "update contacts
                  set status = {$status}
                  WHERE id = {$contact->id}";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute();
    }
}