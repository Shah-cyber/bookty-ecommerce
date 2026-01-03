# ToyyibPay Error Troubleshooting Guide

## Error: "Failed to create ToyyibPay bill. Please try again."

This guide will help you diagnose and fix the ToyyibPay integration issue.

---

## 🔍 **Step 1: Check Your .env File**

Make sure these variables are set in your `.env` file:

```env
TOYYIBPAY_SECRET_KEY=your_secret_key_here
TOYYIBPAY_CATEGORY_CODE=your_category_code_here
```

**Important:**
- Remove any quotes around the values
- No spaces before or after the `=` sign
- Make sure there are no typos

---

## 🔍 **Step 2: Check Laravel Logs**

The error details are logged in `storage/logs/laravel.log`. Look for entries like:

```
[TIMESTAMP] local.ERROR: ToyyibPay Error: Failed to create bill
```

**To view logs:**
```bash
# Windows (PowerShell)
Get-Content storage\logs\laravel.log -Tail 50

# Or open the file directly
notepad storage\logs\laravel.log
```

**Look for:**
- `ToyyibPay API Response Body` - This shows the actual error from ToyyibPay
- `ToyyibPay API Error Message` - This shows the specific error message
- `ToyyibPay Configuration Missing` - If credentials are missing

---

## 🔍 **Step 3: Common Error Messages & Solutions**

### **Error: "ToyyibPay configuration is missing"**
**Solution:**
1. Check your `.env` file has `TOYYIBPAY_SECRET_KEY` and `TOYYIBPAY_CATEGORY_CODE`
2. Run `php artisan config:clear` to clear config cache
3. Restart your server

### **Error: "Invalid userSecretKey" or "Invalid categoryCode"**
**Solution:**
1. Verify your credentials in ToyyibPay dashboard
2. Make sure you're using the correct environment (dev vs production)
3. Check if your account is activated

### **Error: "Category not found"**
**Solution:**
1. Create a category in ToyyibPay dashboard
2. Use the correct category code
3. Make sure the category is active

### **Error: "Connection timeout" or "Unable to connect"**
**Solution:**
1. Check your internet connection
2. Verify ToyyibPay API is accessible: `https://dev.toyyibpay.com`
3. Check firewall settings
4. Try using production URL if dev is down

### **Error: "Invalid phone number format"**
**Solution:**
- Phone number should be in Malaysian format
- Examples: `0123456789`, `+60123456789`, `60123456789`
- The system will auto-format it, but make sure it's a valid Malaysian number

---

## 🔍 **Step 4: Test Your Configuration**

Create a test route to verify your configuration:

```php
// Add this to routes/web.php temporarily
Route::get('/test-toyyibpay', function() {
    $secretKey = config('services.toyyibpay.secret_key');
    $categoryCode = config('services.toyyibpay.category_code');
    
    return [
        'has_secret_key' => !empty($secretKey),
        'has_category_code' => !empty($categoryCode),
        'secret_key_length' => strlen($secretKey ?? ''),
        'category_code_length' => strlen($categoryCode ?? ''),
    ];
})->middleware('auth');
```

Visit `/test-toyyibpay` and check:
- `has_secret_key` should be `true`
- `has_category_code` should be `true`
- Both should have reasonable lengths (not 0)

---

## 🔍 **Step 5: Check ToyyibPay Dashboard**

1. **Login to ToyyibPay Dashboard**
   - Dev: https://dev.toyyibpay.com
   - Production: https://toyyibpay.com

2. **Verify:**
   - Your account is active
   - You have a category created
   - The category code matches your `.env` file
   - Your secret key is correct

---

## 🔍 **Step 6: Test API Directly**

You can test the API directly using curl or Postman:

```bash
curl -X POST https://dev.toyyibpay.com/index.php/api/createBill \
  -d "userSecretKey=YOUR_SECRET_KEY" \
  -d "categoryCode=YOUR_CATEGORY_CODE" \
  -d "billName=Test Bill" \
  -d "billDescription=Test" \
  -d "billPriceSetting=1" \
  -d "billPayorInfo=1" \
  -d "billAmount=5300" \
  -d "billReturnUrl=http://localhost/return" \
  -d "billCallbackUrl=http://localhost/callback" \
  -d "billExternalReferenceNo=TEST123" \
  -d "billTo=Test User" \
  -d "billEmail=test@example.com" \
  -d "billPhone=+60123456789" \
  -d "billPaymentChannel=0" \
  -d "billChargeToCustomer=0" \
  -d "billExpiryDays=3"
```

**Expected Response (Success):**
```json
[{
  "BillCode": "abc123xyz",
  "BillName": "Test Bill",
  ...
}]
```

**Expected Response (Error):**
```json
[{
  "code": "1",
  "msg": "Invalid userSecretKey"
}]
```

---

## 🔧 **Quick Fixes**

### **Fix 1: Clear Config Cache**
```bash
php artisan config:clear
php artisan cache:clear
```

### **Fix 2: Restart Server**
```bash
# If using Laragon, restart Apache/Nginx
# Or restart your development server
```

### **Fix 3: Check .env File Format**
Make sure your `.env` file looks like this:
```env
TOYYIBPAY_SECRET_KEY=sk_live_xxxxxxxxxxxxx
TOYYIBPAY_CATEGORY_CODE=xxxxxxxxxxxxx
```

**NOT like this:**
```env
TOYYIBPAY_SECRET_KEY="sk_live_xxxxxxxxxxxxx"  # ❌ No quotes
TOYYIBPAY_SECRET_KEY = sk_live_xxxxxxxxxxxxx   # ❌ No spaces
```

---

## 📝 **What Was Fixed in the Code**

The code has been improved to:
1. ✅ Better error message extraction from ToyyibPay API
2. ✅ Proper handling of API errors (even when HTTP status is 200)
3. ✅ Connection timeout handling
4. ✅ Better logging for debugging
5. ✅ Validation of required fields before API call

---

## 🆘 **Still Having Issues?**

1. **Check the logs** - `storage/logs/laravel.log` will show the exact error
2. **Check ToyyibPay dashboard** - Verify your account and category
3. **Test with curl** - Use the curl command above to test directly
4. **Contact ToyyibPay support** - If credentials are correct but still failing

---

## 📞 **Need Help?**

Share these details when asking for help:
1. Error message from logs
2. Your `.env` configuration (hide the actual keys!)
3. Response from ToyyibPay API (from logs)
4. Whether you're using dev or production environment

