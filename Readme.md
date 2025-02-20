# 🎵 Musical Bands & Concerts Management App

This project is a **full-stack web application** built using **Symfony (backend)** and **Angular (frontend)** to manage musical bands and concerts.

---


## 🛠️ **Installation**
Follow these steps to set up the project on your local machine.

### 1️⃣ Clone the repository:
```bash
git clone https://github.com/Hrabi80/qualipro-coding-test.git
cd qualipro-coding-test
 ```

###  2️⃣ Install Backend (Symfony)
```bash
cd backend
composer install
 ```

### 3️⃣ Install Frontend (Angular)

```bash
cd ../frontend
npm install

 ```

 ### 🔧 Backend Configuration (Symfony)
1️⃣ Set up environment variables by changing the .env file
2️⃣ Create the database & run migrations
  
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate


 ```
