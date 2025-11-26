# Bookty E-Commerce System - Activity Diagrams

This document contains detailed activity diagrams for all major workflows in the Bookty system.

---

## 1. Customer Purchase Journey

### Complete Purchase Flow from Browse to Order Confirmation

```mermaid
graph TD
    Start([Customer Lands on Homepage]) --> CheckAuth{Authenticated?}
    CheckAuth -->|No| ShowGeneric[Show New Arrivals]
    CheckAuth -->|Yes| ShowPersonal[Show Personalized Recommendations]
    
    ShowGeneric --> Browse[Browse Books]
    ShowPersonal --> Browse
    
    Browse --> FilterOptions{Apply Filters?}
    FilterOptions -->|Yes| SelectGenre[Select Genre/Trope/Author]
    FilterOptions -->|No| ViewBooks[View Book List]
    SelectGenre --> ApplyFilter[Apply Filter]
    ApplyFilter --> ViewBooks
    
    ViewBooks --> ViewBook[Click on Book]
    ViewBook --> LoadDetails[Load Book Details]
    LoadDetails --> LoadSimilar[Load Similar Books Sidebar]
    LoadSimilar --> ShowDetails[Display Book Page]
    
    ShowDetails --> UserDecision{User Decision}
    UserDecision -->|Add to Cart| QuickAdd[Quick Add to Cart]
    UserDecision -->|Add Wishlist| AddWishlist[Add to Wishlist]
    UserDecision -->|View Reviews| ShowReviews[Show Reviews]
    UserDecision -->|Write Review| WriteReview[Write Review Form]
    
    QuickAdd --> CheckStock[Check Stock Availability]
    CheckStock -->|Insufficient| ErrorStock[Show Out of Stock Error]
    CheckStock -->|Available| UpdateCart[Update Cart Item]
    UpdateCart --> UpdateCount[Update Cart Badge Count]
    UpdateCount --> ShowToast[Show Success Toast]
    
    ErrorStock --> ShowDetails
    ShowToast --> Return[Return to Book]
    Return --> ShowDetails
    
    WriteReview --> CheckPurchased{Has Purchased?}
    CheckPurchased -->|No| ErrorReview[Cannot Review - Purchase Required]
    CheckPurchased -->|Yes| SubmitReview[Submit Review]
    CheckPurchased -->|Already Reviewed| ErrorDuplicate[Already Reviewed Error]
    ErrorDuplicate --> ShowDetails
    ErrorReview --> ShowDetails
    SubmitReview --> UploadImages[Upload Images]
    UploadImages --> SaveReview[Save Review]
    SaveReview --> ShowReviews
    
    ShowReviews --> AddToCart{Add to Cart?}
    AddWishlist --> ConfirmWishlist[Confirm Wishlist Addition]
    ConfirmWishlist --> ShowDetails
    
    AddToCart --> GoToCart[Go to Cart Page]
    GoToCart --> ViewCart[Display Cart Items]
    ViewCart --> CartDecision{Cart Decision}
    
    CartDecision -->|Update Quantity| UpdateQty[Update Item Quantity]
    CartDecision -->|Remove Item| RemoveItem[Remove from Cart]
    CartDecision -->|Apply Coupon| EnterCoupon[Enter Coupon Code]
    CartDecision -->|Proceed Checkout| CheckAuth2{Auth Check}
    
    UpdateQty --> ValidateStock[Validate Stock]
    ValidateStock --> SaveCart[Save Cart]
    SaveCart --> ViewCart
    
    RemoveItem --> SaveCart
    EnterCoupon --> ValidateCoupon[Validate Coupon]
    ValidateCoupon -->|Invalid| ErrorCoupon[Show Error]
    ValidateCoupon -->|Valid| ApplyCoupon[Apply Discount]
    ErrorCoupon --> ViewCart
    ApplyCoupon --> CalculateTotal[Recalculate Total]
    CalculateTotal --> ViewCart
    
    CheckAuth2 -->|Not Auth| RequireAuth[Require Authentication]
    RequireAuth --> ViewCart
    
    CheckAuth2 -->|Auth| ProceedCheckout[Load Checkout Page]
    ProceedCheckout --> EnterShipping[Enter Shipping Details]
    EnterShipping --> CalcPostage[Calculate Postage Rate]
    CalcPostage --> ApplyFreeShip{Has Free Shipping?}
    
    ApplyFreeShip -->|Flash Sale| SetFreeShip[Set Free Shipping]
    ApplyFreeShip -->|Coupon| SetFreeShip
    ApplyFreeShip -->|No Free Ship| CalculateShip[Calculate Shipping Cost]
    
    SetFreeShip --> ReviewOrder[Review Order Summary]
    CalculateShip --> ReviewOrder
    
    ReviewOrder --> ConfirmOrder[Confirm Order]
    ConfirmOrder --> StartTransaction[Start DB Transaction]
    
    StartTransaction --> LockStock[Lock Book Stock]
    LockStock --> CheckAllStock{All Items in Stock?}
    CheckAllStock -->|No| Rollback[Rollback Transaction]
    Rollback --> ReturnToCart[Return to Cart with Error]
    ReturnToCart --> ViewCart
    
    CheckAllStock -->|Yes| CreateOrder[Create Order Record]
    CreateOrder --> CreateOrderItems[Create Order Items]
    CreateOrderItems --> DecrementStock[Decrement Stock]
    DecrementStock --> CreatePayment[Create ToyyibPay Bill]
    
    CreatePayment --> PaymentCreated{Bill Created?}
    PaymentCreated -->|Failed| RollbackPayment[Rollback]
    PaymentCreated -->|Success| SavePayment[Save Payment Info]
    
    RollbackPayment --> ReturnToCart
    SavePayment --> CommitTransaction[Commit Transaction]
    CommitTransaction --> ClearCart[Clear Cart]
    ClearCart --> RedirectPayment[Redirect to ToyyibPay]
    
    RedirectPayment --> CustomerPay[Customer Completes FPX Payment]
    CustomerPay --> ToyyibPayCallback[ToyyibPay Callback]
    ToyyibPayCallback --> UpdateOrder[Update Order Status]
    UpdateOrder --> SendNotification[Send Notification]
    SendNotification --> RedirectReturn[ToyyibPay Return URL]
    RedirectReturn --> OrderSuccess[Display Order Success Page]
    OrderSuccess --> End([Order Complete])
```

