<?php
// public/index.php

// Inicia la sesión al comienzo de todo
session_start();

// --- CARGA DE AUTOLOAD DE COMPOSER (¡SOLO ESTO!) ---
// ESTA LÍNEA DEBE ESTAR AHÍ PARA QUE EL SISTEMA ENCUENTRE LAS CLASES
require_once '../vendor/autoload.php';
// --------------------------------------------------

// Carga de configuración (Necesaria para DB_HOST, etc.)
require_once '../config.php';

// Importación de Controladores
use App\Controllers\AlojamientoController;
use App\Controllers\AuthController;
use App\Controllers\AdminController;

// Instancias de Controladores
$alojamientoController = new AlojamientoController(); 
$authController = new AuthController();
$adminController = new AdminController();

// --- Lógica de Ruteo simple (Perfectamente funcional) ---
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Manejo de la Petición (Ruteo)
switch ($page) {
    case 'home':
        // Punto 1: Landing Page
        $alojamientoController->index();
        break;
    
    case 'auth':
        // Punto 2: Crear Cuenta e Iniciar Sesión
        if ($action === 'register') {
            $authController->register();
        } elseif ($action === 'login') {
            $authController->login();
        } elseif ($action === 'logout') {
            $authController->logout();
        }
        break;

    case 'user':
        // Punto 3 & 4: Vista de Usuario (Seleccionar y Eliminar)
        // Redirección si el usuario no está logueado o no es 'usuario'
        if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario') {
            if ($action === 'index') {
                $alojamientoController->userAccount();
            } elseif ($action === 'delete_selected') {
                // Validación y saneamiento del ID
                $alojamiento_id = filter_var($_GET['alojamiento_id'] ?? 0, FILTER_VALIDATE_INT);
                if ($alojamiento_id) {
                    // CORRECCIÓN: Se usa $alojamiento_id
                    $alojamientoController->deleteSelected($alojamiento_id);
                } else {
                    // Si el ID es inválido, vuelve a la cuenta
                    header('Location: index.php?page=user');
                    exit;
                }
            } elseif ($action === 'select') {
                // Validación y saneamiento del ID
                $alojamiento_id = filter_var($_GET['alojamiento_id'] ?? 0, FILTER_VALIDATE_INT);
                 if ($alojamiento_id) {
                    // CORRECCIÓN: Se usa $alojamiento_id
                    $alojamientoController->selectAlojamiento($alojamiento_id);
                } else {
                    // Si el ID es inválido, vuelve a la página de inicio
                    header('Location: index.php?page=home');
                    exit;
                }
            }
        } else {
            // Redirige si el usuario no está logueado o no es 'usuario'
            header('Location: index.php?page=auth&action=login');
            exit;
        }
        break;
    
    case 'admin':
        // Punto 5: Usuario Administrador (Solo Agregar)
        if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador') {
            if ($action === 'index') {
                $adminController->index();
            } elseif ($action === 'create') {
                $adminController->createAlojamiento();
            }
        } else {
            // Acceso denegado: redirigir a la landing page
            header('Location: index.php');
            exit;
        }
        break;

    default:
        // Página no encontrada: redirigir a la landing page
        header('Location: index.php?page=home');
        exit;
        break;
}
?>
