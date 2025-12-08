# Reports Graphs Guide: Data Distribution & Target Tracking

## 📊 Overview

This guide provides detailed suggestions for adding **data distribution graphs** and **target vs actual comparison graphs** to your reports section. These visualizations will help admins understand data patterns and track performance against goals.

---

## 🎯 Types of Graphs to Add

### 1. **Data Distribution Graphs**
Show how data is spread across different categories, ranges, or segments.

### 2. **Target vs Actual Graphs**
Compare current performance against predefined targets/goals.

---

## 📈 Detailed Graph Suggestions by Report Section

---

## 1. SALES REPORTS (`admin.reports.sales`)

### A. Revenue Distribution Graph

#### **Histogram: Revenue Distribution by Price Range**
**Purpose**: Shows how sales are distributed across different price ranges.

**What it shows**:
- Number of orders in each price range (e.g., RM 0-20, RM 21-40, RM 41-60, etc.)
- Identifies which price points are most popular
- Helps understand customer spending patterns

**Data needed**:
```php
// In ReportsController::sales()
$revenueDistribution = $this->getRevenueDistribution($startDate, $endDate);

// Helper method
private function getRevenueDistribution($startDate, $endDate) {
    return Order::where('status', 'completed')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->selectRaw('
            CASE 
                WHEN total_amount < 20 THEN "RM 0-20"
                WHEN total_amount < 40 THEN "RM 21-40"
                WHEN total_amount < 60 THEN "RM 41-60"
                WHEN total_amount < 80 THEN "RM 61-80"
                WHEN total_amount < 100 THEN "RM 81-100"
                ELSE "RM 100+"
            END as price_range,
            COUNT(*) as order_count,
            SUM(total_amount) as total_revenue
        ')
        ->groupBy('price_range')
        ->orderByRaw('MIN(total_amount)')
        ->get();
}
```

**Graph Type**: Bar Chart (Horizontal or Vertical)
**Chart.js Configuration**:
```javascript
{
    type: 'bar',
    data: {
        labels: ['RM 0-20', 'RM 21-40', 'RM 41-60', 'RM 61-80', 'RM 81-100', 'RM 100+'],
        datasets: [{
            label: 'Number of Orders',
            data: [orderCounts],
            backgroundColor: 'rgba(99, 102, 241, 0.6)',
            borderColor: 'rgba(99, 102, 241, 1)',
            borderWidth: 1
        }]
    }
}
```

---

#### **Pie Chart: Sales Distribution by Genre**
**Purpose**: Visual representation of which genres contribute most to sales.

**What it shows**:
- Percentage of total revenue by genre
- Identifies top-performing genres
- Helps with inventory planning

**Data needed**: Already available in `$salesByGenre`
**Graph Type**: Pie Chart or Donut Chart
**Implementation**: Replace the placeholder in `sales.blade.php` line 308

---

### B. Target vs Actual: Sales Performance

#### **Line Chart: Revenue Target vs Actual**
**Purpose**: Compare actual revenue against monthly/quarterly targets.

**What it shows**:
- Actual revenue (line)
- Target revenue (dashed line)
- Gap analysis (how far ahead/behind)
- Trend over time

**Data needed**:
```php
// Add to database: settings table or targets table
// Create migration for targets
Schema::create('revenue_targets', function (Blueprint $table) {
    $table->id();
    $table->string('period'); // 'monthly', 'quarterly', 'yearly'
    $table->date('period_date'); // e.g., '2025-01-01' for January 2025
    $table->decimal('target_amount', 10, 2);
    $table->timestamps();
});

// In ReportsController
private function getRevenueTargetsVsActual($startDate, $endDate) {
    $actual = $this->getRevenueOverTime($startDate, $endDate, 'monthly');
    
    $targets = DB::table('revenue_targets')
        ->whereBetween('period_date', [$startDate, $endDate])
        ->where('period', 'monthly')
        ->get()
        ->keyBy(function($item) {
            return Carbon::parse($item->period_date)->format('Y-m');
        });
    
    return $actual->map(function($item) use ($targets) {
        $target = $targets->get($item->period);
        return [
            'period' => $item->period,
            'actual' => $item->revenue,
            'target' => $target ? $target->target_amount : null,
            'variance' => $target ? ($item->revenue - $target->target_amount) : null,
            'variance_percent' => $target && $target->target_amount > 0 
                ? (($item->revenue - $target->target_amount) / $target->target_amount) * 100 
                : null
        ];
    });
}
```

