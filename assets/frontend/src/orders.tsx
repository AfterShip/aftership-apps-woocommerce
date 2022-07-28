import { render } from 'solid-js/web';
import './global.scss';
import Orders from './pages/Orders';

customElements.define(
  'aftership-orders-modal',
  class Tracking extends HTMLElement {
    private initialized = false;
    constructor() {
      super();
      this.attachShadow({ mode: 'open' });
    }

    connectedCallback() {
      if (!this.shadowRoot) return;
      if (this.initialized) return;
      this.initialized = true;
      if (import.meta.env.MODE === 'production') {
        const currentScript = document.currentScript as HTMLScriptElement;
        const linkElm = document.createElement('link');
        linkElm.rel = 'stylesheet';
        linkElm.href = currentScript.src.replace(/\/index\.js\?/, '/style.css?');
        this.shadowRoot.appendChild(linkElm);
      }
      render(() => <Orders />, this.shadowRoot);
    }
  }
);
