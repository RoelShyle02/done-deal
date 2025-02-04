# Done Deal

Done Deal is a task management app with user authentication, buckets for tasks, and tasks with due date, status, and priority. The application includes a database to store all relevant information. Note: The project is currently not finished.

The platform integrates a Vue frontend and Laravel backend to ensure a smooth user experience, while leveraging Docker to simplify the development and deployment workflow.

GitHub Repository: [Done Deal](https://github.com/RoelShyle02/done-deal.git)

## Steps to Set Up the Project

### 1. **Set Up Dockerfiles and Docker Compose**

1. **Create Dockerfiles**:
   - For each container (e.g., `nginx`, `php`, `mysql`, etc.), create appropriate `Dockerfile` configuration files.
   - Ensure that `Dockerfile` files define the environment properly (e.g., PHP for backend, Nginx for serving static files).

2. **Create Docker Compose File**:
   - Define the services such as `nginx`, `php`, `mysql`, and any other dependencies in a `docker-compose.yml` file.
   - Example for `docker-compose.yml`:
     ```yaml
     version: '3'
     services:
       nginx:
         image: nginx:alpine
         container_name: your-nginx-container
         ports:
           - "80:80"
         volumes:
           - ./frontend:/var/www
           - ./nginx.conf:/etc/nginx/nginx.conf
       php:
         image: php:8.1-fpm
         container_name: your-php-container
         volumes:
           - ./backend:/var/www
       mysql:
         image: mysql:8.0
         container_name: your-mysql-container
         environment:
           MYSQL_ROOT_PASSWORD: password
     ```

### 2. **Giving Permissions for Docker Files**

1. **Permissions for Storage Folders**:
   - Ensure appropriate file permissions for directories like `storage` and `logs` to avoid permission issues.
     ```bash
     sudo chmod -R 775 ./backend/storage
     sudo chmod -R 775 ./backend/storage/logs
     ```

2. **Ownership of Files**:
   - Ensure the correct ownership, especially for Nginx and PHP-FPM to write to the file system.
     ```bash
     sudo chown -R www-data:www-data ./frontend
     sudo chown -R www-data:www-data ./backend/storage
     ```

### 3. **Configure Nginx**

1. **Set Up Nginx to Serve Vue and Laravel (Backend)**:
   - Configure `nginx.conf` to serve your frontend and handle PHP requests for Laravel.
   - Example Nginx configuration:
     ```nginx
     server {
         listen 80;
         server_name localhost;

         root /var/www/public;
         index index.php index.html;

         location ~ \.php$ {
             include fastcgi_params;
             fastcgi_pass tasks_php:8000; # tasks_php is the PHP container
             fastcgi_index index.php;
             fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
         }

         location / {
             try_files $uri $uri/ /index.php?$query_string;
         }

         location ~ /\.ht {
             deny all;
         }
     }
     ```

2. **Map Volumes in Docker Compose**:
   - Map the `nginx.conf` file into the Nginx container.
     ```yaml
     volumes:
       - ./frontend:/var/www
       - ./nginx.conf:/etc/nginx/nginx.conf
     ```

### 4. **Build the Vue Project with Vite**

1. **Install Node.js and NPM**.

2. **Install Project Dependencies**:
   - Navigate to the `frontend` directory:
     ```bash
     cd frontend
     ```
   - Install the necessary dependencies:
     ```bash
     npm install
     ```

3. **Run the Vue Project with Vite**:
     ```bash
     npm run dev
     ```

---

### Additional Setup

1. **Use Sanctum for Authentication**.

2. **Install Tailwind**:
   ```bash
   npm install tailwindcss
   ```

### Features (Planned and Implemented)

- **User Authentication**: Secure user authentication using Laravel Sanctum.
- **Task Management**: Create, update, and delete tasks.
- **Buckets for Tasks**: Group tasks into different buckets for easy organization.
- **Task Attributes**: Set due dates, status, and priority for tasks.
- **Responsive Design**: Built with TailwindCSS to ensure the app is accessible on multiple devices.
- **Database Integration**: MySQL database to store all tasks, users, and related information.
