# Girls Boarding House Management System - PHP Version

A modern, responsive web application for managing boarding house operations including tenant management, room management, payment tracking, and reporting.

## 🎨 Features

- **Modern Dashboard** - Beautiful dashboard with statistics cards showing key metrics
- **Sidebar Navigation** - Clean sidebar with SVG icons for easy navigation
- **Tenant Management** - Add, edit, and delete tenant information
- **Room Management** - Manage rooms with different types and statuses
- **Payment Tracking** - Track payment history for rooms
- **Reporting** - View historical records and reports
- **Responsive Design** - Works seamlessly on desktop, tablet, and mobile devices
- **Gradient UI** - Modern gradient design with smooth animations

## 📋 Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web Server (Apache, Nginx, etc.)
- Modern Web Browser

## 🚀 Installation

### 1. Database Setup

1. Open phpMyAdmin or your MySQL client
2. Create a new database named `boardinghouse_db`
3. Import the SQL file:
   ```sql
   source boardinghouse_db.sql
   ```

### 2. Configure Database Connection

Edit `config.php` and update the database credentials:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'boardinghouse_db');
```

### 3. Deploy Files

- Place all files in your web server's root directory (usually `htdocs` for Apache or `www` for Nginx)
- Ensure the `static` and `includes` folders have proper permissions

### 4. Access the Application

Open your browser and navigate to:
```
http://localhost/GHB-PHP/
```

## 📁 Project Structure

```
GHB-PHP/
├── index.php                    # Dashboard entry point
├── config.php                   # Database configuration
├── README.md                    # This file
├── boardinghouse_db.sql         # Database schema and sample data
│
├── public/
│   └── static/
│       ├── style.css            # Main stylesheet with dashboard & sidebar styles
│       └── images/
│           ├── lily.png
│           └── rosa(owner).gif
│
├── includes/
│   ├── header.php               # Header with sidebar navigation
│   └── footer.php               # Footer template
│
└── pages/
    ├── dashboard.php            # Dashboard page (also in index.php)
    ├── tenant/
    │   ├── index.php            # Tenant list
    │   ├── add.php              # Add new tenant
    │   └── edit.php             # Edit tenant
    ├── room/
    │   ├── index.php            # Room list
    │   ├── add.php              # Add new room
    │   └── edit.php             # Edit room
    ├── payment/
    │   └── index.php            # Payment tracking
    └── report/
        └── index.php            # Reports
```

## 🎯 Database Schema

### Tables

**m_tenant** - Tenant information
- `tenant_id` (INT, Primary Key)
- `name` (VARCHAR)
- `phone` (VARCHAR)
- `address` (TEXT)
- `emergency_contact` (VARCHAR)

**m_room** - Room details
- `room_id` (INT, Primary Key)
- `room_number` (VARCHAR)
- `type` (VARCHAR)
- `price` (DECIMAL)
- `status` (VARCHAR)

**t_payment** - Payment records
- `payment_id` (INT, Primary Key)
- `room_id` (INT, Foreign Key)
- `tenant_id` (INT, Foreign Key)
- `amount` (DECIMAL)
- `payment_date` (DATE)

**m_facility** - Room facilities
- `facility_id` (INT, Primary Key)
- `room_id` (INT, Foreign Key)
- `name` (VARCHAR)
- `condition` (VARCHAR)
- `description` (TEXT)

**r_history** - History/Reports
- `report_id` (INT, Primary Key)
- `tenant_id` (INT, Foreign Key)
- `room_id` (INT, Foreign Key)
- `payment_id` (INT, Foreign Key)
- `report_date` (DATE)
- `description` (TEXT)

## 🎨 Design Features

### Color Scheme
- Primary Pink: `#ff6b9d`
- Light Pink: `#ff8fab`
- Background: `#f8f9fa`
- Text: `#333`

### SVG Icons
All navigation items use inline SVG icons:
- Dashboard - Clock icon
- Tenants - People icon
- Rooms - Building icon
- Payments - Credit card icon
- Reports - Chart icon

### Gradients
The sidebar features a beautiful gradient:
```css
background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
```

## 🛠️ Usage

### Adding a Tenant
1. Click "Tenants" in the sidebar
2. Click "Add Tenant" button
3. Fill in the form with tenant information
4. Click "Save Tenant"

### Managing Rooms
1. Click "Rooms" in the sidebar
2. View all rooms or click "Add Room"
3. Fill in room details (number, type, price, status)
4. Status options: Vacant, Occupied, Maintenance

### Viewing Dashboard
The dashboard displays:
- Total tenants count
- Total rooms count
- Occupied rooms count
- Vacant rooms count
- Recent tenants list
- Recent rooms list

## 📱 Responsive Design

The application is fully responsive:
- **Desktop** (1024px+): Full sidebar with labels
- **Tablet** (768px-1024px): Compact sidebar
- **Mobile** (Below 768px): Collapsed sidebar with icons only

## 🔧 Maintenance

### Common Issues

**Database Connection Error:**
- Verify MySQL is running
- Check credentials in `config.php`
- Ensure database `boardinghouse_db` exists

**Files Not Found:**
- Ensure all files are uploaded to the correct directory
- Check file permissions (should be readable)
- Verify includes folder contains header.php and footer.php

**Styling Issues:**
- Clear browser cache (Ctrl+F5 or Cmd+Shift+R)
- Verify static/style.css file exists and is accessible

## 🚀 Future Enhancements

- User authentication system
- Advanced search and filtering
- Expense tracking
- Maintenance scheduling
- Tenant contracts management
- Email notifications
- PDF report generation
- Dashboard charts and graphs

## 📝 License

This project is for educational purposes.

## 👤 Developer

Converted from Flask (Python) to PHP with modern dashboard design and SVG icons.

---

**Last Updated:** June 2026
