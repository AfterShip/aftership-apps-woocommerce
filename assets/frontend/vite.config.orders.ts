import { defineConfig } from 'vite';
import path from 'path';
import solidPlugin from 'vite-plugin-solid';

export default defineConfig({
  base: '/wp-content/plugins/aftership-woocommerce-tracking/assets/frontend/',
  plugins: [solidPlugin()],
  resolve: {
    alias: {
      '@src': path.resolve(__dirname, './src'),
    },
  },
  build: {
    target: 'es2015',
    outDir: './dist/orders',
    lib: {
      entry: 'src/orders.tsx',
      name: 'orders',
      fileName: (_format) => `index.js`,
      formats: ['iife'],
    },
  },
});
