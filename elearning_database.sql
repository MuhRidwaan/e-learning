-- ============================================================
-- DATABASE E-LEARNING - LARAVEL
-- Compatible: MySQL 8.0+ / MariaDB 10.4+
-- Role & Permission: Spatie Laravel Permission compatible
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;
SET NAMES utf8mb4;

-- ------------------------------------------------------------
-- 1. AUTH & ROLE PERMISSION (Spatie compatible)
-- ------------------------------------------------------------

CREATE TABLE `users` (
  `id`                BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`              VARCHAR(255) NOT NULL,
  `email`             VARCHAR(255) NOT NULL,
  `password`          VARCHAR(255) NOT NULL,
  `avatar`            VARCHAR(255) NULL,
  `bio`               TEXT NULL,
  `phone`             VARCHAR(20) NULL,
  `is_active`         TINYINT(1) NOT NULL DEFAULT 1,
  `email_verified_at` TIMESTAMP NULL,
  `remember_token`    VARCHAR(100) NULL,
  `created_at`        TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`        TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at`        TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `roles` (
  `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(125) NOT NULL,
  `guard_name`  VARCHAR(125) NOT NULL DEFAULT 'web',
  `description` VARCHAR(255) NULL COMMENT 'Deskripsi singkat peran',
  `created_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_unique` (`name`, `guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `permissions` (
  `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(125) NOT NULL,
  `guard_name`  VARCHAR(125) NOT NULL DEFAULT 'web',
  `module`      VARCHAR(100) NULL COMMENT 'Modul/fitur: courses, users, assignments, dst',
  `description` VARCHAR(255) NULL,
  `created_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_unique` (`name`, `guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Relasi role <-> user (many-to-many)
CREATE TABLE `role_user` (
  `role_id`       BIGINT UNSIGNED NOT NULL,
  `model_id`      BIGINT UNSIGNED NOT NULL,
  `model_type`    VARCHAR(255) NOT NULL DEFAULT 'App\\Models\\User',
  PRIMARY KEY (`role_id`, `model_id`, `model_type`),
  KEY `role_user_model_idx` (`model_id`, `model_type`),
  CONSTRAINT `fk_role_user_role` FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_role_user_user` FOREIGN KEY (`model_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Relasi role <-> permission (many-to-many)
CREATE TABLE `role_permission` (
  `permission_id` BIGINT UNSIGNED NOT NULL,
  `role_id`       BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`),
  CONSTRAINT `fk_rp_permission` FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_rp_role`       FOREIGN KEY (`role_id`)       REFERENCES `roles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Permission langsung ke user (opsional, jika butuh override)
CREATE TABLE `user_permission` (
  `permission_id` BIGINT UNSIGNED NOT NULL,
  `model_id`      BIGINT UNSIGNED NOT NULL,
  `model_type`    VARCHAR(255) NOT NULL DEFAULT 'App\\Models\\User',
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`),
  CONSTRAINT `fk_up_permission` FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_up_user`       FOREIGN KEY (`model_id`)      REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ------------------------------------------------------------
-- 2. SILABUS (dikelola Admin/Akademik)
-- ------------------------------------------------------------

CREATE TABLE `syllabus` (
  `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`           VARCHAR(255) NOT NULL COMMENT 'Nama kursus/silabus',
  `theme`          VARCHAR(255) NULL,
  `description`    TEXT NULL,
  `duration_weeks` INT UNSIGNED NOT NULL DEFAULT 1,
  `created_by`     BIGINT UNSIGNED NULL,
  `created_at`     TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`     TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at`     TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_syllabus_creator` FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ------------------------------------------------------------
-- 3. KELAS / COURSE
-- ------------------------------------------------------------

CREATE TABLE `courses` (
  `id`              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `syllabus_id`     BIGINT UNSIGNED NULL,
  `instructor_id`   BIGINT UNSIGNED NOT NULL,
  `title`           VARCHAR(255) NOT NULL,
  `description`     TEXT NULL,
  `thumbnail`       VARCHAR(255) NULL,
  `status`          ENUM('draft','published','archived') NOT NULL DEFAULT 'draft',
  `duration_weeks`  INT UNSIGNED NULL,
  `max_students`    INT UNSIGNED NULL COMMENT 'NULL = tidak terbatas',
  `published_at`    TIMESTAMP NULL,
  `created_at`      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at`      TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  KEY `courses_instructor_idx` (`instructor_id`),
  KEY `courses_status_idx` (`status`),
  CONSTRAINT `fk_courses_instructor` FOREIGN KEY (`instructor_id`) REFERENCES `users`(`id`),
  CONSTRAINT `fk_courses_syllabus`   FOREIGN KEY (`syllabus_id`)   REFERENCES `syllabus`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Pendaftaran pelajar ke kelas
CREATE TABLE `enrollments` (
  `id`           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id`    BIGINT UNSIGNED NOT NULL,
  `student_id`   BIGINT UNSIGNED NOT NULL,
  `status`       ENUM('active','completed','dropped') NOT NULL DEFAULT 'active',
  `enrolled_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `completed_at` TIMESTAMP NULL,
  `created_at`   TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`   TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `enrollments_course_student_unique` (`course_id`, `student_id`),
  CONSTRAINT `fk_enrollments_course`   FOREIGN KEY (`course_id`)  REFERENCES `courses`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_enrollments_student`  FOREIGN KEY (`student_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Penilaian / rating kelas oleh pelajar
CREATE TABLE `course_ratings` (
  `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id`  BIGINT UNSIGNED NOT NULL,
  `student_id` BIGINT UNSIGNED NOT NULL,
  `rating`     TINYINT UNSIGNED NOT NULL COMMENT '1-5',
  `review`     TEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ratings_course_student_unique` (`course_id`, `student_id`),
  CONSTRAINT `fk_ratings_course`   FOREIGN KEY (`course_id`)  REFERENCES `courses`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_ratings_student`  FOREIGN KEY (`student_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ------------------------------------------------------------
-- 4. MODUL & MATERI PEMBELAJARAN
-- ------------------------------------------------------------

CREATE TABLE `course_modules` (
  `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id`   BIGINT UNSIGNED NOT NULL,
  `title`       VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `order`       INT UNSIGNED NOT NULL DEFAULT 0,
  `created_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `modules_course_order_idx` (`course_id`, `order`),
  CONSTRAINT `fk_modules_course` FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `materials` (
  `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `module_id`        BIGINT UNSIGNED NOT NULL,
  `title`            VARCHAR(255) NOT NULL,
  `type`             ENUM('video','pdf','text','link','audio','image') NOT NULL DEFAULT 'text',
  `file_path`        VARCHAR(500) NULL,
  `content`          LONGTEXT NULL COMMENT 'Konten teks atau embed URL',
  `duration_minutes` INT UNSIGNED NULL COMMENT 'Khusus video/audio',
  `order`            INT UNSIGNED NOT NULL DEFAULT 0,
  `is_preview`       TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Bisa diakses tanpa enroll?',
  `created_at`       TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`       TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at`       TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  KEY `materials_module_order_idx` (`module_id`, `order`),
  CONSTRAINT `fk_materials_module` FOREIGN KEY (`module_id`) REFERENCES `course_modules`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Progres pelajar per materi
CREATE TABLE `material_progress` (
  `id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id`    BIGINT UNSIGNED NOT NULL,
  `material_id`   BIGINT UNSIGNED NOT NULL,
  `is_completed`  TINYINT(1) NOT NULL DEFAULT 0,
  `last_position` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Detik terakhir ditonton (video)',
  `completed_at`  TIMESTAMP NULL,
  `created_at`    TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`    TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `progress_student_material_unique` (`student_id`, `material_id`),
  CONSTRAINT `fk_progress_student`  FOREIGN KEY (`student_id`)  REFERENCES `users`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_progress_material` FOREIGN KEY (`material_id`) REFERENCES `materials`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Bookmark materi penting
CREATE TABLE `bookmarks` (
  `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id`  BIGINT UNSIGNED NOT NULL,
  `material_id` BIGINT UNSIGNED NOT NULL,
  `note`        TEXT NULL,
  `created_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bookmarks_student_material_unique` (`student_id`, `material_id`),
  CONSTRAINT `fk_bookmarks_student`  FOREIGN KEY (`student_id`)  REFERENCES `users`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_bookmarks_material` FOREIGN KEY (`material_id`) REFERENCES `materials`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ------------------------------------------------------------
-- 5. TUGAS (ASSIGNMENT)
-- ------------------------------------------------------------

CREATE TABLE `assignments` (
  `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id`   BIGINT UNSIGNED NOT NULL,
  `title`       VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `due_date`    TIMESTAMP NOT NULL,
  `max_score`   INT UNSIGNED NOT NULL DEFAULT 100,
  `created_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at`  TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  KEY `assignments_course_idx` (`course_id`),
  CONSTRAINT `fk_assignments_course` FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `assignment_submissions` (
  `id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `assignment_id` BIGINT UNSIGNED NOT NULL,
  `student_id`    BIGINT UNSIGNED NOT NULL,
  `file_path`     VARCHAR(500) NULL COMMENT 'Path file yang diunggah',
  `text_answer`   LONGTEXT NULL COMMENT 'Jawaban berbentuk teks',
  `note`          TEXT NULL COMMENT 'Catatan dari pelajar',
  `score`         DECIMAL(5,2) NULL,
  `feedback`      TEXT NULL COMMENT 'Komentar pengajar',
  `status`        ENUM('draft','submitted','graded','returned') NOT NULL DEFAULT 'draft',
  `submitted_at`  TIMESTAMP NULL,
  `graded_at`     TIMESTAMP NULL,
  `created_at`    TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`    TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `submissions_assignment_student_unique` (`assignment_id`, `student_id`),
  CONSTRAINT `fk_submissions_assignment` FOREIGN KEY (`assignment_id`) REFERENCES `assignments`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_submissions_student`    FOREIGN KEY (`student_id`)    REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ------------------------------------------------------------
-- 6. QUIZ / TES
-- ------------------------------------------------------------

CREATE TABLE `quizzes` (
  `id`              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id`       BIGINT UNSIGNED NOT NULL,
  `title`           VARCHAR(255) NOT NULL,
  `description`     TEXT NULL,
  `duration_minutes`INT UNSIGNED NULL COMMENT 'NULL = tidak dibatasi waktu',
  `max_attempts`    INT UNSIGNED NOT NULL DEFAULT 1,
  `passing_score`   DECIMAL(5,2) NOT NULL DEFAULT 70.00,
  `randomize`       TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Acak urutan soal?',
  `show_result`     TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Tampilkan hasil setelah submit?',
  `created_at`      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at`      TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_quizzes_course` FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `quiz_questions` (
  `id`           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `quiz_id`      BIGINT UNSIGNED NOT NULL,
  `question`     TEXT NOT NULL,
  `type`         ENUM('multiple_choice','true_false','short_answer','essay') NOT NULL DEFAULT 'multiple_choice',
  `points`       INT UNSIGNED NOT NULL DEFAULT 1,
  `order`        INT UNSIGNED NOT NULL DEFAULT 0,
  `explanation`  TEXT NULL COMMENT 'Penjelasan jawaban benar',
  `created_at`   TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`   TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_questions_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `quiz_options` (
  `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `question_id` BIGINT UNSIGNED NOT NULL,
  `option_text` TEXT NOT NULL,
  `is_correct`  TINYINT(1) NOT NULL DEFAULT 0,
  `order`       INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_options_question` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `quiz_attempts` (
  `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `quiz_id`     BIGINT UNSIGNED NOT NULL,
  `student_id`  BIGINT UNSIGNED NOT NULL,
  `score`       DECIMAL(5,2) NULL,
  `is_passed`   TINYINT(1) NULL,
  `started_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `finished_at` TIMESTAMP NULL,
  `created_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `attempts_quiz_student_idx` (`quiz_id`, `student_id`),
  CONSTRAINT `fk_attempts_quiz`    FOREIGN KEY (`quiz_id`)    REFERENCES `quizzes`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_attempts_student` FOREIGN KEY (`student_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `quiz_answers` (
  `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `attempt_id`  BIGINT UNSIGNED NOT NULL,
  `question_id` BIGINT UNSIGNED NOT NULL,
  `option_id`   BIGINT UNSIGNED NULL COMMENT 'Untuk multiple choice / true-false',
  `text_answer` TEXT NULL COMMENT 'Untuk short_answer / essay',
  `is_correct`  TINYINT(1) NULL,
  `points_earned` DECIMAL(5,2) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_answers_attempt`  FOREIGN KEY (`attempt_id`)  REFERENCES `quiz_attempts`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_answers_question` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_answers_option`   FOREIGN KEY (`option_id`)   REFERENCES `quiz_options`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ------------------------------------------------------------
-- 7. JADWAL & ABSENSI
-- ------------------------------------------------------------

CREATE TABLE `schedules` (
  `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id`   BIGINT UNSIGNED NOT NULL,
  `title`       VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `start_time`  DATETIME NOT NULL,
  `end_time`    DATETIME NOT NULL,
  `location`    VARCHAR(255) NULL COMMENT 'Ruang/URL meeting',
  `type`        ENUM('online','offline','hybrid') NOT NULL DEFAULT 'online',
  `created_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_schedules_course` FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `attendances` (
  `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_id` BIGINT UNSIGNED NOT NULL,
  `course_id`   BIGINT UNSIGNED NOT NULL,
  `student_id`  BIGINT UNSIGNED NOT NULL,
  `status`      ENUM('present','absent','late','excused') NOT NULL DEFAULT 'absent',
  `note`        VARCHAR(255) NULL,
  `recorded_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attendance_schedule_student_unique` (`schedule_id`, `student_id`),
  CONSTRAINT `fk_attendance_schedule` FOREIGN KEY (`schedule_id`) REFERENCES `schedules`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_attendance_course`   FOREIGN KEY (`course_id`)   REFERENCES `courses`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_attendance_student`  FOREIGN KEY (`student_id`)  REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ------------------------------------------------------------
-- 8. PENGUMUMAN
-- ------------------------------------------------------------

CREATE TABLE `announcements` (
  `id`           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id`    BIGINT UNSIGNED NULL COMMENT 'NULL = pengumuman global',
  `created_by`   BIGINT UNSIGNED NOT NULL,
  `title`        VARCHAR(255) NOT NULL,
  `content`      TEXT NOT NULL,
  `is_published` TINYINT(1) NOT NULL DEFAULT 0,
  `published_at` TIMESTAMP NULL,
  `created_at`   TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`   TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at`   TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_announcements_course`  FOREIGN KEY (`course_id`)  REFERENCES `courses`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_announcements_creator` FOREIGN KEY (`created_by`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ------------------------------------------------------------
-- 9. FORUM DISKUSI
-- ------------------------------------------------------------

CREATE TABLE `forum_threads` (
  `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id`  BIGINT UNSIGNED NOT NULL,
  `user_id`    BIGINT UNSIGNED NOT NULL,
  `title`      VARCHAR(255) NOT NULL,
  `content`    TEXT NOT NULL,
  `is_pinned`  TINYINT(1) NOT NULL DEFAULT 0,
  `is_locked`  TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Dilock oleh admin/pengajar',
  `views`      INT UNSIGNED NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_threads_course` FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_threads_user`   FOREIGN KEY (`user_id`)   REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `forum_posts` (
  `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `thread_id`   BIGINT UNSIGNED NOT NULL,
  `user_id`     BIGINT UNSIGNED NOT NULL,
  `parent_id`   BIGINT UNSIGNED NULL COMMENT 'Untuk reply bersarang',
  `content`     TEXT NOT NULL,
  `is_approved` TINYINT(1) NOT NULL DEFAULT 1,
  `is_solution` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Ditandai sebagai jawaban terbaik',
  `created_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at`  TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  KEY `posts_thread_idx` (`thread_id`),
  CONSTRAINT `fk_posts_thread` FOREIGN KEY (`thread_id`) REFERENCES `forum_threads`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_posts_user`   FOREIGN KEY (`user_id`)   REFERENCES `users`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_posts_parent` FOREIGN KEY (`parent_id`) REFERENCES `forum_posts`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ------------------------------------------------------------
-- 10. NOTIFIKASI
-- ------------------------------------------------------------

CREATE TABLE `notifications` (
  `id`          CHAR(36) NOT NULL COMMENT 'UUID - compatible dengan Laravel Notification',
  `type`        VARCHAR(255) NOT NULL COMMENT 'Class notifikasi Laravel',
  `notifiable_type` VARCHAR(255) NOT NULL,
  `notifiable_id`   BIGINT UNSIGNED NOT NULL,
  `data`        JSON NOT NULL COMMENT 'Payload notifikasi',
  `read_at`     TIMESTAMP NULL,
  `created_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_idx` (`notifiable_type`, `notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ------------------------------------------------------------
-- 11. SERTIFIKAT
-- ------------------------------------------------------------

CREATE TABLE `certificates` (
  `id`              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id`       BIGINT UNSIGNED NOT NULL,
  `student_id`      BIGINT UNSIGNED NOT NULL,
  `certificate_no`  VARCHAR(100) NOT NULL UNIQUE COMMENT 'Nomor sertifikat unik',
  `file_path`       VARCHAR(500) NULL,
  `issued_at`       TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at`      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `certificates_course_student_unique` (`course_id`, `student_id`),
  CONSTRAINT `fk_certificates_course`   FOREIGN KEY (`course_id`)  REFERENCES `courses`(`id`),
  CONSTRAINT `fk_certificates_student`  FOREIGN KEY (`student_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ------------------------------------------------------------
-- 12. ACTIVITY LOG (untuk monitor admin)
-- ------------------------------------------------------------

CREATE TABLE `activity_logs` (
  `id`           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`      BIGINT UNSIGNED NULL,
  `log_name`     VARCHAR(255) NULL COMMENT 'e.g.: courses, users, assignments',
  `description`  TEXT NOT NULL,
  `subject_type` VARCHAR(255) NULL,
  `subject_id`   BIGINT UNSIGNED NULL,
  `causer_type`  VARCHAR(255) NULL,
  `causer_id`    BIGINT UNSIGNED NULL,
  `properties`   JSON NULL,
  `created_at`   TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `activity_log_user_idx` (`user_id`),
  KEY `activity_log_subject_idx` (`subject_type`, `subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- SEED DATA AWAL
-- ============================================================

-- Roles default
INSERT INTO `roles` (`name`, `guard_name`, `description`) VALUES
  ('super_admin', 'web', 'Super Administrator - akses penuh semua fitur'),
  ('akademik',    'web', 'Staf Akademik - kelola data administratif'),
  ('pengajar',    'web', 'Pengajar / Instruktur kelas'),
  ('pelajar',     'web', 'Pelajar / Siswa');


-- Permissions per modul (bisa ditambah bebas via UI)
INSERT INTO `permissions` (`name`, `guard_name`, `module`, `description`) VALUES
  -- Users
  ('users.view',    'web', 'users', 'Lihat daftar pengguna'),
  ('users.create',  'web', 'users', 'Tambah pengguna baru'),
  ('users.edit',    'web', 'users', 'Edit data pengguna'),
  ('users.delete',  'web', 'users', 'Hapus pengguna'),
  -- Roles & Permissions
  ('roles.view',    'web', 'roles', 'Lihat daftar role'),
  ('roles.create',  'web', 'roles', 'Buat role baru'),
  ('roles.edit',    'web', 'roles', 'Edit role dan permission'),
  ('roles.delete',  'web', 'roles', 'Hapus role'),
  -- Courses
  ('courses.view',   'web', 'courses', 'Lihat semua kelas'),
  ('courses.create', 'web', 'courses', 'Buat kelas baru'),
  ('courses.edit',   'web', 'courses', 'Edit kelas'),
  ('courses.delete', 'web', 'courses', 'Hapus kelas'),
  ('courses.publish','web', 'courses', 'Publish/unpublish kelas'),
  -- Materials
  ('materials.view',   'web', 'materials', 'Akses materi pembelajaran'),
  ('materials.create', 'web', 'materials', 'Upload materi baru'),
  ('materials.edit',   'web', 'materials', 'Edit materi'),
  ('materials.delete', 'web', 'materials', 'Hapus materi'),
  -- Assignments
  ('assignments.view',   'web', 'assignments', 'Lihat tugas'),
  ('assignments.create', 'web', 'assignments', 'Buat tugas'),
  ('assignments.edit',   'web', 'assignments', 'Edit tugas'),
  ('assignments.delete', 'web', 'assignments', 'Hapus tugas'),
  ('assignments.grade',  'web', 'assignments', 'Beri nilai tugas'),
  ('assignments.submit', 'web', 'assignments', 'Kumpulkan tugas (pelajar)'),
  -- Quizzes
  ('quizzes.view',   'web', 'quizzes', 'Lihat quiz'),
  ('quizzes.create', 'web', 'quizzes', 'Buat quiz'),
  ('quizzes.edit',   'web', 'quizzes', 'Edit quiz'),
  ('quizzes.delete', 'web', 'quizzes', 'Hapus quiz'),
  ('quizzes.take',   'web', 'quizzes', 'Ikuti quiz (pelajar)'),
  -- Forum
  ('forum.view',    'web', 'forum', 'Lihat forum diskusi'),
  ('forum.post',    'web', 'forum', 'Posting di forum'),
  ('forum.moderate','web', 'forum', 'Moderasi forum (pin, lock, hapus)'),
  -- Schedules
  ('schedules.view',   'web', 'schedules', 'Lihat jadwal'),
  ('schedules.manage', 'web', 'schedules', 'Kelola jadwal (tambah/edit/hapus)'),
  -- Attendance
  ('attendance.view',   'web', 'attendance', 'Lihat absensi'),
  ('attendance.manage', 'web', 'attendance', 'Kelola absensi'),
  -- Reports & Certificates
  ('reports.view',        'web', 'reports', 'Lihat laporan akademik'),
  ('reports.export',      'web', 'reports', 'Export nilai (Excel/PDF)'),
  ('certificates.manage', 'web', 'certificates', 'Kelola sertifikat'),
  -- Announcements
  ('announcements.view',   'web', 'announcements', 'Lihat pengumuman'),
  ('announcements.manage', 'web', 'announcements', 'Buat dan kelola pengumuman'),
  -- Notifications
  ('notifications.manage', 'web', 'notifications', 'Atur notifikasi sistem'),
  -- Activity
  ('activity.view', 'web', 'activity', 'Monitor aktivitas sistem'),
  -- Syllabus
  ('syllabus.view',   'web', 'syllabus', 'Lihat silabus'),
  ('syllabus.manage', 'web', 'syllabus', 'Kelola silabus');


-- Assign semua permission ke super_admin (role id=1)
INSERT INTO `role_permission` (`permission_id`, `role_id`)
SELECT `id`, 1 FROM `permissions`;


-- Assign permission pengajar (role id=3)
INSERT INTO `role_permission` (`permission_id`, `role_id`)
SELECT id, 3 FROM `permissions`
WHERE `name` IN (
  'courses.view','courses.edit',
  'materials.view','materials.create','materials.edit','materials.delete',
  'assignments.view','assignments.create','assignments.edit','assignments.delete','assignments.grade',
  'quizzes.view','quizzes.create','quizzes.edit','quizzes.delete',
  'forum.view','forum.post','forum.moderate',
  'schedules.view','schedules.manage',
  'attendance.view','attendance.manage',
  'reports.view','reports.export',
  'announcements.view','announcements.manage'
);


-- Assign permission pelajar (role id=4)
INSERT INTO `role_permission` (`permission_id`, `role_id`)
SELECT id, 4 FROM `permissions`
WHERE `name` IN (
  'courses.view',
  'materials.view',
  'assignments.view','assignments.submit',
  'quizzes.view','quizzes.take',
  'forum.view','forum.post',
  'schedules.view',
  'attendance.view',
  'announcements.view'
);


-- Assign permission akademik (role id=2)
INSERT INTO `role_permission` (`permission_id`, `role_id`)
SELECT id, 2 FROM `permissions`
WHERE `name` IN (
  'users.view','users.create','users.edit',
  'roles.view',
  'courses.view','courses.create','courses.edit','courses.delete','courses.publish',
  'schedules.view','schedules.manage',
  'attendance.view',
  'reports.view','reports.export',
  'certificates.manage',
  'announcements.view','announcements.manage',
  'notifications.manage',
  'activity.view',
  'syllabus.view','syllabus.manage',
  'forum.view','forum.moderate'
);

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- SELESAI
-- Total tabel: 25
-- ============================================================
