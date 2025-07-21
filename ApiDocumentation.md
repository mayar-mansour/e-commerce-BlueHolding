# API Documentation

## User Management

### Register

**Endpoint:** `POST /api/register`  
**Description:** Register a new user.  
**Parameters:**
- `name` (required): User's full name.
- `email` (required): User's email address (must be unique).
- `password` (required): User's password.
- `phone` (required): User's phone number.
- `push_token` (optional): Push notification token.
- `role` (optional): Role to be assigned to the user.

**Response:**
- `200 OK`: Successfully registered.
- `400 Bad Request`: Validation errors.

### Verify Email

**Endpoint:** `POST /api/verifyEmail`  
**Description:** Verify a user's email address using the verification code sent to their email.  
**Parameters:**
- `email` (required): User's email address.
- `verification_code` (required): Verification code sent to the user's email.

**Response:**
- `200 OK`: Successfully verified and logged in.
- `400 Bad Request`: Validation errors or invalid verification code.
- `401 Unauthorized`: Account not verified.

### Login

**Endpoint:** `POST /api/login`  
**Description:** Log in a user.  
**Parameters:**
- `phone` (required): User's phone number.
- `password` (required): User's password.

**Response:**
- `200 OK`: Successfully logged in.
- `400 Bad Request`: Validation errors.
- `401 Unauthorized`: Incorrect credentials or account not verified.

### Get Profile

**Endpoint:** `GET /api/getProfile`  
**Description:** Get the logged-in user's profile information.

**Response:**
- `200 OK`: User profile data.
- `404 Not Found`: User not found.

### Logout

**Endpoint:** `POST /api/logout`  
**Description:** Log out the current user.

**Response:**
- `200 OK`: Successfully logged out.

## Shipping Addresses

### List Shipping Addresses

**Endpoint:** `GET /api/ShippingAddress`  
**Description:** Get a list of the logged-in user's shipping addresses.

**Response:**
- `200 OK`: List of shipping addresses.
- `404 Not Found`: No shipping addresses found.

### View Shipping Address

**Endpoint:** `GET /api/ShippingAddress/{id}`  
**Description:** View details of a specific shipping address by ID.

**Parameters:**
- `id` (required): ID of the shipping address.

**Response:**
- `200 OK`: Shipping address details.
- `403 Forbidden`: Not authorized to view this shipping address.
- `404 Not Found`: Shipping address not found.

### Store Shipping Address

**Endpoint:** `POST /api/ShippingAddress`  
**Description:** Create a new shipping address for the logged-in user.

**Parameters:**
- `address` (required): Shipping address.
- `city_id` (required): City ID.
- `area_id` (required): Area ID.
- `lat` (required): Latitude.
- `lng` (required): Longitude.
- `additional_phone` (optional): Additional phone number.
- `distinct_mark` (optional): Distinct mark or landmark.

**Response:**
- `200 OK`: Shipping address created.
- `400 Bad Request`: Validation errors.
- `500 Internal Server Error`: Failed to create shipping address.

### Update Shipping Address

**Endpoint:** `PUT /api/ShippingAddress/{id}`  
**Description:** Update an existing shipping address by ID.

**Parameters:**
- `id` (required): ID of the shipping address.
- `address` (required): Shipping address.
- `city_id` (required): City ID.
- `area_id` (required): Area ID.
- `lat` (required): Latitude.
- `lng` (required): Longitude.
- `additional_phone` (optional): Additional phone number.
- `distinct_mark` (optional): Distinct mark or landmark.

**Response:**
- `200 OK`: Shipping address updated.
- `400 Bad Request`: Validation errors.
- `403 Forbidden`: Not authorized to update this shipping address.
- `404 Not Found`: Shipping address not found.

### Delete Shipping Address

**Endpoint:** `DELETE /api/ShippingAddress/{id}`  
**Description:** Delete a shipping address by ID.

**Parameters:**
- `id` (required): ID of the shipping address.

**Response:**
- `200 OK`: Shipping address deleted.
- `403 Forbidden`: Not authorized to delete this shipping address.
- `404 Not Found`: Shipping address not found.
- `500 Internal Server Error`: Failed to delete shipping address.

## Payment Management

### List Payment Methods

**Endpoint:** `GET /payment/listPaymentMethods`  
**Description:** Get a list of available payment methods.

**Response:**
- `200 OK`: List of payment methods.


## Role Management

### Assign Role

**Endpoint:** `POST /api/assignRole`  
**Description:** Assign a role to a user.

**Parameters:**
- `email` (required): User's email address.
- `role` (required): Role name.

**Response:**
- `200 OK`: Role assigned successfully.
- `400 Bad Request`: User already has this role or validation errors.
- `404 Not Found`: User not found.

### Revoke Role

**Endpoint:** `POST /api/revokeRole`  
**Description:** Revoke a role from a user.

**Parameters:**
- `email` (required): User's email address.
- `role` (required): Role name.

**Response:**
- `200 OK`: Role revoked successfully.
- `400 Bad Request`: User does not have this role or validation errors.
- `404 Not Found`: User not found.
# Product Management API

## Get Product Details

**Endpoint:** `GET /api/product/getProductDetails/{id}`  
**Description:** Get details of a specific product by ID.

**Parameters:**
- `id` (required): ID of the product.

