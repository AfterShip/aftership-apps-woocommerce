export interface AdditionalFields {
  account_number: string;
  key: string;
  postal_code: string;
  ship_date: string;
  destination_country: string;
  state: string;
}

export interface Tracking {
  tracking_id: string;
  slug: string;
  tracking_number: string;
  additional_fields: AdditionalFields;
  line_items?: Pick<LineItem, 'id' | 'quantity'>[];
  metrics: {
    created_at: string;
    updated_at: string;
  };
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
