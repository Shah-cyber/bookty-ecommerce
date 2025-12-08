# Bookty E-Commerce - Use Case Diagram Summary

## 📊 Quick Reference

### Actors (5)
1. **Guest** - Unauthenticated visitor
2. **Customer** - Authenticated user
3. **Admin** - Store administrator
4. **SuperAdmin** - System administrator
5. **Payment Gateway** - External payment system (ToyyibPay)

---

## 📋 Use Cases by Actor

### 👤 Guest (8 use cases)
```
┌─────────────────────────┐
│   Guest Use Cases       │
├─────────────────────────┤
│ • Browse Books          │
│ • View Book Details     │
│ • Search Books          │
│ • Filter Books          │
│ • View About Page       │
│ • Register Account      │
│ • Login                 │
│ • Google OAuth Login   │
└─────────────────────────┘
```

### 👤 Customer (20 use cases total)
```
┌──────────────────────────────┐
│   Customer Use Cases        │
├──────────────────────────────┤
│ All Guest Use Cases +        │
│                              │
│ • Manage Profile             │
│ • Add to Cart               │
│ • Update Cart               │
│ • Remove from Cart          │
│ • View Cart                 │
│ • Add to Wishlist           │
│ • Remove from Wishlist      │
│ • View Wishlist             │
│ • Checkout                  │
│ • Apply Coupon              │
│ • Calculate Shipping        │
│ • View Order History        │
│ • View Order Details        │
│ • Download Invoice           │
│ • Write Review              │
│ • Upload Review Images      │
│ • Mark Review as Helpful    │
│ • Report Review             │
│ • View Recommendations       │
│ • Process Payment           │
└──────────────────────────────┘
```

### 👤 Admin (22 use cases total)
```
┌──────────────────────────────┐
│   Admin Use Cases            │
├──────────────────────────────┤
│ All Customer Use Cases +     │
│                              │
│ • View Dashboard             │
│ • Manage Books              │
│ • Manage Genres             │
│ • Manage Tropes             │
│ • Manage Orders             │
│ • Update Order Status       │
│ • View Customers            │
│ • Manage Discounts          │
│ • Manage Coupons            │
│ • Manage Flash Sales        │
│ • View Sales Reports        │
│ • View Customer Reports     │
│ • View Inventory Reports    │
│ • View Promotion Reports    │
│ • View Shipping Reports     │
│ • View Profitability Reports│
│ • Export Reports            │
│ • Manage Review Reports     │
│ • View Review Analytics     │
│ • Manage Postage Rates      │
│ • View Recommendation       │
│   Analytics                 │
│ • Manage System Settings    │
└──────────────────────────────┘
```

### 👤 SuperAdmin (5 use cases total)
```
┌──────────────────────────────┐
│   SuperAdmin Use Cases       │
├──────────────────────────────┤
│ All Admin Use Cases +        │
│                              │
│ • Manage Admins              │
│ • Manage Roles               │
│ • Manage Permissions         │
│ • View System Health         │
│ • Configure System Settings  │
└──────────────────────────────┘
```

### 🔌 Payment Gateway (2 use cases)
```
┌──────────────────────────────┐
│   Payment Gateway Use Cases  │
├──────────────────────────────┤
│ • Process Payment Callback   │
│ • Return Payment Status      │
└──────────────────────────────┘
```

---

## 🔗 Use Case Relationships

### Include Relationships (Required)
```
Checkout
  ├─► includes → Apply Coupon
  ├─► includes → Calculate Shipping
  └─► includes → Process Payment
      └─► includes → Process Payment Callback

Write Review
  └─► includes → Upload Review Images
```

### Extend Relationships (Optional)
```
Manage Books
  ├─► extends → Manage Genres (optional)
  └─► extends → Manage Tropes (optional)

Manage Orders
  └─► extends → Update Order Status (optional)

View Sales Reports
  └─► extends → Export Reports (optional)

View Customer Reports
  └─► extends → Export Reports (optional)

View Inventory Reports
  └─► extends → Export Reports (optional)

View Promotion Reports
  └─► extends → Export Reports (optional)

View Shipping Reports
  └─► extends → Export Reports (optional)

View Profitability Reports
  └─► extends → Export Reports (optional)
```

---

## 📊 Statistics

| Category | Count |
|----------|-------|
| **Total Use Cases** | 57 |
| **Guest Use Cases** | 8 |
| **Customer Use Cases** | 20 (includes Guest) |
| **Admin Use Cases** | 22 (includes Customer) |
| **SuperAdmin Use Cases** | 5 (includes Admin) |
| **Payment Gateway Use Cases** | 2 |
| **Include Relationships** | 5 |
| **Extend Relationships** | 9 |

---

## 🎯 Actor Inheritance

```
Guest (Base)
  │
  ├─► Customer (inherits Guest)
  │     │
  │     ├─► Admin (inherits Customer)
  │     │     │
  │     │     └─► SuperAdmin (inherits Admin)
  │     │
  │     └─► (Customer remains independent)
  │
  └─► Payment Gateway (independent)
```

**Note:** Each level inherits all use cases from previous levels.

---

## 📁 Files Created

1. **`USE_CASE_DIAGRAM.md`** - Complete documentation with PlantUML and Mermaid diagrams
2. **`USE_CASE_DIAGRAM.puml`** - Standalone PlantUML file for direct use
3. **`USE_CASE_SUMMARY.md`** - This file (quick reference)

---

## 🛠️ How to Use

### View PlantUML Diagram:
1. **VS Code**: Install "PlantUML" extension, open `.puml` file, press `Alt+D`
2. **Online**: Go to http://www.plantuml.com/plantuml/uml/ and paste PlantUML code
3. **IntelliJ IDEA**: Right-click `.puml` file → "Diagrams" → "Show Diagram"

### View Mermaid Diagram:
1. **GitHub**: Paste Mermaid code in README.md
2. **VS Code**: Install "Markdown Preview Mermaid Support" extension
3. **Online**: Go to https://mermaid.live/ and paste Mermaid code

---

## 📝 Key Notes

1. **Actor Hierarchy**: Customer inherits Guest, Admin inherits Customer, SuperAdmin inherits Admin
2. **Authentication**: Most customer use cases require login
3. **Role-Based Access**: Admin and SuperAdmin use cases protected by middleware
4. **Payment Integration**: External system (ToyyibPay) handles payment processing
5. **Use Case Relationships**: Include = required, Extend = optional

---

For complete details, see **`USE_CASE_DIAGRAM.md`** 📖

