<?php
mb_internal_encoding("UTF-8");
$str = file_get_contents('db.json');
$json = json_decode($str, true);

$ff=fopen('report.qqq','w+');

$mysqli = new mysqli($json['host'], $json['username'], $json['password'], $json['dbname']);
if ($mysqli->connect_error) {
    die('Ошибка подключения (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    fwrite($ff,'Ошибка подключения' . $mysqli->connect_error);
    
}
$mysqli->set_charset('utf8');

if ($json['SQLite_db'] === " ") { //Для отладки на локальном сервере должна быть указана база в db.json
    $json['SQLite_db'] = $_FILES["file"]["tmp_name"]; // на реальном сервере база загружается
    //$json['SQLite_db'] = __DIR__.'\\upload\\foto.db';
}
 fwrite($ff,$_FILES["file"]["tmp_name"]);
 
$db = new SQLite3($json['SQLite_db']);
$arhiv_file_name = "";

$results = $db->query(
    "SELECT count(name) as tabl FROM sqlite_master where name='Fotodata'"
);
$row = $results->fetchArray();
if ($row['tabl'] == 1) {
    $results = $db->query(
        "SELECT `date`, LS, potrebitel, adres, sob_id, obg_id, res_id, `user_id`, foto 
        FROM Fotodata 
        ORDER BY `date`, ls, sob_id, `user_id`"
    );
    // Запись в быт
    $bsob = $mysqli->prepare(
        "INSERT INTO bsob (sob_id, res_id, LS, potrebitel, adres, dates, `user_id`)
        VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    $bfoto = $mysqli->prepare(
        "INSERT INTO bfoto (sob_id, `user_id`, bsob_id, foto_id, f1)
        VALUES (?, ?, ?, ?, ?)"
    );
} else {
    $results = false;
}


if ($results) {
    if ($row = $results->fetchArray()) {// Первая запись
        //var_dump($row);
        $date = $row['date'];
        $LS = $row['LS'];
        $sob_id = $row['sob_id'];
        $user_id = $row['user_id'];
        bsob($row, $bsob);
        $insert_id = $mysqli->insert_id;
        bfoto($row, $bfoto, $insert_id);
        $arhiv_file_name = substr($row['date'], 6, 4).substr($row['date'], 0, 2).substr($row['date'], 3, 2).
        "_res{$row['res_id']}_user{$row['user_id']}_fotob";
    }
    while ($row = $results->fetchArray()) {
        if ($date == $row['date'] && $LS == $row['LS'] && $sob_id == $row['sob_id'] && $user_id == $row['user_id']) {
            bfoto($row, $bfoto, $insert_id);
        } else {
            $date = $row['date'];
            $LS = $row['LS'];
            $sob_id = $row['sob_id'];
            $user_id = $row['user_id'];
            bsob($row, $bsob);
            $insert_id = $mysqli->insert_id;
            bfoto($row, $bfoto, $insert_id);
        }
    }
    //$bsob->close();
    //$bfoto->close();
}


$results = $db->query(
    "SELECT count(name) as tabl FROM sqlite_master where name='Prom'"
);
$row = $results->fetchArray();
if ($row['tabl'] == 1) {
    $results = $db->query(
        "SELECT `date`, LS, potrebitel, adres, sob_id, obg_id, res_id, `user_id`, foto, id_ycheta, name_ycheta, adres_ycheta, TopCode, okpo
        FROM Prom 
        ORDER BY `date`, ls, sob_id, `user_id`"
    );
    // Запись в пром
    $psob = $mysqli->prepare(
        "INSERT INTO psob (sob_id, res_id, Abcode, potrebitel, adres, dates, `user_id`, TopAddress, TopCode, TopId, TopName, Okpo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $pfoto = $mysqli->prepare(
        "INSERT INTO pfoto (sob_id, `user_id`, psob_id, foto_id, f1)
        VALUES (?, ?, ?, ?, ?)"
    );
} else {
    $results = false;
}
if ($results) {
    if ($row = $results->fetchArray()) {// Первая запись
        //var_dump($row);
        $date = $row['date'];
        $LS = $row['LS'];
        $sob_id = $row['sob_id'];
        $user_id = $row['user_id'];
        psob($row, $psob);
        $insert_id = $mysqli->insert_id;
        pfoto($row, $pfoto, $insert_id);
        if ($arhiv_file_name === "") {
            $arhiv_file_name = substr($row['date'], 6, 4).substr($row['date'], 0, 2).substr($row['date'], 3, 2).
            "_res{$row['res_id']}_user{$row['user_id']}_fotop";
        } else {
            $arhiv_file_name.='b';
        }
    }
    while ($row = $results->fetchArray()) {
        if ($date == $row['date'] && $LS == $row['LS'] && $sob_id == $row['sob_id'] && $user_id == $row['user_id']) {
            pfoto($row, $pfoto, $insert_id);
        } else {
            $date = $row['date'];
            $LS = $row['LS'];
            $sob_id = $row['sob_id'];
            $user_id = $row['user_id'];
            psob($row, $psob);
            $insert_id = $mysqli->insert_id;
            pfoto($row, $pfoto, $insert_id);
        }
    }
    //$psob->close();
    //$pfoto->close();
}

// Запись показаний контролеров MobApp
$results = $db->query(
    "SELECT count(name) as tabl FROM sqlite_master where name='Pokazy'"
);
$row = $results->fetchArray();
if ($row['tabl'] == 1) {
    $results = $db->query(
        "SELECT `date`, LS, potrebitel, adres, res_id, `user_id`, pokazan, pokazan1, pokazan2
        FROM Pokazy "
    );
    if ($arhiv_file_name != "") {
        $arhiv_file_name .= '_pokazy';
    }
} else {
    $results = false;
}
if ($results) {
    $pokazy = $mysqli->prepare(
        "INSERT INTO sms (`number`, `date`, res_id, LS, potrebitel, adres, pokazan, pokazan1, pokazan2, client)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    while ($row = $results->fetchArray()) {
        $date = substr($row['date'], 6, 4).'-'.substr($row['date'], 0, 2).'-'.substr($row['date'], 3, 2);
        $cl = 'MobApp';
        $pokazy->bind_param(
            'ssisssiiis',
            $row['user_id'],
            $date,
            $row['res_id'],
            $row['LS'],
            $row['potrebitel'],
            $row['adres'],
            $row['pokazan'],
            $row['pokazan1'],
            $row['pokazan2'],
            $cl
        );
        if ($arhiv_file_name === "") {
            $arhiv_file_name = substr($row['date'], 6, 4).substr($row['date'], 0, 2).substr($row['date'], 3, 2).
            "_res{$row['res_id']}_user{$row['user_id']}_pokazy";
        }
        $pokazy->execute();
    }
    //$pokazy->close();
}

// закрываем подключения
//$mysqli->close();
//$db->close();
//echo "Ok";
//if ($json['SQLite_db'] === " ") {// Для локального сервера базу оставляем
    move_uploaded_file($_FILES["file"]["tmp_name"], "upload/".$arhiv_file_name);
//}

/** 
 * Запись в быт 
 *  
 * @param array  $row СТРОКА ЗАПРОСА sqlite
 * @param object $bsob ЗАПРОС
 */
function bsob($row, $bsob)  
{
    $date = substr($row['date'], 6, 4).'-'.substr($row['date'], 0, 2).'-'.substr($row['date'], 3, 2);
    //$row['user_id'] = 1; //delete
    $bsob->bind_param(
        'iissssi',
        $row['sob_id'],
        $row['res_id'],
        $row['LS'],
        $row['potrebitel'],
        $row['adres'],
        $date,
        $row['user_id']
    );
    $bsob->execute();
}

/** 
 * Запись в базу объектов съемки быт
 *  
 * @param array  $row СТРОКА ЗАПРОСА sqlite
 * @param object $bfoto ЗАПРОС
 * @param int    $insert_id id записи
 */
function bfoto($row, $bfoto, $insert_id)
{
    static $n = 0;
    //$row['user_id'] = 1; //delete
    $n++;
    $file_name = substr($row['date'], 6, 4).substr($row['date'], 0, 2).substr($row['date'], 3, 2).
        "_res{$row['res_id']}_LS{$row['LS']}_sob{$row['sob_id']}_obj{$row['obg_id']}_user{$row['user_id']}_{$n}.jpg";
    $bfoto->bind_param(
        'iiiis',
        $row['sob_id'],
        $row['user_id'],
        $insert_id,
        $row['obg_id'],
        $file_name
    );
    $bfoto->execute();
    //$fp1 = fopen("aaaaaa", 'w+');
    //fwrite($fp1, __DIR__."/foto_wifi/byt/{$file_name}");
    $fp = fopen(__DIR__."/foto_wifi/byt/{$file_name}", 'w+');
    fwrite($fp, base64_decode($row['foto']));
    fclose($fp);
}

function psob($row, $psob)  // Запись в базу событий пром
{
    $date = substr($row['date'], 6, 4).'-'.substr($row['date'], 0, 2).'-'.substr($row['date'], 3, 2);
    //$row['user_id'] = 1; //delete
    $psob->bind_param(
        'iissssississ',
        $row['sob_id'],
        $row['res_id'],
        $row['LS'],
        $row['potrebitel'],
        $row['adres'],
        $date,
        $row['user_id'],
        $row['adres_ycheta'],
        $row['TopCode'],
        $row['id_ycheta'],
        $row['name_ycheta'],
        $row['okpo']
    );
    $psob->execute();
}

function pfoto($row, $pfoto, $insert_id)  // Запись в базу объектов съемки пром
{
    static $n = 0;
    //$row['user_id'] = 1; //delete
    $n++;
    $file_name = substr($row['date'], 6, 4).substr($row['date'], 0, 2).substr($row['date'], 3, 2).
        "_res{$row['res_id']}_LS{$row['LS']}_sob{$row['sob_id']}_obj{$row['obg_id']}_user{$row['user_id']}_{$n}.jpg";
    $pfoto->bind_param(
        'iiiis',
        $row['sob_id'],
        $row['user_id'],
        $insert_id,
        $row['obg_id'],
        $file_name
    );
    $pfoto->execute();
    $fp = fopen(__DIR__."\\foto_wifi\\prom\\{$file_name}", 'w+');
    fwrite($fp, base64_decode($row['foto']));
    fclose($fp);
}
