# YounMarket

YounMarket is a simple online bookstore built with **PHP** and **MySQL**, designed to demonstrate backend logic, database interaction, and basic e-commerce functionality.  
The project includes both **user** and **admin** panels with separate layouts, authentication, and order management.

---

## 🚀 Features

### 👤 User Panel
- User registration and login system  
- View a list of available books on the main page  
- Add books to the shopping cart  
- Edit or remove items in the cart  
- Choose a delivery date for the order  
- Orders can be edited if the selected date is more than 48 hours ahead  
- View and manage personal orders (edit or delete them)  

### 🛠️ Admin Panel
- Admin login page (separate from user login)  
- Add, edit, or delete books from the store  
- View all user orders awaiting approval  
- Approve or delete user orders with customer details  
- Separate header and footer layout for admin pages  

---

## 🧱 Technologies Used
- PHP (Core PHP, no framework)  
- MySQL (via PDO)  
- HTML5 / CSS3  
- Session-based authentication  
- Modular layout (header, footer, main content)  

---

## 📂 Project Structure

YounMarket/
├── config/ # Database connection (db.php)
├── layout/ # Header and main header templates
├── public/ # Cart and order processing scripts
├── registeration/ # Login, register, logout pages
├── styles/ # CSS files for all pages
├── uploads/ # Uploaded book images
└── images/ # Static images

---

## ⚙️ Setup & Installation

1. Clone this repository:
   git clone https://github.com/YourUsername/YounMarket.git
   
2. Import the provided SQL file into your MySQL database.

3. Update the database credentials in:
   config/db.php

4. Start a local PHP server:
   php -S localhost:8000

5. Open in your browser:
   http://localhost:8000/younMarket/

---

## 🔐 Admin Login Credentials

By default, there is no registration page for the admin.
To access the admin panel, use the following credentials:

Username: Dantey

Password: adminpass

After logging in, you can manage books and orders from the admin dashboard.

---

## 🧑‍💻 Author

Amin Hajian — A PHP developer learning by building real-world projects.

---

## 🏷️ License

This project is released for educational purposes and is free to use or modify.