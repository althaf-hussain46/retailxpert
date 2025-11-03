# 🛒 RetailXpert – Web-Based Inventory Management System

RetailXpert is a **web-based inventory management system** designed to streamline retail operations such as product management, purchases, sales, stock management, and user access control.  
It was developed as part of the **MCA Final Year Project** for a real-world retail shop named **OPTIONS Mobiles & Accessories - Saligramam**.

---

## 🚀 Project Overview

RetailXpert is built using **Core PHP**, **MariaDB**, **HTML**, **CSS**, **Bootstrap** and **JavaScript**.  
The system allows small and medium retailers to efficiently manage suppliers, customers, products, stock flow, and user permissions — all from a single dashboard.

---

## 🧩 Key Modules

### 1. Masters Module
Manage master data used across the system:
- Company & Branch Forms – Accessed only by developer 
- Suppliers  
- Customers  
- Salespersons  

### 2. Product Module
Manage product catalog with detailed attributes:
- Product, Brand, Design, and Category  
- Color, Size, Batch, Tax and HSN Code  
- MRP and Item Management 
- (Add / Edit / Delete / Reprint)

### 3. Transactions Module
Handle purchase and sales processes:
- **Purchase Entry** 
- **Purchase Return** 
- **Sales Entry** &  **Sales Return** 
- (Add / Edit / Delete / Reprint)

### 4. Stock Management
Track and manage stock availability, movement, and valuation across all transactions.

### 5. User Management & RBAC
Includes an **Advanced Role-Based Access Control (RBAC)** system:
| Role | Permissions |
|------|--------------|
| **Admin** | Full Forms access (except Company & Branch Forms) |
| **Manager** | Based on admin permission |
| **User** | Based on manager permission |

---

## ⚙️ Technology Stack

| Component | Technology |
|------------|-------------|
| **Frontend** | HTML5, CSS3, Bootstrap And JavaScript |
| **Backend** | Core PHP |
| **Database** | MariaDB |
| **Web Server** | Apache (XAMPP/WAMP recommended) |

---

## 🧠 Features Summary

- Intuitive dashboard for purchase and sales tracking  
- User-based permission system (Admin, Inventory, Sales)  
- Auto stock update on transactions  
- Reprint functionality for invoices  
- Simple UI with optimized performance  
- Real-time data validation  

---


## 🧾 Setup Instructions

### 1. Prerequisites
- Install Visual Studio Code
- Install **XAMPP** or **WAMP** on your system.
- Ensure **Apache** and **MySQL/MariaDB** services are running.

### 2. Installation
1. Copy the `RetailXpert` folder to your web directory:  
   - `C:\xampp\htdocs\RetailXpert` (for XAMPP)
2. Import the database:
   - Open **phpMyAdmin** → Create a database named `retailxpert`
   - Import the SQL file (`retailxpert.sql`)
3. Update your database credentials inside  
   `includes/config.php`
4. Start Apache & MySQL servers.
5. Access the app via browser:  
   👉 `http://localhost/RetailXpert`

---

## 🔐 Default Credentials

| Role | Username | Password |
|------|-----------|-----------|
| Admin | Demo@Admin | Demo_12345 |
| Manager | Demo@Manager | 123 |


---

## 🧱 Pending Features

- GST Tax Reports  
- Advanced Analytics Dashboard  
- Barcode Integration  

---


## 📸 Screenshots
<img width="1891" height="770" alt="image" src="https://github.com/user-attachments/assets/c33e2c88-cf1c-4a5e-83c4-aa93cdcc1a70" />
<br>
<br>
<br>
<img width="1891" height="829" alt="image" src="https://github.com/user-attachments/assets/d17734af-e795-45b8-b815-75baa11f9d80" />
<br>
<br>
<br>
<img width="1891" height="829" alt="image" src="https://github.com/user-attachments/assets/eb81989a-f08f-4e34-b519-f723ca1c862e" />
<br>
<br>
<br>
<img width="1891" height="829" alt="image" src="https://github.com/user-attachments/assets/d9bbde14-939d-48d7-b6f7-e481ad0fb91c" />
<br>
<br>
<br>
<img width="1891" height="829" alt="image" src="https://github.com/user-attachments/assets/c9ecb48d-90ed-4d8f-9c96-4abfb8c0e312" />
<br>
<br>
<br>
<img width="1891" height="829" alt="image" src="https://github.com/user-attachments/assets/f51e3fbf-daae-49f0-8b50-4df7dd4c463b" />
<br>
<br>
<br>

---


## 🤝 Acknowledgements
Special thanks to **OPTIONS Mobiles & Accessories Shop** for providing real-time project requirements and feedback during system development.

---

##  Project Links :

Website Link : https://www.retailxpert.in
<br>
<br>
Demo Video  : https://drive.google.com/file/d/1mAIXT4P57S3A7-4Uc-ysghSSBiWxQLuN/view





