# User Interface Description (Use Case Based)

This document describes the user interface for the Bookty Management System **strictly based on the use cases** defined in the Use Case Diagram. Each section maps a use case to its required UI elements in paragraph form.

---

## 1. Guest Actor

### 1.1 Register

The Register use case is supported by a dedicated registration page or modal form. The interface provides input fields for the user to enter their email, password, name, and any other required registration details. A submit button allows the user to create their account. Upon successful registration, the user is typically redirected to the login page or logged in automatically.

### 1.2 Login

The Login use case is supported by a login page or modal form. The interface includes input fields for the user to enter their email or username and password. A Log In button submits the credentials for authentication. An optional Forgot Password link may be provided to help users recover their account access.

### 1.3 Browse Books

The Browse Books use case is supported by the main book discovery interface. A prominent search bar allows users to find books by title, author, or keywords. Navigation or filtering options such as categories, genres, or new arrivals help users explore the catalog. A display area shows book listings with cover images, titles, authors, and prices. When a user selects a book, they are taken to a Book Details page that presents more comprehensive information about the selected book.

---

## 2. Customer Actor

*The Customer actor has access to all Guest use cases plus the following:*

### 2.1 View Recommendations

The View Recommendations use case is supported by a dedicated section or widget on the customer dashboard or homepage. This area displays personalized book recommendations tailored to the logged-in customer. The recommendations may be presented as a carousel, a list, or a grid of suggested books based on the customer's preferences or purchase history.

### 2.2 Add to Cart

The Add to Cart use case is supported by an Add to Cart button or icon that appears on the Book Details page and optionally on book listing cards. When the customer clicks this control, the selected book is added to their shopping cart. The button may provide visual feedback such as a quantity indicator or confirmation message.

### 2.3 Purchase Books

The Purchase Books use case is supported by a multi-step checkout process. The first step is a Shopping Cart page that displays all selected items with their quantities, subtotal, and options to update or remove items. The next step presents a form for the customer to enter or select shipping information, including delivery address and delivery options. A subsequent step allows the customer to select or enter payment information, which may integrate with a payment gateway. Finally, an Order Review page presents a summary of the order before the customer confirms the purchase.

### 2.4 Manage Profile

The Manage Profile use case is supported by a My Profile or Account Settings page. This page allows the customer to view their personal information such as name, email, and shipping addresses. Editable forms enable the customer to update their personal details. A separate form or section allows the customer to change their password. The interface provides a clear way to save changes and receive confirmation of updates.

---

## 3. Admin Actor

### 3.1 Manage Book

The Manage Book use case is supported by an administrative section for the book catalog. A book list displays all books with options to search, filter, and sort. An Add New Book action leads to a form where the admin can enter the book title, author, ISBN, description, price, stock quantity, and upload a cover image. Edit Book functionality opens a pre-populated form to update existing book details. Delete Book functionality allows removal of a book, typically with a confirmation dialog to prevent accidental deletion.

### 3.2 Manage Order

The Manage Order use case is supported by an order management interface. A list displays all customer orders with details such as order ID, customer name, date, total amount, and current status. Filtering and sorting options allow the admin to find orders by status or date range. An Order Details page for each order shows the items purchased, customer details, and shipping information. Controls allow the admin to update the order status through stages such as Processing, Shipped, and Delivered.

### 3.3 Manage Promotion

The Manage Promotion use case is supported by a promotion management interface. A list displays active and past promotions or coupons. Create New Promotion leads to a form where the admin can define the promotion type (e.g., discount percentage or fixed amount), applicable products, validity dates, coupon codes, and minimum purchase requirements. Edit Promotion and Delete Promotion options allow the admin to modify or remove existing promotions.

### 3.4 Manage Reports

The Manage Reports use case is supported by a reports interface. A dashboard or menu provides access to different report types such as sales reports, inventory reports, and customer activity reports. Options allow the admin to generate reports with specified parameters such as date ranges or product categories. Reports are displayed as tables, charts, or downloadable files for analysis and decision-making.

---

## 4. Superadmin Actor

*The Superadmin actor has access to all Admin use cases plus the following:*

### 4.1 Manage Admin

The Manage Admin use case is supported by an admin user management interface. A list displays all admin accounts in the system. Create New Admin leads to a form where the superadmin can set up new admin users with their credentials and assign an initial role. Edit Admin allows the superadmin to update admin details or change their roles. Delete Admin functionality allows removal of admin accounts, typically with appropriate safeguards.

### 4.2 Manage Permission and Roles

The Manage Permission and Roles use case is supported by a roles and permissions management interface. A list displays all defined roles such as Admin, Editor, and Moderator. Create Role functionality allows the superadmin to define new roles and assign specific permissions to each role, such as "can manage books," "can view reports," or "can manage users." This may be presented as a matrix or checklist interface to associate permissions with roles. Edit Role and Delete Role options allow the superadmin to modify or remove existing roles.

---

*This document is derived solely from the Bookty Management System Use Case Diagram.*
