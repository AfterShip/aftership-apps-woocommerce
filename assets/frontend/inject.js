console.log('inject.js');
const scriptElm = document.createElement('script');
scriptElm.src = 'http://localhost:3000/src/index.tsx';
scriptElm.type = 'module';

document.body.appendChild(scriptElm);
