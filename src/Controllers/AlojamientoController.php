<?php
// src/Controllers/AlojamientoController.php

namespace App\Controllers;

use App\Models\Alojamiento;

class AlojamientoController
{
    private $alojamientoModel;

    public function __construct()
    {
        $this->alojamientoModel = new Alojamiento();
    }

    // --- Punto 1: Landing Page de Alojamientos ---
    /**
     * Muestra la lista de todos los alojamientos.
     */
    public function index()
    {
        // Obtiene todos los alojamientos de la base de datos
        $alojamientos = $this->alojamientoModel->getAll();

        // Carga la vista
        $title = "Alojamientos Disponibles";
        require_once '../views/landing.php';
    }
    
    // --- Punto 3: Vista de Cuenta de Usuario ---
    /**
     * Muestra la vista de la cuenta del usuario con sus alojamientos seleccionados.
     */
    public function userAccount()
    {
        // Revisa si el usuario está logueado (esto ya se hizo en index.php, pero es buena práctica verificar)
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=auth&action=login');
            exit;
        }

        $usuario_id = $_SESSION['user_id'];
        
        // Obtiene los alojamientos que el usuario ha seleccionado
        $alojamientos = $this->alojamientoModel->getSelectedByUser($usuario_id);

        $title = "Mi Cuenta y Alojamientos Seleccionados";
        require_once '../views/user_account.php';
    }

    /**
     * Agrega un alojamiento a la lista de seleccionados del usuario (Punto 3).
     */
    public function selectAlojamiento($alojamiento_id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=auth&action=login');
            exit;
        }
        
        $usuario_id = $_SESSION['user_id'];
        
        if ($this->alojamientoModel->selectAlojamiento($usuario_id, $alojamiento_id)) {
            $_SESSION['message'] = "Alojamiento añadido a tu cuenta.";
        } else {
            $_SESSION['message'] = "El alojamiento ya estaba en tu lista.";
        }
        
        // Redirigir a la landing page
        header('Location: index.php?page=home');
        exit;
    }
    
    // --- Punto 4: Función de Eliminar Alojamientos (de la lista del usuario) ---
    /**
     * Elimina un alojamiento de la lista de seleccionados del usuario.
     */
    public function deleteSelected($alojamiento_id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=auth&action=login');
            exit;
        }

        $usuario_id = $_SESSION['user_id'];
        
        if ($this->alojamientoModel->deleteSelected($usuario_id, $alojamiento_id)) {
            $_SESSION['message'] = "Alojamiento eliminado de tu lista.";
        } else {
            $_SESSION['message'] = "Error al eliminar el alojamiento.";
        }
        
        // Redirigir a la vista de cuenta
        header('Location: index.php?page=user');
        exit;
    }
}