# Usar una imagen oficial de Node.js
FROM node:16

# Establecer directorio de trabajo
WORKDIR /app

# Copiar archivos del frontend al contenedor
COPY . /app

# Instalar dependencias
RUN npm install

# Exponer el puerto 8080 para el frontend
EXPOSE 8080

# Comando para ejecutar el servidor de Vue.js
CMD ["npm", "run", "serve"]
