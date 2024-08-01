import { mergeProps, Show } from 'solid-js';
import styles from './NumberInput.module.scss';
import iconUp from './images/caret-up-fill.svg';
import iconDown from './images/caret-down-fill.svg';

export interface Props {
  defaultValue?: number;
  min?: number;
  max?: number;
  step?: number;
  value?: number;
  onChange(val: number | undefined): void;
}

export default function NumberInput(props: Props) {
  let inputRef: HTMLInputElement;
  const merged = mergeProps({ step: 1 }, props);

  function isSmallerThanMin(value: string) {
    return merged.min !== undefined && Number(value) < merged.min;
  }
  function isBiggerThanMax(value: string) {
    return merged.max !== undefined && Number(value) > merged.max;
  }

  function handleInput(value: string) {
    if (!value) return;
    if (isSmallerThanMin(value) || isBiggerThanMax(value)) return;
    merged.onChange(Number(value));
  }
  function handleBlur(value: string) {
    if (value) {
      if (isSmallerThanMin(value)) {
        merged.onChange(merged.min);
        inputRef.value = String(merged.min);
        return;
      } else if (isBiggerThanMax(value)) {
        merged.onChange(merged.max);
        inputRef.value = String(merged.max);
        return;
      } else {
        merged.onChange(Number(value));
      }
    } else {
      inputRef.value = '';
      merged.onChange(undefined);
    }
  }
  function handleArrowClick(sign: 1 | -1) {
    const value = merged.value;
    let nextValue;
    if (value === undefined) {
      nextValue = sign > 0 ? merged.min : merged.max;
      merged.onChange(nextValue || 0);
    } else {
      nextValue = value + sign * merged.step;
      const str = String(nextValue);
      if (isSmallerThanMin(str) || isBiggerThanMax(str)) return;
    }
    merged.onChange(nextValue);
  }

  return (
    <div className={styles.root}>
      <div>
        <input
          ref={(el) => (inputRef = el)}
          type="number"
          inputMode="numeric"
          min={merged.min}
          max={merged.max}
          value={merged.value}
          onInput={(e) => handleInput(e.currentTarget.value)}
          onBlur={(e) => handleBlur(e.currentTarget.value)}
        />
      </div>
      <Show when={merged.max !== undefined}>
        <div className={styles.suffix} onClick={() => inputRef.focus()}>
          of {merged.max}
        </div>
      </Show>
      <div class={styles.action} aria-hidden>
        <div onClick={() => handleArrowClick(1)} role="button" tabIndex={-1}>
          <img src={iconUp} />
        </div>
        <div onClick={() => handleArrowClick(-1)} role="button" tabIndex={-1}>
          <img src={iconDown} />
        </div>
      </div>
    </div>
  );
}
