# ToyyibPay Integration Guide

This document explains how to set up and use the ToyyibPay payment integration in the Bookty e-commerce application.

## Overview

The ToyyibPay integration provides secure FPX (Financial Process Exchange) payment processing for Malaysian online banking. Customers can pay using their online banking credentials from major Malaysian banks.

## Setup Instructions

### 1. Environment Configuration

Add the following variables to your `.env` file:

```env
# ToyyibPay Configuration
TOYYIBPAY_SECRET_KEY=your_secret_key_here
TOYYIBPAY_CATEGORY_CODE=your_category_code_here
TOYYIBPAY_BASE_URL=https://toyyibpay.com
```

### 2. Getting ToyyibPay Credentials

1. **Register for ToyyibPay Account**: Visit [toyyibpay.com](https://toyyibpay.com) and create an account
2. **Get Secret Key**: Log into your ToyyibPay dashboard and obtain your User Secret Key
3. **Create Category**: Use the ToyyibPay API or dashboard to create a category for your bills
4. **Get Category Code**: Note down the category code returned after creation

### 3. Creating a Category (Optional)

If you need to create a category programmatically, you can use the ToyyibPayService:

```php
use App\Services\ToyyibPayService;

$toyyibPay = new ToyyibPayService();
$categoryCode = $toyyibPay->createCategory('Bookty Orders', 'E-commerce book orders');
```

## How It Works

### Payment Flow

1. **Customer Checkout**: Customer fills out shipping information and clicks "Proceed to Payment"
2. **Order Creation**: System creates an order with "pending" payment status
3. **Bill Creation**: ToyyibPay bill is created with order details
4. **Redirect**: Customer is redirected to ToyyibPay payment page
5. **Payment**: Customer completes payment using FPX online banking
6. **Callback**: ToyyibPay sends server-side notification to update order status
7. **Return**: Customer is redirected back to the application

### Callback Handling

The system handles two types of ToyyibPay notifications:

#### Server-side Callback (`/toyyibpay/callback`)
- **Method**: POST
- **Purpose**: Updates order status when payment is completed
- **Parameters**: 
  - `refno`: Payment reference number
  - `status`: Payment status (1=success, 2=pending, 3=failed)
  - `billcode`: ToyyibPay bill code
  - `order_id`: External reference number (order public ID)
  - `amount`: Payment amount
  - `transaction_time`: Transaction timestamp

#### Return URL (`/toyyibpay/return`)
- **Method**: GET
- **Purpose**: Redirects customer after payment
- **Parameters**:
  - `status_id`: Payment status
  - `billcode`: ToyyibPay bill code
  - `order_id`: External reference number

## Database Schema

The following fields have been added to the `orders` table:

```sql
toyyibpay_bill_code VARCHAR(255) NULL
toyyibpay_payment_url VARCHAR(255) NULL
toyyibpay_invoice_no VARCHAR(255) NULL
toyyibpay_payment_date TIMESTAMP NULL
toyyibpay_settlement_reference VARCHAR(255) NULL
toyyibpay_settlement_date TIMESTAMP NULL
```

## API Methods

### ToyyibPayService Methods

- `createCategory($name, $description)`: Create a new category
- `createBill($orderData)`: Create a payment bill
- `getBillTransactions($billCode, $status)`: Get transaction details
- `getCategoryDetails()`: Get category information
- `inactiveBill($billCode)`: Deactivate a bill
- `convertToCents($amount)`: Convert amount to cents
- `convertFromCents($cents)`: Convert cents to amount

### Order Model Methods

- `hasToyyibPayPayment()`: Check if order has ToyyibPay payment
- `getToyyibPayUrl()`: Get ToyyibPay payment URL
- `isToyyibPayPaid()`: Check if order is paid via ToyyibPay

## Testing

### Test Mode
ToyyibPay provides a sandbox environment for testing. Update your configuration:

```env
TOYYIBPAY_BASE_URL=https://dev.toyyibpay.com
```

### Test Payment Flow
1. Create a test order
2. Use test bank credentials provided by ToyyibPay
3. Verify callback handling
4. Check order status updates

## Security Considerations

1. **HTTPS Required**: ToyyibPay callbacks require HTTPS in production
2. **Callback Validation**: Always validate callback parameters
3. **Order Verification**: Verify order exists before updating status
4. **Logging**: All payment activities are logged for audit purposes

## Troubleshooting

### Common Issues

1. **Callback Not Received**
   - Ensure your server is accessible from the internet
   - Check HTTPS configuration
   - Verify callback URL is correct

2. **Payment Status Not Updated**
   - Check database connection
   - Verify order exists
   - Review error logs

3. **Redirect Issues**
   - Ensure return URL is properly configured
   - Check for JavaScript errors
   - Verify route definitions

### Debugging

Enable detailed logging by checking Laravel logs:

```bash
tail -f storage/logs/laravel.log
```

Look for ToyyibPay-related log entries with prefixes:
- `ToyyibPay Callback Received`
- `ToyyibPay Payment Success`
- `ToyyibPay Payment Failed`

## Support

For ToyyibPay-specific issues:
- Visit [toyyibpay.com](https://toyyibpay.com) documentation
- Contact ToyyibPay support

For application-specific issues:
- Check Laravel logs
- Review database records
- Verify configuration settings
