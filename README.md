# Laravel Ticketing System

A comprehensive Laravel 10-based customer support ticketing system with a modern, responsive interface.

## ✨ Features

### 🔐 Authentication System
- User registration with email validation
- Secure login/logout functionality with "remember me" option
- Password reset via email
- Profile management (update profile, change password, delete account)
- Complete CSRF protection and input validation

### 📊 Customer Dashboard
- Statistics overview (total tickets, open, in-progress, resolved)
- Recent tickets table with quick actions
- Responsive design with Bootstrap 5
- Professional gradient styling and hover effects

### 🎫 Ticket Management
- **Create tickets** with category, priority, description, and file attachments
- **View ticket details** with conversation thread and activity timeline
- **Edit ticket information** (title, description, priority, category) for open tickets
- **List all tickets** with advanced filtering (status, category, priority), searching, and sorting
- **Add replies** to existing tickets with real-time conversation flow
- **File attachment system** with validation and secure downloads

### 🎨 Frontend Features
- Modern Bootstrap 5 design with custom CSS
- Responsive navigation with collapsible sidebar
- Professional gradient color schemes
- Interactive elements with smooth hover effects
- Form validation with comprehensive error handling
- Success/error flash messages
- Sortable table columns with pagination

### 🛡️ Security Features
- CSRF protection on all forms
- Input validation and sanitization
- File upload validation (types: jpg, png, pdf, doc, docx, txt, zip, max 10MB)
- Authorization middleware ensuring users can only access their own data
- SQL injection prevention through Eloquent ORM

### 📁 File Management
- Secure file upload with validation
- Support for multiple file types (images, documents, archives)
- Secure download with authorization checks
- Automatic file size formatting

## 🚀 Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL/MariaDB
- Node.js & NPM (for frontend assets)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/isacnaveen12/laravel-ticketing-system.git
   cd laravel-ticketing-system
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   Edit `.env` file with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_ticketing
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run database migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Create storage symlink**
   ```bash
   php artisan storage:link
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` to access the application.

## 📊 Database Schema

### Tables
- **users** - Customer accounts
- **categories** - Ticket categories (Technical Support, Billing, etc.)
- **tickets** - Support tickets with status tracking
- **ticket_replies** - Conversation messages
- **ticket_attachments** - File attachments
- **password_reset_tokens** - Password reset functionality

### Relationships
- User → hasMany → Tickets, TicketReplies
- Category → hasMany → Tickets
- Ticket → belongsTo → User, Category
- Ticket → hasMany → TicketReplies, TicketAttachments

## 🎯 Usage

### For Customers

1. **Registration/Login**
   - Create an account or login with existing credentials
   - Password reset functionality available

2. **Dashboard**
   - View ticket statistics and recent activity
   - Quick access to common actions

3. **Creating Tickets**
   - Navigate to "New Ticket"
   - Fill in subject, category, priority, and description
   - Attach relevant files (optional)
   - Submit for support team review

4. **Managing Tickets**
   - View all tickets with filtering and search
   - Click on any ticket to view details
   - Add replies to ongoing conversations
   - Edit open tickets as needed

5. **Profile Management**
   - Update personal information
   - Change password
   - Delete account (with confirmation)

## 🔧 Configuration

### File Upload Settings
- Supported formats: JPG, PNG, PDF, DOC, DOCX, TXT, ZIP
- Maximum file size: 10MB per file
- Storage location: `storage/app/ticket-attachments/`

### Email Configuration
Configure email settings in `.env` for password reset functionality:
```
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yoursite.com
MAIL_FROM_NAME="${APP_NAME}"
```

## 🎨 Customization

### Color Schemes
The application uses CSS custom properties for easy theme customization:
```css
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}
```

### Adding Categories
Use the Category seeder or add directly to the database:
```php
Category::create([
    'name' => 'Your Category',
    'description' => 'Category description'
]);
```

## 🔒 Security Best Practices

- All forms include CSRF tokens
- User input is validated and sanitized
- File uploads are restricted by type and size
- Users can only access their own tickets
- Passwords are hashed using Laravel's bcrypt
- SQL injection prevention through Eloquent ORM

## 📱 Responsive Design

The application is fully responsive and works on:
- Desktop computers
- Tablets
- Mobile phones
- Various screen sizes and orientations

## 🛠️ Technology Stack

- **Backend**: Laravel 10, PHP 8.1+
- **Frontend**: Bootstrap 5, Custom CSS, JavaScript
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel's built-in auth system
- **File Storage**: Local storage with Laravel's filesystem
- **Validation**: Laravel's form validation
- **Security**: CSRF protection, input sanitization

## 📝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 🆘 Support

For support or questions, please create an issue in the GitHub repository or contact the development team.

---

**Laravel Ticketing System** - A modern, secure, and user-friendly customer support solution.