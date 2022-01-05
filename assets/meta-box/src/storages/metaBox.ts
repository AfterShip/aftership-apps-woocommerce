import { createSignal } from 'solid-js';

import { Tracking, Courier, LineItem } from '@src/typings/trackings';

interface GetTrackingsResponse {
  data: {
    line_items: LineItem[];
    selected_couriers: Courier[];
    trackings: Tracking[];
  };
}

export const [trackings, setTrackings] = createSignal<Tracking[]>([]);
export const [selectedCouriers, setSelectedCouriers] = createSignal<Courier[]>([]);
export const [courierMap, setCourierMap] = createSignal<Map<string, Courier>>(new Map());
export const [lineItems, setLineItems] = createSignal<LineItem[]>([]);

export async function fetchTrackings() {
  const response = await fetch(`/wp-admin/admin-ajax.php?action=aftership_get_order_trackings`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      order_id: window.woocommerce_admin_meta_boxes.post_id,
      security: document.querySelector<HTMLInputElement>('#aftership_get_nonce')?.value || '',
    }),
  })
    .then((res): Promise<GetTrackingsResponse> => res.json())
    .then((res) => {
      const data = res.data;
      const allCouriers = window.get_aftership_couriers();
      const courierMap = new Map<string, Courier>();
      data.selected_couriers.forEach((c) => {
        courierMap.set(c.slug, c);
      });
      data.trackings.forEach((t) => {
        if (courierMap.has(t.slug)) return;
        const c = allCouriers.find((c) => c.slug === t.slug);
        c && courierMap.set(t.slug, c);
      });
      setTrackings(data.trackings);
      setSelectedCouriers(data.selected_couriers);
      setCourierMap(courierMap);
      setLineItems(data.line_items);
    });
}

interface SubmitData extends Omit<Tracking, 'tracking_link' | 'line_items' | 'metrics'> {
  tracking_link?: string;
  line_items?: Pick<LineItem, 'id' | 'quantity'>[];
  metrics?: Tracking['metrics'];
}

export async function editTracking(data: SubmitData) {
  const allTrackings = [...trackings().filter((t) => t.tracking_id !== data.tracking_id), data];
  // remove tracking_link property as request by BE
  const transformedData = allTrackings.map((t) =>
    Object.fromEntries<Omit<Tracking, 'tracking_link'>[]>(
      Object.entries(t).filter(([key, _v]) => key !== 'tracking_link')
    )
  );
  await fetch(`/wp-admin/admin-ajax.php?action=aftership_save_order_tracking`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      order_id: window.woocommerce_admin_meta_boxes.post_id,
      security: document.querySelector<HTMLInputElement>('#aftership_create_nonce')?.value || '',
      modified_tracking_ids: data.tracking_id ? [data.tracking_id] : [],
      trackings: transformedData,
    }),
  });
  await fetchTrackings();
}

export async function deleteTracking(id: string) {
  await fetch(`/wp-admin/admin-ajax.php?action=aftership_delete_order_tracking`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      order_id: window.woocommerce_admin_meta_boxes.post_id,
      security: document.querySelector<HTMLInputElement>('#aftership_delete_nonce')?.value || '',
      trackings: trackings().filter((t) => t.tracking_id !== id),
    }),
  });
  await fetchTrackings();
}
