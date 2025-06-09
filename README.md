# Bookgest

Bookgest is a Symfony-based web application for managing a library catalog. It allows administrators to add, update, and delete books, authors, and editors through an intuitive admin panel using EasyAdminBundle.

## Features

- CRUD operations for Books, Authors, and Editors
- Automatic slug generation for books
- Optional ISBN field with validation
- Integration with Symfony EasyAdmin for fast backend management

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/joaomarcalst/Bookgest.git
   ```
2. Navigate to the project directory:
   ```
   cd Bookgest
   ```
3. Install dependencies:
   ```
   composer install
   ```
4. Set up your `.env` database credentials.

5. Run the following commands to set up the database:
   ```
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

6. Start the Symfony server:
   ```
   symfony server:start
   ```

## Usage

Visit `https://127.0.0.1:8000/admin` to access the admin panel.

## License

This project is for academic purposes.
