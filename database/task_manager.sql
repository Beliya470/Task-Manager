-- Task Manager Database Dump
-- Author: Anne Anziya <beliya.anziya2022@gmail.com>

CREATE DATABASE IF NOT EXISTS `task_manager` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `task_manager`;

CREATE TABLE `tasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `due_date` date NOT NULL,
  `priority` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tasks_title_due_date_unique` (`title`, `due_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tasks` (`title`, `due_date`, `priority`, `status`, `created_at`, `updated_at`) VALUES
('Fix M-Pesa payment callback bug', '2026-03-29', 'high', 'in_progress', NOW(), NOW()),
('Update Q1 revenue report for management', '2026-03-31', 'high', 'pending', NOW(), NOW()),
('Review pull request #47 - user auth module', '2026-03-29', 'medium', 'pending', NOW(), NOW()),
('Prepare onboarding docs for new Nairobi office hires', '2026-04-03', 'medium', 'pending', NOW(), NOW()),
('Deploy updated build to staging server', '2026-03-30', 'high', 'pending', NOW(), NOW()),
('Write unit tests for KES currency conversion module', '2026-04-02', 'high', 'in_progress', NOW(), NOW()),
('Follow up on client meeting notes - Safaricom project', '2026-03-30', 'medium', 'pending', NOW(), NOW()),
('Configure automated daily database backups', '2026-04-01', 'medium', 'pending', NOW(), NOW()),
('Optimise homepage load time on low bandwidth', '2026-04-05', 'low', 'pending', NOW(), NOW()),
('Update third-party package dependencies', '2026-04-04', 'low', 'pending', NOW(), NOW()),
('Set up CI/CD pipeline on GitHub Actions', '2026-03-20', 'high', 'done', NOW(), NOW()),
('Design API documentation page', '2026-03-18', 'medium', 'done', NOW(), NOW()),
('Refactor user authentication flow', '2026-03-15', 'high', 'done', NOW(), NOW()),
('Add rate limiting to public API endpoints', '2026-04-06', 'medium', 'pending', NOW(), NOW()),
('Archive old project assets from Google Drive', '2026-03-22', 'low', 'done', NOW(), NOW());
