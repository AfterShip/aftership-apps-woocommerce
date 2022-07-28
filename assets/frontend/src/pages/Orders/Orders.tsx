import { Component, createSignal, onCleanup, onMount } from 'solid-js';
import EditTrackingModal, { FormValue } from '@src/components/EditTrackingModal';
import {
  fetchOrderTrackings,
  fetchSelectedCouriers,
  editOrderTracking,
  deleteOrderTracking,
  editingOrderNumber,
} from '@src/storages/tracking';
import { Tracking } from '@src/typings/trackings';

const Orders: Component = () => {
  const [showModal, setShowModal] = createSignal(false);
  const [orderId, setOrderId] = createSignal('');
  const [editingTracking] = createSignal<Tracking>();

  const handleAddTrackingClick = async (e: MouseEvent) => {
    const target = e.target as HTMLAnchorElement | null;
    if (!target) return;
    if (target.tagName !== 'A' || !target.className.includes('aftership_add_inline_tracking')) {
      return;
    }
    e.preventDefault();
    const match = target.href.match(/#order-id-(\S+)$/);
    if (match) {
      await setOrderId(match[1]);
      await fetchOrderTrackings(match[1]);
      setShowModal(true);
    }
  };
  const handleDeleteTrackingClick = async (e: MouseEvent) => {
    const parentElement = (e.target as HTMLAnchorElement | null)?.parentElement;
    if (!parentElement) return;
    if (
      parentElement.tagName !== 'A' ||
      !parentElement.className.includes('aftership_inline_tracking_delete')
    ) {
      return;
    }
    e.preventDefault();
    const result = window.confirm('Do you really want to delete tracking number?');
    if (result) {
      const dataSet = parentElement.dataset as { orderId: string; trackingId: string };
      await deleteOrderTracking(dataSet.orderId, dataSet.trackingId);
      window.location.reload();
    }
  };

  onMount(() => {
    fetchSelectedCouriers();
    window.addEventListener('click', handleAddTrackingClick, true);
    window.addEventListener('click', handleDeleteTrackingClick);
  });

  onCleanup(() => {
    window.removeEventListener('click', handleAddTrackingClick);
    window.removeEventListener('click', handleDeleteTrackingClick);
  });

  const handleOk = async (values: FormValue) => {
    const selectedItems = values.line_items || {};
    await editOrderTracking(orderId(), {
      ...values,
      line_items: Object.entries(selectedItems)
        .map(([id, quantity]) => ({
          id: Number(id),
          quantity,
        }))
        .filter((item) => item.quantity > 0),
    });
    window.location.reload();
  };
  const handleCancel = () => {
    setShowModal(false);
  };

  return (
    <EditTrackingModal
      value={editingTracking()}
      visible={showModal()}
      onCancel={handleCancel}
      onOk={handleOk}
      orderId={editingOrderNumber()}
    />
  );
};

export default Orders;
