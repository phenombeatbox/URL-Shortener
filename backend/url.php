<?php
include_once 'db.php';

if (empty($_REQUEST['cmd'])) {
    echo 'Not have in request cmd param';
}

switch ($_REQUEST['cmd']) {
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
    if (!$res->execute([$_REQUEST['full'], $_REQUEST['cut']])) {
        throw new Exception("Not add", 500);
    }
    echo 'Success';
}

function edit($db) {
    $res = $db->prepare('UPDATE url SET cut = ? WHERE full = ?');
    if (!$res->execute([$_REQUEST['cut'], $_REQUEST['full']])) {
        throw new Exception("Not edit", 500);
    }
    echo 'Success';
}

function search($db) {
    $res = $db->prepare("SELECT full, cut FROM url WHERE full LIKE %{$_REQUEST['full']}}%");
    if (!$res->execute()) {
        throw new Exception("Not search", 500);
    }

    $rows = $res->fetchAll();

    echo json_encode(empty($rows) ? [] : $rows);
}