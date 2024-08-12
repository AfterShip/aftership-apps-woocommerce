import { createSignal } from 'solid-js';
import md5 from 'crypto-js/md5';
import { stringifyUrl } from 'query-string';

import {Courier, LineItem, Fulfillment} from '@src/typings/trackings';


interface GetFulfillmentsResponse {
    data: {
        line_items: LineItem[];
        fulfillments: Fulfillment[];
        number: string; // order number
    };
}


interface GetSelectedCouriersResponse {
  data: {
    couriers: Courier[];
    custom_domain: string;
  };
}

export const [fulfillments, setFulfillments] = createSignal<Fulfillment[]>([]);
export const [selectedCouriers, setSelectedCouriers] = createSignal<Courier[]>([]);
export const [courierMap, setCourierMap] = createSignal<Map<string, Courier>>(new Map());
export const [lineItems, setLineItems] = createSignal<LineItem[]>([]);
export const [customDomain, setCustomDomain] = createSignal<string>('');
export const [editingOrderNumber, setEditingOrderNumber] = createSignal<string>('');

const AJAX_URL = window.woocommerce_admin_meta_boxes.ajax_url;

export async function fetchSelectedCouriers() {
  await fetch(
    stringifyUrl({
      url: AJAX_URL,
      query: {
        action: 'aftership_get_settings',
        t: Date.now(),
      },
    })
  )
    .then((res): Promise<GetSelectedCouriersResponse> => res.json())
    .then((res) => {
      const selected_couriers = res.data.couriers;
      const nextCourierMap = new Map(courierMap());
      selected_couriers.forEach((c) => {
        nextCourierMap.set(c.slug, c);
      });
      setCourierMap((prev) => new Map([...prev, ...nextCourierMap]));
      setSelectedCouriers(selected_couriers);
      setCustomDomain(res.data.custom_domain);
    });
}

export async function fetchOrderFulfillments(orderId: string) {
    const security = document.querySelector<HTMLInputElement>('#aftership_get_nonce')?.value || '';
    await fetch(
        stringifyUrl({
            url: AJAX_URL,
            query: {
                action: 'aftership_get_order_fulfillments',
                security: security,
                order_id: orderId,
                t: Date.now(),
            },
        })
    )
        .then((res): Promise<GetFulfillmentsResponse> => res.json())
        .then((res) => {
            const data = res.data;
            const allCouriers = window.get_aftership_couriers();
            const nextCourierMap = new Map();

            data.fulfillments.forEach((f,index) => {
                f.trackings.forEach((t) => {
                    if (nextCourierMap.has(t.slug)) return;
                    const c = allCouriers.find((c) => c.slug === t.slug);
                    if (c) {
                        nextCourierMap.set(t.slug, c);
                    }
                });
            });

            setCourierMap((prev) => new Map([...prev, ...nextCourierMap]));
            setFulfillments(data.fulfillments);
            setLineItems(data.line_items);
            setEditingOrderNumber(data.number);
        });
}

export async function editOrderFulfillments(orderId: string, data: Fulfillment) {
    const oldFulfillment = fulfillments().find((f) => f.id === data.id);
    const oldFulfillmentIndex = fulfillments().findIndex((f) => f.id === data.id);
    let result: Fulfillment[] = [...fulfillments()];
    if (oldFulfillment) {
        result.splice(oldFulfillmentIndex, 1, data);
    } else {
        result.push(data);
    }
    const security = document.querySelector<HTMLInputElement>('#aftership_create_nonce')?.value || '';

    await fetch(
        stringifyUrl({
            url: AJAX_URL,
            query: {
                action: 'aftership_save_order_fulfillments',
                security: security,
            },
        }),
        {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                order_id: orderId,
                fulfillments: result,
            }),
        }
    );
}

export async function deleteOrderFulfillment(orderId: string, fulfillmentId: string) {
    const security = document.querySelector<HTMLInputElement>('#aftership_delete_nonce')?.value || '';
    await fetch(
        stringifyUrl({
            url: AJAX_URL,
            query: {
                action: 'aftership_delete_order_fulfillments',
                security: security,
            },
        }),
        {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                order_id: orderId,
                fulfillment_id: fulfillmentId,
            }),
        }
    );
}

export async function deleteOrderFulfillmentTracking(orderId: string, trackingId: string) {
    const security = document.querySelector<HTMLInputElement>('#aftership_delete_nonce')?.value || '';
    await fetch(
        stringifyUrl({
            url: AJAX_URL,
            query: {
                action: 'aftership_delete_order_fulfillment_tracking',
                security: security,
            },
        }),
        {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                order_id: orderId,
                tracking_id: trackingId,
            }),
        }
    );
}
