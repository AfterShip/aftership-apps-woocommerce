import { JSX } from 'solid-js';
import styles from './Spinner.module.scss';

interface Props {
  children: JSX.Element;
  width?: JSX.CSSProperties['width'];
  height?: JSX.CSSProperties['height'];
}

export default function Spinner(props) {
  return (
    <div
      className={styles.spinner}
      style={{
        width: props.width,
        height: props.height,
      }}
    />
  );
}
