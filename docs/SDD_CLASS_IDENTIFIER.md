# 4.1.5 Class Identifier — Bookty E-Commerce System

**Table 4.4 List of Classes and Packages**

This table categorises and identifies software classes within the Bookty E-Commerce System using unique identifiers. The system follows a layered architecture: **View Layer**, **Controller Layer**, and **Data Access Layer** (Eloquent Models).

---

## View Layer (SDD_PKG_100)

| Class Name | Identifier | View Path |
|------------|------------|-----------|
| HomeView | SDD_CLASS_100 | home/index |
| BooksIndexView | SDD_CLASS_101 | books/index |
| BooksShowView | SDD_CLASS_102 | books/show |
| CartView | SDD_CLASS_103 | cart/index |
| CheckoutView | SDD_CLASS_104 | checkout/index |
| CheckoutSuccessView | SDD_CLASS_105 | checkout/success |
| ProfileEditView | SDD_CLASS_106 | profile/edit |
| ProfileOrdersView | SDD_CLASS_107 | profile/orders |
| ProfileOrderDetailView | SDD_CLASS_108 | profile/order-detail |
| ProfileInvoiceView | SDD_CLASS_109 | profile/invoice |
| WishlistView | SDD_CLASS_110 | wishlist/index |
| LoginView | SDD_CLASS_111 | auth/login |
| RegisterView | SDD_CLASS_112 | auth/register |
| ForgotPasswordView | SDD_CLASS_113 | auth/forgot-password |
| ResetPasswordView | SDD_CLASS_114 | auth/reset-password |
| VerifyEmailView | SDD_CLASS_115 | auth/verify-email |
| ConfirmPasswordView | SDD_CLASS_116 | auth/confirm-password |
| AboutView | SDD_CLASS_117 | about/index |
| ContactView | SDD_CLASS_118 | contact/index |
| AdminDashboardView | SDD_CLASS_119 | admin/dashboard |
| AdminBooksIndexView | SDD_CLASS_120 | admin/books/index |
| AdminBooksCreateView | SDD_CLASS_121 | admin/books/create |
| AdminBooksEditView | SDD_CLASS_122 | admin/books/edit |
| AdminBooksShowView | SDD_CLASS_123 | admin/books/show |
| AdminOrdersIndexView | SDD_CLASS_124 | admin/orders/index |
| AdminOrdersEditView | SDD_CLASS_125 | admin/orders/edit |
| AdminOrdersShowView | SDD_CLASS_126 | admin/orders/show |
| AdminOrdersInvoiceView | SDD_CLASS_127 | admin/orders/invoice |
| AdminCouponsIndexView | SDD_CLASS_128 | admin/coupons/index |
| AdminCouponsCreateView | SDD_CLASS_129 | admin/coupons/create |
| AdminCouponsEditView | SDD_CLASS_130 | admin/coupons/edit |
| AdminCouponsShowView | SDD_CLASS_131 | admin/coupons/show |
| AdminCustomersIndexView | SDD_CLASS_132 | admin/customers/index |
| AdminCustomersShowView | SDD_CLASS_133 | admin/customers/show |
| AdminGenresIndexView | SDD_CLASS_134 | admin/genres/index |
| AdminGenresCreateView | SDD_CLASS_135 | admin/genres/create |
| AdminGenresEditView | SDD_CLASS_136 | admin/genres/edit |
| AdminTropesIndexView | SDD_CLASS_137 | admin/tropes/index |
| AdminTropesCreateView | SDD_CLASS_138 | admin/tropes/create |
| AdminTropesEditView | SDD_CLASS_139 | admin/tropes/edit |
| AdminFlashSalesIndexView | SDD_CLASS_140 | admin/flash-sales/index |
| AdminFlashSalesCreateView | SDD_CLASS_141 | admin/flash-sales/create |
| AdminFlashSalesEditView | SDD_CLASS_142 | admin/flash-sales/edit |
| AdminFlashSalesShowView | SDD_CLASS_143 | admin/flash-sales/show |
| AdminDiscountsIndexView | SDD_CLASS_144 | admin/discounts/index |
| AdminDiscountsCreateView | SDD_CLASS_145 | admin/discounts/create |
| AdminDiscountsEditView | SDD_CLASS_146 | admin/discounts/edit |
| AdminDiscountsShowView | SDD_CLASS_147 | admin/discounts/show |
| AdminReportsIndexView | SDD_CLASS_148 | admin/reports/index |
| AdminReportsSalesView | SDD_CLASS_149 | admin/reports/sales |
| AdminReportsCustomersView | SDD_CLASS_150 | admin/reports/customers |
| AdminReportsInventoryView | SDD_CLASS_151 | admin/reports/inventory |
| AdminReportsPromotionsView | SDD_CLASS_152 | admin/reports/promotions |
| AdminReportsProfitabilityView | SDD_CLASS_153 | admin/reports/profitability |
| AdminReportsShippingView | SDD_CLASS_154 | admin/reports/shipping |
| AdminRecommendationsIndexView | SDD_CLASS_155 | admin/recommendations/index |
| AdminRecommendationsSettingsView | SDD_CLASS_156 | admin/recommendations/settings |
| AdminRecommendationsUserDetailsView | SDD_CLASS_157 | admin/recommendations/user-details |
| AdminPostageRatesIndexView | SDD_CLASS_158 | admin/postage-rates/index |
| AdminPostageRatesCreateView | SDD_CLASS_159 | admin/postage-rates/create |
| AdminPostageRatesEditView | SDD_CLASS_160 | admin/postage-rates/edit |
| AdminPostageRatesHistoryView | SDD_CLASS_161 | admin/postage-rates/history |
| AdminReviewsHelpfulView | SDD_CLASS_162 | admin/reviews/helpful/index |
| AdminReviewsReportsIndexView | SDD_CLASS_163 | admin/reviews/reports/index |
| AdminReviewsReportsShowView | SDD_CLASS_164 | admin/reviews/reports/show |
| AdminSettingsSystemView | SDD_CLASS_165 | admin/settings/system |
| SuperAdminDashboardView | SDD_CLASS_166 | superadmin/dashboard |
| SuperAdminAdminsIndexView | SDD_CLASS_167 | superadmin/admins/index |
| SuperAdminAdminsCreateView | SDD_CLASS_168 | superadmin/admins/create |
| SuperAdminAdminsEditView | SDD_CLASS_169 | superadmin/admins/edit |
| SuperAdminAdminsShowView | SDD_CLASS_170 | superadmin/admins/show |
| SuperAdminRolesIndexView | SDD_CLASS_171 | superadmin/roles/index |
| SuperAdminRolesCreateView | SDD_CLASS_172 | superadmin/roles/create |
| SuperAdminRolesEditView | SDD_CLASS_173 | superadmin/roles/edit |
| SuperAdminRolesShowView | SDD_CLASS_174 | superadmin/roles/show |
| SuperAdminPermissionsIndexView | SDD_CLASS_175 | superadmin/permissions/index |
| SuperAdminPermissionsCreateView | SDD_CLASS_176 | superadmin/permissions/create |
| SuperAdminPermissionsEditView | SDD_CLASS_177 | superadmin/permissions/edit |
| SuperAdminPermissionsShowView | SDD_CLASS_178 | superadmin/permissions/show |
| SuperAdminSettingsView | SDD_CLASS_179 | superadmin/settings/index |
| BookCardView | SDD_CLASS_180 | components/book-card |
| AuthModalView | SDD_CLASS_181 | components/auth-modal |
| FlashSaleCountdownView | SDD_CLASS_182 | components/flash-sale-countdown |
| OrderStatusStepperView | SDD_CLASS_183 | components/order-status-stepper |

