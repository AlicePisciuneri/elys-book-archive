# BOOK NEST
## A personal library manager powered by PHP and the Open Library API.

A PHP and MySQL CRUD application that helps users manage a personal book collection.

The application also integrates the Open Library API to search and import book information automatically.
---

## Features

✅ Create new books

✅ View all books

✅ View book details

✅ Edit existing books

✅ Delete books with confirmation

✅ MySQL database integration

✅ Responsive interface
✅ Search books in the local database

✅ Search books using the Open Library API

✅ Import book title and author automatically

✅ Duplicate detection before saving

---

## Tech Stack

- PHP
- MySQL
- HTML5
- CSS3
- Git
- GitHub
- MAMP

---

## Project Structure

```txt
elys-book-archive 
│
├── index.php
├── create.php
├── store.php
├── show.php
├── edit.php
├── update.php
├── delete.php
├── database.php
├── style.css
├── database.sql
│
└── screenshots
    ├── home.png
    ├── create.png
    ├── show.png
    └── edit.png
```

---

## Screenshots

### Home Page

![Home](screenshots/home.png)

### Add New Book

![Create](screenshots/create.png)



### Edit Book

![Edit](screenshots/edit.png)

---

## Installation

1. Clone the repository

```bash
git clone https://github.com/AlicePisciuneri/elys-book-archive.git
```

2. Move the project inside:

```txt
C:\MAMP\htdocs
```

3. Create a MySQL database named:

```txt
elys_book_archive
```

4. Import the database.sql file into your MySQL database

5. Start Apache and MySQL from MAMP

6. Open:

```txt
http://localhost:8888/elys-book-archive/index.php
```


---

## Future Improvements

- Import book covers from Open Library

- Reading status (To Read / Reading / Completed)

- Rating system

- Category filtering

- Pagination

- User authentication

---
## During this project I practiced:

- PHP CRUD operations
- Working with MySQL
- GET and POST requests
- Consuming a REST API
- JSON decoding
- Form validation
- Git and GitHub workflow

## Workflow
Search book

↓

Open Library API

↓

Import title and author

↓

Review information

↓

Save to MySQL database
## About the project

BookNest was created as a learning project to practice PHP, MySQL and REST API integration while building a small real-world library management application.

## Author

Alice Pisciuneri

Frontend Developer & Digital Content Creator