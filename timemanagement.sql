-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 18 2023 г., 12:03
-- Версия сервера: 10.8.4-MariaDB
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `timemanagement`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1677162818),
('head_teacher', '3', NULL),
('manager', '32', 1685872793),
('manager', '4', NULL),
('manager', '5', 1677289602),
('manager', '6', 1677289636),
('student', '2', NULL),
('student', '20', NULL),
('student', '27', 1683281408),
('student', '29', 1684249074),
('student', '33', 1685872894),
('student', '34', 1685874498),
('student', '35', 1685874620),
('student', '36', 1685874725),
('student', '37', 1685874768),
('student', '38', 1685874810),
('student', '39', 1685874875),
('student', '40', 1685874927),
('student', '41', 1685874965),
('student', '42', 1685875000),
('student', '43', 1685875039),
('student', '44', 1685875088),
('student', '45', 1685875169),
('student', '46', 1685875208),
('student', '47', 1685875240),
('student', '48', 1685875273),
('student', '49', 1685875311),
('student', '50', 1685875354),
('student', '51', 1685875405),
('student', '52', 1685875441),
('student', '53', 1685875522),
('student', '54', 1685875555),
('student', '55', 1685875583),
('student', '56', 1685875616),
('student', '57', 1685875644),
('student', '58', 1685875745),
('student', '59', 1685875841);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `rule_name` varchar(64) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `title`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 'Администратор', 1, NULL, NULL, NULL, 1677162818, 1677162818),
('can_admin', NULL, 2, 'Все разрешения + создавать пользователей, изменять их удалять.', NULL, NULL, 1677162818, 1677162818),
('head_teacher', 'Заместитель директора', 1, NULL, NULL, NULL, 1677162818, 1677162818),
('manager', 'Куратор', 1, NULL, NULL, NULL, 1677162818, 1677162818),
('per_head_teacher', NULL, 2, 'Добавить куратора. Добавить группу. Добавить куратора в группу. Изменить куратора в группе. Создать предмет. Удалить предмет. Добавить задачу для студентов. Изменить задачу. Удалить задачу. Просмотреть ответы студентов на задачу.', NULL, NULL, 1677162818, 1677162818),
('per_manager', NULL, 2, 'Создать группу. Изменить группу. Удалить группу. Добавить студента в группу. Удалить студента из группы. Создать предмет. Удалить предмет. Добавить задачу для студентов. Изменить задачу. Удалить задачу. Просмотреть ответы студентов на задачу.', NULL, NULL, 1677162818, 1677162818),
('per_student', NULL, 2, 'Отправить ответ на задачу. Изменить ответ. Отменить ответ.', NULL, NULL, 1677162818, 1677162818),
('per_user', NULL, 2, 'Доступ в личный аккаунт. Добавить задачу. Просмотреть задачи. Редактировать задачу. Удалить задачу. Добавить предмет к задаче.', NULL, NULL, 1677162818, 1677162818),
('student', 'Студент', 1, NULL, NULL, NULL, 1677162818, 1677162818),
('user', NULL, 1, NULL, NULL, NULL, 1677162818, 1677162818);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'can_admin'),
('head_teacher', 'per_head_teacher'),
('head_teacher', 'user'),
('manager', 'per_manager'),
('manager', 'user'),
('student', 'per_student'),
('student', 'user'),
('user', 'per_user');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `file`
--

CREATE TABLE `file` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `file`
--

INSERT INTO `file` (`id`, `name`) VALUES
(51, '/files/19_26.04.23.15.26_pr2.png'),
(52, '/files/19_26.04.23.15.26_pr7.png'),
(80, '/files/19_28.04.23.15.39_pr3.png'),
(81, '/files/19_28.04.23.15.39_pr4.png'),
(82, '/files/19_28.04.23.15.39_pr6.png'),
(83, '/files/9_04.05.23.15.10_pr9.png'),
(84, '/files/9_04.05.23.15.10_Текст.docx'),
(87, '/files/9_04.05.23.15.42_pr3.png'),
(88, '/files/9_04.05.23.15.42_pr7.png'),
(89, '/files/9_04.05.23.15.42_Текст.docx'),
(108, '/files/9_05.05.23.12.27_pr4.png'),
(111, '/files/9_05.05.23.13.01_123.png'),
(114, '/files/9_05.05.23.13.01_pr3.png'),
(120, '/files/31_25.05.23.12.25.29_Текст.docx'),
(121, '/files/3_11.06.23.13.00.58_Текст.docx');