---

## 2. Hybrid Recommendation System Flow

### Detailed Algorithm Execution

```mermaid
graph TD
    Start([User Requests Recommendations]) --> CheckUser{User Authenticated?}
    CheckUser -->|No| ReturnPopular[Return Popular Books]
    CheckUser -->|Yes| CheckCache{Results Cached?}
    
    ReturnPopular --> End1([End])
    
    CheckCache -->|Yes| RetrieveCache[Retrieve from Cache]
    CheckCache -->|No| BeginProcess[Start Recommendation Process]
    
    RetrieveCache --> AttachScore[Attach Scores to Books]
    AttachScore --> ReturnResults[Return Recommendations]
    
    BeginProcess --> GetUserData[Get User Data]
    GetUserData --> GetPurchases[Get Purchased Books]
    GetPurchases --> GetWishlist[Get Wishlisted Books]
    GetWishlist --> GetOrders[Get Order History]
    
    GetOrders --> ContentBased[Content-Based Filtering]
    GetOrders --> Collaborative[Collaborative Filtering]
    
    %% Content-Based Path
    ContentBased --> ExtractGenre[Extract Favorite Genres]
    ExtractGenre --> ExtractTrope[Extract Favorite Tropes]
    ExtractTrope --> ExtractAuthor[Extract Favorite Authors]
    ExtractAuthor --> CalculateGenreWeight[Calculate Genre Weights]
    CalculateGenreWeight --> CalculateTropeWeight[Calculate Trope Weights]
    CalculateTropeWeight --> CalculateAuthorWeight[Calculate Author Weights]
    CalculateAuthorWeight --> NormalizeContent[Normalize Content Weights]
    
    %% Collaborative Path
    Collaborative --> FindSimilarUsers[Find Similar Users]
    FindSimilarUsers --> AnalyzeCoPurchase[Analyze Co-purchase Patterns]
    AnalyzeCoPurchase --> CalculateSimilarity[Calculate User Similarity]
    CalculateSimilarity --> GetPeerPurchases[Get Peer Purchases]
    GetPeerPurchases --> ScoreByFrequency[Score by Frequency]
    ScoreByFrequency --> NormalizeCollab[Normalize Collaborative Scores]
    
    %% Fusion
    NormalizeContent --> HybridFusion[Hybrid Fusion]
    NormalizeCollab --> HybridFusion
    
    HybridFusion --> CombineScores[Combine Scores 60/40]
    CombineScores --> ExcludePurchased[Exclude Already Purchased Books]
    ExcludePurchased --> FilterInStock[Filter Only In-Stock Books]
    FilterInStock --> SortByScore[Sort by Final Score]
    SortByScore --> LimitBooks[Limit to 12 Books]
    LimitBooks --> AttachDetails[Attach Book Details]
    AttachDetails --> CacheResults[Cache for 30 minutes]
    
    CacheResults --> ReturnResults
    ReturnResults --> DisplayFrontend[Display on Frontend]
    DisplayFrontend --> End([End])
```

---

## 3. Admin Dashboard Analytics Flow

### Real-time Analytics & Reporting

