<?php
spl_autoload_register(function ($class) {
    $namespace = __DIR__.'/'.str_replace('\\', '/', $class).'.php';
    require_once $namespace;
}, true);

$contactManager = new \Service\ContactManager();
$contact = $contactManager->findFreeContact();

if (!$contact) {
    throw new Exception('на данный момент нет контактов для работы');
}

$busyContact = new \Service\BusyContactManager();
$busyContact->setClient($contact);

//operator does some work

//after operator end`s some work set new contact status
$contactManager->setNewStatus($contact, \Service\ContactManager::BUSY);

//then delete contact from busy_contact
$busyContact->removeContact($contact);

exit();


