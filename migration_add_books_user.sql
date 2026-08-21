ALTER TABLE books ADD COLUMN user_id INT UNSIGNED NULL AFTER id;
ALTER TABLE books ADD INDEX idx_books_user_id (user_id);
ALTER TABLE books ADD CONSTRAINT fk_books_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;
