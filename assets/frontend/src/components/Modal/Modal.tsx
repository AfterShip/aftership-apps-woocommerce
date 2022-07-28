import { createEffect, JSX, Show } from 'solid-js';
import Button from '../Button';
import styles from './Modal.module.scss';
import iconX from './x.svg';

interface ModalProps {
  visible: boolean;
  onOk?(): void;
  okText?: string;
  onCancel?(): void;
  children: JSX.Element;
  title?: string;
  disabled?: boolean;
}

export default function Modal(props: ModalProps) {
  createEffect(() => {
    if (props.visible) {
      document.body.style.overflowY = 'hidden';
    } else {
      document.body.style.overflowY = 'auto';
    }
  });
  return (
    <Show when={props.visible}>
      <div className={styles.container}>
        <div className={styles.backdrop} onClick={props.onCancel} />
        <section className={styles.modal}>
          <header className={styles.header}>
            <h1>{props.title}</h1>
            <div role="button" onClick={props.onCancel}>
              <img src={iconX} />
            </div>
          </header>
          <article>{props.children}</article>
          <footer>
            <Button
              disabled={props.disabled}
              onClick={() => props.onOk && props.onOk()}
              type="primary">
              {props.okText || 'Ok'}
            </Button>
          </footer>
        </section>
      </div>
    </Show>
  );
}
