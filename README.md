# Settle Medical Module

A comprehensive Laravel application for managing medical student clinical rotations, incidents, learning logs, and weekly reflections.

## 🏥 Features

### Core Functionality
- **Clinical Rotation Management** - Track student rotations and progress
- **Incident Reporting** - Structured incident reporting system
- **Learning Logs** - Document learning experiences and insights
- **Weekly Reflections** - Student reflection and feedback system
- **User Management** - Multi-role user system (Admin, Students, Department Admins)
- **Activity Logging** - Comprehensive activity tracking
- **WhatsApp Notifications** - Automated notifications via WhatsApp

### Dashboard Features
- **Admin Dashboard** - Comprehensive overview with statistics
- **Student Dashboard** - Personalized student interface
- **Department Admin Dashboard** - Department-specific management
- **Real-time Statistics** - Live data with caching for performance
- **Recent Activity** - Recent incidents, learning logs, and reflections

### Technical Features
- **Laravel 11** - Latest Laravel framework
- **Tailwind CSS** - Modern, responsive design
- **MySQL Database** - Robust data management
- **Caching System** - Optimized performance
- **Email Integration** - SMTP email notifications
- **WhatsApp Integration** - Fonnte API integration
- **Multi-language Support** - Indonesian language support

## 🚀 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL 8.0 or higher

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/gmaramis/settlemodule.git
   cd settlemodule
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Build assets**
   ```bash
   npm run build
   ```

6. **Start the application**
   ```bash
   php artisan serve
   ```

## 📊 Database Structure

### Key Tables
- `users` - User management with roles
- `clinical_rotations` - Rotation tracking
- `incidents` - Incident reports
- `weekly_reflections` - Student reflections
- `learning_logs` - Learning documentation
- `activity_logs` - System activity tracking
- `broadcast_messages` - System notifications

### User Roles
- **Admin** - Full system access
- **Student** - Personal dashboard and submissions
- **Department Admin** - Department-specific management

## 🎨 Customization

### Logo & Branding
- Replace logo files in `public/images/logos/`
- Update favicon in `public/favicon.ico`
- Modify app name in `.env` file

### Developer Information
- Update developer details in `config/developer.php`
- Customize footer in `resources/views/components/footer.blade.php`

### Email Configuration
- Configure SMTP settings in `.env`
- Customize email templates in `resources/views/emails/`

## 📱 WhatsApp Integration

### Setup
1. Get Fonnte API token
2. Configure in `.env`:
   ```
   FONNTE_API_TOKEN=your_token_here
   FONNTE_PHONE_NUMBER=your_phone_number
   ```

### Features
- Incident notifications
- Learning log reminders
- Weekly reflection alerts
- System announcements

## 🔧 Configuration

### Environment Variables
```env
APP_NAME="Settle Medical"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=settle_medical
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls

FONNTE_API_TOKEN=your_fonnte_token
FONNTE_PHONE_NUMBER=your_phone_number
```

## 📚 Documentation

### Guides Available
- `docs/guides/COMPLETE_CUSTOMIZATION_GUIDE.md` - Full customization guide
- `docs/guides/EMAIL_CONFIG.md` - Email configuration
- `docs/guides/WHATSAPP_NOTIFICATION_SETUP.md` - WhatsApp setup
- `docs/guides/INCIDENT_REPORTING_GUIDE.md` - Incident reporting system

### API Documentation
- RESTful API endpoints for all modules
- Authentication via Laravel Sanctum
- Rate limiting and security measures

## 🧪 Testing

### Run Tests
```bash
php artisan test
```

### Test Coverage
- Authentication tests
- Feature tests
- Unit tests
- Integration tests

## 🚀 Deployment

### Production Setup
1. Configure production environment
2. Set up SSL certificate
3. Configure database
4. Set up email service
5. Configure WhatsApp service
6. Run migrations and seeders

### Performance Optimization
- Enable caching
- Optimize database queries
- Use CDN for assets
- Configure queue workers

## 📈 Monitoring

### Activity Logging
- User actions tracking
- System events logging
- Performance monitoring
- Error tracking

### Analytics
- User engagement metrics
- System usage statistics
- Performance indicators

## 🤝 Contributing

### Development
1. Fork the repository
2. Create feature branch
3. Make changes
4. Test thoroughly
5. Submit pull request

### Code Standards
- Follow PSR-12 coding standards
- Write comprehensive tests
- Document new features
- Maintain backward compatibility

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 👨‍💻 Developer

**Glenn Maramis**
- Email: glendpm@gmail.com
- WhatsApp: +62 852-4054-3123
- Services: Web Development, Mobile App Development, System Integration

## 🆘 Support

For support and inquiries:
- Email: glendpm@gmail.com
- WhatsApp: +62 852-4054-3123
- GitHub Issues: [Create an issue](https://github.com/gmaramis/settlemodule/issues)

## 🔄 Changelog

### Version 1.0.0
- Initial release
- Core functionality implemented
- Admin dashboard with statistics
- Student management system
- Incident reporting system
- Learning logs and reflections
- WhatsApp notifications
- Email integration
- Multi-language support

---

**Settle Medical Module** - Streamlining medical education management 🏥✨