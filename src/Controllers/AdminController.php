<?php
// src/Controllers/AdminController.php

namespace App\Controllers;

use App\Models\Alojamiento;

class AdminController
{
    private $alojamientoModel;

    public function __construct()
    {
        $this->alojamientoModel = new Alojamiento();
    }

    // --- Punto 5: Interfaz de Administración ---
    /**
     * Muestra la vista principal del administrador.
     */
    public function index()
    {
        // La validación de rol ya se hizo en index.php, solo cargamos la vista.
        $title = "Panel de Administración";
        // Obtener la lista de alojamientos para mostrarlos si es necesario (no requerido, pero útil)
        // $alojamientos = $this->alojamientoModel->getAll(); 
        require_once '../views/admin_panel.php';
    }

    /**
     * Maneja la lógica para crear un nuevo alojamiento.
     */
    public function createAlojamiento()
    {
        $error = null;
        $success = null;

        // La verificación de rol ya está en index.php, pero por seguridad, la revalidamos.
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
             header('Location: index.php');
             exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = trim($_POST['titulo'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $precio = filter_var($_POST['precio'] ?? 0, FILTER_VALIDATE_FLOAT);
            $ciudad = trim($_POST['ciudad'] ?? 'N/A'); // Asume que 'ciudad' viene del formulario
            
            // Usamos el ID del administrador logueado
            $admin_id = $_SESSION['user_id']; 

            if (empty($titulo) || empty($descripcion) || $precio === false || $precio <= 0) {
                $error = "Todos los campos son obligatorios y el precio debe ser un número positivo.";
            } else {
                // Agregar el alojamiento a la BD (Operación CREATE)
                // Se llama al modelo con los 4 parámetros esperados: titulo, descripcion, precio, admin_id, ciudad
                if ($this->alojamientoModel->create($titulo, $descripcion, $precio, $admin_id, $ciudad)) {
                    $success = "¡Alojamiento '{$titulo}' agregado con éxito!";
                } else {
                    $error = "Ocurrió un error al guardar el alojamiento.";
                }
            }
        }
        
        // Carga la vista de administración nuevamente con el resultado
        $title = "Panel de Administración - Agregar";
        require_once '../views/admin_panel.php';
    }
}
