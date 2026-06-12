# MSL FinTrack & Scheduler

**MSL FinTrack & Scheduler** is an integrated scheduling, inventory management, and real-time financial tracking system. Designed for retail businesses and warehouse operations, this application enables managers to monitor inventory health, schedule routine tasks, define monthly budgets, and analyze spending efficiency under a unified, premium-grade interface.

Built using the **Laravel 11** framework, **Tailwind CSS**, **Chart.js**, and an embedded **SQLite** database, the system runs with zero server configuration and fast query execution.

---

## 📖 Table of Contents
1. [System Overview](#-system-overview)
2. [Key Features](#-key-features)
   - [Authentication & Access Control](#1-authentication--access-control)
   - [Interactive Calendar & Event Scheduling](#2-interactive-calendar--event-scheduling)
   - [Inventory & Expiry-to-Schedule Sync](#3-inventory--expiry-to-schedule-sync)
   - [Dynamic Financial Analytics & Budgeting](#4-dynamic-financial-analytics--budgeting)
   - [Budget Variance Analysis (Rencana vs Realisasi)](#5-budget-variance-analysis-rencana-vs-realisasi)
   - [Monthly PDF Performance Exporter](#6-monthly-pdf-performance-exporter)
   - [Supplier CRUD Management](#7-supplier-crud-management)
3. [Database Architecture](#%EF%B8%8F-database-architecture)
4. [Installation & Setup](#%EF%B8%8F-installation--setup)
5. [Running Tests](#-running-tests)

---

## 🌟 System Overview

MSL FinTrack & Scheduler acts as the central control room for your shop's operations. The application is divided into a **Public Interface** (read-only calendar, information page) and an **Admin Dashboard** (role-restricted controls). 

The application utilizes a **50/30/20 budgeting rule** (Needs / Wants / Savings) and provides real-time financial advisory warnings. It also connects directly to Cashier POS API logs to dynamically feed transaction data into the cash flow ledger, ensuring that the main cash pool ("Saldo Kas Utama") stays up-to-date automatically.

---

## 🚀 Key Features

### 1. Authentication & Access Control
- **Secure Authentication**: Traditional credentials log-in with dynamic input highlights for errors and show/hide password buttons.
- **Role-Based Access Control (RBAC)**:
  - `admin` (Super Admin): Full access to user management, supplier listings, schedules, inventory, and finance dashboards.
  - `operator`: Access to edit inventory, suppliers, and schedules. Cannot access user management or financial analysis.
  - `staff`: Read-only access to view schedules and active tasks.
- **User Management**: Dedicated control page restricted to Super Admins to add, edit, or delete users.

### 2. Interactive Calendar & Event Scheduling
- **FullCalendar 6 Integration**: High-performance calendar view styled in a custom slate/emerald theme.
- **Drag-and-Drop Rescheduling**: Admins can reschedule tasks by dragging them to new dates on the grid, updating the backend instantly via AJAX.
- **National Holidays Sync**: Pulls live holiday listings from a government holidays API. Public holidays are colored amber, marked as read-only, and factored into scheduling conflicts.
- **Public vs Admin Views**: Public calendar view is strictly read-only for employees or customers, while the Admin calendar provides task completion toggling and deletion.

### 3. Inventory & Expiry-to-Schedule Sync
- **Stock Tracking**: Logs item checkings, listing minimum stock requirements, wholesale costs, retail prices, and expiry dates.
- **Automatic Expiry Scheduling**: When an item's expiration date is set, the system automatically creates a calendar task named after the product in the "Kedaluwarsa Barang" category.
- **Expiry Formula**: 
  - The actual expiration task date is set on the product's `expired_date`.
  - An implementation action reminder is created **30 days prior** to expiration (prevented from pre-dating the entry date).
- **Cascaded Sync**: Deleting or updating an item's expiration details in the inventory automatically updates or removes the corresponding calendar events.

### 4. Dynamic Financial Analytics & Budgeting
- **Saldo Kas Utama**: A prominent main cash pool card starting with a default baseline of Rp1,000,000,000. It dynamically increases from POS sales profits and decreases from operational expenses.
- **Health Advisor Engine**: Generates a dynamic layout score (0-100) and recommendations based on the operating ratio (total expenses vs gross profits).
- **50/30/20 Allocation Meter**: Progress bars tracking:
  - **Needs**: Operational costs & maintenance.
  - **Wants**: Restocking and raw inventory purchases.
  - **Savings**: Favorable surplus margins retained in the cash pool.
- **Monthly Period Selector**: All calculations, ledgers, daily transactions, and charts are filtered to the selected month.
- **Interactive Budget Simulator**: A sandbox widget where users input proposed costs to see how it affects their 50/30/20 compliance and cash flow status *before* creating the expense.
- **6-Month Performance Chart**: An area line chart mapping Gross Profit, Expenses, and Net margins over the last 6 months.

### 5. Budget Variance Analysis (Rencana vs Realisasi)
- Located on the Finance page, this table analyzes:
  - **Budget Limit**: The category allocation defined in the monthly budgeting planner.
  - **Actual Spent**: Real-time spending compiled from schedule costs and manual transaction logs.
  - **Remaining Balance**: Positive surplus or negative overrun values.
  - **Variance %**: Percentage deviation. Over-budget categories trigger animated warning badges to help identify waste immediately.

### 6. Monthly PDF Performance Exporter
- A printable report layout launched from the main dashboard via the **"Ekspor PDF"** button.
- Styled with A4 print-optimized styles (hides navigation bars and sidebars, formats text fields, and prevents orphan headers).
- Features:
  - Core financial summary (KPIs, Cash pool, Financial Health).
  - Copy of the Budget Variance table.
  - **Pembelian Barang / Restocking section**: Table listing item name, category, quantity, wholesale/retail prices, total modal, and gross profit.
  - **Operational Costs section**: Itemized list of operational schedules and manual expenses.
  - **Maintenance Costs section**: Itemized list of maintenance schedules and manual expenses.
- Includes manager sign-off blocks and an auto-triggered print dialog.

### 7. Supplier CRUD Management
- Full database of business vendors, storing addresses, PIC (person-in-charge) names, and partnership start dates.
- Status toggle to mark suppliers as active/inactive to restrict scheduling raw material purchases.

---

## 🛠️ Database Architecture

The application uses an embedded **SQLite** database (`database/database.sqlite`). The schema consists of the following primary tables:

1. **`users`**: User records containing role, email, telephone, and password credentials.
2. **`suppliers`**: Supplier details (PIC, address, active status).
3. **`inventory_checkings`**: Active warehouse inventory items, tracking stock, wholesale cost, and retail price.
4. **`schedules`**: Calendar events with status, date, budget allocations, and references to creator and inventory IDs.
5. **`jenis_schedules`**: Categories for schedules (e.g. `Pembelian Barang / Restocking`, `Operasional`, `Maintenance`, `Libur`).
6. **`jenis_barangs`**: Product category groups.
7. **`daily_transactions`**: Manual daily logs or API cashier transaction receipts (pemasukan/pengeluaran).
8. **`monthly_budgets`**: Overall monthly budget goals and starting cash baselines.
9. **`budget_allocations`**: Target category limit configurations under a monthly budget.

---

## ⚙️ Installation & Setup

Follow these steps to set up and run MSL FinTrack & Scheduler locally:

### 1. Prerequisites
- **PHP**: ^8.2
- **Composer**
- **Node.js & NPM**

### 2. Setup Project
Clone the repository and navigate into the root directory:
```bash
composer install
npm install
```

Copy the environment configuration file:
```bash
cp .env.example .env
```
*(By default, `.env` configures `DB_CONNECTION=sqlite` and points to the `database/database.sqlite` file. If the SQLite file does not exist, touch it)*:
```bash
touch database/database.sqlite
```

Generate the application key:
```bash
php artisan key:generate
```

### 3. Initialize Database
Run database migrations and seeders to populate realistic 6-month transaction records, active categories, and default users:
```bash
php artisan migrate:fresh --seed
```

Default credentials:
- **Email**: `admin@example.com`
- **Password**: `password123`
- **Role**: `admin`

### 4. Compile Assets & Run Server
Run the Vite asset compiler and boot the PHP server in separate terminal windows:
```bash
npm run dev
php artisan serve
```
The application will default to `http://127.0.0.1:8000` or `http://127.0.0.1:8001`.

---

## 🧪 Running Tests

The application features a comprehensive automated test suite testing routes, access control middleware, database model hooks, and finance calculations.

To run the automated tests:
```bash
php artisan test
```
*(All 36 test cases should pass successfully)*.
