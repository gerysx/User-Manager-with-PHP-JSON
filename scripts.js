const API_URL = "api.php";

/**
 * Obtiene la lista de usuarios desde la API y la muestra en el DOM.
 * @async
 * @function obtenerUsuarios
 * @returns {Promise<void>}
 */
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

/**
 * Agrega un nuevo usuario o actualiza uno existente.
 * Envía los datos al backend usando los métodos POST o PUT según corresponda.
 * @async
 * @function agregarUsuario
 * @param {Event} event - Evento de envío del formulario.
 * @returns {Promise<void>}
 */
async function agregarUsuario(event) {
  event.preventDefault();
  const id = document.getElementById("userId").value;
  const usuario = {
    name: document.getElementById("name").value,
    email: document.getElementById("email").value,
    username: document.getElementById("username").value,
  };

  if (id) {
    usuario.id = id;
    await fetch(API_URL, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(usuario),
    });
  } else {
    await fetch(API_URL, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(usuario),
    });
  }

  document.getElementById("userForm").reset();
  obtenerUsuarios();
}

/**
 * Elimina un usuario enviando una solicitud DELETE al backend.
 * @async
 * @function eliminarUsuario
 * @param {number} id - ID del usuario a eliminar.
 * @returns {Promise<void>}
 */
async function eliminarUsuario(id) {
  await fetch(API_URL, {
    method: "DELETE",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id }),
  });
  obtenerUsuarios();
}

/**
 * Rellena el formulario con los datos del usuario seleccionado para editar.
 * @function editarUsuario
 * @param {number} id - ID del usuario.
 * @param {string} name - Nombre del usuario.
 * @param {string} email - Correo electrónico del usuario.
 * @param {string} username - Nombre de usuario.
 */
function editarUsuario(id, name, email, username) {
  document.getElementById("userId").value = id;
  document.getElementById("name").value = name;
  document.getElementById("email").value = email;
  document.getElementById("username").value = username;
}

/**
 * Añade el evento de envío al formulario para agregar o actualizar usuarios.
 * @event submit
 * @memberof HTMLFormElement
 */
document
  .getElementById("userForm")
  .addEventListener("submit", agregarUsuario);

/**
 * Llama a la función para obtener usuarios al cargar el script.
 * @function
 */
obtenerUsuarios();
