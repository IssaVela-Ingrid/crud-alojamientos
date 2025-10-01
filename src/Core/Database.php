<?php
// src/Core/Database.php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        // El DSN (Data Source Name) usa los valores del config.php
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Manejo de errores con excepciones
            // LA CLAVE: Usar FETCH_ASSOC para que los resultados sean arrays asociativos (como lo espera la vista)
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Desactiva emulación para más seguridad
        ];

        try {
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // En un entorno real, registra el error y muestra un mensaje genérico.
            // Para desarrollo, mostramos el error:
            die("Error de Conexión a la Base de Datos: " . $e->getMessage());
        }
    }

    // Patrón Singleton: Garantiza que solo haya una instancia de conexión
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Método para obtener la conexión PDO
    public function getConnection()
    {
        return $this->connection;
    }
    
    // Método de ayuda para consultas preparadas
    public function query($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
