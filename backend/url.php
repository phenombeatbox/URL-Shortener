<?php
include_once 'db.php';

if (empty($_REQUEST['cmd'])) {
    echo json_encode(['msg' => 'Not have cmd param in request', 'GET' => $_GET, 'POST' => $_POST, 'REUQEST' => $_REQUEST]);
}

$cmd  =  $_REQUEST['cmd'];

switch ($cmd) {
    case 'update':
        update($db);
        break;
    case 'add':
        add($db);
        break;
    case 'edit':
        edit($db);
        break;
    case 'search':
        search($db);
        break;
    case 'get_full_url': 
        getFullUrl($db);
        break;
    default: 
        echo 'Not found cmd';
        return;
}

function update($db) {
    $full = $_REQUEST['full'];
    $res = $db->prepare("SELECT full_url FROM url WHERE full_url = ?");
    if (!$res->execute([$full])) {
        echo json_encode($res->errorInfo());
        return;
    }

    $rows = $res->fetchAll();

    if (empty($rows)) {
        add($db);
    } else {
        edit($db);
    }

}


function add($db) {
    $res = $db->prepare('INSERT INTO url (full_url, cut_url) VALUES (?,?)');
    if (!$res->execute([$_REQUEST['full'], $_REQUEST['cut']])) {
        echo json_encode($res->errorInfo());
        return;
    }
    echo 'Success';
}

function edit($db) {
    $res = $db->prepare('UPDATE url SET cut_url = ? WHERE full_url = ?');
    if (!$res->execute([$_REQUEST['cut'], $_REQUEST['full']])) {
        echo json_encode($res->errorInfo());
        return;
    }
    echo 'Success';
}

function search($db) {
    $search_text = $_REQUEST['full'];
    $res = $db->prepare("SELECT full_url, cut_url FROM url WHERE full_url LIKE '%$search_text%'");
    if (!$res->execute()) {
        echo json_encode($res->errorInfo());
        return;
    }

    $rows = $res->fetchAll();

    echo json_encode(empty($rows) ? [] : $rows);
}

function getFullUrl($db) {
    $cut_text = $_REQUEST['cut_url'];
    $res = $db->prepare("SELECT full_url FROM url WHERE cut_url = ?");
    if (!$res->execute([$cut_text])) {
        echo json_encode($res->errorInfo());
        return;
    }

    $rows = $res->fetchAll();

    echo json_encode(empty($rows) ? [] : $rows);
}
//echo  json_encode(['GET' => var_dump($_GET), 'POST' => var_dump($_POST), 'REUQEST' => var_dump($_REQUEST)]);