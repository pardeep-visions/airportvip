# Fast Track Technical Documentation (Manual Deployment)

## Project Context

This document maps the implemented Fast Track feature in the `heathrowvip` theme for a non-Git manual deployment workflow.

Audited implementation files:

- `wp-content/themes/heathrowvip/functions.php`
- `wp-content/themes/heathrowvip/assets/js/fast-track.js`
- `wp-content/themes/heathrowvip/style.css`

Additional files containing only static "Fast Track" text references:

- `wp-content/themes/heathrowvip/cpts/locations/content-single-locations.php`
- `wp-content/themes/heathrowvip/cpts/locations/content-single-locationsXXX.php`

---

## 1) Feature Breakdown

### 1.1 Frontend UI (Checkbox + Quantity)

- Implemented in `functions.php` via `hvip_render_fast_track_field()`
- Renders:
  - Checkbox: `hvip_fast_track_enabled`
  - Quantity dropdown: `hvip_fast_track_quantity` (1-10)
  - Helper link: "Check if Fast Track is included"
  - Nonce: `hvip_fast_track_nonce`

### 1.2 jQuery / JavaScript Behavior

- Implemented in `assets/js/fast-track.js`
- Handles:
  - Show/hide quantity block when checkbox is toggled
  - Open popup modal from helper link
  - Close popup via close button, overlay click, or `Escape`

### 1.3 Popup Modal Functionality

- Modal markup rendered in `hvip_render_fast_track_field()` (`functions.php`)
- Modal behavior in `fast-track.js`
- Modal styling in `style.css` under `.hvip-fast-track-*`

### 1.4 Admin Settings (Popup Content)

- Admin page created with `add_options_page` in `functions.php`
- Popup content saved with `update_option('hvip_fast_track_popup_content', ...)`
- Popup content loaded with `get_option('hvip_fast_track_popup_content', '')`
- Uses `wp_editor` for editable content

### 1.5 WooCommerce Cart Integration

- `woocommerce_add_cart_item_data` used in `hvip_fast_track_add_cart_item_data()`
- Stores:
  - `hvip_fast_track_enabled`
  - `hvip_fast_track_quantity`
  - `hvip_fast_track_total`

### 1.6 Dynamic Price Modification

- Implemented in `hvip_baggage_apply_price()` on `woocommerce_before_calculate_totals`
- Fast Track cost added to base booking product price
- Base price lock used (`hvip_base_price`, `hvip_base_price_set`) to prevent duplicate additions

### 1.7 Cart and Checkout Display

- Implemented in `hvip_baggage_item_data()` with `woocommerce_get_item_data`
- Displays:
  - Fast Track: Yes/No
  - Quantity: X
  - Added Cost: currency value

### 1.8 Order Meta Saving

- Implemented in `hvip_baggage_add_order_item_meta()` using `woocommerce_checkout_create_order_line_item`
- Saves Fast Track details into order item meta

---

## 2) File-wise Code Mapping

### Core Feature Logic

**File:** `wp-content/themes/heathrowvip/functions.php`  
**Type:** PHP  
**Purpose:** End-to-end Fast Track feature implementation:

- Product page UI render (checkbox, qty, popup link, modal HTML)
- Input validation + security nonce verification
- Cart item custom data attachment
- Dynamic price adjustment in cart totals lifecycle
- Cart/checkout custom item data output
- Order item meta persistence
- Admin settings page + option storage for popup content
- Frontend script enqueue

### Frontend Interaction Script

**File:** `wp-content/themes/heathrowvip/assets/js/fast-track.js`  
**Type:** JavaScript (jQuery)  
**Purpose:** UI interactions:

- Toggle quantity dropdown visibility
- Modal open/close interactions

### Styling

**File:** `wp-content/themes/heathrowvip/style.css`  
**Type:** CSS  
**Purpose:** Fast Track block and modal styles:

- Fast Track section spacing
- Overlay/dialog/close button styles
- Prevent body scroll when modal open

### Non-functional Text Mentions

