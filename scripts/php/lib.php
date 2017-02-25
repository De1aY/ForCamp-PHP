<?php

/*
Коды:
200 - OK
500 - Ошибка при создании подключения к базе данных
501 - Ошибка при выполнении запроса к базе данных
502 - Ошибка при закрытии соединения с базой данных
503 - Ошибка при смене базы данных
504 - Ошибка загрузки файла на сервер
505 - Ошибка генерации пароля
506 - Ошибка записи в файл
600 - Неверный формат входных данных
601 - Неверный логин/пароль
602 - Неверный токен
603 - Пользователя с таким логином не существует
604 - Ошибка доступа (Недостаточно прав)
605 - Ошибка доступа (Запрашиваемый пользователь состоит в другой организации)
606 - Ошибка доступа (Запрещено изменять баллы своей команде)
*/

define("ENCRYPT_METHOD", "AES-256-CTR");  // Метод шифрования для openssl
define("FUNCTION_ORGANIZATION", "vd4uFQ==");  // Название организации
define("FUNCTION_TEAM", "u6oyE5MjgIA=");  // Название команд/групп/классов и.т.д.
define("FUNCTION_CATEGORY", "ht8iS6sl2curGgxE");  // Название категории
define("FUNCTION_PARTICIPANT", "vKoiApU10depLCURuv+2tg==");  // Названия участников
define("FUNCTION_PERIOD", "vKoyApAlhNY="); // Название отчётного периода
define("SETTING_ABS", "hrouAQ==");  // Могут ли баллы быть отрицательными
define("SETTING_TEAM_LEADER", "u6oyE5MkhM6SIyESgsmutg==");  // Может ли сотрудник выставлять баллы своей команде
define("PATH_FILES", "../media/temp"); // Путь к каталогу для временных файлов

/**
 * @param array $Array
 */
function EchoJSON($Array)
{
    try {
        echo json_encode($Array);
        return TRUE;
    } catch (Exception $e) {
        exit(json_encode(["status" => "ERROR", "code" => 600]));
    }
}

/**
 * @param string $str
 * @return string
 */
function EncodeAES($str)
{
    $SecretKey = "bb62afd41e03935f138221d05aeca1a4847c0c154fad323b3a09c8128054a4d7";
    $Salt = "f59761522aaf0cf9";
    $str = base64_encode($str);
    $EncStr = openssl_encrypt($str, ENCRYPT_METHOD, $SecretKey, OPENSSL_ZERO_PADDING, $Salt);
    return $EncStr;
}

/**
 * @param string $str
 * @return string
 */
function DecodeAES($str)
{
    $SecretKey = "bb62afd41e03935f138221d05aeca1a4847c0c154fad323b3a09c8128054a4d7";
    $Salt = "f59761522aaf0cf9";
    $str = openssl_decrypt($str, ENCRYPT_METHOD, $SecretKey, OPENSSL_ZERO_PADDING, $Salt);
    $str = base64_decode($str);
    return $str;
}
