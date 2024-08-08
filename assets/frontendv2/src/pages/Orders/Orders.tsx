import { Component, createSignal, onCleanup, onMount } from 'solid-js';
import EditTrackingModal, {setTitle} from '@src/components/EditTrackingModal';
import {
  fetchOrderFulfillments,
  fetchSelectedCouriers,
  editOrderFulfillments,
  editingOrderNumber,
  deleteOrderFulfillmentTracking
} from '@src/storages/tracking';
import {Fulfillment} from '@src/typings/trackings';
import {forEach} from "lodash-es";
import md5 from "crypto-js/md5";
import { v4 as uuidv4 } from 'uuid';


const Orders: Component = () => {
    const [showModal, setShowModal] = createSignal(false);
    const [orderId, setOrderId] = createSignal('');

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
            await fetchOrderFulfillments(match[1]);
            setTitle('Add')
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
            const elPath = e.composedPath();
            await deleteOrderFulfillmentTracking(dataSet.orderId, dataSet.trackingId);
            for (let el of elPath) {
                if (
                    el instanceof HTMLElement &&
                    el.tagName === 'LI' &&
                    el.parentElement?.className.includes('wcas-tracking-number-list')
                ) {
                    el.remove();
                    return;
                }
            }
        }
        window.location.reload();
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


    const handleCancel = () => {
        setShowModal(false);
    };

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
        console.log('handleOk' + f);
        await editOrderFulfillments(orderId(), f);
        window.location.reload();
    };

    return (
        <EditTrackingModal
            visible={showModal()}
            onCancel={handleCancel}
            onOk={handleOk}
            orderId={editingOrderNumber()}
        />
    );
};

export default Orders;