```mermaid
graph TD
    Start([Admin Opens Dashboard]) --> LoadStats[Load Statistics]
    LoadStats --> CountUsers[Count Total Users]
    CountUsers --> CountBooks[Count Total Books]
    CountBooks --> CountOrders[Count Total Orders]
    CountOrders --> CalculateRevenue[Calculate Total Revenue]
    CalculateRevenue --> GetPendingOrders[Get Pending Orders Count]
    GetPendingOrders --> FetchLowStock[Fetch Low Stock Books]
    FetchLowStock --> FetchBestsellers[Fetch Best Selling Books]
    
    FetchBestsellers --> DisplayCards[Display Metric Cards]
    DisplayCards --> LoadRecentOrders[Load Recent Orders]
    LoadRecentOrders --> LoadRecentCustomers[Load Recent Customers]
    LoadRecentCustomers --> DisplayDashboard[Display Dashboard]
    
    DisplayDashboard --> UserInteraction{Admin Action}
    
    UserInteraction -->|View Orders| LoadOrders[List All Orders]
    UserInteraction -->|Manage Books| ManageBooks[Book Management]
    UserInteraction -->|View Reports| LoadReports[Load Reports]
    UserInteraction -->|View Analytics| LoadRecommendations[Load Recommendation Analytics]
    
    LoadOrders --> FilterStatus{Filter by Status?}
    FilterStatus -->|Yes| ApplyStatus[Apply Status Filter]
    FilterStatus -->|No| DisplayOrders[Display All Orders]
    ApplyStatus --> DisplayOrders
    DisplayOrders --> OrderAction{Order Action}
    
    OrderAction -->|View Details| ShowOrderDetails[Show Order Details]
    OrderAction -->|Update Status| UpdateStatus[Update Order Status]
    OrderAction -->|Add Tracking| AddTracking[Add Tracking Number]
    OrderAction -->|Download Invoice| GenerateInvoice[Generate PDF Invoice]
    
    UpdateStatus --> StatusOptions{Select Status}
    StatusOptions -->|Processing| SetProcessing[Set to Processing]
    StatusOptions -->|Shipped| SetShipped[Set to Shipped]
    StatusOptions -->|Completed| SetCompleted[Set to Completed]
    StatusOptions -->|Cancelled| SetCancelled[Set to Cancelled]
    
    SetProcessing --> SaveOrder[Save Order Changes]
    SetShipped --> SaveOrder
    SetCompleted --> SaveOrder
    SetCancelled --> RestoreStock[Restore Stock]
    RestoreStock --> SaveOrder
    
    AddTracking --> EnterTracking[Enter Tracking Number]
    EnterTracking --> SaveOrder
    
    GenerateInvoice --> GetOrderData[Get Order Data]
    GetOrderData --> GeneratePDF[Generate PDF]
    GeneratePDF --> DownloadFile[Download Invoice]
    
    LoadReports --> ReportType{Select Report Type}
    ReportType -->|Sales| SalesReport[Generate Sales Report]
    ReportType -->|Customers| CustomerReport[Generate Customer Report]
    ReportType -->|Inventory| InventoryReport[Generate Inventory Report]
    ReportType -->|Profitability| ProfitReport[Generate Profitability Report]
    
    SalesReport --> ConfigureFilters[Configure Date Range]
    ConfigureFilters --> QueryData[Query Database]
    QueryData --> CalculateMetrics[Calculate Metrics]
    CalculateMetrics --> DisplayCharts[Display Charts]
    DisplayCharts --> ExportOptions{Export?}
    
    ExportOptions -->|Yes| ExportExcel[Export to Excel]
    ExportOptions -->|No| ViewData[View Data Only]
    
    ExportExcel --> DownloadFile2[Download Report File]
    DownloadFile2 --> End1([End])
    ViewData --> End1
    SaveOrder --> End1
    ShowOrderDetails --> End1
    
    LoadRecommendations --> DisplayRecAnalytics[Display Recommendation Analytics]
    DisplayRecAnalytics --> ViewPerformance[View Performance Metrics]
    ViewPerformance --> ViewSettings[View Settings]
    ViewSettings --> ConfigureAlgorithm[Configure Algorithm]
    ConfigureAlgorithm --> TestSettings[Test Settings]
    TestSettings --> SaveRecSettings[Save Recommendation Settings]
    SaveRecSettings --> ClearCache[Clear Recommendation Cache]
    ClearCache --> End2([End])
```

---

## 4. Flash Sale Management Flow

### Creating & Managing Flash Sales

```mermaid
graph TD
    Start([Admin Opens Flash Sales]) --> ListSales[List Existing Sales]
    ListSales --> SelectAction{Select Action}
    
    SelectAction -->|Create New| StartCreate[Start Creation Process]
    SelectAction -->|Edit Existing| LoadSale[Load Sale Data]
    SelectAction -->|Toggle Active| ToggleSale[Toggle Sale Status]
    SelectAction -->|Delete| ConfirmDelete[Confirm Deletion]
    
    StartCreate --> EnterName[Enter Sale Name]
    EnterName --> EnterDescription[Enter Description]
    EnterDescription --> SetStartDate[Set Start Date & Time]
    SetStartDate --> SetEndDate[Set End Date & Time]
    SetEndDate --> ValidateDates{Validate Date Range}
    
    ValidateDates -->|Invalid| ErrorDates[Show Date Error]
    ValidateDates -->|Valid| SelectDiscount[Select Discount Type]
    ErrorDates --> SetEndDate
    
    SelectDiscount --> DiscountType{Discount Type?}
    DiscountType -->|Percentage| SetPercentDiscount[Set Percentage Value]
    DiscountType -->|Fixed| SetFixedDiscount[Set Fixed Amount]
    
    SetPercentDiscount --> ValidatePercent{1-100%?}
    ValidatePercent -->|No| ErrorPercent[Invalid Percentage]
    ValidatePercent -->|Yes| SelectBooks
    ErrorPercent --> SetPercentDiscount
    
    SetFixedDiscount --> SelectBooks[Select Books for Sale]
    SelectBooks --> LoadBooks[Load Available Books]
    LoadBooks --> FilterGenre{Filter by Genre?}
    FilterGenre -->|Yes| SelectGenre[Select Genre]
    FilterGenre -->|No| ShowAll[Show All Books]
    SelectGenre --> ShowByGenre[Show Books in Genre]
    ShowByGenre --> ChooseBooks[Choose Books]
    ShowAll --> ChooseBooks
    
    ChooseBooks --> SetSpecialPrice{Set Special Prices?}
    SetSpecialPrice -->|Yes| CheckSpecialPrice[For Each Book Check Special Price]
    SetSpecialPrice -->|No| CheckDiscountRules[Check Discount Rules]
    
    CheckSpecialPrice --> ValidateSpecial{Special Price < Original?}
    ValidateSpecial -->|No| ErrorSpecialPrice[Invalid Price]
    ValidateSpecial -->|Yes| ApplySpecial[Apply Special Price]
    ErrorSpecialPrice --> CheckSpecialPrice
    ApplySpecial --> CheckDiscountRules
    
    CheckDiscountRules --> ValidateDiscount{Validate Discount}
    ValidateDiscount -->|Invalid| ErrorDiscount[Show Error]
    ValidateDiscount -->|Valid| SetFreeShipping[Set Free Shipping Option]
    ErrorDiscount --> SetSpecialPrice
    
    SetFreeShipping --> CheckPriceRules[Re-check Price Rules]
    CheckPriceRules --> StartDB[Start DB Transaction]
    StartDB --> DeactivateOldSales[Deactivate Old Sales for Selected Books]
    DeactivateOldSales --> CreateFlashSale[Create Flash Sale Record]
    CreateFlashSale --> CreateItems[Create Flash Sale Items]
    CreateItems --> CommitDB[Commit Transaction]
    CommitDB --> Success[Flash Sale Created Successfully]
    Success --> RefreshList[Refresh Sales List]
    
    ToggleSale --> LoadSale
    LoadSale --> ShowEdit[Show Edit Form]
    ShowEdit --> UpdateSale[Update Sale Details]
    UpdateSale --> SaveChanges[Save Changes]
    SaveChanges --> RefreshList
    
    ConfirmDelete --> DeleteSale[Delete Sale]
    DeleteSale --> DeleteItems[Delete Items]
    DeleteItems --> RefreshList
    RefreshList --> End([End])
```

