-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2026 at 07:17 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beauty`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `image_mobile` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `type` enum('hero_slider','offer_banner','popup_banner','category_banner') NOT NULL DEFAULT 'hero_slider',
  `position` enum('homepage','category_page','checkout_page','all_pages') NOT NULL DEFAULT 'homepage',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `subtitle`, `image`, `image_mobile`, `button_text`, `link_url`, `type`, `position`, `sort_order`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Skip to the beginning of the images gallery Isla Beaded Mini Dress', 'Mini dress with alluring floral print', '1778600495_6a034a2fe15a9.png', '1778600495_6a034a2fe9f05.png', 'shop now', 'https://google.com', 'hero_slider', 'homepage', 0, NULL, NULL, 1, '2026-04-27 11:07:14', '2026-05-12 10:11:35'),
(3, 'Square neck with spaghetti straps', 'Cross back straps with bead accents', '1778600580_6a034a84dd12b.png', '1778600580_6a034a84dea38.png', 'shop now', 'https://www.forevernew.co.in/isla-beaded-mini-dress-cp-30275101.html', 'offer_banner', 'homepage', 0, NULL, NULL, 1, '2026-05-12 10:13:00', '2026-05-12 10:13:00');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `logo`, `description`, `website_url`, `is_featured`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'lakme', 'lakme', '1778598663_6a0343076cd57.png', 'SUGAR ka lipstick 12 hours se zyada chala — khana khaane ke baad bhi. Shade selection is excellent and the formula feels so lightweight', NULL, 0, 1, 0, '2026-05-12 09:41:03', '2026-05-12 09:41:03'),
(3, 'nika', 'nika', '1778599596_6a0346ac734ac.png', 'Delivery was super fast and packaging was beautiful! The Vitamin C sunscreen is my everyday essential now. Very happy with GlowNova!', 'https://abc.com', 0, 1, 10, '2026-05-12 09:55:27', '2026-05-12 09:56:36');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `meta_title`, `meta_description`, `status`, `created_at`, `updated_at`) VALUES
(7, 'Women', 'women', '1778488796_6a0195dc5f2c7.jpg', NULL, NULL, 1, '2026-05-11 03:09:56', '2026-05-11 03:09:56'),
(8, 'Men', 'men', '1778488895_6a01963f696bc.jpg', NULL, NULL, 1, '2026-05-11 03:11:35', '2026-05-11 03:11:35'),
(9, 'Kids', 'kids', '1778488954_6a01967a91ed5.jpg', NULL, NULL, 1, '2026-05-11 03:12:34', '2026-05-11 03:12:34');

-- --------------------------------------------------------

--
-- Table structure for table `child_subcategories`
--

CREATE TABLE `child_subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `child_subcategories`
--

INSERT INTO `child_subcategories` (`id`, `category_id`, `subcategory_id`, `name`, `slug`, `image`, `meta_title`, `meta_description`, `status`, `created_at`, `updated_at`) VALUES
(1, 7, 1, 'suit set', 'suit-set', '1778489642_6a01992a8e21c.jpg', NULL, NULL, 1, '2026-05-11 03:24:02', '2026-05-11 03:24:02'),
(2, 7, 2, 'mini dress', 'mini-dress', '1778489714_6a019972769af.png', NULL, NULL, 1, '2026-05-11 03:25:14', '2026-05-11 03:25:14'),
(4, 7, 1, 'indian suit', 'indian-suit', '1778489783_6a0199b7cab88.png', NULL, NULL, 1, '2026-05-11 03:26:23', '2026-05-11 03:26:23'),
(5, 7, 3, 'polo bag', 'polo-bag', '1778489812_6a0199d4b8799.jpg', NULL, NULL, 1, '2026-05-11 03:26:52', '2026-05-11 03:26:52'),
(6, 7, 3, 'hero bag', 'hero-bag', '1778489842_6a0199f2716de.jpg', NULL, NULL, 1, '2026-05-11 03:27:22', '2026-05-11 03:27:22'),
(7, 7, 4, 'bata shoes', 'bata-shoes', '1778489883_6a019a1ba5842.jpg', NULL, NULL, 1, '2026-05-11 03:28:03', '2026-05-11 03:28:03'),
(8, 7, 4, 'nika shoes', 'nika-shoes', '1778489906_6a019a32a7848.jpg', NULL, NULL, 1, '2026-05-11 03:28:26', '2026-05-11 03:28:26'),
(9, 8, 5, 'man pent', 'man-pent', '1778489945_6a019a5916354.jpg', NULL, NULL, 1, '2026-05-11 03:29:05', '2026-05-11 03:29:05'),
(10, 8, 6, 'man bottomm jens', 'man-bottomm-jens', '1778489970_6a019a72ab09b.jpg', NULL, NULL, 1, '2026-05-11 03:29:30', '2026-05-11 03:29:30'),
(11, 8, 7, 'tranding kurta', 'tranding-kurta', '1778490002_6a019a92afce5.png', NULL, NULL, 1, '2026-05-11 03:30:02', '2026-05-11 03:30:02');

