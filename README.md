# JELA SVIJETA

## Prerequisites

- **XAMPP**: Ensure you have XAMPP installed and running. You can download it from [here](https://www.apachefriends.org/index.html).
- **VISUAL STUDIO CODE** You can download it from [here](https://code.visualstudio.com/download).

## Getting Started

Follow these steps to set up and run the project:

### Clone the Repository

Open a terminal or command prompt and run the following command to clone the repository:

```bash
git clone <https://github.com/Klara-Iva/jela_svijeta.git>
```

## Setup

### Install XAMPP
1. Download and install XAMPP from the official website.
2. Start the Apache and MySQL servers using the XAMPP control panel.
   
### Configure the Environment
1. Navigate to the project directory in your terminal.

2. Copy the .env.example file to .env:
```bash
 cp .env.example .env
```

3. Generate the application key:
```bash
php artisan key
```

4. Configure your .env file with the correct database settings.

### Migrate and Seed the Database

1. Run database migrations:
```bash
php artisan migrate
```

2. Seed the database:
```bash
php artisan db:seed
```

### Running the Development Server
To start the server within Visual Studio Code:

1. Open Visual Studio Code.
2. Open the terminal within Visual Studio Code (Ctrl + `).
3. Run the following command to start the development server:
```bash
php artisan serve
```

Visit http://localhost:8000/meals?lang=en in your browser to see the application.
Link with additional parameters: http://localhost:8000/meals?per_page=5&tags=2&lang=hr&with=ingredients,category,tags&diff_time=1493902343&page=1



