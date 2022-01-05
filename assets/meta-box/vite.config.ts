import { defineConfig, Plugin } from 'vite';
import path from 'path';
import solidPlugin from 'vite-plugin-solid';
// @ts-ignore
import MyExamplePlugin from './plugins/hotReloadShadowDomCss.js';

export default defineConfig({
  base: '/wp-content/plugins/aftership-woocommerce-tracking/assets/meta-box/',
  plugins: [solidPlugin(), MyExamplePlugin('aftership-meta-box')],
  resolve: {
    alias: {
      '@src': path.resolve(__dirname, './src'),
    },
  },
  build: {
    // target: 'esnext',
    // polyfillDynamicImport: false,
    target: 'es2015',
    outDir: './dist',
    lib: {
      entry: 'src/index.tsx',
      name: 'metabox',
      fileName: (_format) => `index.js`,
      formats: ['iife'],
    },
  },
});
