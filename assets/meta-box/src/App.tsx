import { Component, createSignal, For, onMount, createMemo, Show } from 'solid-js';
import Button from './components/Button';
import styles from './App.module.scss';
import {
  trackings,
  courierMap,
  fetchTrackings,
  deleteTracking,
  editTracking,
} from './storages/metaBox';
import EditTrackingModal, { FormValue } from './components/EditTrackingModal';
import { Tracking } from './typings/trackings';
import { calcUnfulfilledItems } from './utils/common';

const App: Component = () => {
  const [showModal, setShowModal] = createSignal(false);
  const [editingTracking, setEditingTracking] = createSignal<Tracking>();
  const remainLineItems = createMemo(() => calcUnfulfilledItems(trackings()));
  const hasUnfulfilledItems = createMemo(() => {
    return remainLineItems().length > 0;
  });

  onMount(() => {
    fetchTrackings();
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
                    onClick={() => {
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
                  <a href={item.tracking_link} target="_blank">
                    {item.tracking_number}
                  </a>
                </div>
              </div>
            </div>
          )}
        </For>
      </div>
      {/* add button */}
      <Show when={hasUnfulfilledItems()}>
        <div style={{ padding: '12px' }}>
          <Button onClick={() => setShowModal(true)} style={{ width: '100%' }}>
            Add Tracking Number
          </Button>
        </div>
      </Show>
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