---

## 5. Review Moderation Flow

### Complete Review Lifecycle

```mermaid
graph TD
    Start([Customer Orders Book]) --> ReceiveOrder[Receive Order]
    ReceiveOrder --> CompleteOrder[Complete Order]
    CompleteOrder --> CanReview{Can Review?}
    
    CanReview -->|No| CheckReason{Why?}
    CheckReason -->|Not Received| WaitDelivery[Wait for Delivery]
    CheckReason -->|Already Reviewed| AlreadyDone[Already Reviewed]
    CheckReason -->|Order Not Completed| CannotReview[Order Not Completed]
    
    WaitDelivery --> End1([End])
    AlreadyDone --> End1
    CannotReview --> End1
    
    CanReview -->|Yes| OpenReview[Open Review Form]
    OpenReview --> SelectOrderItem[Select Order Item]
    SelectOrderItem --> SetRating[Set Rating 1-5 Stars]
    SetRating --> WriteComment[Write Review Comment]
    WriteComment --> UploadImages{Upload Images?}
    
    UploadImages -->|Yes| SelectFiles[Select Image Files]
    SelectFiles --> ValidateFiles{Validate Files}
    ValidateFiles -->|Invalid Size| ErrorSize[File Too Large Error]
    ValidateFiles -->|Invalid Type| ErrorType[Invalid File Type]
    ValidateFiles -->|Valid| ProcessImages[Process Image Upload]
    ErrorSize --> UploadImages
    ErrorType --> UploadImages
    
    UploadImages -->|No| SubmitReview
    ProcessImages --> UploadToStorage[Upload to Storage]
    UploadToStorage --> SubmitReview[Submit Review]
    
    SubmitReview --> SaveReview[Save Review to Database]
    SaveReview --> AutoApprove[Auto-Approve Review]
    AutoApprove --> DisplayReview[Display on Book Page]
    DisplayReview --> ShowStats[Update Book Statistics]
    ShowStats --> End2([End])
    
    DisplayReview --> UserInteraction{User Interaction}
    UserInteraction -->|Mark Helpful| MarkHelpful[Mark as Helpful]
    UserInteraction -->|Report| ReportFlow
    UserInteraction -->|View Images| ShowGallery[Show Image Gallery]
    
    MarkHelpful --> CheckHelpful{Already Marked?}
    CheckHelpful -->|Yes| RemoveHelpful[Remove Helpful Vote]
    CheckHelpful -->|No| AddHelpful[Add Helpful Vote]
    RemoveHelpful --> UpdateCount[Update Helpful Count]
    AddHelpful --> UpdateCount
    UpdateCount --> End3([End])
    ShowGallery --> End3
    
    ReportFlow --> SelectReason[Select Report Reason]
    SelectReason --> ReasonOptions{Reason?}
    ReasonOptions -->|Spam| ConfirmSpam[Confirm Spam]
    ReasonOptions -->|Inappropriate| ConfirmInapp[Confirm Inappropriate]
    ReasonOptions -->|Offensive| ConfirmOffensive[Confirm Offensive]
    ReasonOptions -->|Fake| ConfirmFake[Confirm Fake]
    ReasonOptions -->|Other| EnterDescription[Enter Description]
    
    ConfirmSpam --> CheckDuplicate{Already Reported?}
    ConfirmInapp --> CheckDuplicate
    ConfirmOffensive --> CheckDuplicate
    ConfirmFake --> CheckDuplicate
    EnterDescription --> CheckDuplicate
    
    CheckDuplicate -->|Yes| ErrorDuplicate[Already Reported Error]
    CheckDuplicate -->|No| CreateReport[Create Report Record]
    
    ErrorDuplicate --> End3
    CreateReport --> NotifyAdmin[Notify Admin]
    NotifyAdmin --> AdminView[Admin Views Report]
    AdminView --> AdminDecision{Admin Decision}
    
    AdminDecision -->|Resolve| MarkResolved[Mark as Resolved]
    AdminDecision -->|Dismiss| DismissReport[Dismiss Report]
    AdminDecision -->|Needs Review| QueueReview[Queue for Review]
    
    MarkResolved --> UpdateReportStatus[Update Report Status]
    DismissReport --> UpdateReportStatus
    QueueReview --> UpdateReportStatus
    
    UpdateReportStatus --> AddNotes{Add Admin Notes?}
    AddNotes -->|Yes| AddNotesText[Add Admin Notes]
    AddNotes -->|No| NotifyReporter[Notify Reporter]
    AddNotesText --> NotifyReporter
    NotifyReporter --> End4([End])
```

