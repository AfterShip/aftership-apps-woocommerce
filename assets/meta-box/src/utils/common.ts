import { lineItems } from '@src/storages/metaBox';
import { Tracking } from '@src/typings/trackings';

export function calcUnfulfilledItems(trackings: Tracking[]) {
  const itemsMap = new Map<number, number>();
  trackings.forEach((tracking) => {
    tracking.line_items?.forEach((item) => {
      // TODO 后端兼容后不需要转换 number
      if (itemsMap.has(Number(item.id))) {
        itemsMap.set(Number(item.id), (itemsMap.get(Number(item.id)) || 0) + Number(item.quantity));
      } else {
        itemsMap.set(Number(item.id), Number(item.quantity));
      }
    });
  });
  const remainLineItems = lineItems()
    .map((item) => {
      const currentQty = itemsMap.get(item.id) || 0;
      return {
        id: item.id,
        name: item.name,
        quantity: item.quantity - currentQty,
      };
    })
    .filter((item) => item.quantity > 0);
  return remainLineItems;
}