---

## Controller Layer (SDD_PKG_200)

| Class Name | Identifier | Namespace |
|------------|------------|-----------|
| HomeController | SDD_CLASS_200 | App\Http\Controllers |
| BookController | SDD_CLASS_201 | App\Http\Controllers |
| CartController | SDD_CLASS_202 | App\Http\Controllers |
| CheckoutController | SDD_CLASS_203 | App\Http\Controllers |
| ProfileController | SDD_CLASS_204 | App\Http\Controllers |
| WishlistController | SDD_CLASS_205 | App\Http\Controllers |
| ReviewController | SDD_CLASS_206 | App\Http\Controllers |
| AboutController | SDD_CLASS_207 | App\Http\Controllers |
| ContactController | SDD_CLASS_208 | App\Http\Controllers |
| AuthenticatedSessionController | SDD_CLASS_209 | App\Http\Controllers\Auth |
| RegisteredUserController | SDD_CLASS_210 | App\Http\Controllers\Auth |
| PasswordController | SDD_CLASS_211 | App\Http\Controllers\Auth |
| PasswordResetLinkController | SDD_CLASS_212 | App\Http\Controllers\Auth |
| ConfirmPasswordController | SDD_CLASS_213 | App\Http\Controllers\Auth |
| NewPasswordController | SDD_CLASS_214 | App\Http\Controllers\Auth |
| EmailVerificationPromptController | SDD_CLASS_215 | App\Http\Controllers\Auth |
| EmailVerificationNotificationController | SDD_CLASS_216 | App\Http\Controllers\Auth |
| VerifyEmailController | SDD_CLASS_217 | App\Http\Controllers\Auth |
| SocialiteController | SDD_CLASS_218 | App\Http\Controllers\Auth |
| ToyyibPayController | SDD_CLASS_219 | App\Http\Controllers |
| Admin\BookController | SDD_CLASS_220 | App\Http\Controllers\Admin |
| Admin\OrderController | SDD_CLASS_221 | App\Http\Controllers\Admin |
| Admin\CouponController | SDD_CLASS_222 | App\Http\Controllers\Admin |
| Admin\FlashSaleController | SDD_CLASS_223 | App\Http\Controllers\Admin |
| Admin\ReportsController | SDD_CLASS_224 | App\Http\Controllers\Admin |
| Admin\CustomerController | SDD_CLASS_225 | App\Http\Controllers\Admin |
| Admin\RecommendationAnalyticsController | SDD_CLASS_226 | App\Http\Controllers\Admin |
| Admin\PostageRateController | SDD_CLASS_227 | App\Http\Controllers\Admin |
| Admin\GenreController | SDD_CLASS_228 | App\Http\Controllers\Admin |
| Admin\TropeController | SDD_CLASS_229 | App\Http\Controllers\Admin |
| Admin\DashboardController | SDD_CLASS_230 | App\Http\Controllers\Admin |
| Admin\BookDiscountController | SDD_CLASS_231 | App\Http\Controllers\Admin |
| Admin\ReviewHelpfulController | SDD_CLASS_232 | App\Http\Controllers\Admin |
| Admin\ReviewReportController | SDD_CLASS_233 | App\Http\Controllers\Admin |
| Admin\SettingsController | SDD_CLASS_234 | App\Http\Controllers\Admin |
| Api\RecommendationController | SDD_CLASS_235 | App\Http\Controllers\Api |
| Api\CouponController | SDD_CLASS_236 | App\Http\Controllers\Api |
| Api\PostageController | SDD_CLASS_237 | App\Http\Controllers\Api |
| SuperAdmin\AdminController | SDD_CLASS_238 | App\Http\Controllers\SuperAdmin |
| SuperAdmin\RoleController | SDD_CLASS_239 | App\Http\Controllers\SuperAdmin |
| SuperAdmin\PermissionController | SDD_CLASS_240 | App\Http\Controllers\SuperAdmin |
| SuperAdmin\SettingController | SDD_CLASS_241 | App\Http\Controllers\SuperAdmin |
| SuperAdmin\DashboardController | SDD_CLASS_242 | App\Http\Controllers\SuperAdmin |

