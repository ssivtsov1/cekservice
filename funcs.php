<?php
function debug($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

// Нормализация № телефона
function tel_normal($tel){
    $len = strlen($tel);
    $rez = '';
    $pos = strpos($tel,'(');
    if($pos>0) $len = 0;
    switch ($len){
        case 10:
            $op = substr($tel,0,3);
            $rez.=$op.' ';
            $op = substr($tel,3,3);
            $rez.=$op.'-';
            $add = substr($tel,6,2);
            $rez.=$add.'-';
            $add = substr($tel,8);
            $rez.=$add;
            return $rez;
        case 7:
            $op = substr($tel,0,3);
            $rez.=$op.'-';
            $add = substr($tel,3,2);
            $rez.=$add.'-';
            $add = substr($tel,5);
            $rez.=$add;
            return $rez;
        case 6:
            $op = substr($tel,0,2);
            $rez.=$op.'-';
            $add = substr($tel,2,2);
            $rez.=$add.'-';
            $add = substr($tel,4);
            $rez.=$add;
            return $rez;
        case 5:
            $op = substr($tel,0,1);
            $rez.=$op.'-';
            $add = substr($tel,1,2);
            $rez.=$add.'-';
            $add = substr($tel,3);
            $rez.=$add;
            return $rez;
        default:
            return $tel;
    }


}
// Изменение формата даты
function changeDateFormat($sourceDate, $newFormat) {
    $r = date($newFormat, strtotime($sourceDate));
    return $r;
}    
    
// Преобразование в число прописью
function num2text_ua($num) {
        $num = trim(preg_replace('~s+~s', '', $num)); // отсекаем пробелы
        if (preg_match("/, /", $num)) {
            $num = preg_replace("/, /", ".", $num);
            
        } // преобразует запятую
        
        if (is_numeric($num)) {
            
            //$num = round($num, 2); // Округляем до сотых (копеек)
            
            $num_arr = explode(".", $num);
            $amount = $num_arr[0]; // переназначаем для удобства, $amount - сумма без копеек
            if (strlen($amount) <= 3) {
                $res = implode(" ", Triada($amount)) . Currency($amount);
            } else {
                $amount1 = $amount;
                while (strlen($amount1) >= 3) {
                    $temp_arr[] = substr($amount1, -3); // засовываем в массив по 3
                    $amount1 = substr($amount1, 0, -3); // уменьшаем массив на 3 с конца
                }
                if ($amount1 != '') {
                    $temp_arr[] = $amount1;
                } // добавляем то, что не добавилось по 3
                $i = 0;
                foreach ($temp_arr as $temp_var) { // переводим числа в буквы по 3 в массиве
                    $i++;
                    if ($i == 3 || $i == 4) { // миллионы и миллиарды мужского рода, а больше миллирда вам все равно не заплатят
                        if ($temp_var == '000') {

                            $temp_res[] = '';
                        } else {
                            $temp_res[] = implode(" ", Triada($temp_var, 1)) . GetNum($i, $temp_var);
                        } # if
                    } else {
                        if ($temp_var == '000') {
                            $temp_res[] = '';
                        } else {
                            $temp_res[] = implode(" ", Triada($temp_var)) . GetNum($i, $temp_var);
                        } # if
                    } # else
                } # foreach
                $temp_res = array_reverse($temp_res); // разворачиваем массив
                $res = implode(" ", $temp_res) . Currency($amount);
            }
            if (!isset($num_arr[1]) || $num_arr[1] == '') {
                $num_arr[1] = '00';
            }
            return $res . ', ' . $num_arr[1] . ' коп.';
        } # if
    }

    function Triada($amount, $case = null) {
        global $_1_2, $_1_19, $des, $hang; // объявляем массив переменных
        $count = strlen($amount);
        for ($i = 0; $i < $count; $i++) {
            $triada[] = substr($amount, $i, 1);
        }
        $triada = array_reverse($triada); // разворачиваем массив для операций
        if (isset($triada[1]) && $triada[1] == 1) { // строго для 10-19
            $triada[0] = $triada[1] . $triada[0]; // Объединяем в единицы
            $triada[1] = ''; // убиваем десятки
            $triada[0] = $_1_19[$triada[0]]; // присваиваем
        } else { // а дальше по обычной схеме
            if (isset($case) && ($triada[0] == 1 || $triada[0] == 2)) { // если требуется м.р.
                $triada[0] = $_1_2[$triada[0]]; // единицы, массив мужского рода
            } else {
                if ($triada[0] != 0) {
                    $triada[0] = $_1_19[$triada[0]];
                } else {
                    $triada[0] = '';
                } // единицы
            } # if
            if (isset($triada[1]) && $triada[1] != 0) {
                $triada[1] = $des[$triada[1]];
            } else {
                $triada[1] = '';
            } // десятки
        }
        if (isset($triada[2]) && $triada[2] != 0) {
            $triada[2] = $hang[$triada[2]];
        } else {
            $triada[2] = '';
        } // сотни
        $triada = array_reverse($triada); // разворачиваем массив для вывода
        foreach ($triada as $triada_) { // вычищаем массив от пустых значений
            if ($triada_ != '') {
                $triada1[] = $triada_;
            }
        } # foreach
        return $triada1;
    }

    function Currency($amount) {
        global $namecurr; // объявляем масиив переменных
        $last2 = substr($amount, -2); // последние 2 цифры
        $last1 = substr($amount, -1); // последняя 1 цифра
        $last3 = substr($amount, -3); //последние 3 цифры
        if ((strlen($amount) != 1 && substr($last2, 0, 1) == 1) || $last1 >= 5 || $last3 == '000') {
            $curr = $namecurr[3];
        } // от 10 до 19
        else if ($last1 == 1) {
            $curr = $namecurr[1];
        } // для 1-цы
        else {
            $curr = $namecurr[2];
        } // все остальные 2, 3, 4
        return ' ' . $curr;
    }

    function GetNum($level, $amount) {
        global $nametho, $namemil, $namemrd; // объявляем массив переменных
        if ($level == 1) {
            $num_arr = null;
        } else if ($level == 2) {
            $num_arr = $nametho;
        } else if ($level == 3) {
            $num_arr = $namemil;
        } else if ($level == 4) {
            $num_arr = $namemrd;
        } else {
            $num_arr = null;
        }
        if (isset($num_arr)) {
            $last2 = substr($amount, -2);
            $last1 = substr($amount, -1);
            if ((strlen($amount) != 1 && substr($last2, 0, 1) == 1) || $last1 >= 5) {
                $res_num = $num_arr[3];
            } // 10-19
            else if ($last1 == 1) {
                $res_num = $num_arr[1];
            } // для 1-цы
            else {
                $res_num = $num_arr[2];
            } // все остальные 2, 3, 4
            return ' ' . $res_num;
        } # if
    }

    $_1_2[1] = "один";
    $_1_2[2] = "два";

    $_1_19[1] = "одна";
    $_1_19[2] = "дві";
    $_1_19[3] = "три";
    $_1_19[4] = "чотири";
    $_1_19[5] = "п'ять";
    $_1_19[6] = "шість";
    $_1_19[7] = "сім";
    $_1_19[8] = "вісім";
    $_1_19[9] = "дев'ять";
    $_1_19[10] = "десять";

    $_1_19[11] = "одинадцять";
    $_1_19[12] = "дванадцять";
    $_1_19[13] = "тринадцять";
    $_1_19[14] = "чотирнадцять";
    $_1_19[15] = "п'ятнадцять";
    $_1_19[16] = "шістнадцять";
    $_1_19[17] = "сімнадцять";
    $_1_19[18] = "вісімнадцять";
    $_1_19[19] = "дев'ятнадцять";


    $des[2] = "двадцять";
    $des[3] = "тридцять";
    $des[4] = "сорок";
    $des[5] = "п'ятдесят";
    $des[6] = "шістьдесят";
    $des[7] = "сімдесят";
    $des[8] = "вісімдесят";
    $des[9] = "дев'яносто";

    $hang[1] = "сто";
    $hang[2] = "двісті";
    $hang[3] = "триста";
    $hang[4] = "чотириста";
    $hang[5] = "п'ятсот";
    $hang[6] = "шістьсот";
    $hang[7] = "сімсот";
    $hang[8] = "вісімсот";
    $hang[9] = "дев'ятьсот";

    $namecurr[1] = "гривня"; // 1
    $namecurr[2] = "гривні"; // 2, 3, 4
    $namecurr[3] = "гривень"; // >4

    $nametho[1] = "тисяча"; // 1
    $nametho[2] = "тисячі"; // 2, 3, 4
    $nametho[3] = "тисяч"; // >4

    $namemil[1] = "мільйон"; // 1
    $namemil[2] = "мільйона"; // 2, 3, 4
    $namemil[3] = "мільйонів"; // >4

    $namemrd[1] = "мільярд"; // 1
    $namemrd[2] = "мільярда"; // 2, 3, 4
    $namemrd[3] = "мільярдів"; // >4

    // Преобразование строки - в первый заглавный символ (для русских символов)
    // $code - кодировка (обычно UTF-8)
    function mb_ucfirst($str,$code) {
    $fc = mb_strtoupper(mb_substr($str, 0, 1,$code),$code);
    return $fc.mb_substr($str,1,256,$code);


    }


// Возвращает строку только с цифрами
function only_digit($data){
    $rez='';
    $len = strlen($data);
    for($i=0;$i<$len;$i++){
        $c=substr($data,$i,1);
        if(is_numeric($c)) $rez.=$c;
    }
    return $rez;
}

// Возвращает строку только с цифрами и запятой
function only_digit1($data){
    $rez='';
    $len = strlen($data);
    for($i=0;$i<$len;$i++){
        $c=substr($data,$i,1);
        if(is_numeric($c) || $c==',') $rez.=$c;
    }
    return $rez;
}

// Преобразует номер ID в знак
function f_sign($z) {
    switch ($z){
        case 1:
            $sign = '=';
            break;
        case 2:
            $sign = '>';
            break;
        case 3:
            $sign = '>=';
            break;
        case 4:
            $sign = '<';
            break;
        case 5:
            $sign = '<=';
            break;
        case 6:
            $sign = '<>';
            break;
        default:
            $sign = '=';
    }
    return $sign;
}

// Дописывает 0, если один знак после запятой
// (нужно для отображения копеек)
function zero_e($v){
    $v=trim($v);
    $pos=strpos($v,'.');
    if(!($pos===false)){
        $v1=substr($v,$pos+1);
        if(strlen($v1)==1) $v.='0';
    }
    return $v;
}

// Преобразует строку в маленькие буквы
// с первой заглавной для русских символов
function ucfirst_ru($s){
    $y=mb_strlen($s,'UTF-8');
    $ss=mb_substr($s,1,$y-1,'UTF-8');
    $f=mb_substr($s,0,1,'UTF-8');
    $r=mb_strtoupper($f).mb_strtolower($ss);
    return $r;
}
// Соответствие одних номеров другим
// используется для соответствия номеров по порядку с номерами РЭСов в таблице
function f_accord($n)
{
    switch ($n) {
        case 1:
            return 8;
        case 2:
            return 6;
        case 3:
            return 5;
        case 4:
            return 4;
        case 5:
            return 2;
        case 6:
            return 7;
        case 7:
            return 3;
        case 8:
            return 1;
    }
}
// Перекодирование строки в соответствии с раскладкой клавиатуры
function recode_c($s) {
    $s1='';
    $y=strlen($s);
    for($i=0;$i<$y;$i++){
        $c=substr($s,$i,1);
        switch($c) {
            case 'q':
                $nc = 'й';
                break;
            case 'w':
                $nc = 'ц';
                break;
            case 'e':
                $nc = 'у';
                break;
            case 'r':
                $nc = 'к';
                break;
            case 't':
                $nc = 'е';
                break;

            case 'y':
                $nc = 'н';
                break;
            case 'u':
                $nc = 'г';
                break;
            case 'i':
                $nc = 'ш';
                break;
            case 'o':
                $nc = 'щ';
                break;
            case 'p':
                $nc = 'з';
                break;

            case '[':
                $nc = 'х';
                break;
            case ']':
                $nc = 'ъ';
                break;
            case 'a':
                $nc = 'ф';
                break;
            case 's':
                $nc = 'і';
                break;
            case 's':
                $nc = 'ы';
                break;
            case 'd':
                $nc = 'в';
                break;

            case 'f':
                $nc = 'а';
                break;
            case 'g':
                $nc = 'п';
                break;
            case 'h':
                $nc = 'р';
                break;
            case 'j':
                $nc = 'о';
                break;
            case 'k':
                $nc = 'л';
                break;

            case 'l':
                $nc = 'д';
                break;
            case ';':
                $nc = 'ж';
                break;
            case "'":
                $nc = 'э';
                break;
            case 'z':
                $nc = 'я';
                break;
            case 'x':
                $nc = 'ч';
                break;

            case 'c':
                $nc = 'с';
                break;
            case 'v':
                $nc = 'м';
                break;
            case "b":
                $nc = 'и';
                break;
            case 'n':
                $nc = 'т';
                break;
            case 'm':
                $nc = 'ь';
                break;
            case ',':
                $nc = 'б';

                break;
            case '.':
                $nc = 'ю';
                break;
            case '>':
                $nc = 'ю';
                break;
            case '<':
                $nc = 'б';
                break;
            case ':':
                $nc = 'ж';
                break;
            case '{':
                $nc = 'х';
                break;
        }
        $s1.=$nc;
    }
    return $s1;
}

function converting_string ($str) {
    $s = explode(chr(32), $str);
    $res = '';
    // debug($s);
    // return;
    $y = mb_strlen($str,'UTF-8');
    $n = count($s);
    $j = 0;
    $arr=[];
    $is_r=0;
//    debug($s);
    for($i=0; $i<$n; $i++){
        $w = $s[$i];
        $pos = strpos($w, ':');
        if ($pos) {
            $is_r=1;
        }
        if ($w == 'ВОДИ:') {
            if($i>0){
                $w = $s[$i-1].' '.$w;
            }
            else {
                $w = 'ЖОВТІ ВОДИ:';
            }
        }
        if ($w == 'РІГ:') {
            if($i>0){
                $w = $s[$i-1].' '.$w;
            }
            else {
                $w = 'КРИВИЙ РІГ:';
            }
        }
        if ($w == 'ШЛЯХ:') $w = 'НОВИЙ ШЛЯХ:';
        if ($w == 'ДАЧА:') $w = 'ШИРОКА ДАЧА:';
        if ($w == 'КОЛОНА:') $w = 'ЧЕРВОНА КОЛОНА:';
        if ($w == 'КРЕМЕНЧУК:') $w = 'НОВИЙ КРЕМЕНЧУК:';
        if ($w == 'РАЙОН/М.ДНІПРО:') $w = 'ДНІПРОВСЬКИЙ РАЙОН/М.ДНІПРО:';
        if($pos){
            $arr[$j]=$w;
            $j++;
        }
    }
    $n = count($arr);
    $a = 0;
    $pos2 = 0;
//    debug($arr);
    if($is_r==0) return trim($str);

    for($i=0; $i<$n; $i++){
        $w = $arr[$i];
        if (($n-$i)==1)
            $w1 = $arr[$i];
        else
            $w1 = $arr[$i+1];
        //    debug($w.'<br>');
        $l = mb_strlen($w,'UTF-8');
        //    debug($l.'<br>');
        $pos1 = mb_strpos($str, $w, $a+$pos2,'UTF-8');
//            debug('pos1 = '.$pos1.'<br>');
        $pos2 = mb_strpos($str, $w1, $a+$pos2+$l,'UTF-8');
//            debug('pos2 = '.$pos2.'<br>');
        $flag = 0;
        if ($pos2 === false) {
            $flag = 1;
        }
        if ($flag == 0){
            $r = $pos2 - $pos1;
            if($r==0) $c = mb_substr($str, $a+$pos1,$y-($a+$pos1),'UTF-8').'<br>';
            else
                $c = mb_substr($str, $a+$pos1, $r,'UTF-8').'<br>';
            //    debug('r = '.$r.'<br>');
            //   debug('$a+$pos1 = '.($a+$pos1).'<br>');
            //    debug($c);
            $res = $res. $c."\n";
        } else {
            $c = mb_substr($str, $a+$pos1,$y-($a+$pos1),'UTF-8').'<br>';
            //    debug('$a+$pos1 = '.($a+$pos1).'<br>');
            //    debug($c);
            $res = $res. $c."\n";
        }
    }
    return trim($res);
}

function objectToArray($d){
    if(is_object($d)){ $d = get_object_vars($d); }
    if(is_array($d)){ return array_map(__FUNCTION__ , $d); } else { return $d; }
}

// Функция поиска подстроки в строке первой попавшейся подстроки - определяет ее наличие (регистрозависимая)
// работает на основе алгоритма Рабина - Карпа
// Аргументы : s - исходная строка
// f - подстрока которую нужно найти
// В случае успешного поиска возвращает номер позиции, где начинается подстрока
// иначе возвращается -1
function find_str($s,$f)
{
    $h = hash_f($f); // Определяеь хэш подстроки которую надо найти
    $y = strlen($s);
    $yf = strlen($f);
    for ($i = 0; $i < $y; $i++) {
        if (($i + $yf) <= $y)
            $ss = substr($s, $i, $yf); // Выцепляем подстроку длиной искомой подстроки
        else {
            return -1;
        }
        $hs = hash_f($ss); // Определяем хэш подстроки из строки, где делается поиск
        if ($hs == $h) {
            if ($ss == $f) { // Проверяем совпадение строк в случае если совпадают хеши
                return $i;
            }
        }
    }
}

// Хеш функция для строки
function hash_f($s) {
    $y=strlen($s);
    $p=0;
    $d=256;
    $q=251;
    for($i=0;$i<$y;$i++) {
        $r=ord(substr($s,$i,1));
        $p=($d*$p+$r) % $q;
    }
    return $p;
}

/**
 * Запись в быт
 *
 * @param array  $row СТРОКА ЗАПРОСА sqlite
 * @param object $bsob ЗАПРОС
 */
function bsob($row, $bsob)
{
    $date = substr($row['date'], 6, 4).'-'.substr($row['date'], 0, 2).'-'.substr($row['date'], 3, 2);
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
    $fp = fopen(__DIR__."/photo/{$file_name}", 'w+');
    fwrite($fp, base64_decode($row['foto']));
    fclose($fp);
}

// Форматирование даты в удобном формате (без времени)
// в виде дд.мм.гггг
function format_date2($date)
{
    $dd=substr($date,8,2);
    $mm =substr($date,5,2);
    $yy = substr($date,0,4);
    return $dd . '.' . $mm . '.' .$yy;
}

// Проверка наличия элемента в массиве
function is_doc($mas, $e) {
    $flag = 0;
    if(!isset($mas))  return $flag;
    foreach ($mas as $v){
        if($v['id_doc'] == $e){
            $flag=1;
            break;
        }
    }
    return $flag;
}

    ?>
