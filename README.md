# Gestión de Usuarios con PHP y JSON

Este proyecto implementa un sistema de gestión de usuarios utilizando PHP y un archivo JSON para almacenar los datos. La API permite realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) sobre los usuarios, y está diseñada para interactuar con un frontend sencillo basado en HTML, CSS y JavaScript.

## Descripción

La API permite realizar las siguientes operaciones sobre los usuarios:

- **GET**: Obtener la lista completa de usuarios.
- **POST**: Crear un nuevo usuario.
- **PUT**: Actualizar los datos de un usuario existente.
- **DELETE**: Eliminar un usuario por su ID.

El backend se basa en PHP y utiliza un archivo `usuarios.json` como base de datos para almacenar los usuarios de manera persistente.

## Estructura del Proyecto

El proyecto se compone de tres partes principales:

### 1. Backend (PHP)
El archivo PHP `api.php` proporciona las funcionalidades CRUD utilizando un archivo JSON para almacenar los datos de los usuarios. A continuación, se detallan las operaciones soportadas por la API.

#### Métodos de la API

- **GET**: Obtiene todos los usuarios almacenados en el archivo JSON.
    ```php
    if ($method === "GET") {
        echo json_encode($usuarios);
        exit;
    }
    ```

- **POST**: Crea un nuevo usuario. Los datos del nuevo usuario deben ser enviados en formato JSON con los campos `name`, `email` y `username`. El ID se genera automáticamente utilizando un `timestamp`.
    ```php
    if ($method === "POST") {
        // Validación y creación del usuario
    }
    ```

- **PUT**: Actualiza un usuario existente. Requiere enviar el `id`, `name`, `email` y `username` para la actualización.
    ```php
    if ($method === "PUT") {
        // Validación y actualización del usuario
    }
    ```

- **DELETE**: Elimina un usuario por su `id`. La eliminación se realiza filtrando la lista de usuarios.
    ```php
    if ($method === "DELETE") {
        // Eliminar usuario
    }
    ```

### 2. Frontend (HTML, CSS y JavaScript)

El archivo `index.html` contiene el formulario para agregar y editar usuarios, y una lista que muestra todos los usuarios actuales. Utiliza JavaScript para interactuar con la API.

- **Formulario**: Los usuarios pueden ser creados o editados mediante un formulario con campos para el `name`, `email` y `username`.
  
- **Lista de Usuarios**: Muestra todos los usuarios en una lista y permite realizar acciones como editar o eliminar un usuario.

#### Código JavaScript

- **obtenerUsuarios()**: Obtiene la lista de usuarios desde la API y la muestra en el DOM.
    ```js
    async function obtenerUsuarios() {
      const res = await fetch(API_URL);
      const usuarios = await res.json();
      document.getElementById("userList").innerHTML = usuarios
        .map(
          (user) => `
          <li>
            <div class="user-info">
              <strong>${user.name}</strong> (${user.email})
            </div>
            <div class="actions">
              <button class="edit" onclick="editarUsuario(${user.id}, '${user.name}', '${user.email}', '${user.username}')">✏️</button>
              <button class="delete" onclick="eliminarUsuario(${user.id})">🗑️</button>
            </div>
          </li>
        `
        )
        .join("");
    }
    ```

- **agregarUsuario(event)**: Agrega o actualiza un usuario. Dependiendo de si el formulario tiene un `id`, se envía un `POST` o un `PUT` a la API.
  
- **eliminarUsuario(id)**: Elimina un usuario de la lista enviando una solicitud `DELETE` al backend.

- **editarUsuario(id, name, email, username)**: Rellena el formulario con los datos de un usuario para su edición.

### 3. Archivos adicionales

- **style.css**: Contiene los estilos básicos para el formulario y la lista de usuarios. Puedes personalizarlo según tus preferencias.
  
- **scripts.js**: Archivo donde se encuentran las funciones JavaScript que manejan la interacción con la API y el DOM.

## Requisitos

- **PHP**: Necesitarás tener PHP instalado en tu máquina para ejecutar el servidor.
- **Navegador Web**: Un navegador moderno para acceder al frontend.

## Instalación

1. Clona este repositorio:
    ```bash
    git clone https://github.com/gerysx/User-Manager-with-PHP-JSON.git
    ```

2. Abre la carpeta del proyecto:
    ```bash
    cd User-Manager-with-PHP-JSON
    ```

3. Inicia el servidor PHP:
    ```bash
    php -S localhost:8000
    ```

4. Accede a `http://localhost:8000` en tu navegador para ver la aplicación.


