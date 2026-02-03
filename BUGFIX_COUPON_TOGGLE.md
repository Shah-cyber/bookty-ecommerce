# Bug Fix: Coupon Free Shipping Toggle Not Updating

**Date**: January 2026  
**Severity**: High  
**Status**: ✅ Fixed

---

## 🐛 Problem

When editing a coupon and toggling "Offer Free Shipping" from **ON** to **OFF**, the admin interface showed "Coupon updated successfully" but the database value remained `free_shipping = 1` (unchanged).

### User Report
- Created coupon "DD10" with free shipping **ON**
- Tried to edit and turn free shipping **OFF**
- Database still showed `free_shipping = 1` after update
- Same issue with `is_active` toggle

---

## 🔍 Root Cause

**Location**: `app/Http/Controllers/Admin/CouponController.php`

### The Bug

**Lines 60 & 119** used `$request->has()` to check toggle values:

```php
// WRONG ❌
$coupon->free_shipping = $request->has('free_shipping') ? true : false;
$coupon->is_active = $request->has('is_active') ? true : false;
```

### Why This Failed

The form uses a **hidden input + checkbox pattern**:

```html
<!-- Hidden input always sends "0" -->
<input type="hidden" name="free_shipping" value="0">

<!-- Checkbox sends "1" when checked, nothing when unchecked -->
<input type="checkbox" name="free_shipping" value="1" {{ $coupon->free_shipping ? 'checked' : '' }}>
```

**When Toggle is ON**:
- Hidden: `free_shipping=0`
- Checkbox: `free_shipping=1` ✅ (overrides hidden)
- `$request->has('free_shipping')` returns `true`
- Result: `free_shipping = true` ✅ **CORRECT**

**When Toggle is OFF**:
- Hidden: `free_shipping=0`
- Checkbox: (not sent)
- `$request->has('free_shipping')` returns `true` ❌ (hidden input exists!)
- Result: `free_shipping = true` ❌ **WRONG! Should be false**

### The Problem

`$request->has('field')` checks if the field **exists**, not its **value**.

Since the hidden input is always present, `has()` always returns `true`, so the toggle is always set to `true` regardless of the checkbox state!

---

## ✅ Solution

Replace `$request->has()` with `$request->boolean()`:

### Store Method (Line 60)

**Before** ❌:
```php
$coupon->free_shipping = $request->has('free_shipping') ? true : false;
```

**After** ✅:
```php
$coupon->free_shipping = $request->boolean('free_shipping');
```

---

### Update Method (Lines 118-119)

**Before** ❌:
```php
$coupon->is_active = $request->has('is_active') ? true : false;
$coupon->free_shipping = $request->has('free_shipping') ? true : false;
```

**After** ✅:
```php
$coupon->is_active = $request->boolean('is_active');
$coupon->free_shipping = $request->boolean('free_shipping');
```

---

## 🔧 How `$request->boolean()` Works

Laravel's `boolean()` method:

1. Checks if field exists
2. Reads its value
3. Returns boolean based on value:
   - `"1"`, `"true"`, `1`, `true` → `true`
   - `"0"`, `"false"`, `0`, `false`, `null` → `false`

```php
// Examples:
$request->boolean('free_shipping')  // "1" → true
$request->boolean('free_shipping')  // "0" → false
$request->boolean('free_shipping')  // null → false
$request->boolean('missing_field')  // → false (doesn't exist)
```

---

## 🧪 Test Scenarios

### Test 1: Create Coupon with Free Shipping ON

**Steps**:
1. Admin → Coupons → Create
2. Set discount: RM 10
3. Toggle "Offer Free Shipping" **ON** (green)
4. Click "Create Coupon"

**Expected**:
- Database: `free_shipping = 1` ✅
- API response includes `"free_shipping": true` ✅

---

### Test 2: Create Coupon with Free Shipping OFF

**Steps**:
1. Admin → Coupons → Create
2. Set discount: RM 10
3. Keep "Offer Free Shipping" **OFF** (gray)
4. Click "Create Coupon"

**Expected**:
- Database: `free_shipping = 0` ✅
- Shipping charged normally at checkout ✅

---

### Test 3: Update Coupon from ON to OFF ⭐ (Main Bug)

**Steps**:
1. Edit coupon "DD10" (currently `free_shipping = 1`)
2. Toggle "Offer Free Shipping" **OFF**
3. Click "Update Coupon"
4. Check database

**Before Fix**:
- Database: `free_shipping = 1` ❌ (unchanged)

**After Fix**:
- Database: `free_shipping = 0` ✅ (correctly updated)

---

### Test 4: Update Coupon from OFF to ON

**Steps**:
1. Edit coupon with `free_shipping = 0`
2. Toggle "Offer Free Shipping" **ON**
3. Click "Update Coupon"

