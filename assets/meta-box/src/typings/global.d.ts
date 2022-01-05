import { Courier } from './trackings';

declare global {
  interface Window {
    woocommerce_admin_meta_boxes: {
      post_id: string;
    };
    get_aftership_couriers(): Courier[];
  }
}
