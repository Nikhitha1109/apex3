# PHP Blog CRUD Project

## Features
- Create, Read, Update, Delete blog posts
- User registration and login
- Session-based authentication
- Search posts by title or content
- Pagination
- Responsive UI with Bootstrap

## Setup
1. Install XAMPP and start Apache + MySQL.
2. Create a MySQL DB named `blog`.
3. Create `users` and `posts` tables.

### SQL:
```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) UNIQUE,
  password VARCHAR(255)
);

CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  content TEXT,
  created_at DATETIME
);
#   a p e x 3  
 #   a p e x 3  
 