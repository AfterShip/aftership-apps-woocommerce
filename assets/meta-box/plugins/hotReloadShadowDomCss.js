const sheetsMap = new Map();

export async function updateStyle(id, content, elName) {
  const shadowRoot = document.querySelector(elName).shadowRoot;
  if (!shadowRoot) {
    await new Promise((resolve) => {
      window.addEventListener('load', () => {
        resolve();
      });
    });
  }
  let style = sheetsMap.get(id);
  if (style && !(style instanceof HTMLStyleElement)) {
    removeStyle(id);
    style = undefined;
  }
  if (!style) {
    style = document.createElement('style');
    style.setAttribute('type', 'text/css');
    style.innerHTML = content;
    document.querySelector(elName).shadowRoot.appendChild(style);
    // document.head.appendChild(style);
  } else {
    style.innerHTML = content;
  }
  sheetsMap.set(id, style);
}

export function removeStyle(id, elName) {
  const style = sheetsMap.get(id);
  document.querySelector(elName).shadowRoot.removeChild(style);
  // document.head.removeChild(style);
  sheetsMap.delete(id);
}

export default function myExample(elName) {
  return {
    name: 'inject-css-to-shadowRoot',
    apply: 'serve',
    enforce: 'post',
    async transform(code, id, _options) {
      if (/(\.module)?\.s?css$/.test(id)) {
        if (process.env.MODE === 'production') return code;
        return (
          `const elName = '${elName}';\n` +
          code
            .replace(
              /(?<=import { updateStyle as __vite__updateStyle, removeStyle as __vite__removeStyle } from )"[^"]+@vite\/client"/,
              `"${__filename}"`
            )
            .replace(/__vite__(?:update|remove)Style\([^)]+/, '$&, elName')
        );
      } else {
        return code;
      }
    },
  };
}
