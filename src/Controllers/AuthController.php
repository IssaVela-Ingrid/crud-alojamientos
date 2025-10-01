<?php
// src/Controllers/AuthController.php

namespace App\Controllers;

use App\Models\Usuario;

class AuthController
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new Usuario();
    }

    /**
     * Muestra el formulario de registro y maneja el envío. (Punto 2)
     */
    public function register()
    {
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['contrasena'] ?? '';
            
            // CORRECCIÓN: Se ajusta para usar 'contrasena_confirm', que es el campo correcto de la vista.
            $password_confirm = $_POST['contrasena_confirm'] ?? ''; 

            if (empty($nombre) || empty($email) || empty($password) || empty($password_confirm)) {
                $error = "Todos los campos son obligatorios.";
            } elseif ($password !== $password_confirm) {
                $error = "Las contraseñas no coinciden.";
            } elseif ($this->usuarioModel->findByEmail($email)) {
                $error = "Este email ya está registrado.";
            } else {
                // Registro exitoso. El modelo Usuario.php se encarga de hashear y asignar el rol por defecto.
                $this->usuarioModel->create($nombre, $email, $password);
                $success = "¡Cuenta creada con éxito! Por favor, inicia sesión.";
                // Opcional: Redirigir al login
                // header('Location: index.php?page=auth&action=login'); exit;
            }
        }
        
        // Carga la vista de registro
        $title = "Crear Cuenta";
        require_once '../views/register.php';
    }

    /**
     * Muestra el formulario de inicio de sesión y maneja el envío. (Punto 2)
     */
    public function login()
    {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['contrasena'] ?? '';

            // findByEmail ahora devuelve un array asociativo con 'id', 'nombre', 'contrasena', 'rol'
            $usuario = $this->usuarioModel->findByEmail($email);

            if ($usuario && password_verify($password, $usuario['contrasena'])) {
                
                // Inicio de sesión exitoso. Configurar sesión.
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['rol'] = $usuario['rol'];
                
                // Redirigir al panel de administrador si tiene el rol (Punto 5)
                if ($usuario['rol'] === 'administrador') {
                    header('Location: index.php?page=admin');
                } else {
                    // Redirigir a la vista de cuenta de usuario (Punto 3)
                    header('Location: index.php?page=user');
                }
                exit;

            } else {
                $error = "Credenciales incorrectas.";
            }
        }
        
        // Carga la vista de login
        $title = "Iniciar Sesión";
        require_once '../views/login.php';
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout()
    {
        session_destroy();
        // Redirigir a la página de inicio
        header('Location: index.php?page=home');
        exit;
    }
}
