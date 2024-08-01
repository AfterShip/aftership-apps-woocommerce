import { defineConfig } from 'vite';
import path from 'path';
import solidPlugin from 'vite-plugin-solid';
// @ts-ignore
import MyExamplePlugin from './plugins/hotReloadShadowDomCss.js';

export default defineConfig({
  base: '/wp-content/plugins/aftership-woocommerce-tracking/assets/frontend/',
  plugins: [solidPlugin(), MyExamplePlugin('aftership-meta-box')],
  resolve: {
    alias: {
      '@src': path.resolve(__dirname, './src'),
    },
  },
  build: {
    target: 'es2015',
    outDir: './dist/metabox',
    lib: {
      entry: 'src/metabox.tsx',
      name: 'metabox',
      fileName: (_format) => `index.js`,
      formats: ['iife'],
    },
  },
});
