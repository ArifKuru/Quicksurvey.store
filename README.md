# QuickSurvey.store

QuickSurvey.store is a platform that allows users to easily create and manage surveys. This project provides a simple and user-friendly interface to quickly set up surveys and analyze results.

## Features
- **Survey Management**: Users can create, edit, and delete surveys.
- **User Authentication**: Login and registration mechanisms are available.
- **Multiple Question Types**: Supports multiple-choice, text-based, and rating scale questions.
- **Responsive Design**: Optimized for both desktop and mobile devices.
- **AI Survey Creation**: This Project Uses Gemini API in order to create surveys with AI

## UI/UX

### Landing 
![Landing Page](http://quicksurvey.store/public/img/landing.png)

### Register
![Register Page](http://quicksurvey.store/public/img/register.png)

### Admin
![Admin Page](http://quicksurvey.store/public/img/admin.png)

### Survey
![Survey Page](http://quicksurvey.store/public/img/survey.png)

### Report
![Report Page](http://quicksurvey.store/public/img/report.png)

## Technical Details

### Database
![Database Schema](http://quicksurvey.store/public/img/database.png)

### UML
![UML Schema](http://quicksurvey.store/public/img/uml.png)

### Basic Representation of Algorithm
![Algorithm Schema](http://quicksurvey.store/public/img/algo.png)


## Installation

### Requirements
- **PHP 8.0+**
- **MySQL 5.7+** or **MariaDB**
- **Apache/Nginx** (mod_rewrite must be enabled)

### Steps
1. **Clone the Repository:**
   ```sh
   git clone https://github.com/ArifKuru/quicksurvey.store.git
   cd quicksurvey.store
   ```

2. **Install Dependencies:**
   ```sh
   composer install
   ```

3. **Set Up Config Settings:**
   Go to a `/config/config.php` file and fill in your MySQL database informations:
   ```config.php
   DB_HOST=localhost
   DB_DATABASE=quicksurvey
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Start the Server:**
   ```sh
   php -S localhost:8000 -t public/
   ```
   
5.**AI**
   For AI Survey Creation you need to deploy `/python-part` then set your deployment url to /api/sendRequestToAi.php;
   ```api/sendRequestToAi.php
   $url = "https://qs-api-3.onrender.com/generate-survey";
   ```
## Usage
- **Create a Survey**: After logging in, users can create new surveys.
- **Share Surveys**: Created surveys can be shared via a unique link.
- **View Results**: Survey owners can analyze responses in real-time.

## License
This project is licensed under the MIT License. For more details, see the `LICENSE` file.
