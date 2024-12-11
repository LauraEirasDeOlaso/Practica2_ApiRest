<template>
  <div id="app">
    <h1>PR UD 2</h1>

    <!-- Menú de navegación -->
    <ul class="nav-menu">
      <li @click="updateSelectedCategory('Class Storage')">Class Storage</li>
      <li @click="updateSelectedCategory('JSON')">JSON</li>
      <li @click="updateSelectedCategory('CSV')">CSV</li>
      <!-- Agregar opción XML al menú -->
      <li @click="updateSelectedCategory('XML')">XML</li>
    </ul>

    <!-- Mostrar el componente de gestión de archivos según la categoría seleccionada -->
    <div v-if="selectedCategory" class="file-management">
      <h2>{{ selectedCategory }} File Management</h2>

      <!-- Menú desplegable para seleccionar una acción -->
      <div class="action-container">
        <label for="action">Seleccione Acción:</label>
        <select id="action" v-model="selectedAction">
          <option value="fetchAll">Mostrar Archivos</option>
          <option value="fetchById">Buscar por ID</option>
          <option value="create">Crear</option>
          <option value="update">Actualizar</option>
          <option value="delete">Eliminar</option>
        </select>
      </div>

      <!-- Botón de acción -->
      <div v-if="selectedAction" class="action-button">
        <button @click="performAction">Ejecutar Acción</button>
      </div>

      <!-- Mostrar respuesta de la API -->
      <div v-if="response" class="response-container">
        <h3>Respuesta:</h3>
        <div v-if="response.contenido">
          <ul>
            <li v-for="(filename, id) in response.contenido" :key="id">{{ filename }}</li>
          </ul>
        </div>
        <pre v-else>{{ response }}</pre>
      </div>
    </div>
  </div>
</template>

<script>
import axios from './axios'; // Asegúrate de que axios esté configurado correctamente en un archivo separado como axios.js

export default {
  data() {
    return {
      categories: ["Class Storage", "JSON", "CSV", "XML"], // Agregar "XML" al array de categorías
      selectedCategory: null,
      selectedAction: '', // Acción seleccionada por el usuario
      response: null, // Respuesta que obtendremos de la API
      apiRoute: ''
    };
  },
  methods: {
    updateSelectedCategory(category) {
      this.selectedCategory = category;
      this.apiRoute = this.getApiRoute(category); // Asignar la ruta correspondiente
    },
    getApiRoute(category) {
      switch (category) {
        case "Class Storage":
          return "/hello";  // Ruta para Class Storage
        case "JSON":
          return "/json";   // Ruta para JSON
        case "CSV":
          return "/csv";    // Ruta para CSV
        case "XML":         // Ruta para XML
          return "/xml";    // Asegúrate de que esta ruta sea correcta en tu backend
        default:
          return "";
      }
    },
    async performAction() {
      switch (this.selectedAction) {
        case 'fetchAll':
          await this.fetchAll(); // Mostrar todos los archivos
          break;
        case 'fetchById':
          await this.fetchById(); // Buscar un archivo por ID
          break;
        case 'create':
          await this.create(); // Crear un archivo
          break;
        case 'update':
          await this.update(); // Actualizar un archivo
          break;
        case 'delete':
          await this.deleteItem(); // Eliminar un archivo
          break;
        default:
          this.response = 'Acción no válida.';
      }
    },
    // Obtener todos los archivos
    async fetchAll() {
      try {
        const res = await axios.get(this.apiRoute);
        this.response = res.data;

        // Asegurarse de que 'contenido' está presente en la respuesta
        if (!this.response || !this.response.contenido) {
          this.response = 'No se encontraron archivos en la categoría seleccionada.';
        }
      } catch (error) {
        this.response = error.response ? error.response.data : 'Error al realizar la solicitud.';
      }
    },
    // Buscar un archivo por su ID (nombre)
    async fetchById() {
      const filename = prompt(`Ingrese el nombre del archivo ${this.selectedCategory}:`);
      if (!filename) return;
      try {
        const res = await axios.get(`${this.apiRoute}/${filename}`);
        this.response = res.data;
      } catch (error) {
        this.response = error.response ? error.response.data : 'Error al realizar la solicitud.';
      }
    },
    // Crear un archivo
    async create() {
      const filename = prompt(`Ingrese el nombre del archivo ${this.selectedCategory}:`);
      const content = prompt(`Ingrese el contenido del archivo ${this.selectedCategory}:`);
      if (!filename || !content) return;
      try {
        const res = await axios.post(this.apiRoute, { filename, content });
        this.response = res.data;
      } catch (error) {
        this.response = error.response ? error.response.data : 'Error al realizar la solicitud.';
      }
    },
    // Actualizar un archivo existente
    async update() {
      const filename = prompt(`Ingrese el nombre del archivo ${this.selectedCategory} a actualizar:`);
      const content = prompt(`Ingrese el nuevo contenido del archivo ${this.selectedCategory}:`);
      if (!filename || !content) return;
      try {
        const res = await axios.put(`${this.apiRoute}/${filename}`, { content });
        this.response = res.data;
      } catch (error) {
        this.response = error.response ? error.response.data : 'Error al realizar la solicitud.';
      }
    },
    // Eliminar un archivo
    async deleteItem() {
      const filename = prompt(`Ingrese el nombre del archivo ${this.selectedCategory} a eliminar:`);
      if (!filename) return;
      try {
        const res = await axios.delete(`${this.apiRoute}/${filename}`);
        this.response = res.data;
      } catch (error) {
        this.response = error.response ? error.response.data : 'Error al realizar la solicitud.';
      }
    }
  }
};
</script>

<style scoped>
#app {
  font-family: 'Arial', sans-serif;
  background-color: #f4f7fc;
  color: #333;
  padding: 20px;
  text-align: center;
}

h1 {
  color: #3498db;
  font-size: 2em;
  margin-bottom: 30px;
}

.nav-menu {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  justify-content: center;
  gap: 20px;
}

.nav-menu li {
  cursor: pointer;
  padding: 10px 20px;
  background-color: #2980b9;
  color: white;
  border-radius: 5px;
  transition: background-color 0.3s;
}

.nav-menu li:hover {
  background-color: #1c5987;
}

.file-management {
  margin-top: 20px;
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.action-container {
  margin-bottom: 15px;
}

select {
  padding: 10px;
  font-size: 16px;
  border-radius: 5px;
  border: 1px solid #ccc;
  width: 200px;
}

button {
  padding: 12px 24px;
  background-color: #3498db;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
  margin-top: 10px;
}

button:hover {
  background-color: #2980b9;
}

.response-container {
  margin-top: 20px;
  background-color: #fafafa;
  padding: 15px;
  border-radius: 5px;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
  font-size: 14px;
  white-space: pre-wrap;
}

ul {
  list-style: none;
  padding: 0;
}

li {
  padding: 5px;
  background-color: #f1f1f1;
  margin-bottom: 5px;
  border-radius: 5px;
}

pre {
  font-size: 14px;
  background-color: #eeeeee;
  padding: 10px;
  border-radius: 5px;
}
</style>