**Graph Type**: Dual Line Chart
**Chart.js Configuration**:
```javascript
{
    type: 'line',
    data: {
        labels: periods,
        datasets: [
            {
                label: 'Actual Revenue',
                data: actualRevenue,
                borderColor: 'rgb(99, 102, 241)',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                tension: 0.4
            },
            {
                label: 'Target Revenue',
                data: targetRevenue,
                borderColor: 'rgb(239, 68, 68)',
                borderDash: [5, 5],
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.4
            }
        ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
}
```

---

#### **Gauge Chart: Sales Target Achievement**
**Purpose**: Visual indicator showing percentage of target achieved.

**What it shows**:
- Current period target achievement (e.g., 85% of monthly target)
- Quick visual indicator (green = on track, red = behind)
- Percentage remaining

**Graph Type**: Gauge/Donut Chart (with percentage in center)
**Use Case**: Dashboard widget showing current month progress

---

## 2. CUSTOMER REPORTS (`admin.reports.customers`)

### A. Customer Distribution Graphs

#### **Histogram: Customer Spending Distribution**
**Purpose**: Shows how customer spending is distributed (low, medium, high spenders).

**What it shows**:
- Number of customers in each spending bracket
- Identifies customer segments
- Helps with marketing targeting

**Data needed**:
```php
private function getCustomerSpendingDistribution($startDate, $endDate) {
    $customers = User::role('customer')
        ->whereHas('orders', function($query) use ($startDate, $endDate) {
            $query->where('status', 'completed')
                  ->whereBetween('created_at', [$startDate, $endDate]);
        })
        ->withSum(['orders as total_spent' => function($query) use ($startDate, $endDate) {
            $query->where('status', 'completed')
                  ->whereBetween('created_at', [$startDate, $endDate]);
        }], 'total_amount')
        ->get();
    
    $avgSpent = $customers->avg('total_spent') ?? 0;
    
    return [
        'low' => $customers->where('total_spent', '<', $avgSpent * 0.5)->count(),
        'medium_low' => $customers->whereBetween('total_spent', [$avgSpent * 0.5, $avgSpent])->count(),
        'medium_high' => $customers->whereBetween('total_spent', [$avgSpent, $avgSpent * 1.5])->count(),
        'high' => $customers->where('total_spent', '>', $avgSpent * 1.5)->count(),
    ];
}
```

**Graph Type**: Bar Chart or Pie Chart
**Labels**: ['Low Spenders', 'Medium-Low', 'Medium-High', 'High Spenders']

---

#### **Bar Chart: Customer Acquisition Distribution**
**Purpose**: Shows when customers joined (distribution over time).

**What it shows**:
- Number of new customers per month
- Growth trends
- Seasonal patterns

**Data needed**:
```php
private function getCustomerAcquisitionDistribution($startDate, $endDate) {
    return User::role('customer')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderBy('month')
        ->get();
}
```

**Graph Type**: Bar Chart (Time Series)

---

### B. Target vs Actual: Customer Growth

#### **Line Chart: Customer Acquisition Target vs Actual**
**Purpose**: Compare new customer acquisition against targets.

**What it shows**:
- Actual new customers per month
- Target new customers per month
- Growth rate vs target

**Data needed**: Similar to revenue targets, but for customer acquisition

---

## 3. INVENTORY REPORTS (`admin.reports.inventory`)

### A. Inventory Distribution Graphs

#### **Histogram: Stock Level Distribution**
**Purpose**: Shows distribution of books across stock levels.

**What it shows**:
- Number of books in each stock range (0, 1-10, 11-50, 51-100, 100+)
- Identifies inventory health
- Highlights reorder needs

**Data needed**:
```php
private function getStockLevelDistribution() {
    return Book::selectRaw('
        CASE 
            WHEN stock = 0 THEN "Out of Stock"
            WHEN stock <= 10 THEN "Low Stock (1-10)"
            WHEN stock <= 50 THEN "Medium Stock (11-50)"
            WHEN stock <= 100 THEN "Good Stock (51-100)"
            ELSE "High Stock (100+)"
        END as stock_level,
        COUNT(*) as book_count,
        SUM(stock) as total_stock
    ')
    ->groupBy('stock_level')
    ->get();
}
```

**Graph Type**: Bar Chart or Pie Chart

---

