<?php
// App/Models/Alojamiento.php

namespace App\Models;

use App\Models\BaseModel; // Importa BaseModel

class Alojamiento extends BaseModel // Ahora hereda de BaseModel
{
    protected $table = 'alojamientos';

    public function __construct()
    {
        // Llama al constructor del BaseModel para inicializar $this->db_connection
        parent::__construct();
    }

    /**
     * Obtiene todos los alojamientos.
     * @return array
     */
    public function getAll()
    {
        // En un entorno real, solo se obtienen los datos de los alojamientos,
        // no de los usuarios seleccionados, para la landing page.
        $stmt = $this->db_connection->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // --- Punto 5: Creación de Alojamiento por Administrador ---
    /**
     * Crea un nuevo alojamiento (Punto 5).
     * * NOTA IMPORTANTE: La columna 'admin_id' se ha renombrado a 'creado_por_admin_id'
     * * @param string $titulo
     * @param string $descripcion
     * @param float $precio
     * @param int $creador_id El ID del administrador que crea el alojamiento.
     * @return int|bool Retorna el ID insertado o false.
     */
    public function create(string $titulo, string $descripcion, float $precio, int $creador_id)
    {
        $stmt = $this->db_connection->prepare(
            "INSERT INTO {$this->table} (titulo, descripcion, precio, creado_por_admin_id) VALUES (?, ?, ?, ?)"
        );
        
        // Uso del nuevo parámetro $creador_id
        if ($stmt->execute([$titulo, $descripcion, $precio, $creador_id])) {
            return $this->db_connection->lastInsertId();
        }
        return false;
    }


    // --- Punto 3: Obtener Alojamientos Seleccionados por Usuario ---
    /**
     * Obtiene los alojamientos seleccionados por un usuario.
     * @param int $usuario_id
     * @return array
     */
    public function getSelectedByUser(int $usuario_id)
    {
        // Realiza un JOIN para obtener los datos completos del alojamiento
        // y un LEFT JOIN con 'alojamiento_usuario' para saber cuáles ha seleccionado.
        $stmt = $this->db_connection->prepare(
            "SELECT a.* FROM alojamientos a
             JOIN alojamientos_usuario au ON a.id = au.alojamiento_id
             WHERE au.usuario_id = ?"
        );
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll();
    }


    /**
     * Selecciona un alojamiento para el usuario (Punto 3).
     * @param int $usuario_id
     * @param int $alojamiento_id
     * @return bool
     */
    public function selectAlojamiento(int $usuario_id, int $alojamiento_id)
    {
        // Primero, verifica si la relación ya existe
        $checkStmt = $this->db_connection->prepare(
            "SELECT COUNT(*) FROM alojamientos_usuario WHERE usuario_id = ? AND alojamiento_id = ?"
        );
        $checkStmt->execute([$usuario_id, $alojamiento_id]);
        
        if ($checkStmt->fetchColumn() > 0) {
            // Ya está seleccionado, no se inserta
            return false;
        }

        // Inserta la relación
        $insertStmt = $this->db_connection->prepare(
            "INSERT INTO alojamientos_usuario (usuario_id, alojamiento_id) VALUES (?, ?)"
        );
        return $insertStmt->execute([$usuario_id, $alojamiento_id]);
    }


    /**
     * Elimina un alojamiento de la lista de seleccionados del usuario (Punto 4).
     * @param int $usuario_id
     * @param int $alojamiento_id
     * @return bool
     */
    public function deleteSelected(int $usuario_id, int $alojamiento_id)
    {
        $stmt = $this->db_connection->prepare(
            "DELETE FROM alojamientos_usuario WHERE usuario_id = ? AND alojamiento_id = ?"
        );
        return $stmt->execute([$usuario_id, $alojamiento_id]);
    }
}
