// frontend/src/axios.js
import axios from 'axios';

const instance = axios.create({
  baseURL: 'http://localhost:8000/api', // URL del backend Laravel
  headers: {
    'Content-Type': 'application/json',
  },
});

export default instance;