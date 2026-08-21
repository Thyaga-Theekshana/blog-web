# Simple Blog Web Application

A full-stack, dynamic PHP blog application built with MySQL, HTML5, CSS3, JavaScript, and Markdown support. Developed as part of an academic coursework assignment to demonstrate core backend programming principles, database relational modeling, and user authorization features.

---

##  Key Features

* **User Authentication & Authorization**: Secure User Registration, Login, and Logout functionality using password hashing (`password_hash`).
* **Blog Post Management (CRUD)**:
  * **Create**: Write and publish blog content with rich formatting support using the EasyMDE Markdown editor.
  * **Read**: View all blog posts on the home page or read individual posts on dedicated pages.
  * **Update**: Edit title and content for existing posts.
  * **Delete**: Delete unwanted posts.
* **Access Control**: Strict ownership checks ensuring users can only edit or delete their own posts.
* **Database Relational Design**: Linked `user` and `blogPost` tables using Foreign Key constraints with cascade deletion.
* **Responsive UI**: Clean, responsive layout using custom CSS styles.

---

## 🛠️ Built With

* **Backend**: PHP (PDO - PHP Data Objects)
* **Database**: MySQL / MariaDB
* **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
* **Third-Party Libraries**: EasyMDE (Markdown Editor)
* **Environment**: XAMPP (Apache & MySQL)

---

## 📁 Directory Structure

```text
blog-app/
│
├── assets/
│   ├── css/
│   │   └── style.css           # Custom CSS stylesheet
│   └── js/
│       └── main.js             # EasyMDE editor initialization
│
├── auth/
│   ├── login.php               # User login form & backend script
│   ├── logout.php              # Session destruction script
│   └── register.php            # User registration script
│
├── blogs/
│   ├── create.php              # Blog creation form (Markdown supported)
│   ├── delete.php              # Blog deletion logic & authorization
│   ├── edit.php                # Blog edit page
│   └── view.php                # Single blog viewing page
│
├── config/
│   └── db.php                  # PDO database connection setup
│
├── includes/
│   ├── footer.php              # Shared HTML footer & script imports
│   └── header.php              # Shared HTML header & navigation bar
│
├── database.sql                # SQL database creation script
├── index.php                   # Application home page (Displays blog feeds)
├── .gitignore                  # Git untracked files specification
└── README.md                   # Project documentation