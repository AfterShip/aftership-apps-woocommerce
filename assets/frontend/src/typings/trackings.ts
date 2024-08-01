export interface AdditionalFields {
  account_number: string;
  key: string;
  postal_code: string;
  ship_date: string;
  destination_country: string;
  state: string;
}

export interface Fulfillment {
  id: string;
  trackings: FulfillmentTracking[];
  items?: Pick<LineItem, 'id' | 'quantity'>[];
  created_at: string;
  updated_at: string;
  from_tracking: boolean;
}

export interface FulfillmentTracking {
  tracking_id: string;
  slug: string;
  tracking_number: string;
  additional_fields: AdditionalFields;
}

export interface LineItem {
  id: number;
  name: string;
  product_id: number;
  variation_id: number;
  quantity: number;
  sku: string;
  // ...
}

export type RequiredField =
  | 'tracking_account_number'
  | 'tracking_key'
  | 'tracking_postal_code'
  | 'tracking_ship_date'
  | 'tracking_destination_country'
  | 'tracking_state';

export interface Courier {
  slug: string;
  name: string;
  other_name: string;
  required_fields: RequiredField[];
}

export class FulfillmentTrackingFactory {
    static createDefault(): FulfillmentTracking {
        return {
            tracking_id: '',
            tracking_number: '',
            slug: '',
            additional_fields: {
                account_number: '',
                key: '',
                postal_code: '',
                ship_date: '',
                destination_country: '',
                state: '',
            },
        };
    }
}

export class FulfillmentFactory {
    static createDefault(): Fulfillment {
        return {
            id: '',
            trackings: [FulfillmentTrackingFactory.createDefault()],
            items: [],
            created_at: '',
            updated_at: '',
            from_tracking: false,
        };
    }
}
