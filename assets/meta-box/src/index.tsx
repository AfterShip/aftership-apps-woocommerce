import { render } from 'solid-js/web';
import App from './App';
import './index.scss';

console.log('src/index.js');
customElements.define(
  'aftership-meta-box',
  class Tracking extends HTMLElement {
    private initialized = false;
    constructor() {
      super();
      this.attachShadow({ mode: 'open' });
    }

    connectedCallback() {
      if (!this.shadowRoot) return;
      if(this.initialized) return;
      this.initialized = true;
      if (import.meta.env.MODE === 'production') {
        const linkElm = document.createElement('link');
        linkElm.rel = 'stylesheet';
        linkElm.href = `${import.meta.env.BASE_URL}dist/style.css`;
        this.shadowRoot.appendChild(linkElm);
      }
      render(() => <App />, this.shadowRoot);
    }
  }
);
