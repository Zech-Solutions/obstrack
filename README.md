
## Setup

### Docker

1. Ensure Docker is installed and running.
2. Clone the repository and navigate to the project root directory.
3. Run `docker-compose up` to start the services.
4. Open a web browser and navigate to `http://localhost:8080` for the home route.

### XAMPP

1. Ensure XAMPP is installed and running.
2. Clone the repository and place the `basic-mvc` directory in the `htdocs` directory of your XAMPP installation (usually `C:\xampp\htdocs` on Windows or `/Applications/XAMPP/htdocs` on macOS).
3. Create a MySQL database named `mvc` and a user with the credentials `user` and `password`. You can use phpMyAdmin or any other MySQL client to do this.
4. Open a web browser and navigate to `http://localhost/basic-mvc/public/` for the home route.

## Database Setup

You can use the following SQL script to create a sample table `some_table` in your `mvc` database for testing:

```sql
CREATE TABLE some_table (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

INSERT INTO some_table (name) VALUES ('Sample Data 1'), ('Sample Data 2');
