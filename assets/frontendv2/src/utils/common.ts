import { lineItems } from '@src/storages/tracking';
import {Fulfillment} from '@src/typings/trackings';

export function calcUnfulfilledItems(fulfillments: Fulfillment[]) {
  const itemsMap = new Map<number, number>();
  fulfillments.forEach((f) => {
    f.items?.forEach((item) => {
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
