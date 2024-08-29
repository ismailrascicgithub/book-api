-- KREIRANJE BAZE PODATAKA
CREATE DATABASE IF NOT EXISTS books_db;

-- KORISTIŠTENJE BAZU PODATAKA
USE books_db;

-- KREIRANJE TABELE
CREATE TABLE IF NOT EXISTS books (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    published_year YEAR NOT NULL,
    genre VARCHAR(100) NOT NULL
);

-- UNOS NEKIH INICIJALNIH PODATAKA
INSERT INTO books (title, author, published_year, genre) VALUES
('Learning PHP, MySQL & JavaScript', 'Robin Nixon', 2018, 'Web Development'),
('JavaScript: The Good Parts', 'Douglas Crockford', 2008, 'Web Development'),
('Eloquent JavaScript', 'Marijn Haverbeke', 2018, 'Web Development'),
('PHP & MySQL: Server-side Web Development', 'Jon Duckett', 2022, 'Web Development'),
('Modern PHP: New Features and Good Practices', 'Josh Lockhart', 2015, 'Web Development');