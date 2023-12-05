-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 05, 2023 at 07:12 AM
-- Server version: 10.5.22-MariaDB-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resolutecontract_resolutedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `created_at`, `updated_at`) VALUES
(1, 'resolute', '2023-04-11 05:43:26', '2023-04-11 05:43:26'),
(6, 'webcontract', '2023-04-11 06:00:08', '2023-04-11 06:00:08'),
(14, 'smbklds', '2023-07-06 19:21:12', '2023-07-06 19:21:12');

-- --------------------------------------------------------

--
-- Table structure for table `contract_type`
--

CREATE TABLE `contract_type` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `External_show` enum('1','0') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contract_type`
--

INSERT INTO `contract_type` (`id`, `name`, `External_show`, `created_at`, `updated_at`) VALUES
(1, 'Owner MSA', '1', '2023-04-13 06:57:04', '2023-04-13 06:57:09'),
(2, 'Vendor MSA/PSA', '0', '2023-04-13 06:57:12', '2023-04-13 06:57:15'),
(3, 'Project Contract Owner', '1', '2023-04-13 06:57:18', '2023-04-13 06:57:20'),
(4, 'Project Contract Vendor', '0', '2023-04-13 06:57:22', '2023-04-13 07:08:53'),
(5, 'NDA', '1', '2023-04-13 07:08:49', NULL),
(6, 'Others', '1', '2023-04-13 07:08:55', '2023-04-13 07:08:57');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2023_04_11_105917_create_company_table', 2),
(8, '2023_04_19_073808_create_permission_tables', 3);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 12);

-- --------------------------------------------------------

--
-- Table structure for table `msa_type`
--

CREATE TABLE `msa_type` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `msa_type`
--

INSERT INTO `msa_type` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'MSA', '2023-04-14 13:04:03', '2023-04-14 13:04:07'),
(2, 'PSA', '2023-04-14 13:04:10', '2023-04-14 13:04:12');

-- --------------------------------------------------------

--
-- Table structure for table `nda`
--

CREATE TABLE `nda` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `status` enum('start','negotiation','workflow','request-for-sign','sign','complete') DEFAULT NULL,
  `contact` text DEFAULT NULL,
  `document` text DEFAULT NULL,
  `obligation` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `team` text DEFAULT NULL,
  `company_id` text DEFAULT NULL,
  `vendor_id` text DEFAULT NULL,
  `insert_user_id` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `user_id` text DEFAULT NULL,
  `sender_id` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('unseen','seen') NOT NULL DEFAULT 'unseen',
  `url` text DEFAULT NULL,
  `did` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `user_id`, `sender_id`, `message`, `status`, `url`, `did`, `created_at`, `updated_at`) VALUES
(51, '46', '12', 'New owner msa created and you are added in team of workflow', 'unseen', 'user-all-contracts', NULL, '2023-07-11 10:05:07', '2023-07-11 10:05:07'),
(52, '12', '12', 'New owner msa created and you are added in team of workflow', 'unseen', 'user-all-contracts', NULL, '2023-07-11 10:05:07', '2023-07-11 10:05:07'),
(53, '47', '12', 'New vendor msa created and you are added in team of workflow', 'unseen', 'user-all-contracts-vendor-msa', NULL, '2023-07-11 10:23:15', '2023-07-11 10:23:15'),
(54, '96', '12', 'New sign request, please review the contract and sign it', 'unseen', 'sign-request-sent', NULL, '2023-07-11 10:35:20', '2023-07-11 10:35:20'),
(55, '47', '12', 'New vendor msa created and you are added in team of workflow', 'unseen', 'user-all-contracts-vendor-msa', NULL, '2023-07-11 10:45:10', '2023-07-11 10:45:10'),
(56, '96', '12', 'New sign request, please review the contract and sign it', 'unseen', 'sign-request-sent', NULL, '2023-07-11 10:49:50', '2023-07-11 10:49:50'),
(57, '47', '12', 'New vendor msa created and you are added in team of workflow', 'unseen', 'user-all-contracts-vendor-msa', NULL, '2023-07-11 10:55:06', '2023-07-11 10:55:06'),
(58, '96', '12', 'New sign request, please review the contract and sign it', 'unseen', 'sign-request-sent', NULL, '2023-07-11 10:59:47', '2023-07-11 10:59:47'),
(59, '47', '12', 'New vendor msa created and you are added in team of workflow', 'unseen', 'user-all-contracts-vendor-msa', NULL, '2023-07-22 09:23:33', '2023-07-22 09:23:33'),
(60, '97', '12', 'New sign request, please review the contract and sign it', 'unseen', 'sign-request-sent', NULL, '2023-07-22 09:27:36', '2023-07-22 09:27:36'),
(61, '47', '12', 'New vendor msa created and you are added in team of workflow', 'unseen', 'user-all-contracts-vendor-msa', NULL, '2023-08-25 05:35:48', '2023-08-25 05:35:48'),
(62, '47', '12', 'New vendor msa created and you are added in team of workflow', 'unseen', 'user-all-contracts-vendor-msa', NULL, '2023-08-25 06:04:54', '2023-08-25 06:04:54'),
(63, '47', '12', 'New vendor msa created and you are added in team of workflow', 'unseen', 'user-all-contracts-vendor-msa', NULL, '2023-08-25 07:48:27', '2023-08-25 07:48:27'),
(64, '101', '12', 'New sign request, please review the contract and sign it', 'unseen', 'sign-request-sent', NULL, '2023-08-25 07:52:22', '2023-08-25 07:52:22'),
(65, '47', '12', 'New vendor msa created and you are added in team of workflow', 'unseen', 'user-all-contracts-vendor-msa', NULL, '2023-08-25 13:19:44', '2023-08-25 13:19:44'),
(66, '47', '12', 'New vendor msa created and you are added in team of workflow', 'unseen', 'user-all-contracts-vendor-msa', NULL, '2023-08-28 14:11:08', '2023-08-28 14:11:08'),
(67, '103', '12', 'New sign request, please review the contract and sign it', 'unseen', 'sign-request-sent', NULL, '2023-08-28 14:15:04', '2023-08-28 14:15:04'),
(68, '47', '12', 'New vendor msa created and you are added in team of workflow', 'unseen', 'user-all-contracts-vendor-msa', NULL, '2023-08-28 14:17:06', '2023-08-28 14:17:06'),
(69, '104', '12', 'New sign request, please review the contract and sign it', 'unseen', 'sign-request-sent', NULL, '2023-08-28 14:20:13', '2023-08-28 14:20:13'),
(70, '47', '12', 'New vendor msa created and you are added in team of workflow', 'unseen', 'user-all-contracts-vendor-msa', NULL, '2023-09-06 17:38:28', '2023-09-06 17:38:28'),
(71, '47', '12', 'New vendor msa created and you are added in team of workflow', 'unseen', 'user-all-contracts-vendor-msa', NULL, '2023-09-06 17:48:28', '2023-09-06 17:48:28'),
(72, '105', '12', 'New sign request, please review the contract and sign it', 'unseen', 'sign-request-sent', NULL, '2023-09-06 17:53:47', '2023-09-06 17:53:47'),
(73, '47', '12', 'New vendor msa created and you are added in team of workflow', 'unseen', 'user-all-contracts-vendor-msa', NULL, '2023-09-06 18:06:58', '2023-09-06 18:06:58'),
(74, '47', '12', 'New vendor msa created and you are added in team of workflow', 'unseen', 'user-all-contracts-vendor-msa', NULL, '2023-09-06 18:09:50', '2023-09-06 18:09:50'),
(75, '106', '12', 'New sign request, please review the contract and sign it', 'unseen', 'sign-request-sent', NULL, '2023-09-06 18:13:42', '2023-09-06 18:13:42'),
(76, '47', '12', 'New vendor msa created and you are added in team of workflow', 'unseen', 'user-all-contracts-vendor-msa', NULL, '2023-09-06 18:24:15', '2023-09-06 18:24:15'),
(77, '47', '12', 'New vendor msa created and you are added in team of workflow', 'unseen', 'user-all-contracts-vendor-msa', NULL, '2023-09-06 19:10:34', '2023-09-06 19:10:34'),
(78, '107', '12', 'New sign request, please review the contract and sign it', 'unseen', 'sign-request-sent', NULL, '2023-09-06 19:14:37', '2023-09-06 19:14:37');

-- --------------------------------------------------------

--
-- Table structure for table `other_contract`
--

CREATE TABLE `other_contract` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `contact` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `document` text DEFAULT NULL,
  `obligation` text DEFAULT NULL,
  `status` enum('start','negotiation','workflow','request-for-sign','sign','complete') DEFAULT NULL,
  `team` text DEFAULT NULL,
  `company_id` text DEFAULT NULL,
  `vendor_id` text DEFAULT NULL,
  `insert_user_id` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owner_msa`