**File:** `wp-content/themes/heathrowvip/cpts/locations/content-single-locations.php`  
**Type:** PHP template  
**Purpose:** Static content mentioning Fast Track (no dynamic logic)

**File:** `wp-content/themes/heathrowvip/cpts/locations/content-single-locationsXXX.php`  
**Type:** PHP template  
**Purpose:** Static content mentioning Fast Track (no dynamic logic)

---

## 3) Function-level Explanation

### `hvip_render_fast_track_field()`

- **Hook:** `woocommerce_before_add_to_cart_button`
- **Belongs to:** Frontend UI + popup content display
- **What it does:** Outputs Fast Track checkbox/select/link/modal and nonce; reads popup content from option and renders with `wp_kses_post`.

### `hvip_validate_fast_track_fields($passed, $product_id, $quantity)`

- **Hook:** `woocommerce_add_to_cart_validation`
- **Belongs to:** Validation and security
- **What it does:** Checks nonce validity, sanitizes posted values, validates quantity range (1-10) when enabled.

### `hvip_fast_track_add_cart_item_data($cart_item_data, $product_id, $variation_id)`

- **Hook:** `woocommerce_add_cart_item_data`
- **Belongs to:** Cart integration + Fast Track pricing setup
- **What it does:**
  - Validates nonce before processing
  - Reads/sanitizes `enabled` + `quantity`
  - Determines per-person rate by product slug:
    - arrival: `35`
    - otherwise: `25`
  - Calculates `hvip_fast_track_total = qty * rate` (or 0 if disabled)
  - Stores Fast Track cart item keys

### `hvip_baggage_apply_price($cart)`

- **Hook:** `woocommerce_before_calculate_totals`
- **Belongs to:** Dynamic cart price modification
- **What it does:** Applies final line item price as:

`base_price + baggage_fee + fast_track_total`

Uses base-price lock fields to prevent multiple re-additions during recalculations.

### `hvip_baggage_item_data($item_data, $cart_item)`

- **Hook:** `woocommerce_get_item_data`
- **Belongs to:** Cart/checkout display layer
- **What it does:** Appends Fast Track metadata rows for frontend cart/checkout display.

### `hvip_baggage_add_order_item_meta($item, $cart_item_key, $values, $order)`

- **Hook:** `woocommerce_checkout_create_order_line_item`
- **Belongs to:** Order persistence layer
- **What it does:** Saves Fast Track fields into order line item meta values.

### `hvip_fast_track_add_settings_page()`

- **Hook:** `admin_menu`
- **Belongs to:** Admin configuration navigation
- **What it does:** Registers `Settings > Fast Track Popup`.

### `hvip_fast_track_render_settings_page()`

- **Hook:** callback from options page registration
- **Belongs to:** Admin popup content management
- **What it does:** Renders admin editor, validates admin nonce, updates popup option with `update_option`.

### `hvip_enqueue_fast_track_script()`

- **Hook:** `wp_enqueue_scripts`
- **Belongs to:** Frontend JS loading
- **What it does:** Enqueues `assets/js/fast-track.js` on product pages.

---

## 4) Data Flow (Step-by-Step)

1. User opens product page.
2. `hvip_render_fast_track_field()` outputs:
   - checkbox + quantity dropdown + info link + modal markup + nonce.
3. User toggles Fast Track:
   - `fast-track.js` shows/hides quantity dropdown dynamically.
4. User submits add-to-cart:
   - `hvip_validate_fast_track_fields()` verifies nonce + validates input.
5. Cart item data is attached:
   - `hvip_fast_track_add_cart_item_data()` stores enabled/qty/total values.
6. WooCommerce totals recalculate:
   - `hvip_baggage_apply_price()` adds `hvip_fast_track_total` to item price.
7. Cart and checkout render custom rows:
   - `hvip_baggage_item_data()` outputs Fast Track details.
8. Order is created:
   - `hvip_baggage_add_order_item_meta()` stores Fast Track values in order item meta.
