<?php
// App/Models/Usuario.php

namespace App\Models;

// NOTA: Se ha eliminado la dependencia directa a App\\Core\\Database,
// ya que la conexión se maneja en el BaseModel.
use App\Models\BaseModel; // Importa BaseModel

class Usuario extends BaseModel // Ahora hereda de BaseModel
{
    protected $table = 'usuarios';

    public function __construct()
    {
        // Llama al constructor del BaseModel para inicializar $this->db_connection
        parent::__construct();
    }

    /**
     * Busca un usuario por email.
     * @param string $email
     * @return array|bool Retorna un array asociativo con el usuario o false.
     */
    public function findByEmail(string $email)
    {
        $stmt = $this->db_connection->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        // CORRECCIÓN: Usamos FETCH_ASSOC para que AuthController pueda acceder a las claves ['id'] y ['rol'].
        return $stmt->fetch(\PDO::FETCH_ASSOC); 
    }

    /**
     * Registra un nuevo usuario (Punto 2).
     * Retorna el ID insertado.
     * @param string $nombre
     * @param string $email
     * @param string $password
     * @return int|bool
     */
    public function create(string $nombre, string $email, string $password)
    {
        // ¡Importante! Hashear la contraseña
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        // CORRECCIÓN: Añadimos la columna 'rol' con valor por defecto 'usuario'
        $rol_defecto = 'usuario';

        $stmt = $this->db_connection->prepare(
            "INSERT INTO {$this->table} (nombre, email, contrasena, rol) VALUES (?, ?, ?, ?)"
        );
        // Agregamos el rol por defecto a la ejecución
        $stmt->execute([$nombre, $email, $hashed_password, $rol_defecto]); 
        return $this->db_connection->lastInsertId();
    }
}
