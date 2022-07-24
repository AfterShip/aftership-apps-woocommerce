import { selectedCouriers, trackings, courierMap } from '@src/storages/metaBox';
import { Tracking, AdditionalFields } from '@src/typings/trackings';
import { createEffect, createMemo, createSignal, For, Show, Switch, Match } from 'solid-js';
import { capitalize } from 'lodash-es';

import Modal from '../Modal';
import NumberInput from '../NumberInput';

import styles from './EditTrackingModal.module.scss';
import { calcUnfulfilledItems } from '@src/utils/common';

interface Props {
  visible: boolean;
  value?: Tracking;
  onOk(v: FormValue): void;
  onCancel(): void;
}

export interface FormValue {
  tracking_id: string;
  slug: string;
  tracking_number: string;
  additional_fields: AdditionalFields;
  line_items?: {
    [id: string]: number;
  };
}

const defaultValue = {
  tracking_id: '',
  tracking_number: '',
  slug: '',
  additional_fields: {
    account_number: '',
    key: '',
    postal_code: '',
    ship_date: '',
    destination_country: '',
    state: '',
  },
  line_items: {},
};

export default function EditTrackingModal(props: Props) {
  const [_val, _setVal] = createSignal<FormValue>(defaultValue);

  const slugName = createMemo(() => _val().slug || '');

  const additionalFields = createMemo(() => {
    const r = courierMap().get(slugName())?.required_fields || [];
    return r.map((item) => ({
      key: item.replace(/^tracking_/, '') as keyof AdditionalFields,
      name: item
        .replace(/^tracking_/, '')
        .split('_')
        .map(capitalize)
        .join(' '),
    }));
  });
  const otherTrackings = createMemo(() => {
    if (props.value) {
      return trackings().filter((t) => t.tracking_id !== props.value?.tracking_id);
    } else {
      return trackings();
    }
  });
  const hasMoreThanOneTracking = createMemo(() => otherTrackings().length);
  const remainLineItems = createMemo(() => calcUnfulfilledItems(otherTrackings()));

  // handle props.value change
  createEffect(() => {
    const today = new Date().toISOString().split('T')[0];
    const lineItems = props.value?.line_items || [];
    if (props.value) {
      // Caveat old tracking don't have line_items property
      // for old tracking,
      // if there's only one tracking, default items qty value should be remain items
      // if there's more than one tracking, default items qty value should be 0
      if (props.value.line_items) {
        _setVal({
          tracking_id: props.value.tracking_id,
          slug: props.value.slug,
          tracking_number: props.value.tracking_number,
          additional_fields: {
            ...props.value.additional_fields,
            ship_date: props.value.additional_fields.ship_date || today,
          },
          line_items: Object.fromEntries(
            lineItems.map((item) => [Number(item.id), Number(item.quantity)])
          ),
        });
      } else {
        if (hasMoreThanOneTracking()) {
          _setVal({
            tracking_id: props.value.tracking_id,
            slug: props.value.slug,
            tracking_number: props.value.tracking_number,
            additional_fields: {
              ...props.value.additional_fields,
              ship_date: props.value.additional_fields.ship_date || today,
            },
            line_items: Object.fromEntries(remainLineItems().map((item) => [Number(item.id), 0])),
          });
        } else {
          _setVal({
            tracking_id: props.value.tracking_id,
            slug: props.value.slug,
            tracking_number: props.value.tracking_number,
            additional_fields: {
              ...props.value.additional_fields,
              ship_date: props.value.additional_fields.ship_date || today,
            },
            line_items: Object.fromEntries(
              remainLineItems().map((item) => [Number(item.id), Number(item.quantity)])
            ),
          });
        }
      }
    } else {
      _setVal({
        ...defaultValue,
        slug: selectedCouriers()?.[0]?.slug || '',
        additional_fields: {
          ...defaultValue.additional_fields,
          ship_date: today,
        },
        line_items: Object.fromEntries(
          remainLineItems().map((item) => [Number(item.id), Number(item.quantity)])
        ),
      });
    }
  });

  const resetAdditionalFields = () => {
    _setVal((prev) => {
      const today = new Date().toISOString().split('T')[0];
      return {
        ...prev,
        additional_fields: {
          ...defaultValue.additional_fields,
          ship_date: today,
        },
      };
    });
  };

  const validator = createMemo(() => {
    let isValid = true;
    const errors: any = {};
    const hasLineItem = Object.entries(_val().line_items || []).some(([, v]) => !!v);
    if (!hasLineItem) {
      isValid = false;
    }
    if (_val().slug === '') {
      isValid = false;
      errors.slug = 'Required';
    }
    if (_val().tracking_number === '') {
      isValid = false;
    }
    if (
      otherTrackings().some(
        (t) => t.slug === _val().slug && t.tracking_number === _val().tracking_number
      )
    ) {
      isValid = false;
      errors.tracking_number = 'This shipment has already been added.';
    }

    additionalFields().forEach((item) => {
      if (_val().additional_fields[item.key] === '') {
        isValid = false;
        errors.additional_fields = {
          ...errors.additional_fields,
          [item.key]: 'Required',
        };
      }
    });
    return { isValid, errors };
  });

  const handleLineItemChange = (id: number, value: number) => {
    _setVal((prev) => ({
      ...prev,
      line_items: {
        ...prev.line_items,
        [id]: value,
      },
    }));
  };
  const handleChange = (key: string, value: string) => {
    _setVal((prev) => ({
      ...prev,
      [key]: value.trim(),
    }));
  };
  const handleAdditionalFieldChange = (key: string, value: string) => {
    _setVal((prev) => ({
      ...prev,
      additional_fields: {
        ...prev.additional_fields,
        [key]: value.trim(),
      },
    }));
  };

  const handleOk = () => props.onOk(_val());
  return (
    <Modal
      title={props.value?.tracking_id ? 'Edit tracking' : 'Add tracking'}
      visible={props.visible}
      okText={props.value?.tracking_id ? 'Save' : 'Add'}
      onOk={handleOk}
      onCancel={props.onCancel}
      disabled={!validator().isValid}>
      <div className={styles.modal}>
        <Switch fallback={<div className={styles.empty}>All items have been fulfilled</div>}>
          <Match when={remainLineItems().length > 0}>
            <table className={styles.items}>
              <thead>
                <tr>
                  <th>Items</th>
                  <th>Qty.</th>
                </tr>
              </thead>
              <tbody>
                <For each={remainLineItems()}>
                  {(item) => (
                    <tr>
                      <td>{item.name}</td>
                      <td>
                        <NumberInput
                          min={0}
                          max={item.quantity}
                          step={1}
                          value={_val().line_items?.[item.id] || 0}
                          onChange={(val) => handleLineItemChange(item.id, val || 0)}
                        />
                      </td>
                    </tr>
                  )}
                </For>
              </tbody>
            </table>
          </Match>
        </Switch>
        <hr style={{ margin: '20px 0' }} />
        <div className={styles.input}>
          <div>
            <label>
              Courier:
              <select
                value={_val()?.slug}
                onChange={(e) => {
                  resetAdditionalFields();
                  handleChange('slug', e.currentTarget.value);
                }}>
                <For each={selectedCouriers()}>
                  {(item) => <option value={item.slug}>{item.name || item.other_name}</option>}
                </For>
              </select>
            </label>
            <a href="admin.php?page=aftership-setting-admin">Update carrier list</a>
          </div>
          <div>
            <label>
              Tracking number:
              <input
                value={_val().tracking_number}
                onInput={(e) => handleChange('tracking_number', e.currentTarget.value)}
              />
            </label>

            <Show when={validator().errors.tracking_number}>
              <div style="color: red;">{validator().errors.tracking_number}</div>
            </Show>
          </div>
          <For each={additionalFields()}>
            {(item) => (
              <div>
                <label>
                  {item.name}:
                  <input
                    type={item.key === 'ship_date' ? 'date' : 'text'}
                    value={_val().additional_fields[item.key]}
                    onInput={(e) => handleAdditionalFieldChange(item.key, e.currentTarget.value)}
                  />
                </label>
              </div>
            )}
          </For>
        </div>
      </div>
    </Modal>
  );
}
