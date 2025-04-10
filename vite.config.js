import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

// Configuración de Vite
export default defineConfig({
  plugins: [react()],  // Plugin para React
  server: {
    port: 5173,  // Puerto en el que corre Vite
    proxy: {
      '/api': {
        target: 'http://localhost:3001',  // Proxy para redirigir las peticiones del cliente al servidor
        changeOrigin: true,
        secure: false
      }
    }
  }
});
