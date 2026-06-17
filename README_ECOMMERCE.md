# Laravel 12 E-Commerce Project

A complete, production-ready e-commerce application built with Laravel 12, featuring a modern and responsive design.

## Features

- 🛍️ **Product Management**: Full CRUD operations for products
- 📂 **Category Management**: Organize products into categories
- 🛒 **Shopping Cart**: Add, update, and remove items from cart
- 📦 **Order Management**: Complete order processing system
- 👤 **User Authentication**: Secure user registration and login
- 🔐 **Admin Panel**: Admin functionality for managing products and categories
- 📱 **Responsive Design**: Mobile-friendly interface using Tailwind CSS
- 🎨 **Modern UI**: Beautiful and intuitive user interface
- 💾 **Database**: Optimized database schema with migrations
- 🧪 **Testing Ready**: PHPUnit configured and ready for tests

## Requirements

- PHP 8.3 or higher
- MySQL 8.0 or higher
- Node.js 18 or higher
- Composer

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/ahmedibrahem20044-cell/LaravelProject.git
   cd LaravelProject
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Copy environment file**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Create database**
   ```bash
   # Update .env with your database credentials
   php artisan migrate
   ```

7. **Seed sample data (optional)**
   ```bash
   php artisan db:seed
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   ```

## Running the Application

### Development Mode
```bash
npm run dev
```

### Production Mode
```bash
npm run build
php artisan serve
```

Access the application at `http://localhost:8000`

## Project Structure

```
.
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ProductController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── CartController.php
│   │   │   └── OrderController.php
│   ├── Models/
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Cart.php
│   │   ├── Order.php
│   │   └── OrderItem.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── layouts/
│       ├── products/
│       ├── cart/
│       └── orders/
├── routes/
│   └── web.php
└── public/
```

## Database Schema

### Tables
- `users` - User accounts
- `categories` - Product categories
- `products` - Products
- `carts` - Shopping cart items
- `orders` - Customer orders
- `order_items` - Items in orders

## API Routes

### Products
- `GET /products` - List all products
- `GET /products/{id}` - View product details
- `POST /products` - Create product (Admin)
- `PUT /products/{id}` - Update product (Admin)
- `DELETE /products/{id}` - Delete product (Admin)

### Categories
- `GET /categories` - List all categories
- `GET /categories/{id}` - View category details
- `POST /categories` - Create category (Admin)
- `PUT /categories/{id}` - Update category (Admin)
- `DELETE /categories/{id}` - Delete category (Admin)

### Cart
- `GET /cart` - View cart
- `POST /cart/add/{product}` - Add item to cart
- `PUT /cart/{id}` - Update cart item
- `DELETE /cart/{id}` - Remove item from cart
- `DELETE /cart` - Clear cart

### Orders
- `GET /orders` - List user orders
- `GET /orders/{id}` - View order details
- `POST /orders` - Create order

## Configuration

Edit `.env` file to configure:
- Database connection
- Application URL
- Mail settings
- File storage

## Testing

Run tests using:
```bash
php artisan test
```

## Deployment

1. Update `.env` for production
2. Run migrations: `php artisan migrate --force`
3. Build assets: `npm run build`
4. Configure web server
5. Set proper file permissions

## Security

- All passwords are hashed using bcrypt
- CSRF protection enabled
- SQL injection protection via Eloquent ORM
- XSS protection enabled
- Admin routes require authentication

## License

MIT License - See LICENSE file

## Support

For issues or questions, please create an issue on GitHub.

## Contributors

- Ahmad Ibrahim

## Changelog

### Version 1.0.0
- Initial release
- Complete product management
- Shopping cart functionality
- Order processing
- User authentication
- Admin panel
