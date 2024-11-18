# Computer Components Online Store

## Idea and Requirements Analysis
**Idea**: Create a small online store for computer components assembly.

**Business Goal**: Provide a user-friendly interface for selecting and purchasing products.

**Target Audience**: 
- Users who assemble PCs themselves.
- Users who want to upgrade their computers.

**Competitor Analysis**: Simplified cart functionality and website design.

---

## Technical Analysis and Evaluation
**Technical Requirements**:
- Use PHP without frameworks.
- MySQL for data storage.
- Hosting on Zone.ee.

**Effort Estimation**: 2–3 weeks.

**Architecture**: Relational database with tables for orders, products, and users.

---

## Design and Prototyping
- **Layout**: Simple page structure with a product catalog and cart.
- **Prototype**: Categorized catalog, shopping cart, and checkout page.

---

## Planning and Prioritization
**Task Breakdown**:
1. Database setup.
2. Cart functionality.
3. Order processing system.

**Priority**: Core functionality first (catalog and cart).

---

## Development
**Scripts**:
1. `cabinet.php` — Handles adding/removing products from the cart.
2. `checkout.php` — Manages order placement.

---

## Testing
https://github.com/MaksimTse/SolShop
- **Unit Tests**: Verify the add/remove functionality in the cart.
- **Automated UI Testing**: Use Cypress for testing.

---

## Code Review
Check for:
- SQL injection vulnerabilities.
- Code optimization opportunities.

---

## Documentation
Descriptions of scripts:
- `cabinet.php`: Handles cart management.
- `checkout.php`: Processes orders.

---

## Production Testing
- Ensure all categories are displayed correctly.
- Verify that orders are recorded properly in the database.

---

## Release
1. Update the database on the production server.
2. Upload the scripts to the server.

---

## Monitoring and Support
**Metrics**:
- Request processing speed.
- Successful cart additions.

---

## Retrospective
**Outcome**: Analyze sales data.

**Improvements**:
- Add sorting by popularity.
- Add product filters.
# Improvements

- Add sorting by popularity.
- Add product filters.

## Website Screenshot with Redirect

<a href="https://maksimtsepelevits22.thkit.ee/SolShop/index.php">
  <img src="https://github.com/user-attachments/assets/750f10df-e296-4890-999d-598805a30bcc" alt="Screenshot of the website" width="600">
</a>

![Additional Screenshot 1](https://github.com/user-attachments/assets/578e8e1a-3a8d-43f0-b97c-d703d431dfd9)
![Additional Screenshot 2](https://github.com/user-attachments/assets/5ab6bc36-2462-4230-9b5d-898f5b14b1be)
![Additional Screenshot 3](https://github.com/user-attachments/assets/aa9280f3-e1fc-47a7-bac4-170744f62624)
![Additional Screenshot 4](https://github.com/user-attachments/assets/019566e3-29de-442c-b27e-fe56cdf77659)