---

## Data Access Layer (SDD_PKG_300)

*In Laravel, Eloquent Models serve as the Data Access Layer, encapsulating database persistence and query logic.*

| Class Name | Identifier | Table |
|------------|------------|-------|
| User | SDD_CLASS_300 | users |
| Book | SDD_CLASS_301 | books |
| Genre | SDD_CLASS_302 | genres |
| Trope | SDD_CLASS_303 | tropes |
| Order | SDD_CLASS_304 | orders |
| OrderItem | SDD_CLASS_305 | order_items |
| Cart | SDD_CLASS_306 | carts |
| CartItem | SDD_CLASS_307 | cart_items |
| Coupon | SDD_CLASS_308 | coupons |
| CouponUsage | SDD_CLASS_309 | coupon_usages |
| FlashSale | SDD_CLASS_310 | flash_sales |
| FlashSaleItem | SDD_CLASS_311 | flash_sale_items |
| BookDiscount | SDD_CLASS_312 | book_discounts |
| Review | SDD_CLASS_313 | reviews |
| ReviewHelpful | SDD_CLASS_314 | review_helpfuls |
| ReviewReport | SDD_CLASS_315 | review_reports |
| Wishlist | SDD_CLASS_316 | wishlists |
| PostageRate | SDD_CLASS_317 | postage_rates |
| PostageRateHistory | SDD_CLASS_318 | postage_rate_history |
| UserBookInteraction | SDD_CLASS_319 | user_book_interactions |
| Setting | SDD_CLASS_320 | settings |

---

## Summary

| Package | Identifier | Class Range | Count |
|---------|------------|-------------|-------|
| View Layer | SDD_PKG_100 | SDD_CLASS_100 – SDD_CLASS_183 | 84 |
| Controller Layer | SDD_PKG_200 | SDD_CLASS_200 – SDD_CLASS_242 | 43 |
| Data Access Layer | SDD_PKG_300 | SDD_CLASS_300 – SDD_CLASS_320 | 21 |

---

*This document supports the Bookty E-Commerce System Software Design Document (SDD). Use these identifiers for traceability in design specifications, sequence diagrams, and test documentation.*