--

CREATE TABLE `owner_msa` (
  `id` int(11) NOT NULL,
  `owner_name` text DEFAULT NULL,
  `owner_email` text DEFAULT NULL,
  `document` text DEFAULT NULL,
  `document_original` text DEFAULT NULL,
  `status` enum('start','negotiation','workflow','request-for-sign','sign-request-sent','completed','declined') DEFAULT NULL,
  `owner_contact` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `obligation` text DEFAULT NULL,
  `team` text DEFAULT NULL,
  `company_id` text DEFAULT NULL,
  `vendor_id` text DEFAULT NULL,
  `start_date` text DEFAULT NULL,
  `end_date` text DEFAULT NULL,
  `insert_user_id` text DEFAULT NULL,
  `documentId` text DEFAULT NULL,
  `sendUrl` text DEFAULT NULL,
  `signLink` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owner_msa`
--

INSERT INTO `owner_msa` (`id`, `owner_name`, `owner_email`, `document`, `document_original`, `status`, `owner_contact`, `address`, `obligation`, `team`, `company_id`, `vendor_id`, `start_date`, `end_date`, `insert_user_id`, `documentId`, `sendUrl`, `signLink`, `created_at`, `updated_at`) VALUES
(61, 'DB Tech', 'project@developerbazaar.com', 'upload/6/contract/3987351689069907.pdf', 'upload/6/original/9074881689069907.pdf', 'request-for-sign', NULL, NULL, NULL, '46,12', '6', '100', '2023-07-12', '2023-07-24', '12', '2ceb6b82-02d2-4971-9dd8-d95f3f80ff24', 'https://app.boldsign.com/document/embed/?documentId=2ceb6b82-02d2-4971-9dd8-d95f3f80ff24e_tBcbu4nn;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', NULL, '2023-07-11 10:05:07', '2023-08-25 07:46:20');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('user@resoluteuser.com', '$2y$10$XruFX/rgG/oDrDHpuDwe5uUeGRDllMWaf9Qt.5JG3Wp9dPK3u6sze', '2023-04-10 01:59:50'),
('pragyachouhan76666@gmail.com', '$2y$10$TtjI3vGDQfCo8.R8IiVL7eql/GC4IJWughh9Jln3nZ/yPNYbnEkRy', '2023-06-02 14:32:37'),
('bhavik@webcontract.com', '$2y$10$R.VHIwwl5msp1.l7atr0Eux4yiVv2VhIZYYbqonDo2.VPlKQMu9hW', '2023-06-07 09:44:27'),
('pragyakushwah2017@gmail.com', '$2y$10$QmGEwWlmtUu7YVfelIsFAu2qr0ib/s.zw3CgYxaAyTVESOFAgzfAq', '2023-06-07 09:46:32');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'user-team', 'web', NULL, NULL),
(2, 'user-create-member', 'web', NULL, NULL),
(3, 'user-store-member', 'web', NULL, NULL),
(4, 'user-edit-member', 'web', NULL, NULL),
(5, 'user-update-member', 'web', NULL, NULL),
(6, 'user-delete-member', 'web', NULL, NULL),
(7, 'user-create-msa-template', 'web', NULL, NULL),
(8, 'user-store-msa-template', 'web', NULL, NULL),
(9, 'user-edit-msa-template', 'web', NULL, NULL),
(10, 'user-update-msa-template', 'web', NULL, NULL),
(11, 'user-delete-msa-template', 'web', NULL, NULL),
(12, 'user-create-project-contract-template', 'web', NULL, NULL),
(13, 'user-store-project-contract-template', 'web', NULL, NULL),
(14, 'user-edit-project-contract-template', 'web', NULL, NULL),
(15, 'user-update-project-contract-template', 'web', NULL, NULL),
(16, 'user-delete-project-contract-template', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_contract_owner`
--

CREATE TABLE `project_contract_owner` (
  `id` int(11) NOT NULL,
  `project_name` text DEFAULT NULL,
  `project_umbea` text DEFAULT NULL,
  `client_name` text DEFAULT NULL,
  `document` text DEFAULT NULL,
  `document_original` text DEFAULT NULL,
  `owner_msa_id` text DEFAULT NULL,
  `status` enum('start','negotiation','workflow','request-for-sign','sign-request-sent','completed','declined') DEFAULT NULL,
  `client_email` text DEFAULT NULL,
  `client_contact` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `obligation` text DEFAULT NULL,
  `team` text DEFAULT NULL,
  `company_id` text DEFAULT NULL,
  `vendor_id` text DEFAULT NULL,
  `does_msa_req` enum('Yes','No') DEFAULT NULL,
  `does_client_have_msa` enum('Yes','No') DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `insert_user_id` text DEFAULT NULL,
  `documentId` text DEFAULT NULL,
  `sendUrl` text DEFAULT NULL,
  `signLink` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_contract_vendor`
--

CREATE TABLE `project_contract_vendor` (
  `id` int(11) NOT NULL,
  `vendor_name` text DEFAULT NULL,
  `vendor_contact` text DEFAULT NULL,
  `vendor_email` text DEFAULT NULL,
  `project_name` text DEFAULT NULL,
  `amount` text DEFAULT NULL,
  `vendor_msa_id` text DEFAULT NULL,
  `document` text DEFAULT NULL,
  `document_original` text DEFAULT NULL,
  `status` enum('start','negotiation','workflow','request-for-sign','sign-request-sent','completed','declined') DEFAULT NULL,
  `address` text DEFAULT NULL,
  `obligation` text DEFAULT NULL,
  `team` text DEFAULT NULL,
  `company_id` text DEFAULT NULL,
  `vendor_id` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `template_id` text DEFAULT NULL,
  `insert_user_id` text DEFAULT NULL,
  `documentId` text DEFAULT NULL,
  `sendUrl` text DEFAULT NULL,
  `signLink` text DEFAULT NULL,
  `comment_email_send` enum('no','yes') NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE `template` (
  `id` int(11) NOT NULL,
  `trade` text DEFAULT NULL,
  `name` text DEFAULT NULL,
  `type` enum('msa_psa','project') DEFAULT NULL,
  `document` text DEFAULT NULL,
  `type_msa_psa` enum('MSA','PSA') DEFAULT NULL,
  `company_id` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`id`, `trade`, `name`, `type`, `document`, `type_msa_psa`, `company_id`, `created_at`, `updated_at`) VALUES
(43, '#1111', 'concreate', 'msa_psa', 'upload/6/template/1159511686135174.pdf', 'MSA', '6', '2023-06-07 10:52:55', '2023-06-07 10:52:55'),
(44, '#2222', 'plumber', 'msa_psa', 'upload/6/template/7100641686135210.pdf', 'PSA', '6', '2023-06-07 10:53:30', '2023-06-07 10:53:30'),
(45, '#3333', 'Hardware', 'project', 'upload/6/template/7285211686135266.pdf', NULL, '6', '2023-06-07 10:54:26', '2023-06-07 10:54:26'),
(46, '#1111', 'web', 'msa_psa', 'upload/6/template/61321692969156.pdf', 'MSA', '6', '2023-08-25 13:12:36', '2023-08-25 13:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `userType` enum('admin','user','vendor') NOT NULL DEFAULT 'vendor',
  `job_title` text DEFAULT NULL,
  `company_name` text DEFAULT NULL,
  `company_id` text DEFAULT NULL,
  `company_role` enum('company-admin','team','vendor') DEFAULT NULL,
  `phone` text DEFAULT NULL,
  `domain` text DEFAULT NULL,
  `status` enum('active','block') NOT NULL DEFAULT 'active',
  `profile_image` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `userType`, `job_title`, `company_name`, `company_id`, `company_role`, `phone`, `domain`, `status`, `profile_image`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Admin', 'admin@superadmin.com', NULL, '$2y$10$nYlj9ulQzc5cGq1cD9THkObmDKtJr6hu87ZtW5VZuto7R/StdJ7My', 'admin', 'super-admin', NULL, NULL, NULL, '54354354', NULL, 'active', 'upload/user_profile/3018601685371281.png', NULL, '2023-04-06 02:49:28', '2023-07-05 13:25:31'),
(12, 'Bhavik Savaliya 1', 'bhavik@webcontract.com', NULL, '$2y$10$jw6ioCHBZ006c/Lz/pM/GeyjFJRR51j57yfS/gd9mtg3aYnqLnvXO', 'user', 'Manager', 'webcontract', '6', 'company-admin', '222333222', 'webcontract.com', 'active', 'upload/user_profile/6100341685369754.png', NULL, '2023-04-11 06:00:08', '2023-07-07 06:05:31'),
(44, 'team1', 'team1@webcontract.com', NULL, '$2y$10$yGhEVkBwriBoY0rbfJCBw.8yO4/iSM76Ke9pFFjUDn5LjTpi/kezG', 'user', 'team1', 'webcontract', '6', 'team', '42343242', 'webcontract.com', 'active', NULL, NULL, '2023-04-21 08:07:58', '2023-04-21 08:07:58'),
(45, 'team2', 'team2@webcontract.com', NULL, '$2y$10$pbdpuYiPcjIe.FpXNeLLi.524BJh5KyyP1yXkSMED4NXACO60ShEO', 'user', 'team2', 'webcontract', '6', 'team', '54354', 'webcontract.com', 'active', NULL, NULL, '2023-04-21 08:08:16', '2023-04-21 08:08:16'),
(46, 'team3', 'team3@webcontract.com', NULL, '$2y$10$XJQJvAwVrBDwDKTe6naSUeTz85M5eZsQZs1oPMvJtt3APW53b2qzW', 'user', 'team3', 'webcontract', '6', 'team', '43534', 'webcontract.com', 'active', NULL, NULL, '2023-04-21 08:08:40', '2023-04-21 08:08:40'),
(47, 'team4', 'team4@webcontract.com', NULL, '$2y$10$Vl/7.nTs7oNCjFbj/b4XDuE3y4JkAI2eCQLZSfUUr.4NcL7Hh8fwm', 'user', 'team4', 'webcontract', '6', 'team', '324234', 'webcontract.com', 'active', NULL, NULL, '2023-04-21 08:08:51', '2023-05-29 13:09:39'),
(72, 'pragya kushwah', 'pragyakushwah2017@gmail.com', NULL, '$2y$10$2QJ7MjG77Cf3CwmQHK8mC.h65QurKm6fuAndz7nBl2HlxXxtJ/BvO', 'vendor', 'vendor', NULL, NULL, NULL, '876878678', NULL, 'active', 'upload/user_profile/3641991685371024.png', NULL, '2023-05-24 07:20:46', '2023-05-29 14:37:18'),
(96, 'testpp', 'testpp@gmail.com', NULL, '$2y$10$jw6ioCHBZ006c/Lz/pM/GeyjFJRR51j57yfS/gd9mtg3aYnqLnvXO', 'vendor', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2023-07-11 10:34:07', '2023-07-11 10:34:07'),
(97, 'vendor', 'vendor11@gmail.com', NULL, '$2y$10$y4qtEM34ooK9hUdTQmP.i.SzQXKdO1qkiFW3QxP6nXXeu6IZbMjBC', 'vendor', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2023-07-22 09:26:59', '2023-07-22 09:26:59'),
(98, 'testtt', 'testtt@gmail.in', NULL, '$2y$10$.stmZsX7roUG.EEYFiQZD.W306ufD1d6ggxXv/j4q5MWpaUVmDkd2', 'vendor', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2023-08-25 06:07:45', '2023-08-25 06:07:45'),
(99, 'pragya test', 'pragyatest@gmail.com', NULL, '$2y$10$rVkmc9tHS5HZTwdnqFELbepR/BvEk0ZM.UG/xBvB8n.9Nyp3Zc.d.', 'vendor', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2023-08-25 06:08:28', '2023-08-25 06:08:28'),
(100, 'DB Tech', 'project@developerbazaar.com', NULL, '$2y$10$O3SUCvzgIMmtTitzhZ.gAesU0XfLuhGEU.NzJEIvxe8rxvIWL0.xm', 'vendor', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2023-08-25 07:46:19', '2023-08-25 07:46:19'),
(101, 'test vendor', 'testvendor@gm.in', NULL, '$2y$10$jgX4tdkyk8C0/oxoC4nPw./ZxnmA8Fzmg.zwATvXflgaNq2EYS5pa', 'vendor', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2023-08-25 07:51:42', '2023-08-25 07:51:42'),
(102, 'team5', 'team5@webcontract.com', NULL, '$2y$10$01VX32MTkXmLNjKQcDC/9eE8EqqTOsQfqXrjzuwIiZqnFBM8IcFr.', 'user', 'developer', 'webcontract', '6', 'team', '87867868', 'webcontract.com', 'active', NULL, NULL, '2023-08-25 13:10:10', '2023-08-25 13:10:10'),
(103, 'rahul', 'rahul@gmail.com', NULL, '$2y$10$JS9mVDjoc3GrqSTZ3cKC..JQEinOgy1vS2tho6PkgKW24Xx4uwGli', 'vendor', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2023-08-28 14:14:37', '2023-08-28 14:14:37'),
(104, 'ram', 'ram@gmail.in', NULL, '$2y$10$GUTdXqBUAdXLOXkBqsN7M.AmmCNFuBAWVclTKy4NrVPocqGKkfWpS', 'vendor', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2023-08-28 14:19:45', '2023-08-28 14:19:45'),
(105, 'ram', 'ram1@gmail.com', NULL, '$2y$10$hq8lwgZvGz48lO0ICg5hl.naF74xHdBRJMfI7tJIEse0OgOYYF6mK', 'vendor', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2023-09-06 17:53:07', '2023-09-06 17:53:07'),
(106, 'sita', 'sita@gmail.com', NULL, '$2y$10$7bM0SttaWB5v00fgGtcop.bsqZ3fQkpCw/MVJdaUJ6ADJhZhUZRDO', 'vendor', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2023-09-06 18:13:09', '2023-09-06 18:13:09'),
(107, 'geeta', 'geeta@gmail.com', NULL, '$2y$10$u9VxGlUlktU/6Jz7gnAyQ.8hOuTWvNa3GwrQvFsr8wLzrAqKVM36S', 'vendor', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2023-09-06 19:13:57', '2023-09-06 19:13:57');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_msa`
--

CREATE TABLE `vendor_msa` (
  `id` int(11) NOT NULL,
  `vendor_name` text DEFAULT NULL,
  `vendor_contact` text DEFAULT NULL,
  `vendor_email` text DEFAULT NULL,
  `document` text DEFAULT NULL,
  `document_original` text DEFAULT NULL,
  `status` enum('start','negotiation','workflow','request-for-sign','sign-request-sent','completed','declined') DEFAULT NULL,
  `template_type` text DEFAULT NULL,
  `type_msa_psa` enum('msa','psa') DEFAULT NULL,
  `executed_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `obligation` text DEFAULT NULL,
  `team` text DEFAULT NULL,
  `company_id` text DEFAULT NULL,
  `vendor_id` text DEFAULT NULL,
  `template_id` text DEFAULT NULL,
  `insert_user_id` text DEFAULT NULL,
  `documentId` text DEFAULT NULL,
  `sendUrl` text DEFAULT NULL,
  `signLink` text DEFAULT NULL,
  `company_admin_id` text DEFAULT NULL,
  `team_member` text DEFAULT NULL,
  `flow_teamno` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_msa`
--

INSERT INTO `vendor_msa` (`id`, `vendor_name`, `vendor_contact`, `vendor_email`, `document`, `document_original`, `status`, `template_type`, `type_msa_psa`, `executed_date`, `due_date`, `expired_date`, `address`, `obligation`, `team`, `company_id`, `vendor_id`, `template_id`, `insert_user_id`, `documentId`, `sendUrl`, `signLink`, `company_admin_id`, `team_member`, `flow_teamno`, `created_at`, `updated_at`) VALUES
(58, 'testpp', '89787766767', 'testpp@gmail.com', 'upload/6/contract/vendor/5908661689071227.pdf', 'upload/6/original/2959961689071577.pdf', 'completed', NULL, 'msa', '2023-07-11', '2023-07-18', '2025-07-18', 'test 1211', NULL, '47_1 46_12', '6', '96', '43', '12', '3805bcd6-bf3b-4a01-a053-f1d0a0d08c11', 'https://app.boldsign.com/document/embed/?documentId=3805bcd6-bf3b-4a01-a053-f1d0a0d08c11e_W7fO4nGZ;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', 'https://app.boldsign.com/document/sign/?documentId=3805bcd6-bf3b-4a01-a053-f1d0a0d08c11s_hEomC;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', '12', '46', '2', '2023-07-11 10:23:15', '2023-07-11 10:38:02'),
(59, 'testpp', '8787866554', 'testpp@gmail.com', 'upload/6/contract/vendor/8690331689072448.pdf', 'upload/6/original/2007721689072509.pdf', 'completed', NULL, 'msa', '2023-07-11', '2023-07-18', '2025-07-18', 'test 121', NULL, '47_1 46_12', '6', '96', '43', '12', 'd7ed3ebb-531f-44fc-b3b7-7b23d23c25c0', 'https://app.boldsign.com/document/embed/?documentId=d7ed3ebb-531f-44fc-b3b7-7b23d23c25c0e_fDyzrssf;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', 'https://app.boldsign.com/document/sign/?documentId=d7ed3ebb-531f-44fc-b3b7-7b23d23c25c0s_Lcr8a;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', '12', '46', '2', '2023-07-11 10:45:10', '2023-07-11 10:50:50'),
(60, 'testpp', '8787878787', 'testpp@gmail.com', 'upload/6/contract/vendor/1413381689073052.pdf', 'upload/6/original/1252141689073126.pdf', 'completed', NULL, 'msa', '2023-07-11', '2023-07-18', '2025-07-18', 'test 121', NULL, '47_1 46_12', '6', '96', '43', '12', 'ec21306c-fd95-4591-86aa-787182fa9c6f', 'https://app.boldsign.com/document/embed/?documentId=ec21306c-fd95-4591-86aa-787182fa9c6fe_kzyqRpuq;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', 'https://app.boldsign.com/document/sign/?documentId=ec21306c-fd95-4591-86aa-787182fa9c6fs_UoLAj;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', '12', '46', '2', '2023-07-11 10:55:05', '2023-07-11 11:00:51'),
(61, 'vendor', '878797878', 'vendor11@gmail.com', 'upload/6/contract/vendor/909121690017812.pdf', 'upload/6/original/2237741690018003.pdf', 'completed', NULL, 'msa', '2023-07-22', '2023-07-29', '2025-07-29', 'test', NULL, '47_1', '6', '97', '43', '12', 'a0a35743-3616-4160-905a-624eef91eb1d', 'https://app.boldsign.com/document/embed/?documentId=a0a35743-3616-4160-905a-624eef91eb1de_4t87JPkN;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', 'https://app.boldsign.com/document/sign/?documentId=a0a35743-3616-4160-905a-624eef91eb1ds_8Uim6;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', '12', '47', '1', '2023-07-22 09:23:33', '2023-07-22 09:28:58'),
(62, 'pragya test', '87656564433', 'pragyatest@gmail.com', 'upload/6/contract/vendor/4003971692941904.pdf', 'upload/6/original/4793071692941748.pdf', 'request-for-sign', NULL, 'msa', NULL, '2023-09-01', '2025-09-01', 'test 121', NULL, '47_1 46_12', '6', '99', '43', '12', NULL, NULL, NULL, '12', '46', '2', '2023-08-25 05:35:48', '2023-08-25 06:08:48'),
(63, 'testtt', '7878787878', 'testtt@gmail.in', 'upload/6/contract/vendor/2595331692943658.pdf', 'upload/6/original/3134431692943494.pdf', 'request-for-sign', NULL, 'msa', NULL, '2023-09-01', '2025-09-01', 'test 1211', NULL, '47_1 46_12', '6', '98', '43', '12', NULL, NULL, NULL, '12', '46', '2', '2023-08-25 06:04:54', '2023-08-25 06:07:45'),
(64, 'test vendor', '8989898989', 'testvendor@gm.in', 'upload/6/contract/vendor/6189391692949888.pdf', 'upload/6/original/2605581692949707.pdf', 'completed', NULL, 'msa', '2023-08-25', '2023-09-01', '2025-09-01', 'test 121', NULL, '47_1 46_12', '6', '101', '43', '12', '19eadc4d-12d3-46b8-bcc1-1ed04cc18e24', 'https://app.boldsign.com/document/embed/?documentId=19eadc4d-12d3-46b8-bcc1-1ed04cc18e24e_WS7ufacT;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', 'https://app.boldsign.com/document/sign/?documentId=19eadc4d-12d3-46b8-bcc1-1ed04cc18e24s_RwTUN;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', '12', '46', '2', '2023-08-25 07:48:27', '2023-08-25 07:53:34'),
(65, 'test tt', '7657567567', 'testpp@gmail.in', 'upload/6/contract/vendor/2757971692969584.pdf', 'upload/6/original/5678471692969584.pdf', 'start', NULL, 'msa', NULL, '2023-09-01', '2025-09-01', 'test 121', NULL, '47_1 46_12', '6', NULL, '43', '12', NULL, NULL, NULL, '12', '47', '1', '2023-08-25 13:19:44', '2023-08-25 13:19:44'),
(66, 'rahul', '897897898', 'rahul@gmail.com', 'upload/6/contract/vendor/1572551693232046.pdf', 'upload/6/original/5604711693231868.pdf', 'sign-request-sent', NULL, 'msa', NULL, '2023-09-04', '2025-09-04', 'test 121', NULL, '47_1 46_12', '6', '103', '43', '12', '28594c05-fb22-4d70-8be2-f311d879976f', 'https://app.boldsign.com/document/embed/?documentId=28594c05-fb22-4d70-8be2-f311d879976fe_YEGOUupB;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', NULL, '12', '46', '2', '2023-08-28 14:11:08', '2023-08-28 14:15:04'),
(67, 'ram', '987987978', 'ram@gmail.in', 'upload/6/contract/vendor/5730241693232373.pdf', 'upload/6/original/6123541693232226.pdf', 'completed', NULL, 'msa', '2023-08-28', '2023-09-04', '2025-09-04', 'test 121', NULL, '47_1 46_12', '6', '104', '46', '12', 'b81c5341-74df-49f7-b6f6-adc9e98cf94a', 'https://app.boldsign.com/document/embed/?documentId=b81c5341-74df-49f7-b6f6-adc9e98cf94ae_I4KFK24f;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', 'https://app.boldsign.com/document/sign/?documentId=b81c5341-74df-49f7-b6f6-adc9e98cf94as_fsoSZ;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', '12', '46', '2', '2023-08-28 14:17:06', '2023-08-28 14:21:26'),
(68, 'bhumika', '7878788888', 'bhumika@gmail.com', 'upload/6/contract/vendor/516631694021965.pdf', 'upload/6/original/7571911694021908.pdf', 'workflow', NULL, 'msa', NULL, '2023-09-13', '2025-09-13', '121 test something', NULL, '47_1 46_12', '6', NULL, '43', '12', NULL, NULL, NULL, '12', '47', '1', '2023-09-06 17:38:28', '2023-09-06 17:39:25'),
(69, 'ram', '9898989999', 'ram1@gmail.com', 'upload/6/contract/vendor/2876821694022670.pdf', 'upload/6/original/3662771694022508.pdf', 'completed', NULL, 'msa', '2023-09-06', '2023-09-13', '2025-09-13', '121 indore', NULL, '47_1 46_12', '6', '105', '46', '12', 'ed699e39-1519-4c44-bea2-86070ff5ae27', 'https://app.boldsign.com/document/embed/?documentId=ed699e39-1519-4c44-bea2-86070ff5ae27e_VMUInz0l;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', 'https://app.boldsign.com/document/sign/?documentId=ed699e39-1519-4c44-bea2-86070ff5ae27s_FbnnA;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', '12', '46', '2', '2023-09-06 17:48:28', '2023-09-06 17:56:53'),
(70, 'sita', '787778778', 'sita@gmail.com', 'upload/6/contract/vendor/1198531694023618.pdf', 'upload/6/original/1038021694023618.pdf', 'start', NULL, 'msa', NULL, '2023-09-13', '2025-09-13', '121 test address', NULL, '47_1 46_12', '6', NULL, '46', '12', NULL, NULL, NULL, '12', '47', '1', '2023-09-06 18:06:58', '2023-09-06 18:06:58'),
(71, 'sita', '878778787', 'sita@gmail.com', 'upload/6/contract/vendor/2765371694023924.pdf', 'upload/6/original/608171694023790.pdf', 'sign-request-sent', NULL, 'msa', NULL, '2023-09-13', '2025-09-13', '121 test address', NULL, '47_1 46_12', '6', '106', '46', '12', '9c5cfa00-2c4e-4290-98fc-15ff214c4a1c', 'https://app.boldsign.com/document/embed/?documentId=9c5cfa00-2c4e-4290-98fc-15ff214c4a1ce_XCTwazqT;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', 'https://app.boldsign.com/document/sign/?documentId=9c5cfa00-2c4e-4290-98fc-15ff214c4a1cs_ONoWH;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', '12', '46', '2', '2023-09-06 18:09:50', '2023-09-06 18:15:05'),
(72, 'john', '9898989', 'john@gmail.com', 'upload/6/contract/vendor/7075041694024655.pdf', 'upload/6/original/5946741694024655.pdf', 'start', NULL, 'msa', NULL, '2023-09-13', '2025-09-13', '1213 test', NULL, '47_1 46_12', '6', NULL, '46', '12', NULL, NULL, NULL, '12', '47', '1', '2023-09-06 18:24:15', '2023-09-06 18:24:15'),
(73, 'geeta', '7878787888', 'geeta@gmail.com', 'upload/6/contract/vendor/1122321694027586.pdf', 'upload/6/original/7756281694027434.pdf', 'completed', NULL, 'msa', '2023-09-06', '2023-09-13', '2025-09-13', '121 test address', NULL, '47_1 46_12', '6', '107', '46', '12', '0c573c6d-ca9d-4a10-a676-042861d42fcd', 'https://app.boldsign.com/document/embed/?documentId=0c573c6d-ca9d-4a10-a676-042861d42fcde_nRAFDPO0;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', 'https://app.boldsign.com/document/sign/?documentId=0c573c6d-ca9d-4a10-a676-042861d42fcds_VJLh5;2b6d7cd6-fdd0-4ccd-b9b7-5acae5a480c0', '12', '46', '2', '2023-09-06 19:10:34', '2023-09-06 19:15:52');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_performance`
--

CREATE TABLE `vendor_performance` (
  `id` int(11) NOT NULL,
  `dome_pm` text DEFAULT NULL,
  `vendor_name` text DEFAULT NULL,
  `project` text DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `rating` text DEFAULT NULL,
  `vendor_pm` text DEFAULT NULL,
  `company_id` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_name_unique` (`company_name`);

--
-- Indexes for table `contract_type`
--
ALTER TABLE `contract_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `msa_type`
--
ALTER TABLE `msa_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nda`
--
ALTER TABLE `nda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_contract`
--
ALTER TABLE `other_contract`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owner_msa`
--
ALTER TABLE `owner_msa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `project_contract_owner`
--
ALTER TABLE `project_contract_owner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_contract_vendor`
--
ALTER TABLE `project_contract_vendor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vendor_msa`
--
ALTER TABLE `vendor_msa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_performance`
--
ALTER TABLE `vendor_performance`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `contract_type`
--
ALTER TABLE `contract_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `msa_type`
--
ALTER TABLE `msa_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nda`
--
ALTER TABLE `nda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `other_contract`
--
ALTER TABLE `other_contract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owner_msa`
--
ALTER TABLE `owner_msa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_contract_owner`
--
ALTER TABLE `project_contract_owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `project_contract_vendor`
--
ALTER TABLE `project_contract_vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `template`
--
ALTER TABLE `template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `vendor_msa`
--
ALTER TABLE `vendor_msa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `vendor_performance`
--
ALTER TABLE `vendor_performance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
