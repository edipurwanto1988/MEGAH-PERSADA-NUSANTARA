-- Bahasa yang didukung
CREATE TABLE languages (
  code        VARCHAR(8) PRIMARY KEY,       -- 'id', 'en'
  name        VARCHAR(50) NOT NULL,         -- 'Indonesian', 'English'
  is_default  TINYINT(1) NOT NULL DEFAULT 0
);

-- Media (opsional untuk galeri/file)
CREATE TABLE media (
  id          BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  path        VARCHAR(255) NOT NULL,
  alt_text    VARCHAR(255) DEFAULT NULL,
  mime_type   VARCHAR(100) DEFAULT NULL,
  created_at  TIMESTAMP NULL,
  updated_at  TIMESTAMP NULL
);
