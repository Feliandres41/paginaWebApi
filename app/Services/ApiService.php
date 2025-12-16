<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = env('API_BASE_URL', 'http://localhost:8000/api');
        $this->token = session('api_token');
    }

    /**
     * Obtener headers con token de autenticación
     */
    protected function getHeaders()
    {
        $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        ];

        if ($this->token) {
            $headers['Authorization'] = 'Bearer ' . $this->token;
        }

        return $headers;
    }

    /**
     * Registrar un nuevo usuario
     */
    public function register($name, $email, $password)
    {
        try {
            $response = Http::timeout(10)->post("{$this->baseUrl}/register", [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Guardar token y usuario en sesión
                if (isset($data['token'])) {
                    session(['api_token' => $data['token']]);
                    session(['api_user' => $data['user']]);
                    $this->token = $data['token'];
                }
                
                return [
                    'success' => true,
                    'user' => $data['user'] ?? null
                ];
            }

            return [
                'success' => false,
                'errors' => $response->json()['errors'] ?? ['Error al registrar usuario']
            ];

        } catch (\Exception $e) {
            Log::error('Exception API - register: ' . $e->getMessage());
            return [
                'success' => false,
                'errors' => ['Error de conexión con la API: ' . $e->getMessage()]
            ];
        }
    }

    /**
     * Login de usuario
     */
    public function login($email, $password)
{
    try {
        $response = Http::timeout(10)->post("{$this->baseUrl}/login", [
            'email' => $email,
            'password' => $password,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            
            // IMPORTANTE: Verificar que la API devuelva 'token'
            if (isset($data['token'])) {
                session(['api_token' => $data['token']]);
                session(['api_user' => $data['user']]);
                $this->token = $data['token'];
            }
            
            return [
                'success' => true,
                'user' => $data['user']
            ];
        }

        return [
            'success' => false,
            'message' => $response->json()['message'] ?? 'Credenciales incorrectas'
        ];

    } catch (\Exception $e) {
        Log::error('Exception API - login: ' . $e->getMessage());
        return [
            'success' => false,
            'message' => 'Error de conexión con la API'
        ];
    }
}

    /**
     * Logout de usuario
     */
    public function logout()
    {
        try {
            if ($this->token) {
                Http::withHeaders($this->getHeaders())
                    ->timeout(10)
                    ->post("{$this->baseUrl}/logout");
            }
            
            session()->forget(['api_token', 'api_user']);
            return true;

        } catch (\Exception $e) {
            session()->forget(['api_token', 'api_user']);
            return true;
        }
    }

    /**
     * Verificar si está autenticado
     */
    public function isAuthenticated()
    {
        return !empty($this->token);
    }

    /**
     * Obtener usuario actual de la sesión
     */
    public function getCurrentUser()
    {
        return session('api_user');
    }

    /**
     * Obtener todos los proyectos del usuario
     */
    public function getProjects()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(10)
                ->get("{$this->baseUrl}/projects");
            
            if ($response->successful()) {
                return $response->json();
            }
            
            // Si es 401, la sesión expiró
            if ($response->status() === 401) {
                session()->forget(['api_token', 'api_user']);
            }
            
            Log::error('Error API - getProjects', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return [];
            
        } catch (\Exception $e) {
            Log::error('Exception API - getProjects: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener un proyecto específico con sus tareas
     */
    public function getProject($id)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(10)
                ->get("{$this->baseUrl}/projects/{$id}");
            
            if ($response->successful()) {
                return $response->json();
            }
            
            if ($response->status() === 401) {
                session()->forget(['api_token', 'api_user']);
            }
            
            return null;
            
        } catch (\Exception $e) {
            Log::error('Exception API - getProject: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Crear un nuevo proyecto
     */
    public function createProject($data)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(10)
                ->post("{$this->baseUrl}/projects", $data);
            
            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }
            
            if ($response->status() === 401) {
                session()->forget(['api_token', 'api_user']);
                return [
                    'success' => false,
                    'errors' => ['Tu sesión ha expirado. Por favor inicia sesión nuevamente.']
                ];
            }
            
            return [
                'success' => false,
                'errors' => $response->json()['errors'] ?? ['Error al crear proyecto']
            ];
            
        } catch (\Exception $e) {
            Log::error('Exception API - createProject: ' . $e->getMessage());
            return [
                'success' => false,
                'errors' => ['Error de conexión: ' . $e->getMessage()]
            ];
        }
    }

    /**
     * Actualizar un proyecto
     */
    public function updateProject($id, $data)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(10)
                ->put("{$this->baseUrl}/projects/{$id}", $data);
            
            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }
            
            if ($response->status() === 401) {
                session()->forget(['api_token', 'api_user']);
            }
            
            return [
                'success' => false,
                'errors' => $response->json()['errors'] ?? ['Error al actualizar proyecto']
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'errors' => [$e->getMessage()]
            ];
        }
    }

    /**
     * Eliminar un proyecto
     */
    public function deleteProject($id)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(10)
                ->delete("{$this->baseUrl}/projects/{$id}");
            
            if ($response->status() === 401) {
                session()->forget(['api_token', 'api_user']);
            }
            
            return $response->successful();
            
        } catch (\Exception $e) {
            Log::error('Exception API - deleteProject: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Crear una nueva tarea
     */
    public function createTask($data)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(10)
                ->post("{$this->baseUrl}/tasks", $data);
            
            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }
            
            if ($response->status() === 401) {
                session()->forget(['api_token', 'api_user']);
            }
            
            return [
                'success' => false,
                'errors' => $response->json()['errors'] ?? ['Error al crear tarea']
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'errors' => [$e->getMessage()]
            ];
        }
    }

    /**
     * Completar una tarea
     */
    public function completeTask($id)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(10)
                ->put("{$this->baseUrl}/tasks/{$id}/complete");
            
            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }
            
            if ($response->status() === 401) {
                session()->forget(['api_token', 'api_user']);
            }
            
            return [
                'success' => false,
                'message' => 'Error al completar la tarea'
            ];
            
        } catch (\Exception $e) {
            Log::error('Exception API - completeTask: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Eliminar una tarea
     */
    public function deleteTask($id)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(10)
                ->delete("{$this->baseUrl}/tasks/{$id}");
            
            if ($response->status() === 401) {
                session()->forget(['api_token', 'api_user']);
            }
            
            return $response->successful();
            
        } catch (\Exception $e) {
            Log::error('Exception API - deleteTask: ' . $e->getMessage());
            return false;
        }
    }
}