9. Popup content lifecycle:
   - Admin updates popup text in settings screen (`update_option`)
   - Frontend modal reads latest content (`get_option`)

---

## 5) Dependencies and Connections

### Frontend Form to WooCommerce

- Field names posted from product form:
  - `hvip_fast_track_enabled`
  - `hvip_fast_track_quantity`
  - `hvip_fast_track_nonce`
- Consumed by Woo filters for validation and cart item data mapping.

### Admin Settings to Popup Display

- Source of truth option: `hvip_fast_track_popup_content`
- Admin writes via `update_option`
- Frontend modal reads via `get_option`

### Pricing to Cart Calculation

- `hvip_fast_track_total` is calculated when adding to cart
- Applied to line item in `woocommerce_before_calculate_totals`
- Prevents duplicate additions by locking base price once

### Cart Data to Checkout and Order

- Same stored keys are reused in:
  - `woocommerce_get_item_data` for display
  - `woocommerce_checkout_create_order_line_item` for persistence

---

## 6) Deployment Strategy (No Git)

## 6.1 Files to Copy to Live

Copy these files from development to live theme:

1. `wp-content/themes/heathrowvip/functions.php`
2. `wp-content/themes/heathrowvip/assets/js/fast-track.js`
3. `wp-content/themes/heathrowvip/style.css`

## 6.2 Pre-deployment Checks

- Confirm active theme on live is `heathrowvip`.
- Confirm WooCommerce product pages use standard add-to-cart flow.
- Ensure no conflicting manual edits in live `functions.php` around same hooks.
- Back up live copies of the three files before overwriting.

## 6.3 Database / Option Considerations

- No schema or table migration needed.
- Ensure option key exists/populated on live:
  - `hvip_fast_track_popup_content`
- You can set/update this from wp-admin:
  - `Settings > Fast Track Popup`

## 6.4 Risk Areas

- Missing or stale JS/CSS due to cache/CDN/minification.
- Hook order conflicts with other custom pricing logic.
- Arrival/Departure rate depends on product slug containing `arrival`:
  - arrival = 35
  - non-arrival = 25
- If script fails to load, UI toggle/modal behavior will not run.

---

## 7) Live Deployment Checklist

- [ ] Backup existing live files before replacing
- [ ] `functions.php` moved to live
- [ ] `assets/js/fast-track.js` moved to live
- [ ] `style.css` moved to live
- [ ] Theme cache / plugin cache / CDN cache purged
- [ ] `Settings > Fast Track Popup` appears in admin
- [ ] Popup content saved on live
- [ ] Product page shows Fast Track checkbox and helper link
- [ ] Quantity dropdown toggles on checkbox change
- [ ] Modal opens and closes correctly (link, close button, overlay, Esc)
- [ ] Add-to-cart works with security nonce validation
- [ ] Arrival pricing test: quantity x 35
- [ ] Departure pricing test: quantity x 25
- [ ] Cart/checkout show Fast Track rows
- [ ] Order item meta stores Fast Track data
- [ ] Recalculate cart does not duplicate Fast Track charge

---

## 8) Code Identification Keywords (Quick Search)

Search these terms to locate all related code quickly:

- `hvip_render_fast_track_field`
- `hvip_validate_fast_track_fields`
- `hvip_fast_track_add_cart_item_data`
- `hvip_fast_track_add_settings_page`
- `hvip_fast_track_render_settings_page`
- `hvip_enqueue_fast_track_script`
- `hvip_fast_track_enabled`
- `hvip_fast_track_quantity`
- `hvip_fast_track_total`
- `hvip_fast_track_popup_content`
- `hvip_fast_track_nonce_action`
- `hvip-fast-track-modal`
- `fast-track.js`

---

## 9) Functional Summary

Fast Track is implemented as an additional per-person service fee integrated through:

- Product frontend selection UI
- Admin-managed popup content
- Cart item metadata
- Dynamic WooCommerce price recalculation
- Cart and checkout display rows
- Order line item persistence

This provides full continuity from user selection through to order records, with validation and nonce protection in place.