-- --------------------------------------------------------

--
-- Table structure for table `discount_codes`
--

CREATE TABLE `discount_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` enum('percentage','fixed') NOT NULL DEFAULT 'percentage',
  `value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `min_order_value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `max_discount` decimal(10,2) DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `usage_per_user` int(11) NOT NULL DEFAULT 1,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `applicable_on` enum('all','category','product') NOT NULL DEFAULT 'all',
  `applicable_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`applicable_ids`)),
  `user_restriction` enum('all','new_users') NOT NULL DEFAULT 'all',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_04_15_021814_add_role_to_users_table', 1),
(6, '2026_04_18_005624_create_categories_table', 1),
(7, '2026_04_18_005625_create_subcategories_table', 1),
(8, '2026_04_18_005935_create_child_subcategories_table', 1),
(9, '2026_04_18_054330_create_products_table', 1),
(10, '2026_04_18_102721_create_product_types_table', 1),
(11, '2026_04_23_163340_remove_shade_size_variants_from_products_table', 1),
(12, '2026_04_25_020917_recreate_products_table', 1),
(13, '2026_04_26_044327_create_brands_table', 1),
(14, '2026_04_26_044653_create_banners_table', 1),
(15, '2026_05_20_163559_create_discount_codes_table', 2),
(16, '2026_05_21_160802_create_shipping_zones_table', 2),
(17, '2026_05_21_160803_create_shipping_settings_table', 2),
(18, '2026_05_21_161412_create_settings_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `child_subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_type` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `mrp_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `display_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `low_stock_alert` int(11) NOT NULL DEFAULT 5,
  `image` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `image4` varchar(255) DEFAULT NULL,
  `image5` varchar(255) DEFAULT NULL,
  `gallery_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery_images`)),
  `description` longtext DEFAULT NULL,
  `how_to_use` text DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `shipping_type` enum('free','paid') NOT NULL DEFAULT 'paid',
  `shipping_charge` decimal(8,2) NOT NULL DEFAULT 0.00,
  `cod_available` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `extra_fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`extra_fields`)),
  `product_on_sale` tinyint(1) NOT NULL DEFAULT 0,
  `new_arrivals` tinyint(1) NOT NULL DEFAULT 0,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `subcategory_id`, `child_subcategory_id`, `product_type`, `sku`, `name`, `slug`, `brand`, `tags`, `mrp_price`, `display_price`, `discount`, `stock`, `low_stock_alert`, `image`, `image2`, `image3`, `image4`, `image5`, `gallery_images`, `description`, `how_to_use`, `features`, `shipping_type`, `shipping_charge`, `cod_available`, `meta_title`, `meta_description`, `meta_keywords`, `extra_fields`, `product_on_sale`, `new_arrivals`, `featured`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 7, 1, 1, 'beauty', 'SKU-GLQXMGLS', 'Cider', 'cider', NULL, 'hello,new all,dredss', 300.00, 200.00, 33.33, 11, 5, '1778490235_6a019b7b0ec01.png', '1778490235_6a019b7b1717c.png', '1778490235_6a019b7b17bb1.jpg', NULL, NULL, '[\"1778490235_6a019b7b18746.jpg\",\"1778490235_6a019b7b1a2e9.jpg\",\"1778490235_6a019b7b1ae23.jpg\",\"1778490235_6a019b7b1bac8.jpg\",\"1778490235_6a019b7b1c8ab.jpg\"]', '<p><span style=\"color: rgb(25, 40, 55); font-family: Inter, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">Do Not Bleach, Tumble Dry With Low Heat, Machine Wash With Cold Water, Iron On Low Heat</span></p>', NULL, NULL, 'paid', 0.00, 1, NULL, NULL, NULL, '{\"skin_type\":[\"Oily\"],\"concern\":[\"Acne\"],\"key_ingredients\":\"hello\",\"full_ingredients\":null,\"is_organic\":false,\"is_vegan\":false,\"is_cruelty_free\":false,\"is_paraben_free\":false,\"net_weight\":\"400\",\"shelf_life\":\"30\",\"gender\":\"Women\"}', 0, 0, 0, 1, '2026-05-11 03:33:15', '2026-05-11 03:34:52'),
