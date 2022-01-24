import { Courier } from './trackings';

declare global {
  interface Window {
    woocommerce_admin_meta_boxes: {
      post_id: string;
      ajax_url: string;
    };
    get_aftership_couriers(): Courier[];
  }
}
