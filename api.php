<?php
/**
 * API para gestión básica de usuarios en un archivo JSON.
 * Permite operaciones CRUD (Crear, Leer, Actualizar, Eliminar) vía métodos HTTP.
 * 
 * Métodos soportados:
 * - GET: Obtener todos los usuarios.
 * - POST: Crear nuevo usuario.
 * - PUT: Actualizar usuario existente.
 * - DELETE: Eliminar usuario por ID.
 */

// Configuración de cabeceras para CORS y JSON
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$archivo = "usuarios.json";

// Crear archivo si no existe
if (!file_exists($archivo)) {
    file_put_contents($archivo, json_encode([]));
}

// Leer usuarios del archivo
$usuarios = json_decode(file_get_contents($archivo), true);
if (!is_array($usuarios)) {
    $usuarios = [];
}

$method = $_SERVER["REQUEST_METHOD"];

/**
 * GET: Retorna la lista completa de usuarios.
 */
if ($method === "GET") {
    echo json_encode($usuarios);
    exit;
}

/**
 * POST: Crea un nuevo usuario.
 * Espera: name, email, username en JSON.
 */
if ($method === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);

    // Validación de campos requeridos
    if (!isset($input["name"], $input["email"], $input["username"])) {
        http_response_code(400);
        echo json_encode(["error" => "Faltan campos obligatorios"]);
        exit;
    }

    // Asignar ID único y guardar
    $input["id"] = time(); // ID basado en timestamp
    $usuarios[] = $input;
    file_put_contents($archivo, json_encode($usuarios, JSON_PRETTY_PRINT));
    echo json_encode($input);
    exit;
}

/**
 * PUT: Actualiza un usuario existente.
 * Soporta JSON y x-www-form-urlencoded.
 * Requiere: id, name, email, username
 */
if ($method === "PUT") {
    $input = [];
    $contentType = $_SERVER["CONTENT_TYPE"] ?? "";

    if (strpos($contentType, "application/json") !== false) {
        $input = json_decode(file_get_contents("php://input"), true);
    } elseif (strpos($contentType, "application/x-www-form-urlencoded") !== false) {
        parse_str(file_get_contents("php://input"), $input);
    }

    // Validación
    if (!isset($input["id"], $input["name"], $input["email"], $input["username"])) {
        http_response_code(400);
        echo json_encode(["error" => "Faltan campos obligatorios"]);
        exit;
    }

    // Actualizar usuario
    foreach ($usuarios as &$usuario) {
        if ($usuario["id"] == $input["id"]) {
            $usuario["name"] = $input["name"];
            $usuario["email"] = $input["email"];
            $usuario["username"] = $input["username"];
            break;
        }
    }

    file_put_contents($archivo, json_encode($usuarios, JSON_PRETTY_PRINT));
    echo json_encode(["message" => "Usuario actualizado"]);
    exit;
}

/**
 * DELETE: Elimina un usuario por ID.
 * Soporta JSON y x-www-form-urlencoded.
 * Requiere: id
 */
if ($method === "DELETE") {
    $input = [];
    $contentType = $_SERVER["CONTENT_TYPE"] ?? "";

    if (strpos($contentType, "application/json") !== false) {
        $input = json_decode(file_get_contents("php://input"), true);
    } elseif (strpos($contentType, "application/x-www-form-urlencoded") !== false) {
        parse_str(file_get_contents("php://input"), $input);
    }

    // Validación de ID
    if (!isset($input["id"])) {
        http_response_code(400);
        echo json_encode(["error" => "ID faltante para eliminar"]);
        exit;
    }

    // Filtrar usuario por ID
    $usuarios = array_filter($usuarios, fn($u) => $u["id"] != $input["id"]);
    file_put_contents($archivo, json_encode(array_values($usuarios), JSON_PRETTY_PRINT));
    echo json_encode(["message" => "Usuario eliminado"]);
    exit;
}
?>