-- --------------------------------------------------------

--
-- Структура таблицы `group`
--

CREATE TABLE `group` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `manager_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `group`
--

INSERT INTO `group` (`id`, `title`, `manager_id`) VALUES
(1, '301', 4),
(2, '301-к', 4),
(3, '302', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1677060896),
('m140506_102106_rbac_init', 1677060912),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1677060913),
('m180523_151638_rbac_updates_indexes_without_prefix', 1677060914),
('m200409_110543_rbac_update_mssql_trigger', 1677060914);

-- --------------------------------------------------------

--
-- Структура таблицы `mood`
--

CREATE TABLE `mood` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `mood`
--

INSERT INTO `mood` (`id`, `title`, `image`) VALUES
(0, 'Я рад(а)', '\\img\\happy.png'),
(1, 'Беспокоюсь', '\\img\\scared.png'),
(2, 'Злюсь', '\\img\\mad.png'),
(3, 'Расстроен(а)', '\\img\\sad.png'),
(4, 'Устал(а)', '\\img\\tired.png');

-- --------------------------------------------------------

--
-- Структура таблицы `priority`
--

CREATE TABLE `priority` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `priority`
--

INSERT INTO `priority` (`id`, `title`) VALUES
(1, 'Повседневная'),
(2, 'Важная');

-- --------------------------------------------------------

--
-- Структура таблицы `reflection`
--

CREATE TABLE `reflection` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `mood_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `reflection`
--

