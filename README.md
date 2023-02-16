# bato-maj-dlc
Majorettes and DLC Competition Tabulation System for Bato Foundation Anniversary


## Development Setup
Here are the steps to set up the development environment for this project:

1. Download and install
   [XAMPP](https://www.apachefriends.org/download.html)
   and [NodeJS](https://nodejs.org/en/),
   if you haven't already.
2. Start Apache and MySQL through XAMPP if not already running.
3. Clone or download this repository to your XAMPP **htdocs** folder.
   The final path should be `path_to/xampp/htdocs/bato-maj-dlc`.
4. Open the terminal and navigate to the project directory **bato-maj-dlc**.
5. Execute the following commands to install the required dependencies:
   ```sh
   npm install
   ```
6. Compile and run the development server with hot reloading:
   ```sh
   npm run dev
   ```
7. Inside [phpMyAdmin](http://localhost/phpmyadmin),
   create a MySQL database named `bato-maj-dlc` and import [bato-maj-dlc.sql](bato-maj-dlc.sql) into it.
8. Open your web browser and access <http://localhost:5175/bato-maj-dlc> to view the application.


## Production Deployment
Here's how to compile the project for production deployment:

1. Generate the public folder by running the following command:
   ```sh
   npm run build
   ```
2. Access the application by visiting `http://[host_name]/bato-maj-dlc`,
   where `host_name` is the **IP address** or **host name** of the server in the network.
   For example:
     - <http://localhost/bato-maj-dlc>
     - <http://192.168.1.99/bato-maj-dlc>