---

## 6. Cart & Checkout Flow

### Detailed Shopping Cart Operations

```mermaid
graph TD
    Start([User Adds Item to Cart]) --> TriggerEvent[Click Add to Cart Button]
    TriggerEvent --> PreventDuplicate[Prevent Double Click]
    PreventDuplicate --> ShowLoading[Show Loading State]
    ShowLoading --> CheckAuth{User Authenticated?}
    
    CheckAuth -->|No| PromptLogin[Prompt to Login]
    PromptLogin --> OpenModal[Open Auth Modal]
    OpenModal --> UserLogin[User Logs In]
    UserLogin --> CheckAuth
    
    CheckAuth -->|Yes| GetOrCreateCart[Get or Create User Cart]
    GetOrCreateCart --> GetBook[Get Book Details]
    GetBook --> CheckCartItem{Item in Cart?}
    
    CheckCartItem -->|No| CheckStock{Stock Available?}
    CheckCartItem -->|Yes| GetExisting[Get Existing Cart Item]
    GetExisting --> AddOne[Add Quantity +1]
    
    CheckStock -->|No Stock| ShowNoStock[Show Out of Stock Error]
    CheckStock -->|Stock Available| CheckQuantity{Quantity <= Stock?}
    
    CheckQuantity -->|No| ErrorQuantity[Show Insufficient Stock Error]
    CheckQuantity -->|Yes| SaveCartItem[Save Cart Item]
    
    AddOne --> CheckStock
    
    ShowNoStock --> End1([End])
    ErrorQuantity --> End1
    
    SaveCartItem --> UpdateCartCount[Update Cart Count Badge]
    UpdateCartCount --> ShowToast[Show Success Toast]
    ShowToast --> End2([End])
    
    %% Cart Management
    ClickCartIcon([User Clicks Cart Icon]) --> LoadCartPage[Load Cart Page]
    LoadCartPage --> FetchCartItems[Fetch All Cart Items]
    FetchCartItems --> CalculateTotals[Calculate Subtotal]
    CalculateTotals --> DisplayItems[Display Cart Items]
    
    DisplayItems --> CartAction{User Action}
    CartAction -->|Update Quantity| UpdateQtyFlow[Update Quantity Flow]
    CartAction -->|Remove Item| RemoveFlow[Remove Item Flow]
    CartAction -->|Apply Coupon| CouponFlow[Coupon Flow]
    CartAction -->|Proceed Checkout| CheckoutFlow[Checkout Flow]
    CartAction -->|Continue Shopping| ContinueShop[Continue Browsing]
    
    UpdateQtyFlow --> NewQty[Enter New Quantity]
    NewQty --> ValidateQty{Valid Quantity?}
    ValidateQty -->|Invalid| ErrorQty[Show Quantity Error]
    ValidateQty -->|Valid| CheckStockQty[Check Stock for Quantity]
    ErrorQty --> DisplayItems
    
    CheckStockQty -->|Insufficient| ErrorStock[Show Stock Error]
    CheckStockQty -->|Sufficient| UpdateItem[Update Cart Item]
    ErrorStock --> DisplayItems
    
    UpdateItem --> SaveCartItems[Save to Database]
    SaveCartItems --> RecalculateTotal[Recalculate Totals]
    RecalculateTotal --> RefreshDisplay[Refresh Cart Display]
    RefreshDisplay --> ShowUpdateToast[Show Updated Toast]
    
    RemoveFlow --> ConfirmRemove{Confirm Removal?}
    ConfirmRemove -->|No| DisplayItems
    ConfirmRemove -->|Yes| RemoveItemDB[Remove from Database]
    RemoveItemDB --> RecalculateTotal
    
    CouponFlow --> EnterCode[Enter Coupon Code]
    EnterCode --> ValidateCouponAPI[Validate via API]
    ValidateCouponAPI -->|Invalid| ErrorCoupon[Show Coupon Error]
    ValidateCouponAPI -->|Valid| CalculateDiscount[Calculate Discount]
    
    ErrorCoupon --> DisplayItems
    CalculateDiscount --> ApplyDiscount[Apply Discount]
    ApplyDiscount --> RecalculateTotal
    
    CheckoutFlow --> LoadCheckout[Load Checkout Page]
    LoadCheckout --> EnterShippingInfo[Enter Shipping Information]
    EnterShippingInfo --> SelectState[Select State]
    SelectState --> CalculatePostage[Calculate Postage Rate]
    CalculatePostage --> CheckFreeShipping{Free Shipping?}
    
    CheckFreeShipping -->|Yes| SetFreeShip[Set Shipping = 0]
    CheckFreeShipping -->|No| CalculateShip[Calculate Shipping]
    
    SetFreeShip --> ValidateCoupon{Use Coupon?}
    CalculateShip --> ValidateCoupon
    
    ValidateCoupon -->|Yes| ValidateCouponAPI
    ValidateCoupon -->|No| ReviewOrderTotal[Review Order Total]
    ApplyDiscount --> ReviewOrderTotal
    
    ReviewOrderTotal --> ConfirmPayment[Confirm Payment]
    ConfirmPayment --> ProcessPayment[Process Payment]
    ProcessPayment --> End([End])
```

---

## 7. Order Processing & Fulfillment Flow

