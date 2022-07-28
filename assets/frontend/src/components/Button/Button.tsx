import { Component, JSX } from 'solid-js';
import styles from './Button.module.scss';

interface Props {
  type?: 'primary';
  style?: JSX.CSSProperties;
  onClick?(e: MouseEvent): void;
  disabled?: boolean;
}

const Button: Component<Props> = (props) => {
  return (
    <button
      classList={{ [styles.button]: true, [styles.primary]: props.type === 'primary' }}
      disabled={props.disabled}
      style={props.style}
      onClick={props.onClick}>
      {props.children}
    </button>
  );
};

export default Button;
