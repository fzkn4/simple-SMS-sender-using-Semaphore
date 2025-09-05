# 📱 Simple SMS Sender

A clean, minimal SMS sending application built with PHP and Docker. No authentication, no database, no complexity - just send SMS messages instantly.

![SMS Sender](https://img.shields.io/badge/SMS-Sender-blue)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4)
![Docker](https://img.shields.io/badge/Docker-Ready-2496ED)
![License](https://img.shields.io/badge/License-MIT-green)

## ✨ Features

- 🚀 **One-Click Setup** - Run with Docker Compose in seconds
- 📱 **Single Page App** - Everything in one clean interface
- 🔐 **No Authentication** - No login/signup required
- 📡 **Real SMS Sending** - Uses Semaphore SMS API
- 📱 **Responsive Design** - Works on desktop and mobile
- 📊 **Character Counter** - Live message length tracking
- ✅ **Input Validation** - Phone number and message validation
- 🐳 **Docker Ready** - Containerized for easy deployment

## 🚀 Quick Start

### Prerequisites

- [Docker](https://www.docker.com/get-started) installed
- [Semaphore SMS API Key](https://semaphore.co/) (free account)

### 1. Clone & Run

```bash
# Clone the repository
git clone <your-repo-url>
cd semaphore-sms-web-app

# Start the application
docker-compose up -d

# Access the app
open http://localhost:8080
```

### 2. Get Your API Key

1. Sign up at [Semaphore](https://semaphore.co/)
2. Get your API key from the dashboard
3. Enter it in the app's configuration section

### 3. Send SMS

1. Enter recipient's phone number (e.g., `+1234567890`)
2. Type your message
3. Click "Send SMS"
4. Wait for confirmation! 🎉

## 📁 Project Structure

```
📂 semaphore-sms-web-app/
├── 📄 simple-sms.html     # Main SMS sender interface
├── 📄 send-sms.php        # Backend API for SMS sending
├── 📄 Dockerfile          # Docker configuration
├── 📄 docker-compose.yml  # Docker Compose setup
├── 📄 .dockerignore       # Docker ignore rules
└── 📄 README.md           # This file
```

## 🐳 Docker Commands

```bash
# Start the application
docker-compose up -d

# Stop the application
docker-compose down

# View logs
docker-compose logs -f

# Rebuild and restart
docker-compose up -d --build

# Check status
docker-compose ps
```

## 🔧 Configuration

### Environment Variables

The app uses the following configuration:

- **Port**: 8080 (configurable in `docker-compose.yml`)
- **PHP Version**: 8.2
- **Web Server**: Apache
- **SMS Provider**: Semaphore API

### Customizing the Port

Edit `docker-compose.yml`:

```yaml
ports:
  - "3000:80" # Change 3000 to your preferred port
```

## 📡 SMS Provider Integration

### Current Provider: Semaphore

- **API**: https://api.semaphore.co/api/v4/messages
- **Documentation**: [Semaphore API Docs](https://semaphore.co/docs)
- **Pricing**: Pay-per-SMS model

### Switching to Other Providers

You can easily modify `send-sms.php` to use other SMS providers:

#### Twilio

```php
$data = [
    'From' => '+1234567890',
    'To' => $phone,
    'Body' => $message
];
```

#### TextMagic

```php
$data = [
    'text' => $message,
    'phones' => $phone
];
```

## 🎨 Customization

### Styling

Edit the CSS in `simple-sms.html` to match your brand:

```css
/* Change the gradient background */
background: linear-gradient(135deg, #your-color-1, #your-color-2);

/* Modify button colors */
background: linear-gradient(135deg, #your-button-color-1, #your-button-color-2);
```

### Sender Name

Update the sender name in `send-sms.php`:

```php
'sendername' => 'YOUR_COMPANY_NAME'
```

### Validation Rules

Modify phone number validation in `simple-sms.html`:

```javascript
// Current: International format
if (!/^[\+]?[1-9][\d]{0,15}$/.test(phone)) {
  // Add your custom validation
}
```

## 🔒 Security Considerations

- **API Key Storage**: Currently stored in browser memory
- **Rate Limiting**: Not implemented (consider adding for production)
- **Input Validation**: Basic validation in place
- **HTTPS**: Recommended for production use

### Production Recommendations

1. **Use HTTPS** - Secure your API key transmission
2. **Add Rate Limiting** - Prevent abuse
3. **Environment Variables** - Store API keys securely
4. **Input Sanitization** - Enhanced validation
5. **Logging** - Monitor SMS sending activity

## 🐛 Troubleshooting

### Common Issues

#### 403 Forbidden Error

```
SMS provider returned HTTP 403: Your account has not yet been approved
```

**Solution**:

- Wait for Semaphore account approval (up to 2 business days)
- Top-up your account to speed up approval
- Contact rex@semaphore.co if not approved within 2 days

#### Docker Container Won't Start

```bash
# Check logs
docker-compose logs

# Rebuild container
docker-compose up -d --build
```

#### SMS Not Sending

- ✅ Check API key is correct
- ✅ Verify phone number format (+country_code_number)
- ✅ Check Semaphore account balance
- ✅ Look at browser console for errors

#### Port Already in Use

```bash
# Change port in docker-compose.yml
ports:
  - "8081:80"  # Use different port
```

### Debug Mode

Enable debug logging in `send-sms.php`:

```php
// Add at the top of the file
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 📊 API Reference

### Send SMS Endpoint

**POST** `/send-sms.php`

**Request Body:**

```json
{
  "phone": "+1234567890",
  "message": "Hello World!",
  "api_key": "your_semaphore_api_key"
}
```

**Response:**

```json
{
  "success": true,
  "message": "SMS sent successfully",
  "message_id": "msg_123456"
}
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- [Semaphore](https://semaphore.co/) for SMS API
- [Docker](https://www.docker.com/) for containerization
- [PHP](https://www.php.net/) for backend processing

## 📞 Support

- **Issues**: [GitHub Issues](https://github.com/your-repo/issues)
- **Documentation**: [Wiki](https://github.com/your-repo/wiki)
- **Email**: your-email@example.com

---

**Made with ❤️ for simple SMS sending**