**Expected**:
- Database: `free_shipping = 1` ✅
- Works correctly before AND after fix

---

### Test 5: Update Active Status

**Steps**:
1. Edit coupon with `is_active = 1`
2. Uncheck "Active" checkbox
3. Click "Update Coupon"

**Before Fix**:
- Database: `is_active = 1` ❌ (unchanged)

**After Fix**:
- Database: `is_active = 0` ✅ (correctly updated)

---

## 📊 Impact Analysis

### What Was Broken

| Action | Before Fix | After Fix |
|--------|------------|-----------|
| Create with free_shipping ON | ✅ Works | ✅ Works |
| Create with free_shipping OFF | ❌ Sets to ON | ✅ Works |
| Update from ON to OFF | ❌ Stays ON | ✅ Works |
| Update from OFF to ON | ✅ Works | ✅ Works |
| Update is_active from ON to OFF | ❌ Stays ON | ✅ Works |
| Update is_active from OFF to ON | ✅ Works | ✅ Works |

### Severity

**High** - Admins cannot disable free shipping once enabled

**User Impact**:
- Coupons always have free shipping if ever turned ON
- Cannot create discount-only coupons after initial save
- Workaround: Delete and recreate coupon (loses usage history)

---

## 📝 Best Practices Learned

### 1. **Always Use `boolean()` for Toggles**

```php
// ❌ DON'T
$model->flag = $request->has('flag') ? true : false;
$model->flag = $request->get('flag') ? true : false;

// ✅ DO
$model->flag = $request->boolean('flag');
```

---

### 2. **Understand Hidden Input + Checkbox Pattern**

```html
<!-- This pattern ensures checkbox always sends a value -->
<input type="hidden" name="field" value="0">
<input type="checkbox" name="field" value="1">

<!-- But requires proper handling in controller! -->
```

**Why use this pattern?**
- HTML checkboxes send nothing when unchecked
- Hidden input ensures a value is always sent
- Prevents field from being missing in request

---

### 3. **Laravel Request Helper Methods**

```php
// Check existence (not value)
$request->has('field')           // true if exists, regardless of value

// Get boolean value (recommended for toggles)
$request->boolean('field')       // true/false based on value

// Get value with default
$request->input('field', false)  // returns value or default

// Get filled value
$request->filled('field')        // true if exists and not empty
```

---

## 🔄 Related Files

### Modified Files

1. **`app/Http/Controllers/Admin/CouponController.php`**
   - Line 60: Fixed `store()` method - free_shipping
   - Line 118: Fixed `update()` method - is_active
   - Line 119: Fixed `update()` method - free_shipping

### No Changes Required

2. **`resources/views/admin/coupons/create.blade.php`**
   - Form already correct ✅
   
3. **`resources/views/admin/coupons/edit.blade.php`**
   - Form already correct ✅

4. **`app/Models/Coupon.php`**
   - Model already correct ✅

---

## ✅ Verification

### Database Check

```sql
-- Before Fix: Try to update DD10 from free_shipping=1 to free_shipping=0
SELECT id, code, free_shipping FROM coupons WHERE code = 'DD10';
-- Result: free_shipping still = 1 ❌

-- After Fix: Try same update
SELECT id, code, free_shipping FROM coupons WHERE code = 'DD10';
-- Result: free_shipping now = 0 ✅
```

---

### Admin Panel Test

1. ✅ Create coupon with free shipping OFF → Database shows 0
2. ✅ Create coupon with free shipping ON → Database shows 1
3. ✅ Update coupon from ON to OFF → Database changes to 0
4. ✅ Update coupon from OFF to ON → Database changes to 1
5. ✅ Toggle Active status → Works correctly

---

## 📚 Documentation Created

1. ✅ `BUGFIX_COUPON_TOGGLE.md` (this file)
2. ✅ `COUPON_SYSTEM_GUIDE.md` (comprehensive guide)
3. ✅ `BUGFIX_COUPON_VALIDATION.md` (previous validation fixes)

---

## 🎯 Summary

| Aspect | Detail |
|--------|--------|
| **Bug** | Toggle always set to ON due to `has()` |
| **Root Cause** | Hidden input always exists, `has()` always true |
| **Fix** | Use `$request->boolean()` instead |
| **Lines Changed** | 3 lines in CouponController |
| **Impact** | Critical - affects all toggle updates |
| **Risk** | Low - simple method replacement |
| **Testing** | Verified all toggle scenarios |

---

## 🚀 Deployment

**Changes Required**: 
- Update `app/Http/Controllers/Admin/CouponController.php`

**No Database Changes**: ✅

**Backward Compatible**: ✅

**Cache Clear**: Not required

**Testing**: Test coupon create/edit with toggles

---

**Status**: ✅ **RESOLVED**

All coupon toggles now work correctly! Admins can freely enable/disable free shipping and active status.
