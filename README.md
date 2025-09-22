# JobBoard Project

This project is a full-stack job board application built with **Symfony** for the backend and **Angular** for the frontend.

## Features

- **Job Offers Management**: View and manage job offers.
- **Complete Authentication**: User registration, login, and secure access.
- **Admin Panel (Optional)**: Administrative interface for managing job offers, applications, and users.
- **File Upload**: Upload CVs when applying for jobs.
- **CORS Handling**: Proper configuration to allow frontend-backend communication.
- **Responsive UI**: Angular frontend with dynamic job listings and application forms.

## Technologies Used

- **Backend**: Symfony 6, Doctrine ORM, Nelmio CORS Bundle
- **Frontend**: Angular 16 (standalone components, HttpClient)
- **Database**: MySQL
- **Authentication**: JWT or Symfony Security (depending on your setup)
- **Others**: Node.js, npm for frontend dependencies, Composer for PHP dependencies

## Installation

### Backend Setup

1. Clone the repository:
   ```bash
   git clone https://your-repository-url.git
   cd your-project-backend
Install PHP dependencies:

bash
composer install
Configure environment variables:

Copy .env file and update database credentials and CORS origins:

bash
cp .env .env.local
Edit .env.local and update:

ini
DATABASE_URL="mysql://root@127.0.0.1:3306/jobboard?serverVersion=8.0.32&charset=utf8mb4"
CORS_ALLOW_ORIGIN=http://localhost:4200
Run database migrations:

bash
php bin/console doctrine:migrations:migrate
Start the Symfony server:

bash
symfony server:start
Frontend Setup
Navigate to the frontend folder:

bash
cd your-project-frontend
Install npm dependencies:

bash
npm install
Run the Angular development server:

bash
npm start
Access the app at:

arduino
http://localhost:4200
Usage
Register or log in via the Angular frontend.

Browse job offers and apply by uploading your CV.

(Optional) Use the admin panel to manage job offers and applications.

Notes
Make sure CORS is properly configured in Symfony for your frontend URL.

Adjust environment variables and database credentials as needed.

The admin panel is optional but recommended for easier management.

License
This project is licensed under the MIT License. See the LICENSE file for details.


### Author
Developed by João Cá