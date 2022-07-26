import { createSignal } from 'solid-js';
import md5 from 'crypto-js/md5';
import { stringifyUrl } from 'query-string';

import { Tracking, Courier, LineItem } from '@src/typings/trackings';

interface GetTrackingsResponse {
  data: {
    line_items: LineItem[];
    trackings: Tracking[];
  };
}

interface GetSelectedCouriersResponse {
  data: {
    couriers: Courier[];
    custom_domain: string;
  };
}

export const [trackings, setTrackings] = createSignal<Tracking[]>([]);
export const [selectedCouriers, setSelectedCouriers] = createSignal<Courier[]>([]);
export const [courierMap, setCourierMap] = createSignal<Map<string, Courier>>(new Map());
export const [lineItems, setLineItems] = createSignal<LineItem[]>([]);
export const [customDomain, setCustomDomain] = createSignal<string>('');

const AJAX_URL = window.woocommerce_admin_meta_boxes.ajax_url;

export async function fetchOrderTrackings(orderId: string) {
  const security = document.querySelector<HTMLInputElement>('#aftership_get_nonce')?.value || '';
  await fetch(
    stringifyUrl({
      url: AJAX_URL,
      query: {
        action: 'aftership_get_order_trackings',
        security: security,
        order_id: orderId,
        t: Date.now(),
      },
    })
  )
    .then((res): Promise<GetTrackingsResponse> => res.json())
    .then((res) => {
      const data = res.data;
      const allCouriers = window.get_aftership_couriers();
      const nextCourierMap = new Map();
      data.trackings.forEach((t) => {
        if (nextCourierMap.has(t.slug)) return;
        const c = allCouriers.find((c) => c.slug === t.slug);
        c && nextCourierMap.set(t.slug, c);
      });
      setCourierMap((prev) => new Map([...prev, ...nextCourierMap]));
      setTrackings(data.trackings);
      setLineItems(data.line_items);
    });
}

interface SubmitData extends Omit<Tracking, 'tracking_id' | 'line_items' | 'metrics'> {
  tracking_id?: string;
  line_items?: Pick<LineItem, 'id' | 'quantity'>[];
  metrics?: Tracking['metrics'];
}

export async function editOrderTracking(orderId: string, data: SubmitData) {
  const oldTracking = trackings().find((t) => t.tracking_id === data.tracking_id);
  const oldTrackingIndex = trackings().findIndex((t) => t.tracking_id === data.tracking_id);
  const nowISOString = new Date().toISOString().replace(/\.\d+(?=Z$)/, '');
  const isSlugOrNumberChanged =
    data.slug !== oldTracking?.slug || data.tracking_number !== oldTracking?.tracking_number;
  let result: SubmitData[] = [...trackings()];
  if (oldTracking && !isSlugOrNumberChanged) {
    result.splice(oldTrackingIndex, 1, {
      ...data,
      metrics: {
        created_at: oldTracking.metrics.created_at || nowISOString,
        updated_at: nowISOString,
      },
    });
  } else {
    result = [
      ...result.filter((t) => t.tracking_id !== data.tracking_id),
      {
        ...data,
        tracking_id: md5(`${data.slug}-${data.tracking_number}`).toString(),
        metrics: {
          created_at: nowISOString,
          updated_at: nowISOString,
        },
      },
    ];
  }
  const security = document.querySelector<HTMLInputElement>('#aftership_create_nonce')?.value || '';

  await fetch(
    stringifyUrl({
      url: AJAX_URL,
      query: {
        action: 'aftership_save_order_tracking',
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
        trackings: result,
      }),
    }
  );
}

export async function deleteOrderTracking(orderId: string, trackingId: string) {
  const security = document.querySelector<HTMLInputElement>('#aftership_delete_nonce')?.value || '';
  await fetch(
    stringifyUrl({
      url: AJAX_URL,
      query: {
        action: 'aftership_delete_order_tracking',
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
