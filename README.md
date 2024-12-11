# Practica2_ApiRest

Este proyecto consiste en una API REST desarrollada en PHP con Laravel. La API permite realizar operaciones sobre archivos de diferentes tipos (JSON, CSV) y se incluyen rutas para crear, leer, actualizar y eliminar estos archivos, así como listar su contenido.

## Características

- **CRUD para archivos JSON**: Crear, leer, actualizar y eliminar archivos JSON.
- **CRUD para archivos CSV**: Crear, leer, actualizar y eliminar archivos CSV.
- **Manejo de almacenamiento local**: La aplicación usa el almacenamiento local para guardar y manipular archivos.
- **Pruebas automatizadas**: El proyecto incluye pruebas para verificar el correcto funcionamiento de la API.

## Instalación

Para comenzar a trabajar con este proyecto, sigue los siguientes pasos:

1. Clona el repositorio en tu máquina local:

    
    git clone https://github.com/LauraEirasDeOlaso/Practica2_ApiRest.git
    

2. Navega al directorio del proyecto:


    cd Practica2_ApiRest


3. En la raiz del proyecto ejecuta este comando para iniciar el backend

    docker-compose up -d --build


4. Comprueba que el contenedor este en ejecución:

    docker ps

   

5. Abre el navegador para confirmar su funcionamiento:

   http://localhost:8000/api/hello


6. cd ../frontend

7. Ejecuta las migraciones (si es necesario para tu base de datos):

    ```bash
    php artisan migrate
    ```

## Uso

### Rutas de la API

La API ofrece varias rutas para gestionar los archivos:

#### 1. Rutas para archivos JSON:

- `GET /api/json`: Lista todos los archivos JSON disponibles.
- `POST /api/json`: Crea un nuevo archivo JSON.
- `GET /api/json/{filename}`: Muestra el contenido de un archivo JSON.
- `PUT /api/json/{filename}`: Actualiza un archivo JSON existente.
- `DELETE /api/json/{filename}`: Elimina un archivo JSON.

#### 2. Rutas para archivos CSV:

- `GET /api/csv`: Lista todos los archivos CSV disponibles.
- `POST /api/csv`: Crea un nuevo archivo CSV.
- `GET /api/csv/{filename}`: Muestra el contenido de un archivo CSV.
- `PUT /api/csv/{filename}`: Actualiza un archivo CSV existente.
- `DELETE /api/csv/{filename}`: Elimina un archivo CSV.




## Pruebas

El proyecto incluye pruebas automatizadas para garantizar que la API funcione correctamente. Para ejecutar las pruebas, sigue estos pasos:

1. Asegúrate de tener las dependencias de PHPUnit instaladas.

2. Ejecuta las pruebas con el siguiente comando:

    php artisan test
    