### Complete Order Lifecycle

```mermaid
graph TD
    Start([Order Created]) --> StatusPending[Status: pending, payment_status: pending]
    StatusPending --> StorePaymentInfo[Store ToyyibPay Info]
    StorePaymentInfo --> ClearCart[Clear Shopping Cart]
    ClearCart --> RedirectToPayment[Redirect to ToyyibPay]
    
    RedirectToPayment --> CustomerPays[Customer Pays via FPX]
    CustomerPays --> CompletePayment{Payment Complete?}
    CompletePayment -->|Yes| Success[Payment Success]
    CompletePayment -->|No| WaitPayment[Wait for Payment]
    WaitPayment --> CheckStatus{Check Payment Status}
    
    Success --> ToyyibCallback[ToyyibPay Calls Callback URL]
    ToyyibCallback --> ProcessCallback[Process Callback Data]
    ProcessCallback --> UpdatePayment[Update Payment Status to 'paid']
    UpdatePayment --> UpdateOrderStatus[Update Order Status to 'processing']
    UpdateOrderStatus --> SaveOrder[Save Order]
    SaveOrder --> NotifyAdmin[Notify Admin of New Order]
    NotifyAdmin --> End1([End])
    
    CheckStatus --> CheckTimestamp{Check Timestamp}
    CheckTimestamp -->|Expired| CancelOrder[Cancel Expired Order]
    CheckTimestamp -->|Valid| ContinueWaiting[Continue Waiting]
    CancelOrder --> RestoreInventory[Restore Inventory]
    RestoreInventory --> UpdateCancelled[Mark as Cancelled]
    UpdateCancelled --> End2([End])
    
    ContinueWaiting --> WaitPayment
    
    %% Admin Fulfillment
    AdminOpensOrders([Admin Opens Orders Page]) --> ViewOrders[View All Orders]
    ViewOrders --> FilterOrders{Filter Orders}
    FilterOrders -->|By Status| FilterStatus[Filter by Status]
    FilterOrders -->|By Date| FilterDate[Filter by Date Range]
    FilterOrders -->|By Customer| FilterCustomer[Filter by Customer]
    FilterOrders -->|No Filter| ShowAll[Show All Orders]
    
    FilterStatus --> DisplayFilteredOrders[Display Filtered Orders]
    FilterDate --> DisplayFilteredOrders
    FilterCustomer --> DisplayFilteredOrders
    ShowAll --> DisplayFilteredOrders
    
    DisplayFilteredOrders --> SelectOrder[Select Order to Process]
    SelectOrder --> ViewOrderDetails[View Order Details]
    ViewOrderDetails --> AdminActions{Admin Action}
    
    AdminActions -->|Update Status| StatusUpdate[Update Order Status]
    AdminActions -->|Add Tracking| AddTrackingFlow[Add Tracking Flow]
    AdminActions -->|Add Notes| AddNotesFlow[Add Admin Notes]
    AdminActions -->|Download Invoice| InvoiceFlow[Generate Invoice]
    
    StatusUpdate --> SelectNewStatus[Select New Status]
    SelectNewStatus --> StatusOptions{New Status?}
    StatusOptions -->|Processing| UpdateProcessing[Set to Processing]
    StatusOptions -->|Shipped| UpdateShipped[Set to Shipped]
    StatusOptions -->|Completed| UpdateCompleted[Set to Completed]
    StatusOptions -->|Cancelled| UpdateCancelledFlow[Set to Cancelled]
    
    UpdateProcessing --> SaveStatus[Save Status]
    UpdateShipped --> SaveStatus
    UpdateCompleted --> SaveStatus
    UpdateCancelledFlow --> RestoreInventory
    SaveStatus --> NotifyCustomer[Notify Customer]
    NotifyCustomer --> End3([End])
    
    AddTrackingFlow --> EnterTrackingNum[Enter Tracking Number]
    EnterTrackingNum --> SelectCourier[Select Courier Name]
    SelectCourier --> SaveTracking[Save Tracking Info]
    SaveTracking --> GenerateURL[Generate Tracking URL]
    GenerateURL --> SaveStatus
    
    AddNotesFlow --> EnterNotes[Enter Admin Notes]
    EnterNotes --> SaveNotes[Save Notes]
    SaveNotes --> End3
    
    InvoiceFlow --> GenerateInvoicePDF[Generate Invoice PDF]
    GenerateInvoicePDF --> DownloadInvoice[Download Invoice]
    DownloadInvoice --> End3
    
    RestoreInventory --> End3
```

---

## 8. Wishlist Management Flow

### Adding & Managing Wishlist Items