(2, 7, 2, 2, 'beauty', 'SKU-TX5BYPDD', 'BDG by Urban Outfitters', 'bdg-by-urban-outfitters', NULL, 'hello', 400.00, 200.00, 50.00, 33, 5, '1778490651_6a019d1b1ecbc.png', NULL, NULL, NULL, NULL, '[\"1778490588_6a019cdc054cb.jpg\",\"1778490588_6a019cdc06328.jpg\",\"1778490588_6a019cdc0718f.jpg\",\"1778490588_6a019cdc07cd6.jpg\"]', '<p><span style=\"color: rgb(25, 40, 55); font-family: Inter, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">Make a style statement with this beige tank top from BDG by Urban Outfitters. Crafted from polyamide, this stylish tank top will have you looking and feeling cool. Team it with a pair of trousers, flats and trendy sunglasses to complete the look.</span></p>', 'Make a style statement with this beige tank top from BDG by Urban Outfitters. Crafted from polyamide, this stylish tank top will have you looking and feeling cool. Team it with a pair of trousers, flats and trendy sunglasses to complete the look.', '[\"Make a style statement with this beige tank top from BDG by Urban Outfitters. Crafted from polyamide, this stylish tank top will have you looking and feeling cool. Team it with a pair of trousers, flats and trendy sunglasses to complete the look.\"]', 'paid', 0.00, 1, NULL, NULL, NULL, '{\"skin_type\":[],\"concern\":[],\"key_ingredients\":null,\"full_ingredients\":\"Make a style statement with this beige tank top from BDG by Urban Outfitters. Crafted from polyamide, this stylish tank top will have you looking and feeling cool. Team it with a pair of trousers, flats and trendy sunglasses to complete the look.\",\"is_organic\":false,\"is_vegan\":false,\"is_cruelty_free\":false,\"is_paraben_free\":false,\"net_weight\":\"300\",\"shelf_life\":\"22\",\"gender\":\"Women\"}', 0, 0, 0, 1, '2026-05-11 03:37:29', '2026-05-11 03:40:51'),
(3, 7, 3, 5, 'beauty', 'SKU-C5AI12AB', 'TERRA LUNA', 'terra-luna', NULL, 'dfdf', 3344.00, 3333.00, 0.33, 333, 5, '1778490738_6a019d7243234.jpg', NULL, NULL, NULL, NULL, '[\"1778490719_6a019d5fbc947.jpg\",\"1778490719_6a019d5fbd1d4.jpg\",\"1778490719_6a019d5fbd8f0.jpg\",\"1778490719_6a019d5fc278e.jpg\"]', NULL, NULL, NULL, 'paid', 0.00, 1, NULL, NULL, NULL, '{\"skin_type\":[],\"concern\":[],\"key_ingredients\":null,\"full_ingredients\":null,\"is_organic\":false,\"is_vegan\":false,\"is_cruelty_free\":false,\"is_paraben_free\":false,\"net_weight\":null,\"shelf_life\":null,\"gender\":null}', 0, 0, 0, 1, '2026-05-11 03:41:59', '2026-05-11 03:42:18'),
(4, 8, 5, 9, 'beauty', 'SKU-CIDDRZ2K', 'U.S. Polo Assn. Denim Co.', 'us-polo-assn-denim-co', NULL, 'fsdfas', 2232.00, 22.00, 99.01, 222, 5, '1778490836_6a019dd4296a2.jpg', NULL, NULL, NULL, NULL, '[\"1778490836_6a019dd42d6e7.jpg\",\"1778490836_6a019dd434f20.jpg\",\"1778490836_6a019dd435b72.jpg\",\"1778490836_6a019dd436827.jpg\"]', '<p><span style=\"color: rgb(25, 40, 55); font-family: Inter, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">Look your stylish best in this trendy brand printed oversized fit t-shirt from the latest collection of U.S. Polo Assn. Denim Co.. It features a half sleeves and crew neck design. The youthful and fashionable all-over printed design, high-quality and soft fabric. Pair with chinos or jeans for an easy transition from day to night.</span></p>', NULL, NULL, 'paid', 0.00, 1, NULL, NULL, NULL, '{\"skin_type\":[],\"concern\":[],\"key_ingredients\":null,\"full_ingredients\":null,\"is_organic\":false,\"is_vegan\":false,\"is_cruelty_free\":false,\"is_paraben_free\":false,\"net_weight\":null,\"shelf_life\":null,\"gender\":null}', 0, 0, 0, 1, '2026-05-11 03:43:56', '2026-05-11 03:43:56'),
(7, 7, 2, 2, 'beauty', 'SKU-MQZIJHAO', 'Michael Lauren', 'michael-lauren', NULL, 'sdfsdf', 3333.00, 3333.00, 0.00, 33, 5, '1778491182_6a019f2ec14df.png', NULL, NULL, NULL, NULL, '[\"1778491182_6a019f2ec8187.png\",\"1778491182_6a019f2ec8ff6.png\",\"1778491182_6a019f2ec9ca3.png\",\"1778491182_6a019f2ecad41.png\",\"1778491182_6a019f2ecbcce.png\"]', NULL, NULL, NULL, 'paid', 0.00, 1, NULL, NULL, NULL, '{\"skin_type\":[],\"concern\":[],\"key_ingredients\":null,\"full_ingredients\":null,\"is_organic\":false,\"is_vegan\":false,\"is_cruelty_free\":false,\"is_paraben_free\":false,\"net_weight\":null,\"shelf_life\":null,\"gender\":null}', 0, 0, 0, 1, '2026-05-11 03:49:42', '2026-05-11 03:49:42'),
(8, 7, 2, 2, 'beauty', 'SKU-W8JQK2TI', 'Swtantra', 'swtantra', NULL, NULL, 4443.00, 4443.00, 0.00, 44, 5, '1778491292_6a019f9c2018d.jpg', NULL, NULL, NULL, NULL, '[\"1778491292_6a019f9c20b37.png\",\"1778491292_6a019f9c2142f.png\",\"1778491292_6a019f9c27cef.png\",\"1778491292_6a019f9c2864a.png\",\"1778491292_6a019f9c290d6.png\"]', NULL, NULL, NULL, 'paid', 0.00, 1, NULL, NULL, NULL, '{\"skin_type\":[],\"concern\":[],\"key_ingredients\":null,\"full_ingredients\":null,\"is_organic\":false,\"is_vegan\":false,\"is_cruelty_free\":false,\"is_paraben_free\":false,\"net_weight\":null,\"shelf_life\":null,\"gender\":null}', 0, 0, 0, 1, '2026-05-11 03:51:32', '2026-05-11 03:51:32'),
(10, 7, NULL, NULL, 'beauty', 'SKU-YSIWT4BC', 'Swtantrad', 'swtantrad', NULL, NULL, 3333.00, 3333.00, 0.00, 22, 5, '1778491396_6a01a00478d48.png', NULL, NULL, NULL, NULL, '[\"1778491374_6a019feec4a47.png\",\"1778491374_6a019feec582f.png\",\"1778491374_6a019feec66c0.png\",\"1778491374_6a019feec76b4.png\",\"1778491374_6a019feecd094.png\"]', NULL, NULL, NULL, 'paid', 0.00, 1, NULL, NULL, NULL, '{\"skin_type\":[],\"concern\":[],\"key_ingredients\":null,\"full_ingredients\":null,\"is_organic\":false,\"is_vegan\":false,\"is_cruelty_free\":false,\"is_paraben_free\":false,\"net_weight\":null,\"shelf_life\":null,\"gender\":null}', 0, 0, 0, 1, '2026-05-11 03:52:54', '2026-05-11 03:53:16'),
(11, 7, 2, 2, 'beauty', 'SKU-5R9UOK4X', 'Libas', 'libas', NULL, 'sadfasdf', 444.00, 444.00, 0.00, 33, 5, '1778491560_6a01a0a8d0b50.jpg', NULL, NULL, NULL, NULL, '[\"1778491560_6a01a0a8d14f5.jpg\",\"1778491560_6a01a0a8d752c.jpg\",\"1778491560_6a01a0a8d7d7d.jpg\",\"1778491560_6a01a0a8d8919.jpg\",\"1778491560_6a01a0a8d928a.jpg\"]', NULL, NULL, NULL, 'paid', 0.00, 1, NULL, NULL, NULL, '{\"skin_type\":[\"Oily\",\"Combination\"],\"concern\":[\"Anti-Aging\",\"Brightening\"],\"key_ingredients\":null,\"full_ingredients\":null,\"is_organic\":false,\"is_vegan\":false,\"is_cruelty_free\":false,\"is_paraben_free\":false,\"net_weight\":null,\"shelf_life\":null,\"gender\":null}', 0, 0, 0, 1, '2026-05-11 03:56:00', '2026-05-11 03:56:00'),
(12, 7, 2, 2, 'beauty', 'SKU-KAGDFSTT', 'Buy Poshak', 'buy-poshak', NULL, 'sfsfgfg', 444.00, 444.00, 0.00, 44, 5, '1778491722_6a01a14a5eda1.jpg', NULL, NULL, NULL, NULL, '[\"1778491722_6a01a14a5fafc.jpg\",\"1778491722_6a01a14a603f8.jpg\",\"1778491722_6a01a14a60b6a.jpg\",\"1778491722_6a01a14a67905.jpg\",\"1778491722_6a01a14a68436.jpg\"]', NULL, NULL, NULL, 'paid', 0.00, 1, NULL, NULL, NULL, '{\"skin_type\":[],\"concern\":[],\"key_ingredients\":null,\"full_ingredients\":null,\"is_organic\":false,\"is_vegan\":false,\"is_cruelty_free\":false,\"is_paraben_free\":false,\"net_weight\":null,\"shelf_life\":null,\"gender\":null}', 0, 0, 0, 1, '2026-05-11 03:58:42', '2026-05-11 03:58:42'),
(13, 7, 1, 1, 'beauty', 'SKU-BSVKPFIX', 'Libasd', 'libasd', NULL, 'dsfsfgds', 222.00, 222.00, 0.00, 22, 5, '1778491787_6a01a18b5453f.png', NULL, NULL, NULL, NULL, '[\"1778491787_6a01a18b5729d.png\",\"1778491787_6a01a18b5cce1.png\",\"1778491787_6a01a18b5d75d.png\",\"1778491787_6a01a18b5ec42.png\"]', NULL, NULL, NULL, 'paid', 0.00, 1, NULL, NULL, NULL, '{\"skin_type\":[],\"concern\":[],\"key_ingredients\":null,\"full_ingredients\":null,\"is_organic\":false,\"is_vegan\":false,\"is_cruelty_free\":false,\"is_paraben_free\":false,\"net_weight\":null,\"shelf_life\":null,\"gender\":null}', 0, 0, 0, 1, '2026-05-11 03:59:47', '2026-05-11 03:59:47');

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE `product_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `tabs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tabs`)),
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`id`, `name`, `slug`, `icon`, `tabs`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Beauty & Cosmetics', 'beauty', '💄', '[\"beauty\"]', 1, 1, '2026-04-27 09:12:00', '2026-04-27 09:12:00'),
(2, 'Clothing & Fashion', 'clothing', '👗', '[\"clothing\"]', 0, 2, '2026-04-27 09:12:00', '2026-04-27 09:12:00'),
(3, 'Books & Stationery', 'book', '📚', '[\"book\"]', 0, 3, '2026-04-27 09:12:00', '2026-04-27 09:12:00'),
(4, 'Electronics', 'electronic', '💻', '[\"electronic\"]', 0, 4, '2026-04-27 09:12:00', '2026-04-27 09:12:00'),
(5, 'Mobile & Accessories', 'mobile', '📱', '[\"mobile\",\"electronic\"]', 0, 5, '2026-04-27 09:12:00', '2026-04-27 09:12:00'),
(6, 'Jewelry', 'jewelry', '💍', '[\"jewelry\"]', 0, 6, '2026-04-27 09:12:00', '2026-04-27 09:12:00'),
(7, 'Grocery & Food', 'grocery', '🛒', '[\"grocery\"]', 0, 7, '2026-04-27 09:12:00', '2026-04-27 09:12:00'),
(8, 'Furniture & Home', 'furniture', '🪑', '[\"furniture\"]', 0, 8, '2026-04-27 09:12:00', '2026-04-27 09:12:00'),
(9, 'Sports & Fitness', 'sports', '⚽', '[\"sports\"]', 0, 9, '2026-04-27 09:12:00', '2026-04-27 09:12:00'),
(10, 'Baby Products', 'baby', '🍼', '[\"baby\"]', 0, 10, '2026-04-27 09:12:00', '2026-04-27 09:12:00'),
(11, 'Pet Products', 'pet', '🐾', '[\"pet\"]', 0, 11, '2026-04-27 09:12:00', '2026-04-27 09:12:00'),
(12, 'Medical & Pharmacy', 'medical', '💊', '[\"medical\"]', 0, 12, '2026-04-27 09:12:00', '2026-04-27 09:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_settings`
--

