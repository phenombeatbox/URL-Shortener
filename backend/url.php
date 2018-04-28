<?php
include_once 'db.php';

switch ($_POST['cmd']) {
    case 'add':
        add($db);
        break;
    case 'edit':
        edit($db);
        break;
    case 'search':
        search($db);
        break;
}




function add($db) {
    $res = $db->prepare('INSERT INTO url (full, cut) VALUES (?,?)');
    if (!$res->execute([$_POST['full'], $_POST['cut']])) {
        throw new Exception("Not add", 500);
    }
}

function edit($db) {
    $res = $db->prepare('UPDATE url SET cut = ? WHERE full = ?');
    if (!$res->execute([$_POST['cut'], $_POST['full']])) {
        throw new Exception("Not edit", 500);
    }
}

function search($db) {
    $res = $db->prepare("SELECT full, cut FROM url WHERE full LIKE %{$_POST['full']}}%");
    if (!$res->execute()) {
        throw new Exception("Not search", 500);
    }

    $rows = $res->fetchAll();

    echo json_encode(empty($rows) ? [] : $rows);
}