```mermaid
graph TD
    Start([User Views Book]) --> ToggleWishlist[Click Wishlist Button]
    ToggleWishlist --> CheckAuth{Authenticated?}
    
    CheckAuth -->|No| PromptLoginModal[Open Login Modal]
    PromptLoginModal --> UserLogin[User Logs In]
    UserLogin --> CheckAuth
    
    CheckAuth -->|Yes| CheckItem{Item in Wishlist?}
    CheckItem -->|Yes| RemoveWishlist[Remove from Wishlist]
    CheckItem -->|No| AddToWishlist[Add to Wishlist]
    
    AddToWishlist --> CheckExists{Already Exists?}
    CheckExists -->|Yes| Skip[Skip - Already Added]
    CheckExists -->|No| CreateWishlistItem[Create Wishlist Entry]
    
    CreateWishlistItem --> SaveToDB[Save to Database]
    SaveToDB --> UpdateButton[Update Button State]
    UpdateButton --> ShowToast[Show Added Toast]
    
    RemoveWishlist --> DeleteFromDB[Delete from Database]
    DeleteFromDB --> UpdateButton
    Skip --> UpdateButton
    ShowToast --> End1([End])
    
    %% View Wishlist
    ViewWishlistPage([User Opens Wishlist Page]) --> LoadWishlist[Load Wishlist Items]
    LoadWishlist --> FetchBooks[Fetch Book Details]
    FetchBooks --> DisplayWishlist[Display Wishlist Grid]
    
    DisplayWishlist --> WishlistAction{User Action}
    WishlistAction -->|Add to Cart| AddFromWish[Add to Cart from Wishlist]
    WishlistAction -->|Remove| RemoveFromWish[Remove from Wishlist]
    WishlistAction -->|View Details| ViewBook[View Book Details]
    
    AddFromWish --> CheckCart{In Cart?}
    CheckCart -->|Yes| UpdateQty[Update Cart Quantity]
    CheckCart -->|No| CreateCartItem[Create Cart Item]
    
    UpdateQty --> SaveCart2[Save to Cart]
    CreateCartItem --> SaveCart2
    SaveCart2 --> CheckStock{Stock Available?}
    
    CheckStock -->|No| ShowStockError[Show Out of Stock Error]
    CheckStock -->|Yes| ShowSuccess[Show Added to Cart Toast]
    
    RemoveFromWish --> ConfirmRemove{Confirm Remove?}
    ConfirmRemove -->|No| DisplayWishlist
    ConfirmRemove -->|Yes| RemoveItemDB2[Remove Item]
    RemoveItemDB2 --> RefreshDisplay[Refresh Wishlist Display]
    
    ViewBook --> NavigateToBook[Navigate to Book Detail Page]
    ShowStockError --> DisplayWishlist
    ShowSuccess --> DisplayWishlist
    RefreshDisplay --> DisplayWishlist
    NavigateToBook --> End2([End])
```

---

## 9. Recommendation Analytics Dashboard Flow

### Admin Monitoring Recommendation Performance

```mermaid
graph TD
    Start([Admin Opens Recommendation Analytics]) --> LoadDashboard[Load Analytics Dashboard]
    LoadDashboard --> FetchBasicStats[Fetch Basic Statistics]
    
    FetchBasicStats --> CountTotalUsers[Count Total Users]
    CountTotalUsers --> CountWithRecs[Count Users with Recommendations]
    CountWithRecs --> CalculateCoverage[Calculate Coverage Rate]
    CalculateCoverage --> FetchPerformance[Fetch Performance Metrics]
    
    FetchPerformance --> GetCTR[Get Click-Through Rate]
    GetCTR --> GetConversion[Get Conversion Rate]
    GetConversion --> GetAvgScore[Get Average Score]
    GetAvgScore --> FetchBehavior[Fetch User Behavior Patterns]
    
    FetchBehavior --> GetPopularGenres[Get Popular Genres]
    GetPopularGenres --> GetPopularTropes[Get Popular Tropes]
    GetPopularTropes --> GetEngagement[Get Engagement Patterns]
    
    GetEngagement --> FetchInsights[Fetch Algorithm Insights]
    FetchInsights --> GetContentEffect[Get Content-Based Effectiveness]
    GetContentEffect --> GetCollabEffect[Get Collaborative Effectiveness]
    GetCollabEffect --> GetDiversity[Get Diversity Metrics]
    
    GetDiversity --> FetchTopBooks[Fetch Top Recommended Books]
    FetchTopBooks --> FetchAccuracy[Fetch Accuracy Metrics]
    FetchAccuracy --> LoadCharts[Initialize Charts]
    
    LoadCharts --> InitEffectivenessChart[Initialize Effectiveness Chart]
    InitEffectivenessChart --> InitAccuracyChart[Initialize Accuracy Chart]
    InitAccuracyChart --> RenderPage[Render Complete Dashboard]
    
    RenderPage --> DisplayMetrics[Display Metric Cards]
    DisplayMetrics --> DisplayCharts[Display Performance Charts]
    DisplayCharts --> DisplayTable[Display Top Books Table]
    DisplayTable --> DashboardReady[Dashboard Ready]
    
    DashboardReady --> UserInteraction{Admin Action}
    
    UserInteraction -->|Refresh| RefreshData[Refresh All Data]
    UserInteraction -->|Switch Chart| ToggleChart[Toggle Chart View]
    UserInteraction -->|Settings| OpenSettings[Open Settings Page]
    UserInteraction -->|View User| ViewUserDetails[View User Details]
    UserInteraction -->|Export| ExportData[Export Analytics Data]
    UserInteraction -->|Print| PrintCharts[Print Charts]
    
    RefreshData --> ReloadPage[Reload Dashboard]
    ReloadPage --> FetchBasicStats
    
    ToggleChart --> UpdateChart[Update Chart Display]
    UpdateChart --> End1([End])
    
    OpenSettings --> LoadSettingsPage[Load Settings Page]
    LoadSettingsPage --> ConfigureWeights[Configure Algorithm Weights]
    ConfigureWeights --> ConfigureThresholds[Configure Thresholds]
    ConfigureThresholds --> ConfigureCache[Configure Cache Settings]
    ConfigureCache --> ToggleComponents[Toggle Components]
    ToggleComponents --> SaveSettings[Save Settings]
    SaveSettings --> ClearRecCache[Clear Recommendation Cache]
    ClearRecCache --> End2([End])
    
    ViewUserDetails --> LoadUser[Load User Profile]
    LoadUser --> ShowPreferences[Show User Preferences]
    ShowPreferences --> ShowRecs[Show Current Recommendations]
    ShowRecs --> ShowHistory[Show Purchase History]
    ShowHistory --> ShowWishlist[Show Wishlist Items]
    ShowWishlist --> End3([End])
    
    ExportData --> GenerateJSON[Generate JSON Export]
    GenerateJSON --> DownloadExport[Download Export File]
    
    PrintCharts --> GeneratePrintHTML[Generate Print HTML]
    GeneratePrintHTML --> OpenPrint[Open Print Dialog]
    
    DownloadExport --> End4([End])
    OpenPrint --> End4
```

