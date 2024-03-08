-- Users table to store admin and employee information
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('admin', 'employee') NOT NULL
);

-- Leads table to store lead information
CREATE TABLE leads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    status ENUM('new', 'contacted', 'follow-up', 'converted', 'closed') NOT NULL DEFAULT 'new',
    assigned_to INT,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL
);
