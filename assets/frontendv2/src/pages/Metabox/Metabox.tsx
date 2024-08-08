import { Component, createMemo, createSignal, For, onMount } from 'solid-js';
import Button from '@src/components/Button';
import styles from './Metabox.module.scss';
import {
  courierMap,
  deleteOrderFulfillment,
  editOrderFulfillments,
  fetchSelectedCouriers,
  customDomain,
  lineItems,
  editingOrderNumber, fulfillments, fetchOrderFulfillments,
} from '@src/storages/tracking';
import EditTrackingModal, {
    editingFulfillment,
    setEditingFulfillment,
    setTitle
} from '@src/components/EditTrackingModal';
import {
    Fulfillment,
    FulfillmentFactory,
    FulfillmentTrackingFactory
} from '@src/typings/trackings';
import {forEach} from "lodash-es";
import md5 from 'crypto-js/md5';
import { v4 as uuidv4 } from 'uuid';

export const Metabox: Component = () => {
    const [showModal, setShowModal] = createSignal(false);

    const orderId = window.woocommerce_admin_meta_boxes.post_id;

    onMount(() => {
        fetchOrderFulfillments(orderId);
        fetchSelectedCouriers();
    });

    const handleOk = async (f: Fulfillment) => {
        const now = new Date().toISOString().replace(/\.\d+(?=Z$)/, '');
        if (f.id === '') {
            f.created_at = now;
            f.updated_at = now;
            f.id = uuidv4();
        } else {
            f.updated_at = now;
        }
        forEach(f.trackings || [], (tracking) => {
            if (tracking.tracking_id === '') {
                tracking.tracking_id = md5(`${tracking.slug}-${tracking.tracking_number}`).toString();
            }
        });
        await editOrderFulfillments(orderId, f);
        setShowModal(false);
        setEditingFulfillment(FulfillmentFactory.createDefault());
        await fetchOrderFulfillments(orderId);
    };

    const handleCancel = () => {
        setShowModal(false);
        setEditingFulfillment(FulfillmentFactory.createDefault());
    };

    const handleDelete = async (fulfillmentId: string) => {
        await deleteOrderFulfillment(orderId, fulfillmentId);
        await fetchOrderFulfillments(orderId);
    };

    const itemsMap = createMemo(() => {
        const itemsMap = new Map<string, { name: string; quantity: number }[]>();
        fulfillments().forEach(fulfillment => {
            const items = fulfillment.items || [];
            const arr = items.map((item, index) => {
                const itemId = Number(item.id);
                const match = lineItems().find(l => itemId === l.id);
                return {
                    name: match?.name || String(item.id),
                    quantity: item.quantity,
                };
            });
            itemsMap.set(String(fulfillment.id), arr);
        });
        return itemsMap;
    });

    const formatTackingLink = (tracking_number: string, slug: string) => {
        return /^https?:\/\//.test(customDomain())
            ? `${customDomain()}/${slug}/${tracking_number}`
            : `https://${customDomain()}/${slug}/${tracking_number}`;
    };

    return (
        <div className={styles.root}>
            <div>
                {fulfillments().map((fulfillment, index) => (
                    <div className={styles.tracking}>
                        <div className={styles.title}>
                            <div>Shipment {index + 1}</div>
                            <div>
                                <a
                                    onClick={async () => {
                                        // 💩 update data first, user maybe modify line_items
                                        await fetchOrderFulfillments(orderId);
                                        setEditingFulfillment(fulfillment);
                                        setTitle('Edit');
                                        setShowModal(true);
                                    }}>
                                    Edit
                                </a>
                                <a onClick={() => handleDelete(fulfillment.id)}>Delete</a>
                            </div>
                        </div>
                        {(itemsMap().get(fulfillment.id) || []).map((item, index) => (
                            <div className={styles.item}>
                                <div title={item.name}>{item.name} &nbsp;x {item.quantity} </div>
                            </div>
                        ))}
                        <br/>
                        {fulfillment.trackings.map((tracking, index) => (
                            <div className={styles.content}>
                                <div>Tracking {index + 1}</div>
                                <div className={styles.number}>
                                    <div>
                                        <strong>{courierMap().get(tracking.slug)?.name || tracking.slug}&nbsp;</strong>
                                    </div>
                                    <div>
                                        <a
                                            title={tracking.tracking_number}
                                            href={formatTackingLink(tracking.tracking_number, tracking.slug)}
                                            target="_blank"
                                        >
                                            {tracking.tracking_number}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                ))}
            </div>
            <div style={{padding: '12px'}}>
                <Button
                    onClick={async () => {
                        await fetchOrderFulfillments(orderId);
                        setTitle('Add');
                        setShowModal(true);
                    }}
                    style={{width: '100%'}}
                >
                    Add Tracking Number
                </Button>
            </div>
            <EditTrackingModal
                visible={showModal()}
                onCancel={handleCancel}
                onOk={handleOk}
                orderId={editingOrderNumber()}
            />
        </div>
    );
};

export default Metabox;
