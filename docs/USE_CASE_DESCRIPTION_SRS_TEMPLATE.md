# Use Case Description Guide for SRS Report

This document provides a template and guide for writing Use Case Descriptions for the Bookty Management System Software Requirements Specification (SRS). Use this structure for each use case in your report.

---

## Table of Contents

1. [Template Structure](#template-structure)
2. [Section Guidelines](#section-guidelines)
3. [Use Case ID Convention](#use-case-id-convention)
4. [Completed Examples](#completed-examples)
5. [Quick Reference Checklist](#quick-reference-checklist)

---

## Template Structure

Copy the following template for each use case:

```
### Use Case: [Use Case Name]
**Use Case ID:** UC-XXX
**Version:** 1.0
**Date:** [Date]

| Attribute | Description |
|-----------|-------------|
| **Use Case Name** | [Name] |
| **Brief Description** | [One or two sentences] |
| **Primary Actor** | [Actor name] |
| **Secondary Actor(s)** | [If any] |
| **Preconditions** | [What must be true before use case starts] |
| **Postconditions (Success)** | [System state after successful completion] |
| **Postconditions (Failure)** | [System state if use case fails] |
| **Trigger** | [What initiates the use case] |
| **Frequency of Use** | [e.g., Daily, Weekly, Per session] |

#### Main Flow
1. [Step 1]
2. [Step 2]
3. [Step 3]
...

#### Alternative Flows
- **A1:** [Condition] – [Steps]
- **A2:** [Condition] – [Steps]

#### Exception Flows
- **E1:** [Condition] – [Steps]
- **E2:** [Condition] – [Steps]

#### Business Rules
- BR-1: [Rule]
- BR-2: [Rule]

#### Special Requirements
- [Non-functional requirements if any]

#### Related Use Cases
- Includes: [Use case name]
- Extends: [Use case name]
```

---

## Section Guidelines

### Brief Description
Write 1–2 sentences summarizing what the use case accomplishes from the actor’s perspective.

### Primary Actor
The main actor who initiates and benefits from the use case (e.g., Guest, Customer, Admin, Superadmin).

### Secondary Actor(s)
Other actors or external systems that participate (e.g., Payment Gateway, Email System). Use "None" if not applicable.

### Preconditions
Conditions that must be true before the use case can start. Examples:
- User is on the correct page
- User is authenticated
- Required data exists in the system

### Postconditions (Success)
System state after successful completion. Examples:
- New record created
- User is logged in
- Order is placed

### Postconditions (Failure)
System state when the use case fails or is cancelled. Examples:
- No changes saved
- User remains on the same page
- Error message displayed

### Trigger
What starts the use case. Examples:
- User clicks "Register"
- User submits login form
- Admin opens order list

### Main Flow
Numbered steps describing the normal, successful path. Use active voice and actor–system interaction. Each step should be clear and testable.

### Alternative Flows
Other valid paths (e.g., optional steps, different choices). Reference steps from the main flow where they branch (e.g., "At step 3, user selects..."). Use format: **A1:** [Condition] – [Steps].

### Exception Flows
Error or failure paths (e.g., validation errors, system errors). Use format: **E1:** [Condition] – [Steps].

### Business Rules
Constraints and rules that apply to this use case. Number them (BR-1, BR-2, etc.) for traceability.

### Special Requirements
Non-functional aspects such as performance, security, or usability.

### Related Use Cases
- **Includes:** Use case that is always invoked (e.g., "Validate Input")
- **Extends:** Use case that optionally extends this one

---

## Use Case ID Convention

| Actor | ID Range | Example |
|-------|----------|---------|
| Guest | UC-001 to UC-099 | UC-001 Register |
| Customer | UC-100 to UC-199 | UC-101 Add to Cart |
| Admin | UC-200 to UC-299 | UC-201 Manage Book |
| Superadmin | UC-300 to UC-399 | UC-301 Manage Admin |

**Bookty Use Case List (for reference):**

| ID | Use Case | Actor |
|----|----------|-------|
| UC-001 | Register | Guest |
| UC-002 | Login | Guest |
| UC-003 | Browse Books | Guest |
| UC-004 | View Recommendations | Customer |
| UC-005 | Add to Cart | Customer |
| UC-006 | Purchase Books | Customer |
| UC-007 | Manage Profile | Customer |
| UC-008 | Manage Book | Admin |
| UC-009 | Manage Order | Admin |
| UC-010 | Manage Promotion | Admin |
| UC-011 | Manage Reports | Admin |
| UC-012 | Manage Admin | Superadmin |
| UC-013 | Manage Permission and Roles | Superadmin |

---

## Completed Examples

### Example 1: UC-001 Register

| Attribute | Description |
|-----------|-------------|
| **Use Case Name** | Register |
| **Brief Description** | Allows a guest user to create a new account in the system by providing required personal and credential information. |
| **Primary Actor** | Guest |
| **Secondary Actor(s)** | None |
| **Preconditions** | User is not logged in. User has access to the registration page. |
| **Postconditions (Success)** | A new customer account is created. User is either redirected to login page or automatically logged in. |
| **Postconditions (Failure)** | No account is created. User remains on registration page. Error messages are displayed for invalid fields. |
| **Trigger** | Guest clicks "Register" or navigates to the registration page. |
| **Frequency of Use** | Occasional (when new users join) |

#### Main Flow
1. Guest navigates to the registration page.
2. System displays the registration form with fields for name, email, password, and any other required information.
3. Guest enters the required information in the form.
4. Guest submits the form.
5. System validates the input (email format, password strength, uniqueness of email).
6. System creates the new customer account.
7. System displays a success message.
8. System redirects the user to the login page or logs the user in automatically.

#### Alternative Flows
- **A1:** At step 5, if email already exists – System displays an error message indicating the email is already registered. Guest may correct the email or navigate to login. Flow ends.
- **A2:** At step 8, if auto-login is enabled – System logs the user in and redirects to the homepage. Flow ends.

#### Exception Flows
- **E1:** At step 5, if validation fails – System displays field-specific error messages. Guest corrects the input and resubmits. Flow returns to step 3.
- **E2:** At step 6, if system error occurs – System displays a generic error message. No account is created. Flow ends.

#### Business Rules
- BR-1: Email must be unique in the system.
- BR-2: Password must meet minimum length and complexity requirements.
- BR-3: All mandatory fields must be filled before submission.

#### Special Requirements
- Registration form should load within 2 seconds.
- Sensitive data (password) must be transmitted securely.

#### Related Use Cases
- Extends: Login (user may proceed to login after registration)

---

### Example 2: UC-005 Add to Cart

| Attribute | Description |
|-----------|-------------|
| **Use Case Name** | Add to Cart |
| **Brief Description** | Allows a logged-in customer to add a book to their shopping cart for later purchase. |
| **Primary Actor** | Customer |
| **Secondary Actor(s)** | None |
| **Preconditions** | Customer is logged in. Customer is viewing a book (on Book Details page or book listing). Book is available in stock. |
| **Postconditions (Success)** | Book is added to the customer's cart. Cart quantity is updated. User receives visual confirmation. |
| **Postconditions (Failure)** | No change to cart. Error message is displayed. |
| **Trigger** | Customer clicks "Add to Cart" button on a book. |
| **Frequency of Use** | Frequent (multiple times per session) |

#### Main Flow
1. Customer views a book on the Book Details page or book listing.
2. Customer clicks the "Add to Cart" button.
3. System verifies the customer is logged in.
4. System checks if the book is in stock.
5. System adds the book to the customer's cart (or increments quantity if already in cart).
6. System updates the cart count/indicator.
7. System displays a confirmation message (e.g., "Added to cart").

#### Alternative Flows
- **A1:** At step 5, if book is already in cart – System increments the quantity by one. Flow continues to step 6.
- **A2:** At step 2, if customer specifies quantity – System adds the specified quantity. Flow continues to step 5.

#### Exception Flows
- **E1:** At step 3, if customer is not logged in – System redirects to login page. Flow ends.
- **E2:** At step 4, if book is out of stock – System displays "Out of stock" message. No item is added. Flow ends.
- **E3:** At step 4, if requested quantity exceeds stock – System adds maximum available quantity and notifies the customer. Flow continues to step 6.

#### Business Rules
- BR-1: Only logged-in customers can add items to cart.
- BR-2: Quantity added cannot exceed available stock.
- BR-3: Cart must persist across sessions until checkout or abandonment.

#### Special Requirements
- Add to Cart action should respond within 1 second.
- Cart count should update without full page reload (AJAX preferred).

#### Related Use Cases
- Includes: Browse Books (customer must view book first)
- Extends: Purchase Books (add to cart leads to checkout)

---

### Example 3: UC-008 Manage Book

| Attribute | Description |
|-----------|-------------|
| **Use Case Name** | Manage Book |
| **Brief Description** | Allows an admin to create, read, update, and delete books in the system catalog. |
| **Primary Actor** | Admin |
| **Secondary Actor(s)** | None |
| **Preconditions** | Admin is logged in. Admin has permission to manage books. |
| **Postconditions (Success)** | Book catalog is updated (added, modified, or removed). Changes are reflected in the customer-facing catalog. |
| **Postconditions (Failure)** | No changes to catalog. Error message displayed. |
| **Trigger** | Admin navigates to the Book Management section. |
| **Frequency of Use** | Daily |

#### Main Flow
1. Admin navigates to the Book Management section.
2. System displays the list of all books with search, filter, and sort options.
3. Admin performs one of: Add New Book, Edit Book, or Delete Book.

**Add New Book:**
4a. Admin clicks "Add New Book."
5a. System displays the book form (title, author, ISBN, description, price, stock, cover image).
6a. Admin fills in the required fields and submits.
7a. System validates the input.
8a. System creates the new book record.
9a. System displays success message and returns to book list.

**Edit Book:**
4b. Admin selects a book and clicks "Edit."
5b. System displays the form pre-populated with existing book data.
6b. Admin modifies the desired fields and submits.
7b. System validates the input.
8b. System updates the book record.
9b. System displays success message and returns to book list.

**Delete Book:**
4c. Admin selects a book and clicks "Delete."
5c. System displays a confirmation dialog.
6c. Admin confirms deletion.
7c. System removes the book from the catalog.
8c. System displays success message and returns to book list.

#### Alternative Flows
- **A1:** At step 3, admin uses search/filter – System filters the list. Admin selects from filtered results. Flow continues.
- **A2:** At step 5c, admin cancels – System closes dialog. No deletion. Flow returns to step 2.

#### Exception Flows
- **E1:** At step 7a/7b, if validation fails – System displays field errors. Admin corrects and resubmits. Flow returns to form.
- **E2:** At step 7a, if ISBN already exists – System displays "ISBN already in use" error. Flow returns to form.
- **E3:** At step 7c, if book has existing orders – System may prevent deletion or require confirmation. Flow ends or continues based on business rule.

#### Business Rules
- BR-1: ISBN must be unique in the system.
- BR-2: Price and stock must be non-negative numbers.
- BR-3: Cover image must be in allowed format (e.g., JPG, PNG).
- BR-4: Deleting a book may be restricted if it has order history (business decision).

#### Special Requirements
- Admin must have "manage books" permission.
- Image upload size limit should be specified.

#### Related Use Cases
- None (standalone administrative use case)

---

## Quick Reference Checklist

Use this checklist when writing each use case description:

- [ ] Use Case ID assigned (UC-XXX)
- [ ] Brief description written (1–2 sentences)
- [ ] Primary and secondary actors identified
- [ ] Preconditions listed (what must be true before)
- [ ] Success postconditions defined
- [ ] Failure postconditions defined
- [ ] Trigger identified
- [ ] Main flow written (numbered steps, 5–15 steps typical)
- [ ] Alternative flows documented (A1, A2, ...)
- [ ] Exception flows documented (E1, E2, ...)
- [ ] Business rules listed (BR-1, BR-2, ...)
- [ ] Special requirements noted (if any)
- [ ] Related use cases (includes/extends) identified
- [ ] Frequency of use specified

---

## Tips for Writing Effective Use Case Descriptions

1. **Use active voice:** "Customer clicks" not "The button is clicked."
2. **Be specific:** "System validates email format" not "System validates input."
3. **One action per step:** Keep steps atomic and testable.
4. **Number alternative/exception flows:** Reference them in the main flow if needed (e.g., "At step 5, see E1").
5. **Keep main flow happy path:** Main flow should be the most common, successful scenario.
6. **Consistent terminology:** Use the same terms as in your use case diagram and glossary.

---

*This document supports the Bookty Management System SRS Report. Use the template and examples to complete all 13 use case descriptions.*