INSERT INTO `reflection` (`id`, `date`, `user_id`, `task_id`, `mood_id`) VALUES
(6, '2023-05-24 09:45:08', 3, 61, 1),
(10, '2023-05-29 11:00:37', 6, 74, 4),
(11, '2023-05-29 14:08:34', 3, 53, 1),
(12, '2023-05-29 14:10:30', 3, 67, 2),
(13, '2023-05-29 14:33:23', 2, 3, 3),
(16, '2023-06-11 13:45:08', 2, 2, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `response`
--

CREATE TABLE `response` (
  `id` int(10) UNSIGNED NOT NULL,
  `text` text DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `task_id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `response`
--

INSERT INTO `response` (`id`, `text`, `date`, `task_id`, `student_id`, `status_id`) VALUES
(17, 'Опрос пройден', '2023-06-11 18:54:53', 11, 20, 4),
(23, 'Тестирование пройдено', '2023-06-04 17:31:51', 12, 2, 2),
(24, 'Отчет отправлен', '2023-06-04 17:32:08', 64, 20, 3),
(25, 'Анкета готова', '2023-06-04 17:32:19', 27, 2, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `response_files`
--

CREATE TABLE `response_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `response_id` int(10) UNSIGNED NOT NULL,
  `file_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `response_files`
--

INSERT INTO `response_files` (`id`, `response_id`, `file_id`) VALUES
(3, 23, 87),
(4, 23, 88),
(5, 23, 89);

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `title`) VALUES
(1, 'Не выполнено'),
(2, 'Выполнено'),
(3, 'Просрочено'),
(4, 'Проверено'),
(5, 'Задача для группы');

-- --------------------------------------------------------

--
-- Структура таблицы `stud_of_group`
--

CREATE TABLE `stud_of_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `stud_of_group`
--

INSERT INTO `stud_of_group` (`id`, `group_id`, `student_id`) VALUES
(1, 1, 2),
(2, 2, 20),
(3, 2, 27),
(9, 3, 29),
(10, 1, 51),
(11, 1, 40),
(12, 1, 39),
(13, 1, 34),
(14, 1, 41),
(15, 1, 45),
(16, 1, 47),
(17, 1, 35),
(18, 1, 50),
(19, 2, 33),
(20, 2, 55),
(21, 2, 42),
(22, 2, 54),
(23, 2, 44),
(24, 2, 56),
(25, 2, 59),
(26, 2, 53);

-- --------------------------------------------------------

--
-- Структура таблицы `subject`
--

CREATE TABLE `subject` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `subject`
--

INSERT INTO `subject` (`id`, `title`) VALUES
(1, 'Иностранный язык'),
(2, 'Компьютерные сети'),
(3, 'Литература'),
(4, 'Русский язык'),
(5, 'Программное обеспечение и компьютерных сетей'),
(6, 'Операционные системы и среды'),
(7, 'Безопасность компьютерных сетей'),
(8, 'Обеспечение безопасности веб-приложений'),
(9, 'Основы алгоритмизации и программирования'),
(10, 'Стандартизация, сертификация и техническое документоведение'),
(11, 'Оптимизация веб-приложений'),
(12, 'Архитектура аппаратных средств'),
(13, 'Технологии физического уровня передачи данных'),
(14, 'Химия'),
(15, 'Физика'),
(16, 'Информатика'),
(17, 'Основы философии'),
(18, 'Естествознание'),
(19, 'Обществознание'),
(20, 'История'),
(21, 'Графический дизайн и мультимедиа'),
(22, 'Основы проектирования баз данных'),
(23, 'Проектирование и дизайн информационных систем'),
(24, 'Тестирование информационных систем'),
(25, 'Менеджмент в профессиональной деятельности'),
(26, 'География'),
(27, 'Экономика отрасли'),
(28, 'Основы экономики организации'),
(29, 'Основы предпринимательской деятельности'),
(30, 'Проектирование и разработка веб-приложений'),
(31, 'Дискретная математика'),
(32, 'Элементы высшей математики'),
(33, 'Психология общения'),
(34, 'Астрономия'),
(35, 'Математика'),
(36, 'Основы безопасности жизнедеятельности');

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--

CREATE TABLE `task` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `deadline_date` date DEFAULT NULL,
  `deadline_time` time DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `status_id` int(10) UNSIGNED NOT NULL,
  `priority_id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED DEFAULT NULL,
  `checked` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `task`
--

INSERT INTO `task` (`id`, `title`, `date`, `deadline_date`, `deadline_time`, `user_id`, `group_id`, `status_id`, `priority_id`, `subject_id`, `checked`) VALUES
(2, 'Выполнить задание по английскому', '2023-02-25', NULL, NULL, 2, NULL, 2, 1, 1, 1),
(3, 'Пройти тестирование по английскому', '2023-02-25', NULL, NULL, 2, NULL, 2, 1, 1, 1),
(6, 'Составить расписание в ежедневнике', '2023-02-25', NULL, NULL, 2, NULL, 2, 1, NULL, 1),
(10, 'Написать 1 главу курсовой работы', '2023-02-26', NULL, NULL, 20, NULL, 1, 1, NULL, 0),
(11, 'Пройти опрос на сайте opros.ru', '2023-02-26', NULL, NULL, 4, 2, 5, 2, NULL, 0),
(12, 'Пройти тестирование по философии', '2023-04-24', NULL, NULL, 3, 1, 5, 2, 17, 0),
(14, 'Заполнить документы по практике', '2023-04-24', NULL, NULL, 3, NULL, 2, 1, NULL, 1),
(15, 'Создать аккаунт на платформе', '2023-04-24', NULL, NULL, 3, NULL, 2, 1, NULL, 1),
(27, 'Заполнить анкету на сайте anketa.ru', '2023-04-26', '2023-05-03', '12:00:00', 3, 1, 5, 2, NULL, 0),
(49, 'Проверить тестирование студентов', '2023-04-26', NULL, NULL, 3, NULL, 2, 1, NULL, 1),
(50, 'Объявить субботник', '2023-04-25', NULL, NULL, 3, NULL, 2, 2, NULL, 1),
(53, 'Проверить отчеты', '2023-04-28', '2023-05-03', '17:00:00', 3, NULL, 2, 2, NULL, 1),
(54, 'Заполнить расписание', '2023-05-01', '2023-05-03', '20:00:00', 3, NULL, 2, 1, NULL, 1),
(60, 'Сдать отчет за текущий месяц', '2023-05-02', '2023-05-06', '23:59:00', 3, NULL, 3, 1, NULL, 0),
(61, 'Узнать расписание', '2023-05-02', NULL, NULL, 3, NULL, 2, 1, NULL, 1),
(64, 'Отправить отчеты', '2023-05-02', '2023-05-02', '23:59:00', 3, 2, 5, 2, NULL, 0),
(66, 'Заполнить список студентов на отчисление', '2023-05-03', '2023-05-06', '23:59:00', 3, NULL, 2, 2, NULL, 1),
(67, 'Сделать опрос в выпускных группах', '2023-05-03', '2023-05-03', '14:00:00', 3, NULL, 2, 1, NULL, 1),
(69, 'Пройти психологическое тестирование ', '2023-05-04', NULL, NULL, 3, 2, 5, 2, NULL, 0),
(70, 'Написать доклад по философии', '2023-05-04', NULL, NULL, 2, NULL, 1, 2, 17, 0),
(71, 'Сделать презентацию по истории', '2023-05-04', NULL, NULL, 2, NULL, 1, 2, 20, 0),
(72, 'Ответить на письмо в вашей электронной почте', '2023-05-11', NULL, NULL, 3, 1, 5, 2, NULL, 0),
(74, 'Отчетная документация', '2023-05-25', NULL, NULL, 6, NULL, 2, 2, NULL, 1),
(76, 'Создать задачу для группы 301', '2023-06-04', NULL, NULL, 4, NULL, 1, 2, NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `task_files`
--

CREATE TABLE `task_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `file_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `task_files`
--

INSERT INTO `task_files` (`id`, `task_id`, `file_id`) VALUES
(15, 49, 51),
(16, 49, 52),
(43, 50, 80),
(44, 50, 81),
(45, 50, 82),
(59, 3, 108),
(63, 74, 120),
(64, 12, 121);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `patronymic` varchar(255) DEFAULT NULL,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `auth_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `patronymic`, `login`, `email`, `password`, `auth_key`) VALUES
(1, 'Савелий', 'Константинов', 'Михайлович', 'admin', 'admin@mail.ru', '$2y$13$I7TQsz62KeRQo2vRMR7MVOH5CiCSwERxd6xtzooVX2dvPaUgr2h52', 'xFpuepCfmeospfWmz5_gX5k01l_Sv91e'),
(2, 'Анастасия', 'Писукова', 'Вадимовна', 'a', 'aa@mail.ru', '$2y$13$rJpvl0IBgDE98VEJ0LeRJuVVkUP6gaGK.0FkdH6KjYvajgrx9UPMC', 'HlwHc82I0ppJ72zvUPXlewXLzXCOH9NF'),
(3, 'Ульяна', 'Золотова', 'Аркадьевна', 'u', 'u@mail.ru', '$2y$13$WXM9yvpu97d6J.ELi.9NvuWzx9O/2Wggvnl0egW2WCE6AYfeTqC5a', 'bdsCRLMDksZUXRbErO9BJ_0hlN68O7DV'),
(4, 'Леонид', 'Цветков', 'Сергеевич', 'l', 'l@mail.ru', '$2y$13$seqLZ2o4Gol9zchF6ho6AubDudkDMYtI0yN2VKaVtVxhsISlarpye', '5e89g8QL0iDha_9VKuHtiV97wdZHD9c1'),
(5, 'Павел', 'Борисов', 'Константинович', 'p', 'p@mail.ru', '$2y$13$QmMyd4rw8VXwJHe/ukC32Olr4YskmNwhRENjLQShOVN3Ip9AH/Mri', 'Ot3lWUXZkyFgPCwZ_cX7d2sfDnBI7ag7'),
(6, 'Рита', 'Киреева', 'Михайловна', 'r', 'r@mail.ru', '$2y$13$RPQyE/pn59yeQyU5s6F0nONxo6W3CHvyan9p/KPC3v1uJsdrezLE6', 'GGYb8r1JWPGR20Wycrny-q4Vl8W72Xgd'),
(20, 'Дмитрий', 'Антонов', 'Глебович', 'd', 'd@mail.ru', '$2y$13$VrLMKLvHBUuNSOQY/K8jLuPpRZ8vsSpQyGvn3hyVhP0S/6jcnjYMO', 'czmYhXDMOM5bCM7Jp37PnfxkVPo6V43x'),
(27, 'Михаил', 'Харитонов', 'Олегович', 'm', 'm@mail.ru', '$2y$13$1e1R.6eHfcIzzS9HVCGdQuY0se1.usK.Vg0Pi7BnxoJEFm7EWZ3IW', 'Ja3lHD2-fE7nz0GYl_iyjEJaEVQtW1qn'),
(29, 'Татьяна', 'Морозова', 'Романовна', 't', 't@mail.ru', '$2y$13$ccgk9CW/3/XhBQ47itgmbOK3ahURPeRyhHU/UCBoVFK6s6lVlvEQy', 'kF9XA_G4qF6YGfEmaEN0oPKtO5wQZe3A'),
(32, 'Ангелина', 'Медведева', 'Владимировна', 'an', 'an@mail.ru', '$2y$13$PgGxlrgEjwBvxj/J/4.QgeFb6FcAVBHlfvLWdsGQCWVHokgpWFfVS', '1FsYLhDC9Drq54gPUbyUJLlQyRQG3UhL'),
(33, 'Захар', 'Пименов', 'Денисович', 'z', 'z@mail.ru', '$2y$13$LRlPBt3Hz5jkGAqYes1kg.mM9egYari4bTU1T5yodlfI3ZW7myF0y', 'srogYxLVbpPBU9HpODTyQYP4m0eN88c4'),
(34, 'Мария', 'Федорова', 'Константиновна', 'ma', 'maria@mail.ru', '$2y$13$yc9c4MnXNLFf0V7I5qeVvuwVuZ5xiH/DgZDNoqPLGTSsvtLWOQzE6', '6GeJlTueHt2zRWFuQDHKOviqrME3nR2P'),
(35, 'Дарья', 'Абрамова', 'Максимовна', 'da', 'da@mail.ru', '$2y$13$wR0M/8vIlaU0cFceUEnqxuESnrl3lyE.hr87jj71K3UI22kMyqVZe', 'jHqR4UQADq5DowoTqYg8EqWGyqy-LxSm'),
(36, 'Елизавета', 'Орлова', 'Андреевна', 'e', 'e@mail.ru', '$2y$13$z24BiH4Cr6N41Ii59elQoueLVmGpbQ/MKc2qaxaZwiq3KIgkgG1oq', 'ur2F5v276BsXbQY2Q_tIZaGQUT3pf6Fd'),
(37, 'Мирослава', 'Балашова', 'Михайловна', 'mi', 'mi@mail.ru', '$2y$13$acPlQ6Ew6JStGHospQ00GupVpGZCXwNQGqWRBJ7HjXgW09P6cu7AO', '88mYhflp08A8llsZMOu3UQMU0yLiwg-4'),
(38, 'Марьям', 'Грачева', 'Стефановна', 'mar', 'mar@mail.ru', '$2y$13$WJv6aQrXhpgXzH8nMV9mA.hBMpX9Ji8D901X.ds85JeEeooUeoc8m', 'DunY1ua7SMLWSAc-67yBMBHPqDFaIor4'),
(39, 'Артём', 'Симонов', 'Фёдорович', 'ar', 'ar@mail.ru', '$2y$13$BxL6jAuYv/6NIg3v7nGbP.BKIfC13RG51lmpDj91TUTmKA42Ets6.', 'sr08VNdGxSRong0bK-XCl1WRQO8SHKbe'),
(40, 'Илья', 'Лебедев', 'Михайлович', 'il', 'il@mail.ru', '$2y$13$7FABlsYnS5U3TlgIWHXoNuX2odComsQkEmtOPniPuAO2/FFHRoC.u', 'JgUr4ZeNOiYoYS8UHuF5Ro9i7sgUdOPY'),
(41, 'Даниил', 'Козлов', 'Георгиевич', 'dan', 'dan@mail.ru', '$2y$13$LOwzefwU6aII/a7rZgFTKulwHMJmYrJpQPHNwZZTniK0h1a/o5gi.', 'KrRZifs2Z1A996gH_SuhYrfoIuopFVUP'),
(42, 'Анна', 'Никитина', 'Ярославовна', 'ann', 'ann@mail.ru', '$2y$13$9riSpVEYgZPw8k0wZy3sru9G0vPdGOxqsxrMjnlOoFI9/JPTJDxNm', 'IxOjCyDa9aVnCbm0Nj2APKd_5tjqVaZe'),
(43, 'Эмма', 'Михайлова', 'Александровна', 'em', 'em@mail.ru', '$2y$13$Q0TL7e0QRUlqljfQq4qu8ua3xY4VDydQtPmc.HywYH1TOKoXP5kwa', 'C_ByDa8Sh9EMwaDeBE-3pGJ6JmbLyzc7'),
(44, 'Василиса', 'Афанасьева', 'Александровна', 'v', 'v@mail.ru', '$2y$13$XtuXJtoBwoudn8ymXf7yMuKRnpCv7B7lyb6LNLuaphyKOnMBPaxhS', '1g9WSAEEYnoyTrnm1Pv6_ENuHkRYOpzh'),
(45, 'София', 'Коновалова', 'Артемьевна', 's', 's@mail.ru', '$2y$13$vA.twMvfa7wEJw7DU76tuepHX/tXOywVsJmNwyvm.Emx8Lek12WC6', 'Hw5HyP1k1r2_z1GIxBbkzMcZhEhtSMx_'),
(46, 'Ольга', 'Кошелева', 'Ильинична', 'o', 'o@mail.ru', '$2y$13$hZexg9.4yjQmT.1VsvM3luY0cVrQdugAfiXtuZGK.hFccnzwgxrfG', 'x19wN3T9f_msgmgPPO7iEp12XDZaDe7z'),
(47, 'Георгий', 'Волков', 'Тимурович', 'g', 'g@mail.ru', '$2y$13$ZP1fWkpAqqhjgCCQuur9e.XRewHKQDqMQkzmySolXqP3NDO5L5Jcy', 'jfpGl6NbNKNhcaGgpMS5g4CJlYt3k5sU'),
(48, 'Алиса', 'Царева', 'Максимовна', 'al', 'al@mail.ru', '$2y$13$Vo3dyHpdJ7ZW8jl2c.MG..bNjLQut2DaXRoN28ehAYjDyJzvZxCBS', 'uIMpLk7vQtxgju5XRqBnGu5jpu3bT7kx'),
(49, 'Евгений', 'Орлов', 'Александрович', 'ev', 'ev@mail.ru', '$2y$13$blx6a0B9y/oKVl78tSU.I.g9.DcquZCsIjY4ajxUfNlgeVrM73a9i', 'nuR-E4KNtPF4eVeuDSstwN5T4ccoYFzl'),
(50, 'Владимир', 'Захаров', 'Кириллович', 'vl', 'vl@mail.ru', '$2y$13$X/L0m.L7lwdLmDCuVgRzrOJzAtyCIz3NX4nM3T99mRx.sSWl81OBe', 'G54U5tL3j50YPcpUeE5Ezc6th-2-iJRk'),
(51, 'Елена', 'Гусева', 'Никитична', 'el', 'el@mail.ru', '$2y$13$haO6JluL5MoDq7TyGbDQMeVF7bgGouBXWtHDFpBpxsRj65soCxbr2', 'sl7Eto4Q-BqLLRD-LcnDZU-tto25fJLR'),
(52, 'Виктория', 'Лебедева', 'Арсентьевна', 'vi', 'vi@mail.ru', '$2y$13$2Twgp36aquTGlMVLyMaoouK7uNPFotuGF/xGF7SKDTioHytVciZ66', 'Wiw7wHsq4XdMTbBToKH0AniXkRjzEKdP'),
(53, 'Михаил', 'Воронин', 'Маркович', 'mih', 'mih@mail.ru', '$2y$13$8VB75KSMUxVv.hz7dPlA/uIZpY1bSptXGfvYieDtz1NiZq.UNaP16', 'tEit28yqtgB2OTkYYmhF2ZEJknUwyxQb'),
(54, 'Иван', 'Данилов', 'Германович', 'iv', 'iv@mail.ru', '$2y$13$sttnlrtQEMZq9UxqqG0d5eRSBfA5BVBn3pjdOBe5w0sJDqtL.d.DC', 'c4gBHMw8arXc-5H4h-q8EkfgwCIdKKkA'),
(55, 'Фёдор', 'Раков', 'Матвеевич', 'f', 'f@mail.ru', '$2y$13$5kg2SX.TcD6KpqDQYSZx3u5d.4zGGsCZRW9E.ljuZbkaxyd4fN48K', 'BB-FXyKVZmt3Kubcq0QEO68QwEU9vOnu'),
(56, 'Татьяна', 'Носова', 'Георгиевна', 'ta', 'ta@mail.ru', '$2y$13$Q3ONN6cJTmVhYexhZR1hBeOJr2U5tj7yGTOOqZyPfhq1b/jTmOGCC', 'HBCvvcoSpopZJAbJiTozVve2Uf4baQ2B'),
(57, 'Ярослав', 'Павлов', 'Кириллович', 'y', 'y@mail.ru', '$2y$13$CVE3KLgw0Wb9S1xjM6JiY.8M/xnLMbQDqAj0AW8fBNFCx0OPoJ8/i', '-80QQp7WQKbyUTtwflsuhA3UV09YjHpz'),
(58, 'Екатерина', 'Лунова', 'Глебовна', 'ek', 'ek@mail.ru', '$2y$13$wP6PXTXH2TzXo3fZxg8w2Om293XZqA8uTb2b9WSD6wyhnlNDMD1vS', 'ElEpI1p3ZYapplCTNl1W7tvIkh9iefOX'),
(59, 'Амина', 'Филиппова', 'Павловна', 'am', 'am@mail.ru', '$2y$13$07hHd8EgepETu84wjUl8XOKxGWC4keY9qAK7pklBMbs32AKnjKJvW', 'i3n7bwJaqTZEKYAgf1vz72FI5kWpYwLE');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Индексы таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manager_id` (`manager_id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `mood`
--
ALTER TABLE `mood`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`title`);

