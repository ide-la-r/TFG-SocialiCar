import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [react()],
  server: {
    proxy: {
      '/users': 'http://localhost:3001',
      '/cars': 'http://localhost:3001',
      '/blog': 'http://localhost:3001',
      '/premium': 'http://localhost:3001',
      '/rent': 'http://localhost:3001',
    },
  },
});