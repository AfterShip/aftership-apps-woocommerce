import { Component, createMemo, createSignal, For, onMount } from 'solid-js';
import Button from '@src/components/Button';
import styles from './Metabox.module.scss';
import {
  trackings,
  courierMap,
  fetchOrderTrackings,
  deleteOrderTracking,
  editOrderTracking,
  fetchSelectedCouriers,
  customDomain,
  lineItems,
  editingOrderNumber,
} from '@src/storages/tracking';
import EditTrackingModal, { FormValue } from '@src/components/EditTrackingModal';
import { Tracking } from '@src/typings/trackings';

const Metabox: Component = () => {
  const [showModal, setShowModal] = createSignal(false);
  const [editingTracking, setEditingTracking] = createSignal<Tracking>();

  const orderId = window.woocommerce_admin_meta_boxes.post_id;

  onMount(() => {
    fetchOrderTrackings(orderId);
    fetchSelectedCouriers();
  });

  const handleOk = async (values: FormValue) => {
    const selectedItems = values.line_items || {};
    await editOrderTracking(orderId, {
      ...values,
      line_items: Object.entries(selectedItems)
        .map(([id, quantity]) => ({
          id: Number(id),
          quantity,
        }))
        .filter((item) => item.quantity > 0),
    });
    setShowModal(false);
    setEditingTracking(undefined);
    await fetchOrderTrackings(orderId);
  };
  const handleCancel = () => {
    setShowModal(false);
    setEditingTracking(undefined);
  };
  const handleDelete = async (trackingId: string) => {
    await deleteOrderTracking(orderId, trackingId);
    await fetchOrderTrackings(orderId);
  };

  const lineItemsMap = createMemo(() => {
    const lineItemsMap = new Map<string, { name: string; quantity: number }[]>();
    trackings().forEach((tracking) => {
      const arr = (tracking.line_items || [])?.map((tl) => {
        const match = lineItems().find((l) => tl.id === l.id);
        return {
          name: match?.name || String(tl.id),
          quantity: tl.quantity,
        };
      });
      lineItemsMap.set(tracking.tracking_id, arr);
    });
    return lineItemsMap;
  });

  const formatTackingLink = (tracking: Tracking) => {
    return /^https?:\/\//.test(customDomain())
      ? `${customDomain()}/${tracking.slug}/${tracking.tracking_number}`
      : `https://${customDomain()}/${tracking.slug}/${tracking.tracking_number}`;
  };

  return (
    <div className={styles.root}>
      {/* trackings */}
      <div>
        <For each={trackings()}>
          {(tracking, index) => (
            <div className={styles.tracking}>
              <div className={styles.title}>
                <div>Shipment {index() + 1}</div>
                <div>
                  <a
                    onClick={async () => {
                      // 💩 update data first, user maybe modify line_items
                      await fetchOrderTrackings(orderId);
                      setEditingTracking(tracking);
                      setShowModal(true);
                    }}>
                    Edit
                  </a>
                  <a onClick={() => handleDelete(tracking.tracking_id)}>Delete</a>
                </div>
              </div>
              <div className={styles.content}>
                <div className={styles.number}>
                  <div>
                    <strong>{courierMap().get(tracking.slug)?.name || tracking.slug}&nbsp;</strong>
                  </div>
                  <div>
                    <a
                      title={tracking.tracking_number}
                      href={formatTackingLink(tracking)}
                      target="_blank">
                      {tracking.tracking_number}
                    </a>
                  </div>
                </div>
                <For each={lineItemsMap().get(tracking.tracking_id) || []}>
                  {(item) => (
                    <div className={styles.item}>
                      <div title={item.name}>{item.name}</div>
                      <div>&nbsp;x {item.quantity}</div>
                    </div>
                  )}
                </For>
              </div>
            </div>
          )}
        </For>
      </div>
      {/* add button */}
      <div style={{ padding: '12px' }}>
        <Button
          onClick={async () => {
            await fetchOrderTrackings(orderId);
            setShowModal(true);
          }}
          style={{ width: '100%' }}>
          Add Tracking Number
        </Button>
      </div>
      <EditTrackingModal
        visible={showModal()}
        value={editingTracking()}
        onCancel={handleCancel}
        onOk={handleOk}
        orderId={editingOrderNumber()}
      />
    </div>
  );
};

export default Metabox;
