import { Component, createSignal, For, onMount, createMemo, Show } from 'solid-js';
import Button from './components/Button';
import styles from './App.module.scss';
import {
  trackings,
  courierMap,
  fetchTrackings,
  deleteTracking,
  editTracking,
  getSelectedCouriers,
  customDomain,
} from './storages/metaBox';
import EditTrackingModal, { FormValue } from './components/EditTrackingModal';
import { Tracking } from './typings/trackings';
import { calcUnfulfilledItems } from './utils/common';

const App: Component = () => {
  const [showModal, setShowModal] = createSignal(false);
  const [editingTracking, setEditingTracking] = createSignal<Tracking>();

  onMount(() => {
    fetchTrackings();
    getSelectedCouriers();
  });

  const handleOk = async (values: FormValue) => {
    const selectedItems = values.line_items || {};
    await editTracking({
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
  };
  const handleCancel = () => {
    setShowModal(false);
    setEditingTracking(undefined);
  };

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
          {(item, index) => (
            <div className={styles.tracking}>
              <div className={styles.title}>
                <div>Shipment {index() + 1}</div>
                <div>
                  <a
                    onClick={async () => {
                      // 💩 update data first, user maybe modify line_items
                      await fetchTrackings();
                      setEditingTracking(item);
                      setShowModal(true);
                    }}>
                    Edit
                  </a>
                  <a onClick={() => deleteTracking(item.tracking_id)}>Delete</a>
                </div>
              </div>
              <div className={styles.content}>
                <div>
                  <strong>{courierMap().get(item.slug)?.name || item.slug}</strong>
                </div>
                <div>
                  <a href={formatTackingLink(item)} target="_blank">
                    {item.tracking_number}
                  </a>
                </div>
              </div>
            </div>
          )}
        </For>
      </div>
      {/* add button */}
      <div style={{ padding: '12px' }}>
        <Button
          onClick={async () => {
            await fetchTrackings();
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
      />
    </div>
  );
};

export default App;