#### **Scatter Plot: Stock vs Sales Velocity**
**Purpose**: Shows relationship between stock levels and sales speed.

**What it shows**:
- Books with high stock but low sales (dead stock)
- Books with low stock but high sales (need reorder)
- Optimal stock levels

**Graph Type**: Scatter Plot
**X-axis**: Current Stock
**Y-axis**: Units Sold (last 30 days)

---

### B. Target vs Actual: Inventory Targets

#### **Gauge Chart: Inventory Turnover Rate**
**Purpose**: Shows actual inventory turnover vs target.

**What it shows**:
- Current turnover rate
- Target turnover rate
- Performance indicator

---

## 4. PROMOTIONS REPORTS (`admin.reports.promotions`)

### A. Promotion Distribution Graphs

#### **Bar Chart: Coupon Usage Distribution**
**Purpose**: Shows which coupon codes are used most frequently.

**What it shows**:
- Usage count per coupon
- Most effective coupons
- Underutilized coupons

**Data needed**: Already available in `$couponStats`

---

#### **Pie Chart: Promotion Type Distribution**
**Purpose**: Shows revenue distribution across promotion types (Coupons, Flash Sales, Discounts).

**What it shows**:
- Which promotion type drives most sales
- Revenue share by promotion type

---

### B. Target vs Actual: Promotion Performance

#### **Bar Chart: Promotion ROI Target vs Actual**
**Purpose**: Compare promotion ROI against targets.

**What it shows**:
- Expected ROI from promotion
- Actual ROI achieved
- Performance gap

---

## 5. PROFITABILITY REPORTS (`admin.reports.profitability`)

### A. Profit Distribution Graphs

#### **Histogram: Profit Margin Distribution**
**Purpose**: Shows distribution of profit margins across products.

**What it shows**:
- Number of books in each margin range (0-10%, 11-20%, 21-30%, etc.)
- Identifies high/low margin products
- Helps with pricing strategy

**Data needed**:
```php
private function getProfitMarginDistribution($startDate, $endDate) {
    return DB::table('books')
        ->join('order_items', 'books.id', '=', 'order_items.book_id')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->where('orders.status', 'completed')
        ->whereBetween('orders.created_at', [$startDate, $endDate])
        ->whereNotNull('order_items.cost_price')
        ->where('order_items.cost_price', '>', 0)
        ->selectRaw('
            CASE 
                WHEN ((order_items.total_selling - order_items.total_cost) / order_items.total_selling * 100) < 10 THEN "0-10%"
                WHEN ((order_items.total_selling - order_items.total_cost) / order_items.total_selling * 100) < 20 THEN "11-20%"
                WHEN ((order_items.total_selling - order_items.total_cost) / order_items.total_selling * 100) < 30 THEN "21-30%"
                ELSE "30%+"
            END as margin_range,
            COUNT(DISTINCT books.id) as book_count
        ')
        ->groupBy('margin_range')
        ->get();
}
```

**Graph Type**: Bar Chart

---

#### **Box Plot: Profit Margin by Genre**
**Purpose**: Shows profit margin distribution within each genre.

**What it shows**:
- Median profit margin per genre
- Range of margins (min, max, quartiles)
- Outliers (books with unusually high/low margins)

**Graph Type**: Box Plot (if using Chart.js, use bar chart with error bars)

---

### B. Target vs Actual: Profitability Targets

#### **Line Chart: Monthly Profit Target vs Actual**
**Purpose**: Compare monthly profit against targets.

**What it shows**:
- Actual profit per month
- Target profit per month
- Variance analysis

**Data needed**: Similar structure to revenue targets

---

## 6. SHIPPING REPORTS (`admin.reports.shipping`)

### A. Shipping Distribution Graphs

#### **Bar Chart: Order Status Distribution**
**Purpose**: Shows distribution of orders across statuses.

**What it shows**:
- Number of orders in each status (pending, processing, shipped, completed, cancelled)
- Identifies bottlenecks
- Helps with fulfillment planning

**Data needed**: Already available in `$ordersByStatus`

---

#### **Histogram: Shipping Time Distribution**
**Purpose**: Shows distribution of shipping times.

**What it shows**:
- Number of orders in each shipping time range (1 day, 2-3 days, 4-5 days, 6+ days)
- Identifies delivery performance
- Highlights areas for improvement

---

### B. Target vs Actual: Shipping Performance

