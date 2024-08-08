import {selectedCouriers, courierMap, fulfillments} from '@src/storages/tracking';
import {
    AdditionalFields,
    Fulfillment, FulfillmentFactory,
    FulfillmentTrackingFactory,
} from '@src/typings/trackings';
import {createMemo, For, Show, Switch, Match, Accessor, createSignal} from 'solid-js';
import {capitalize} from 'lodash-es';

import Modal from '../Modal';
import NumberInput from '../NumberInput';

import styles from './EditTrackingModal.module.scss';
import { calcUnfulfilledItems } from '@src/utils/common';

interface Props {
  visible: boolean;
  onOk(v: Fulfillment): void;
  onCancel(): void;
  orderId: string;
}

export const [title, setTitle] = createSignal('');
export const [editingFulfillment, setEditingFulfillment] = createSignal<Fulfillment>(FulfillmentFactory.createDefault());
export default function EditTrackingModal(props: Props) {
    const MAX_TRACKING_NUMBER = 20;
    const [trackingIndexCourierMap, setTrackingIndexCourierMap] = createSignal(new Map<number, string>());

    function updateFormValueAtIndex(index: Accessor<number>, field: string, newValue: string) {
        setEditingFulfillment(f => {
            const newFulfillments = {...f};
            switch (field){
                case "tracking_number":
                    newFulfillments.trackings[index()].tracking_number = newValue
                    break;
                case "slug":
                    newFulfillments.trackings[index()].slug = newValue
                    setTrackingIndexCourierMap(prev => {
                        const m = new Map(Object.assign([], prev));
                        m.set(index(), newValue);
                        return m;
                    });
                    break;
            }
            return newFulfillments;
        });
    }

    function updateAdditionalFieldsAtIndex(index: Accessor<number>, field: string, newValue: string) {
        setEditingFulfillment(f => {
            const newFulfillments = {...f};
            switch (field){
                case "account_number":
                    newFulfillments.trackings[index()].additional_fields.account_number = newValue
                    break;
                case "postal_code":
                    newFulfillments.trackings[index()].additional_fields.postal_code = newValue
                    break;
                case "key":
                    newFulfillments.trackings[index()].additional_fields.key = newValue
                    break;
                case "destination_country":
                    newFulfillments.trackings[index()].additional_fields.destination_country = newValue
                    break;
                case "state":
                    newFulfillments.trackings[index()].additional_fields.state = newValue
                    break;
                case "ship_date":
                    newFulfillments.trackings[index()].additional_fields.ship_date = newValue
                    break;
            }
            return newFulfillments;
        });
    }

    function addTracking() {
        setEditingFulfillment(f => {
            const newFulfillments = {...f};
            newFulfillments.trackings.push(FulfillmentTrackingFactory.createDefault());
            return newFulfillments;
        });
    }

    function removeTracking(index: Accessor<number>) {
        const newTrackings = [...editingFulfillment().trackings];
        newTrackings.splice(index(), 1);
        setEditingFulfillment({ ...editingFulfillment(), trackings: newTrackings });
    }

    function additionalFields(slug: string) {
        console.log(slug)
        const r = courierMap().get(slug)?.required_fields || [];
        return r.map((item) => ({
            key: item.replace(/^tracking_/, '') as keyof AdditionalFields,
            name: item
                .replace(/^tracking_/, '')
                .split('_')
                .map(capitalize)
                .join(' '),
        }));
    };

    const otherFulfillments = createMemo(() => {
        if (editingFulfillment()) {
            return fulfillments().filter((t) => t.id !== editingFulfillment().id);
        } else {
            return fulfillments();
        }
    });

    const otherFulfillmentsTrackings = createMemo(() => {
        let filter = new Map();
        for (const otherFulfillment of otherFulfillments()) {
            for (let t of otherFulfillment.trackings) {
                let exist = filter.get(t.slug + t.tracking_number);
                if (exist === undefined) {
                    filter.set(t.slug + t.tracking_number, true);
                }
            }
        }
        return filter
    });

    const remainLineItems = createMemo(() => calcUnfulfilledItems(otherFulfillments()));

    const validator = createMemo(() => {
        let isValid = true;
        let errors: string = '';

        const items = editingFulfillment().items;

        if (!items || items.length === 0) {
            return {isValid: false, errors: 'Required items'};
        }
        // 任意 item.quantity > 0 即可
        isValid = false;
        items.forEach((item) => {
            if (item.quantity > 0) {
                isValid = true;
            }
        });
        if (!isValid) {
            return {isValid: false, errors: 'Required items'};
        }

        let filter = new Map();
        for (const tracking of editingFulfillment().trackings) {
            if (tracking.slug === '') {
                return { isValid: false, errors: 'Required tracking slug' };
            }
            if (tracking.tracking_number === '') {
                return { isValid: false, errors: 'Required tracking number' };
            }
            if (tracking.tracking_number.length > 256) {
                return { isValid: false, errors: 'Tracking number invalid' };
            }

            // check if tracking number has already been added by other fulfillments
            let exist = otherFulfillmentsTrackings().get(tracking.slug + tracking.tracking_number);
            if (exist) {
                return { isValid: false, errors: 'Tracking number has already been added' };
            }

            // check if tracking number has already been added by current fulfillment
            exist = filter.get(tracking.slug + tracking.tracking_number);
            if (exist) {
                return { isValid: false, errors: 'Tracking number has already been added' };
            }
            if (exist === undefined) {
                filter.set(tracking.slug + tracking.tracking_number, true);
            }

            let requiredFields = courierMap().get(tracking.slug)?.required_fields || [];
            if (requiredFields.length > 0) {
                requiredFields.forEach((field) => {
                    let fieldKey = field.replace(/^tracking_/, '') as keyof AdditionalFields;
                    let fieldName = fieldKey.split('_').join(' ');
                    if (tracking.additional_fields[fieldKey] === '') {
                        isValid = false;
                        errors = `Required ${fieldName}`;
                    }
                    if (tracking.additional_fields[fieldKey].length > 256) {
                        isValid = false;
                        errors = `${fieldName} invalid`;
                    }
                });
            }
        }

        if (editingFulfillment().trackings.length > MAX_TRACKING_NUMBER) {
            isValid = false;
            errors = 'Tracking number limit exceeded';
        }

        return { isValid, errors };
    });

    const handleLineItemChange = (id: number, value: number) => {
        setEditingFulfillment(f => {
            const newFulfillment = {...f};
            let i = newFulfillment.items?.find((item) => item.id === id);
            if (i !== undefined) {
                i.quantity = value
            } else {
                newFulfillment.items?.push({id: id, quantity: value});
            }
            return newFulfillment;
        });
    };

    const handleOk = () => {
        props.onOk(editingFulfillment());
    };

    const getTitle = createMemo(
        () => {
            return title().toString() + ` tracking - order - #${props.orderId}`
        }
    );

    const buttonText = createMemo(
        () => {
            let ts = editingFulfillment().trackings;
            if (ts === undefined) {
                return `Add`
            }
            if (ts.length > 0) {
                return `Save`
            }
            return `Add`
        }
    );

    return (
        <Modal
            title={getTitle()}
            visible={props.visible}
            okText={buttonText().toString()}
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
                                                value={editingFulfillment().items?.find((i) => i.id === item.id)?.quantity || 0}
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
                <Show when={!validator().isValid}>
                    <hr style={{margin: '20px 0'}}/>
                    <div style="color: red;">{validator().errors}</div>
                </Show>
                <hr style={{margin: '20px 0'}}/>
                <div style={{margin: '10px 0'}}>
                    <a href="admin.php?page=aftership-setting-admin">Update carrier list</a>
                </div>
                <For each={editingFulfillment().trackings}>
                {(tracking, index) =>
                    <div>
                        <div className={styles.input}>
                            <label style={{marginLeft: '10px'}}>
                                Courier:
                                <select
                                    value={tracking?.slug}
                                    onChange={(e) => {
                                        updateFormValueAtIndex(index, 'slug', e.currentTarget.value)
                                    }}>
                                    <For each={selectedCouriers()}>
                                        {(item) => <option
                                            value={item.slug}>{item.name || item.other_name}</option>}
                                    </For>
                                </select>
                            </label>
                            <label>
                                Tracking number:
                                <input
                                    value={tracking.tracking_number}
                                    onInput={(e) =>
                                        updateFormValueAtIndex(index, 'tracking_number', e.currentTarget.value)
                                    }
                                />
                            </label>
                            <button onClick={() => removeTracking(index)}>x</button>
                        </div>
                        <div className={styles.input}>
                            <For each={additionalFields(trackingIndexCourierMap().get(index()) ?? '')}>
                                {(item) => (
                                    <div>
                                        <label>
                                            {item.name}:
                                            <input
                                                type={item.key === 'ship_date' ? 'date' : 'text'}
                                                value={tracking.additional_fields[item.key]}
                                                onInput={(e) => updateAdditionalFieldsAtIndex(index, item.key, e.currentTarget.value)}
                                            />
                                        </label>
                                    </div>
                                )}
                            </For>
                        </div>
                    </div>
                    }
                </For>
                <br/>
                <button disabled={editingFulfillment().trackings.length >= MAX_TRACKING_NUMBER} onClick={addTracking}>Add Tracking Number</button>
            </div>
        </Modal>
    );
}