---

## 10. Profitability Tracking Flow

### Cost Analysis & Profit Calculation

```mermaid
graph TD
    Start([Admin Opens Profitability Report]) --> LoadReport[Load Profitability Report]
    LoadReport --> SelectTimeRange[Select Time Range]
    SelectTimeRange --> SelectView{View Type?}
    
    SelectView -->|By Book| ByBook[View by Book]
    SelectView -->|By Genre| ByGenre[View by Genre]
    SelectView -->|Monthly| ByMonth[View Monthly]
    
    ByBook --> FetchBookData[Fetch Book Sales Data]
    FetchBookData --> CalculateBookRevenue[Calculate Revenue per Book]
    CalculateBookRevenue --> CalculateBookCost[Calculate Cost per Book]
    CalculateBookCost --> CalculateBookProfit[Calculate Profit per Book]
    CalculateBookProfit --> CalculateBookMargin[Calculate Profit Margin %]
    CalculateBookMargin --> SortByProfit[Sort by Profit Descending]
    SortByProfit --> DisplayBookReport[Display Book Report]
    
    ByGenre --> FetchGenreData[Fetch Genre Sales Data]
    FetchGenreData --> AggregateByGenre[Aggregate Sales by Genre]
    AggregateByGenre --> CalculateGenreRevenue[Calculate Genre Revenue]
    CalculateGenreRevenue --> CalculateGenreCost[Calculate Genre Cost]
    CalculateGenreCost --> CalculateGenreProfit[Calculate Genre Profit]
    CalculateGenreProfit --> CalculateGenreMargin[Calculate Genre Margin]
    CalculateGenreMargin --> SortGenreByProfit[Sort by Profit]
    SortGenreByProfit --> DisplayGenreReport[Display Genre Report]
    
    ByMonth --> FetchMonthlyData[Fetch Monthly Sales Data]
    FetchMonthlyData --> CalculateMonthlyRevenue[Calculate Monthly Revenue]
    CalculateMonthlyRevenue --> CalculateMonthlyCost[Calculate Monthly Cost]
    CalculateMonthlyCost --> CalculateMonthlyProfit[Calculate Monthly Profit]
    CalculateMonthlyProfit --> CalculateMonthlyMargin[Calculate Monthly Margin]
    CalculateMonthlyMargin --> DisplayMonthlyReport[Display Monthly Report]
    
    DisplayBookReport --> ExportOptions{Export to Excel?}
    DisplayGenreReport --> ExportOptions
    DisplayMonthlyReport --> ExportOptions
    
    ExportOptions -->|Yes| GenerateExcel[Generate Excel File]
    ExportOptions -->|No| ViewOnly[View Only]
    
    GenerateExcel --> FormatExcel[Format Excel with Headers]
    FormatExcel --> ApplyStyles[Apply Styling]
    ApplyStyles --> DownloadFile[Download Excel File]
    
    ViewOnly --> AnalyzeTrends[Analyze Profit Trends]
    AnalyzeTrends --> IdentifyBestsellers[Identify Bestsellers]
    IdentifyBestsellers --> IdentifyPoorSellers[Identify Poor Sellers]
    
    DownloadFile --> End1([End])
    AnalyzeTrends --> End1
    
    %% Order Item Cost Tracking
    OrderPlaced([Order Placed]) --> StoreCostPrice[Store Book Cost Price]
    StoreCostPrice --> StoreSellingPrice[Store Book Selling Price]
    StoreSellingPrice --> StoreQuantity[Store Quantity]
    StoreQuantity --> CalculateTotalSelling[Calculate Total Selling Amount]
    CalculateTotalSelling --> CalculateTotalCost[Calculate Total Cost Amount]
    CalculateTotalCost --> SaveOrderItem[Save Order Item with Costs]
    SaveOrderItem --> OrderComplete[Order Complete]
    OrderComplete --> GenerateReport[Generate Profitability Report]
    GenerateReport --> End2([End])
```

---

## Summary

These activity diagrams provide comprehensive visualization of all major workflows in the Bookty E-commerce system, covering:

1. ✅ **Customer Purchase Journey** - Complete flow from browsing to order completion
2. ✅ **Hybrid Recommendation System** - Algorithm execution and scoring
3. ✅ **Admin Dashboard & Analytics** - Real-time monitoring and reporting
4. ✅ **Flash Sale Management** - Creation and management of promotional sales
5. ✅ **Review Moderation** - Customer review lifecycle with moderation
6. ✅ **Cart & Checkout** - Shopping cart operations and checkout process
7. ✅ **Order Processing** - Order fulfillment and status management
8. ✅ **Wishlist Management** - Wishlist operations
9. ✅ **Recommendation Analytics** - Monitoring recommendation performance
10. ✅ **Profitability Tracking** - Cost analysis and profit calculation

Each diagram shows the complete flow including:
- Decision points
- Error handling
- Database operations
- User interactions
- System integrations
- Notification triggers