#### **Gauge Chart: Average Shipping Time Target**
**Purpose**: Compare actual shipping time against target (e.g., target: 3 days).

**What it shows**:
- Current average shipping time
- Target shipping time
- Performance indicator

---

## 🎨 Implementation Recommendations

### Chart Library
**Recommended**: **ApexCharts** (already used in your sales report) or **Chart.js**

### Color Scheme
- **Actual Data**: Blue/Purple (`#7c3aed` or `#6366f1`)
- **Target Data**: Red/Orange (`#ef4444` or `#f97316`)
- **Distribution**: Use gradient colors for different segments

### Graph Placement
1. **Distribution Graphs**: Add below existing tables/charts
2. **Target vs Actual**: Add as prominent section at top or side
3. **Gauge Charts**: Use as dashboard widgets

---

## 📝 Database Schema for Targets

```php
// Migration: create_revenue_targets_table.php
Schema::create('revenue_targets', function (Blueprint $table) {
    $table->id();
    $table->string('type'); // 'revenue', 'customers', 'orders', 'profit'
    $table->string('period'); // 'daily', 'monthly', 'quarterly', 'yearly'
    $table->date('period_date'); // The specific period (e.g., 2025-01-01 for January 2025)
    $table->decimal('target_amount', 10, 2);
    $table->text('notes')->nullable();
    $table->timestamps();
    
    $table->unique(['type', 'period', 'period_date']);
});

// Migration: create_performance_targets_table.php
Schema::create('performance_targets', function (Blueprint $table) {
    $table->id();
    $table->string('metric'); // 'shipping_time', 'inventory_turnover', 'customer_retention'
    $table->string('period');
    $table->date('period_date');
    $table->decimal('target_value', 10, 2);
    $table->string('unit')->nullable(); // 'days', 'percentage', 'count'
    $table->timestamps();
});
```

---

## 🔧 Controller Methods to Add

Add these methods to `ReportsController.php`:

```php
// Distribution methods
private function getRevenueDistribution($startDate, $endDate) { ... }
private function getCustomerSpendingDistribution($startDate, $endDate) { ... }
private function getStockLevelDistribution() { ... }
private function getProfitMarginDistribution($startDate, $endDate) { ... }

// Target vs Actual methods
private function getRevenueTargetsVsActual($startDate, $endDate) { ... }
private function getCustomerAcquisitionTargetsVsActual($startDate, $endDate) { ... }
private function getProfitTargetsVsActual($startDate, $endDate) { ... }
private function getShippingTimeTargetsVsActual($startDate, $endDate) { ... }
```

---

## 📊 Priority Implementation Order

### Phase 1 (High Priority):
1. ✅ **Sales Distribution by Genre** (Pie Chart) - Easy, data already available
2. ✅ **Revenue Distribution by Price Range** (Bar Chart) - High value
3. ✅ **Revenue Target vs Actual** (Line Chart) - Critical for goal tracking

### Phase 2 (Medium Priority):
4. ✅ **Customer Spending Distribution** (Bar Chart)
5. ✅ **Stock Level Distribution** (Bar Chart)
6. ✅ **Order Status Distribution** (Bar Chart)

### Phase 3 (Nice to Have):
7. ✅ **Profit Margin Distribution** (Histogram)
8. ✅ **Shipping Time Distribution** (Histogram)
9. ✅ **All Target vs Actual comparisons**

---

## 💡 Additional Suggestions

### 1. **Interactive Filters**
- Allow users to change distribution ranges (e.g., price brackets)
- Toggle between different time periods
- Filter by genre, author, etc.

### 2. **Export Capabilities**
- Export distribution data to Excel
- Include target vs actual in PDF reports

### 3. **Alerts**
- Alert when actual performance is below target by X%
- Notify when distribution patterns change significantly

### 4. **Comparison Views**
- Compare current period distribution vs previous period
- Year-over-year target achievement

---

## 🎯 Summary

**Data Distribution Graphs** help you understand:
- How data is spread across categories
- Patterns and trends
- Outliers and anomalies

**Target vs Actual Graphs** help you:
- Track performance against goals
- Identify gaps early
- Make data-driven decisions
- Motivate teams with clear targets

Both types of graphs are essential for comprehensive business intelligence and strategic decision-making.

---

Would you like me to implement any of these graphs? I can start with the highest priority ones (Sales Distribution by Genre, Revenue Distribution, and Revenue Target vs Actual).

