<?php
$dsn = array(
    'username' => 'postgres',
    'password' => 'admini',
    'database' => 'postgres',
);

try {
    $db = new PDO('pgsql:host=localhost;dbname='.$dsn['database'], $dsn['username'], $dsn['password'],
        array(
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        )
    );
    //    $db->query("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    print "Error connect postresql!: " . $e->getMessage() . "<br/>";
    die();
}