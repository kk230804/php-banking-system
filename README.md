# PHP Banking Management System

A secure and dynamic web-based banking system built using **PHP**, **MySQL**, and **Tailwind CSS**. This project simulates real-world banking operations such as login via MPIN, fund transfers, sweep-in/out automation, and investment/insurance management.

---

## 🔧 Technologies Used

- **Frontend**: HTML, Tailwind CSS, JavaScript (AJAX)
- **Backend**: PHP (using PDO for database interaction)
- **Database**: MySQL (with phpMyAdmin or MySQL Workbench)
- **Hosting (Local)**: WAMP or XAMPP stack

---

## 🎯 Key Features

- MPIN-based login system with security questions
- Auto-refreshing balance and real-time UI updates
- Fund transfers with support for linked accounts
- Sweep-In / Sweep-Out automation with logs
- Investment and insurance tracking
- Transaction history with date filtering
- Fully responsive UI with custom header and footer

---

## 🛠️ How to Run Locally

1. **Clone the repository**  
  
   git clone https://github.com/kk230804/php-banking-system.git
Set up the database

Open phpMyAdmin

Create a new database: bankdata

Import your project SQL file (bankdata.sql if available)

Update DB connection (if needed)
In your PHP files, ensure DB connection is like this:


$conn = new PDO("mysql:host=localhost;dbname=bankdata", "root", "pass");
Launch the application

Start Apache & MySQL in WAMP/XAMPP

Visit in browser:
http://localhost/BankProject/login.php
📁 Folder Structure
pgsql
Copy
Edit
BankProject/
├── login.php
├── dashboard.php
├── fundtransfer.php
├── sweep.php
├── investments.php
├── insurance.php
├── profile.php
├── README.md
└── bankdata.sql (optional)
🚫 Disclaimer
This application is for educational/demo use only. It is not production-ready.
All user data is stored locally and not encrypted. Use responsibly.

👤 Author
GitHub: kk230804
Project Type: Academic BCA Final Project
Status: Completed & Functional on Localhost


