<?php

namespace Dipoengoro\GudangBase\Util;

use PDO;

class Connect
{

    static function getConnection(): PDO
    {
        $host = "dipoengoro.mysql.database.azure.com";
        $port = "3306";
        $database = "gudang";
        $username = "dipoengoro@dipoengoro";
        $password = "4wj_qDJ.4k2GZwn";
        $dsn = "mysql:host=$host;port=$port;dbname=$database";
        // $options = openssl_get_cert_locations();

        return new PDO(
            $dsn,
            $username,
            $password,
            // options: $options
        );
    }
}
