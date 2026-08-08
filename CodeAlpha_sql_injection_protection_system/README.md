# CodeAlpha SQL Injection Protection & Secure Data System

A Laravel-based web application developed as part of the CodeAlpha internship project.

The system is designed to protect user data against SQL injection attacks while implementing encrypted sensitive data storage, secure password hashing, capability-based access control, and attack logging.

## Live Application

https://codealpha-security.up.railway.app

## Project Repository

https://github.com/vikashtiwari-FSD/codealpha_tasks

---

## Project Objectives

The main objectives of this project are:

- Detect and block SQL injection attempts.
- Log detected attack attempts for security monitoring.
- Protect sensitive user information using AES-256 encryption.
- Store passwords securely using password hashing.
- Implement a second security layer using a Capability Code.
- Restrict access to protected security resources.
- Deploy the application and database to the cloud.
- Provide a lightweight web-based security system accessible through the internet.

---

## Technology Stack

### Backend

- PHP 8.2
- Laravel 12

### Frontend

- Blade Templates
- HTML
- CSS
- Tailwind CSS
- Vite

### Database

- MySQL
- Laravel Eloquent ORM
- Laravel Migrations

### Security

- SQL Injection Detection Middleware
- AES-256-CBC Encryption
- Bcrypt Password Hashing
- Capability Code Verification
- Capability Middleware
- Attack Logging

### Deployment

- Railway
- GitHub

---

# System Security Architecture

```text
                    User
                      |
                      v
              Laravel Application
                      |
          +-----------+-----------+
          |                       |
          v                       v
   SQL Injection             Authentication
     Middleware                    |
          |                  +------+------+
          |                  |             |
     Attack Detected       Password    Capability
          |                  |             |
          v                  v             v
     HTTP 403             Bcrypt       Hash::check()
          |                              |
          v                              v
     attack_logs                   Capability
          |                       Middleware
          |                              |
          +-------------+----------------+
                        |
                        v
                 Protected Resources
                        |
                        v
                   Railway MySQL

SQL Injection Protection

The application uses a custom SqlInjectionMiddleware.

The middleware examines incoming request values for common SQL injection patterns, including:

SQL comments
OR 1=1
AND 1=1
UNION SELECT
DROP TABLE
DELETE FROM
INSERT INTO
UPDATE
information_schema
xp_cmdshell
EXEC

When a suspicious input is detected:

The request is blocked.
HTTP status 403 is returned.
The attempted input is recorded.
Request information is stored in the attack_logs table.

Example response:

403
SQL Injection attempt detected.
Attack Logging

Detected attacks are stored in the attack_logs table.

The system records information such as:

IP address
HTTP request method
Requested route
User agent
Attempted input
Attack type
Status

Example:

Attack Type: SQL Injection
Status: Blocked
Method: POST
Route: login

This provides an audit trail for security testing and monitoring.

Data Encryption

Sensitive user information such as the phone number is encrypted before being stored in the database.

The application uses Laravel's encryption service:

Crypt::encryptString($value);

The production application was verified to use:

AES-256-CBC

The corresponding decryption process uses:

Crypt::decryptString($encryptedValue);

This allows sensitive data to be securely stored while still being recoverable when required by the application.

Password Security

User passwords are not encrypted and are not stored as plain text.

Passwords are securely hashed using Laravel's password hashing mechanism:

Hash::make($request->password);

The production database was verified to contain bcrypt hashes beginning with:

$2y$12$

This is intentional because passwords should normally be stored using a one-way password hash rather than reversible encryption.

Capability Code Security

The application implements a second security layer using a Capability Code.

During registration, the Capability Code is hashed:

Hash::make($request->capability_code);

During verification, Laravel checks the supplied code against the stored hash:

Hash::check(
    $request->capability_code,
    $user->capability_code
);

A successful verification creates a session flag:

capability_verified = true
Capability Middleware

Protected security resources require successful Capability Code verification.

The middleware checks:

session('capability_verified')

If verification has not been completed, the user is redirected to the security verification page.

This provides an additional authorization layer beyond normal login authentication.

Database Structure

The production MySQL database contains tables including:

users
attack_logs
migrations
sessions
cache
cache_locks
jobs
job_batches
failed_jobs
password_reset_tokens

The primary security-related tables are:

users

Stores application user information.

Sensitive fields are protected using hashing or encryption according to their purpose.

attack_logs

Stores detected SQL injection attempts and request information.

Security Testing

The deployed application was tested against a controlled SQL injection attempt.

Test payload:

' OR '1'='1' --
Result

The application detected the malicious input and returned:

HTTP 403
SQL Injection attempt detected.

The attack was also recorded in the production attack_logs table.

Result Summary
Test	Result
Normal registration	Passed
User stored in MySQL	Passed
Password hashing	Passed
AES-256 encryption	Passed
AES-256 decryption	Passed
Normal login	Passed
Invalid Capability Code	Blocked
Valid Capability Code	Passed
Direct protected-page access	Blocked
SQL Injection detection	Passed
SQL Injection blocking	Passed
Attack logging	Passed
Cloud Deployment

The application is deployed using Railway.

The production architecture consists of:

GitHub
   |
   v
Railway
   |
   +---- Laravel Application
   |
   +---- MySQL Database

The Laravel application is connected to the Railway MySQL database using Railway service variables.

The production database connection was verified using Laravel Tinker.

The active production database was confirmed as:

railway
Environment Configuration

Sensitive environment variables are not committed to GitHub.

Examples include:

APP_KEY
DB_PASSWORD
MYSQLPASSWORD

Production credentials are managed through Railway environment variables.

Project Testing Evidence

The project was tested in the deployed environment for:

User registration
User login
Password hashing
Sensitive data encryption
Capability verification
Protected dashboard access
SQL injection detection
SQL injection blocking
Attack logging
Production MySQL storage
Important Security Design Decisions
Passwords

Passwords use one-way hashing rather than AES encryption.

Sensitive Recoverable Data

Sensitive data that may need to be retrieved, such as phone numbers, uses AES-256 encryption.

SQL Injection

The application detects suspicious SQL injection patterns at the middleware layer and blocks the request.

Database Queries

Laravel's Eloquent/query builder is used for database operations, providing parameterized database interaction rather than manually concatenating SQL queries.

Future Improvements

Possible future improvements include:

Rate limiting for repeated login attacks.
More advanced SQL injection detection.
Security event dashboard with attack statistics.
Email alerts for repeated attacks.
IP-based temporary blocking.
Role-based access control.
Automated security testing.
Centralized security monitoring.
Improved audit logging.
HTTPS/security-header hardening.
Author

Vikash Tiwari

CodeAlpha Internship Project

License

This project was developed for educational and internship purposes.