**Response:**
- **200 OK**: Product details.
- **401 Unauthorized**: User not authenticated.
- **404 Not Found**: Product not found.

## Get All Products

**Endpoint:** `GET /api/product/getAllProducts`  
**Description:** Get a list of all products with pagination.

**Parameters:**
- `page` (optional): Page number for pagination.
- `per_page` (optional): Number of products per page.
- `filters` (optional): Filtering parameters (e.g., category, tag).

**Response:**
- **200 OK**: List of products.
- **401 Unauthorized**: User not authenticated.
- **204 No Content**: No products found.

## Create Product

**Endpoint:** `POST /api/product/createProduct`  
**Description:** Create a new product.

**Parameters:**
- `name` (required): Product name.
- `price` (required): Product price.
- `description` (optional): Product description.
- `images` (optional): Product images.
- `categories` (optional): List of category IDs.
- `tags` (optional): List of tag IDs.

**Response:**
- **201 Created**: Product created successfully.
- **401 Unauthorized**: User not authenticated.
- **400 Bad Request**: Validation errors.

## Update Product

**Endpoint:** `POST /api/product/updateProduct`  
**Description:** Update an existing product by ID.

**Parameters:**
- `id` (required): ID of the product.
- `name` (optional): Product name.
- `price` (optional): Product price.
- `description` (optional): Product description.
- `images` (optional): Product images.

**Response:**
- **200 OK**: Product updated successfully.
- **401 Unauthorized**: User not authenticated.
- **400 Bad Request**: Product not found or validation errors.

## Delete Product

**Endpoint:** `GET /api/product/deleteProduct/{id}`  
**Description:** Delete a product by ID.

**Parameters:**
- `id` (required): ID of the product.

**Response:**
- **200 OK**: Product deleted successfully.
- **401 Unauthorized**: User not authenticated.
- **404 Not Found**: Product not found.

## Search Product

**Endpoint:** `POST /api/product/searchForProduct`  
**Description:** Search for products by keyword.

**Parameters:**
- `keyword` (required): Search keyword.
- `items` (optional): Number of items to return.

**Response:**
- **200 OK**: List of products matching the keyword.
- **401 Unauthorized**: User not authenticated.
- **204 No Content**: No products found.


## Order Management

### Create Order

**Endpoint:** `POST /api/order/createOrder`  
**Description:** Create a new order and process payment.  
**Parameters:**
- `products` (required): List of product IDs to be included in the order.
- `status_id` (required): ID of the order status (must exist in `order_statuses` table).
- `shipping_address_id` (required): ID of the shipping address (must exist in `shipping_addresses` table).
- `payment_method_id` (required): ID of the payment method (must exist in `payment_methods` table).
- `stripe_payment_method` (optional): Payment method ID for Stripe.

**Response:**
- `200 OK`: Order created and payment processed successfully.
- `400 Bad Request`: Validation errors.
- `401 Unauthorized`: Order creation failed or user not authenticated.
- `500 Internal Server Error`: Payment processing failed.

### Show Orders

**Endpoint:** `GET /api/order/showOrders`  
**Description:** Retrieve a list of all orders.  
**Response:**
- `200 OK`: List of orders.

### List Of Orders

**Endpoint:** `GET /api/order/listOfOrders`  
**Description:** Retrieve a list of orders for the logged-in user with pagination.  
**Parameters:**
- `page` (optional): Page number for pagination.
- `per_page` (optional): Number of orders per page.

**Response:**
- `200 OK`: Paginated list of orders.
- `401 Unauthorized`: User not authenticated.

### Order Details

**Endpoint:** `GET /api/order/orderDetails/{order_id}`  
**Description:** Retrieve details of a specific order by ID.  
**Parameters:**
- `order_id` (required): ID of the order.

**Response:**
- `200 OK`: Order details.
- `400 Bad Request`: Invalid order ID.
- `404 Not Found`: Order not found.

### Update Order Status

**Endpoint:** `POST /api/order/updateOrderStatus`  
**Description:** Update the status of an order.  
**Parameters:**
- `order_id` (required): ID of the order.
- `status_id` (required): New status ID (must exist in `order_statuses` table).

**Response:**
- `200 OK`: Order status updated successfully.
- `400 Bad Request`: Invalid parameters or validation errors.
- `404 Not Found`: Order not found.
- `403 Forbidden`: Not authorized to update order status.


### Track Order

**Endpoint:** `GET /api/order/trackOrder/{order_id}`  
**Description:** Track the status of an order by ID.  
**Parameters:**
- `order_id` (required): ID of the order.

**Response:**
- `200 OK`: Order status.
- `404 Not Found`: Order not found.

### List Order Statuses

**Endpoint:** `GET /api/order/listOrderStatuses`  
**Description:** Get a list of all possible order statuses.  

**Response:**
- `200 OK`: List of order statuses.
- `401 Unauthorized`: User not authenticated.
### Cancel Order

**Endpoint:** `POST /api/order/cancelOrder`  
**Description:** Cancel an order.

**Parameters:**
- `order_id` (required): ID of the order.

**Response:**
- `200 OK`: Order canceled successfully.
- `401 Unauthorized`: User not authenticated.
- `403 Forbidden`: Not authorized to cancel this order.
- `404 Not Found`: Order not found.
