<?php
// App/Models/BaseModel.php
// Este modelo base proporciona la conexión a la BD (PDO) a todos los modelos que lo extienden.

namespace App\Models;

use App\Core\Database; // Asegura que se importe la clase Database

/**
 * Clase base para todos los modelos que necesitan interactuar con la base de datos.
 */
class BaseModel
{
    /**
     * @var \PDO $db_connection Conexión PDO a la base de datos.
     */
    protected $db_connection;

    public function __construct()
    {
        // Obtiene la instancia de conexión PDO desde la clase Database (Patrón Singleton)
        // Esto inicializa la conexión si aún no existe y la devuelve.
        $this->db_connection = Database::getInstance()->getConnection();
    }
    
    // Aquí se podrían añadir métodos CRUD comunes: find($id), findAll(), update($id, $data), delete($id)
    // Pero por ahora solo proveemos la conexión para que los modelos hijos (Usuario, Alojamiento)
    // implementen su lógica específica.
}