CREATE TABLE `shipping_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_zones`
--

CREATE TABLE `shipping_zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `states` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`states`)),
  `base_charge` decimal(8,2) NOT NULL DEFAULT 0.00,
  `free_above` decimal(10,2) DEFAULT NULL,
  `cod_available` tinyint(1) NOT NULL DEFAULT 1,
  `cod_charge` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `name`, `slug`, `image`, `meta_title`, `meta_description`, `status`, `created_at`, `updated_at`) VALUES
(1, 7, 'indian wear', 'indian-wear', '1778489060_6a0196e49881f.jpg', NULL, NULL, 1, '2026-05-11 03:14:20', '2026-05-11 03:14:20'),
(2, 7, 'Western Wear', 'western-wear', '1778489183_6a01975f75fbf.jpg', NULL, NULL, 1, '2026-05-11 03:16:23', '2026-05-11 03:16:23'),
(3, 7, 'Bag', 'bag', '1778489280_6a0197c0c6df2.jpg', NULL, NULL, 1, '2026-05-11 03:18:00', '2026-05-11 03:18:00'),
(4, 7, 'Sport Shoes', 'sport-shoes', '1778489388_6a01982ccdd29.jpg', NULL, NULL, 1, '2026-05-11 03:19:48', '2026-05-11 03:19:48'),
(5, 8, 't-shirt', 't-shirt', '1778489457_6a019871a15e8.jpg', NULL, NULL, 1, '2026-05-11 03:20:57', '2026-05-11 03:20:57'),
(6, 8, 'jens', 'jens', '1778489497_6a019899ba0ba.jpg', NULL, NULL, 1, '2026-05-11 03:21:37', '2026-05-11 03:21:37'),
(7, 8, 'kurta set', 'kurta-set', '1778489546_6a0198cae69d7.jpg', NULL, NULL, 1, '2026-05-11 03:22:26', '2026-05-11 03:22:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `phone` varchar(15) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `phone`, `avatar`, `is_active`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@beautyshop.com', 'admin', NULL, NULL, 1, NULL, '$2y$12$s7DjUbu/8EQ6eJEOY5DNBObEZQIinmzlHlirZHLx8./BRvWPeOh.a', NULL, '2026-04-27 09:10:23', '2026-04-27 09:10:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `child_subcategories`
--
ALTER TABLE `child_subcategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `child_subcategories_slug_unique` (`slug`),
  ADD KEY `child_subcategories_category_id_foreign` (`category_id`),
  ADD KEY `child_subcategories_subcategory_id_foreign` (`subcategory_id`);

--
-- Indexes for table `discount_codes`
--
ALTER TABLE `discount_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discount_codes_code_unique` (`code`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_subcategory_id_foreign` (`subcategory_id`),
  ADD KEY `products_child_subcategory_id_foreign` (`child_subcategory_id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_types_slug_unique` (`slug`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `shipping_settings`
--
ALTER TABLE `shipping_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shipping_settings_key_unique` (`key`);

--
-- Indexes for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subcategories_slug_unique` (`slug`),
  ADD KEY `subcategories_category_id_foreign` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `child_subcategories`
--
ALTER TABLE `child_subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `discount_codes`
--
ALTER TABLE `discount_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_settings`
--
ALTER TABLE `shipping_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `child_subcategories`
--
ALTER TABLE `child_subcategories`
  ADD CONSTRAINT `child_subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `child_subcategories_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_child_subcategory_id_foreign` FOREIGN KEY (`child_subcategory_id`) REFERENCES `child_subcategories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