--
-- Индексы таблицы `priority`
--
ALTER TABLE `priority`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `reflection`
--
ALTER TABLE `reflection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`date`),
  ADD KEY `product_id` (`task_id`),
  ADD KEY `mood_id` (`mood_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Индексы таблицы `response_files`
--
ALTER TABLE `response_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `task_id` (`response_id`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `stud_of_group`
--
ALTER TABLE `stud_of_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Индексы таблицы `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `priority_id` (`priority_id`);

--
-- Индексы таблицы `task_files`
--
ALTER TABLE `task_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `task_id` (`task_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `file`
--
ALTER TABLE `file`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT для таблицы `group`
--
ALTER TABLE `group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `mood`
--
ALTER TABLE `mood`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `priority`
--
ALTER TABLE `priority`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `reflection`
--
ALTER TABLE `reflection`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `response`
--
ALTER TABLE `response`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `response_files`
--
ALTER TABLE `response_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `stud_of_group`
--
ALTER TABLE `stud_of_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT для таблицы `task`
--
ALTER TABLE `task`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT для таблицы `task_files`
--
ALTER TABLE `task_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `group`
--
ALTER TABLE `group`
  ADD CONSTRAINT `group_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reflection`
--
ALTER TABLE `reflection`
  ADD CONSTRAINT `reflection_ibfk_1` FOREIGN KEY (`mood_id`) REFERENCES `mood` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reflection_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reflection_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `response`
--
ALTER TABLE `response`
  ADD CONSTRAINT `response_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `response_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `response_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `response_files`
--
ALTER TABLE `response_files`
  ADD CONSTRAINT `response_files_ibfk_1` FOREIGN KEY (`response_id`) REFERENCES `response` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `response_files_ibfk_2` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `stud_of_group`
--
ALTER TABLE `stud_of_group`
  ADD CONSTRAINT `stud_of_group_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stud_of_group_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_ibfk_4` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_ibfk_5` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_ibfk_6` FOREIGN KEY (`priority_id`) REFERENCES `priority` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `task_files`
--
ALTER TABLE `task_files`
  ADD CONSTRAINT `task_files_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_files_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
