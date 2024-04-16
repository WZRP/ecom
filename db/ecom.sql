-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: April 14, 2024 at 15:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecomm`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cat_slug` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `cat_slug`) VALUES
(1, 'Domestic Fruits', 'domestic'),
(2, 'Imported Fruits', 'imported');

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `slug` varchar(200) NOT NULL,
  `price` double NOT NULL,
  `photo` varchar(200) NOT NULL,
  `date_view` date NOT NULL,
  `counter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `slug`, `price`, `photo`, `date_view`, `counter`) VALUES
(1, 1, 'Apple', "Crunch into the classic apple - sweet, juicy, and bursting with goodness. These crowd-pleasing fruits are packed with vitamins and antioxidants to keep you feeling fresh. Whether baked in a pie or enjoyed on their own, apples are always a recipe for satisfaction.", 'apple', 95000, 'apple.jpg', '2023-12-02', 50),
(2, 1, 'Avocado', "Creamy, dreamy, and brimming with healthy fats - the avocado is the ultimate superfood. Mash it on toast, blend it into a smoothie, or simply savor it as nature intended. One bite and you'll be hooked on this buttery, nutrient-dense delight.", 'avocado', 80000, 'avocado.jpg', '2023-11-25', 55),
(3, 1, 'Banana', "Nature's energy bar, the humble banana packs a powerful punch of potassium and natural sugars. Whether you're fueling up for a workout or just need a quick pick-me-up, these portable treats are always a winning choice. Just be sure to mind your step - those peels can be slippery!", 'banana', 35000, 'banana.jpg', '2024-05-25', 200),
(4, 1, 'Coconut', "Escape to the tropics with every sip and bite of this versatile fruit. Crack open a coconut and indulge in the refreshing drink and delectable flesh - a taste of paradise that will have you feeling like you're on a beach somewhere. Just be wary of any falling coconuts - they can really pack a punch!", 'coconut', 35000, 'coconut.jpg', '2024-07-15', 100),
(5, 1, 'Custard Apple', "Prepare to be swept off your feet by the luscious, tropical flavor of the custard apple. This unique fruit boasts a creamy, custardy texture that's sure to delight your taste buds. Just watch out for the pesky seeds - they may not be as delightful as the flesh.", 'custard-apple', 52000, 'custard-apple.jpg', '2023-12-20', 75),
(6, 2, 'Dragonfruit', "Also known as pitaya, the dragonfruit is a true showstopper. With its vibrant pink or yellow skin and speckled white flesh, this tropical delight is as visually stunning as it is delicious. Enjoy the sweet, mild flavor and refreshing crunch of the tiny edible seeds. Just be sure to let its unique beauty shine - this fruit is far too elegant to be hidden in a smoothie!", 'dragonfruit', 55000, 'dragonfruit.jpg', '2024-07-25', 80),
(7, 1, 'Durian', "Brave the pungent exterior of the durian and you'll be rewarded with a creamy, custard-like treasure. This divisive fruit is loved by many for its rich, almost savory flavor, but its intense aroma can be a bit overpowering. Embrace your adventurous side and give this polarizing delight a try.", 'durian', 95000, 'durian.jpg', '2024-07-01', 50),
(8, 1, 'Grape', "Pop open a juicy cluster of grapes and let nature's candy burst with sweetness on your tongue. Whether you enjoy them fresh, frozen, or blended into your favorite juice, these poppable perfections are sure to satisfy your cravings. Just don't try to recreate that famous grape stomping scene - it's messier than you might think!", 'grape', 68000, 'grape.jpg', '2024-05-12', 65),
(9, 1, 'Green Apple', "Enjoy the crisp, refreshing taste of a green apple. With its sweet and tart flavor, this fruit is perfect for snacking or adding a burst of flavor to salads and desserts. Its vibrant green color and juicy texture make it a delightful treat any time of day.", 'green-apple', 45000, 'green-apple.jpg', '2024-11-15', 65),
(10, 2, 'Guava', "Discover the power-packed punch of the guava, bursting with vitamin C and antioxidants to keep you feeling your best. Savor the sweet, slightly tangy flavor and let your taste buds take a tropical vacation. Just don't try munching on the leaves - they're not quite as tasty as the fruit.", 'guava', 48000, 'guava.jpg', '2023-11-12', 100),
(11, 1, 'Jackfruit', "Beneath its spiky exterior lies a tropical treasure - the mighty jackfruit. Prepare to be delighted by its unique, sweet flavor and versatile texture, perfect for both sweet and savory dishes. But be warned, getting to the good stuff can be quite an adventure in itself!", 'jackfruit', 75000, 'jackfruit.jpg', '2023-11-22', 60),
(12, 2, 'Kiwi', "Fuzzy on the outside but bursting with vibrant green goodness on the inside, kiwis are the perfect blend of sweet and tart. Packed with vitamin C, these little powerhouses will have you feeling energized and refreshed. Just be careful not to overindulge - their tartness can be quite the wake-up call!", 'kiwi', 35000, 'kiwi.jpg', '2024-04-01', 75),
(13, 2, 'Lemon', "Pucker up and enjoy the bright, tangy goodness of the lemon. This versatile citrus fruit adds a zesty punch to both sweet and savory dishes. Squeeze the juice over your favorite seafood, bake it into a tart, or simply slice and add it to your water for a refreshing twist. Just be careful not to get any in your eyes - that stinging sensation is no joke!", 'lemon', 25000, 'lemon.jpg', '2024-03-15', 85),
(14, 2, 'Lime', "Pucker up and enjoy the bright, tangy punch of the lime. This zesty citrus fruit adds a burst of flavor to everything from cocktails to salsa. Squeeze it over your favorite dishes, use the zest to liven up baked goods, or simply slice and add it to your water for a refreshing twist. Just be careful not to get any in your eyes - that stinging sensation is no joke!", 'lime', 20000, 'lime.jpg', '2024-04-20', 90),
(15, 2, 'Longan', "Tiny but mighty, the longan packs a sweet, floral punch in every bite. Peel back the thin shell and savor these juicy, delightful treats. Just don't try to juggle them - those slippery little suckers are bound to end up on the floor.", 'longan', 55000, 'longan.jpg', '2024-06-15', 95),
(16, 2, 'Lychee', "Dive into the jewel of the tropics, the luscious lychee. With its delicate, floral aroma and sweet, juicy flesh, this fruit will transport you to a paradise of pure bliss. Just be warned - these addictive delights are hard to resist!", 'lychee', 70000, 'lychee.jpg', '2024-06-20', 85),
(17, 1, 'Mango', "Bask in the sunshine-y sweetness of the mango, the true king of tropical fruits. Whether you slice it up, blend it into a smoothie, or simply savor it straight off the pit, this versatile delight is sure to brighten your day. Just be prepared for a little mess - it's all part of the mango experience!", 'mango', 50000, 'mango.jpg', '2023-12-15', 120),
(18, 2, 'Mangosteen', "Unlock the elegant secret of the mangosteen, where a sweet, juicy treasure lies hidden beneath its purple exterior. Savor the unique, delicate flavor and feel like you're indulging in a royal treat. Just be mindful of those purple stains - they can be a real fashion faux pas.", 'mangosteen', 85000, 'mangosteen.jpg', '2024-07-10', 70),
(19, 1, 'Orange', "Let the sunshine in with every segment of this vibrant, vitamin C-packed orange. Peel back the rind and enjoy the burst of sweetness and refreshment that awaits. Juggling these citrus orbs, however, is not recommended - leave that to the professionals.", 'orange', 45000, 'orange.jpg', '2023-12-10', 110),
(20, 2, 'Papaya', "Prepare to be swept away by the luscious, butter-like texture of the papaya. This vibrant orange fruit boasts a refreshing sweetness that's perfect for quenching your thirst on a hot day. Scoop out the caviar-like seeds and enjoy the juicy flesh - just don't try to grow a papaya tree in your living room.", 'papaya', 42000, 'papaya.jpg', '2024-05-08', 120),
(21, 1, 'Peach', "Savor the sweet, juicy delight of the peach. With its delicate, fuzzy skin and succulent flesh, this fruit is the epitome of summertime bliss. Enjoy it fresh, baked into a pie, or blended into a refreshing smoothie - the possibilities are endless. Just be mindful of those pesky pits!", 'peach', 55000, 'peach.jpg', '2024-08-15', 75),
(22, 1, 'Pear', "Delight in the crisp, juicy perfection of a ripe pear. Savor the sweet, delicate flavor on its own or incorporate it into your favorite recipes. Just don't try to use these delicate fruits as bowling balls - they're not nearly as sturdy as they might appear.", 'pear', 72000, 'pear.jpg', '2023-11-15', 80),
(23, 1, 'Pineapple', "Beneath the spiky exterior lies a tropical treasure - the sweet and tart pineapple. Enjoy this juicy fruit fresh, grilled, or blended into a refreshing smoothie. But beware of the prickly rind - these pineapples pack a punch!", 'pineapple', 30000, 'pineapple.jpg', '2024-05-18', 140),
(24, 1, 'Pomegranate', "Unlock the juicy, jewel-like seeds of the pomegranate and prepare for a burst of sweet-tart perfection. Pop these ruby-red arils one by one, or blend them into a refreshing juice. This superfruit is packed with antioxidants, making it a healthy and delightful addition to your diet. Just mind the mess - those juices can really stain!", 'pomegranate', 65000, 'pomegranate.jpg', '2024-10-01', 75),
(25, 1, 'Pomelo', "Dive into the gentle giant of the citrus family, the mighty pomelo. Peel back the thick skin to reveal the sweet, tangy segments that burst with refreshing juiciness. Just be prepared for a workout - these fruits aren't the easiest to tackle.", 'pomelo', 65000, 'pomelo.jpg', '2023-11-18', 90),
(26, 2, 'Passionfruit', "Unlock the mysterious allure of the passionfruit, where a symphony of tart and sweet flavors await. Slice open the wrinkly shell to reveal the glistening, gelatinous insides, bursting with tiny edible seeds. This tropical delight is sure to transport your taste buds to far-off lands.", 'passionfruit', 60000, 'passionfruit.jpg', '2024-06-12', 90),
(27, 2, 'Rambutan', "Unlock the hidden jewel within the rambutan's spiky red shell. Peel back the fuzzy exterior to reveal the sweet, translucent flesh - a true tropical treat. Savor the delicate flavor and refreshing texture of these bite-sized delights, but watch out for the pesky pit inside.", 'rambutan', 52000, 'rambutan.jpg', '2024-06-18', 85),
(28, 2, 'Starfruit', "The star of the show has arrived, and it's ready to dazzle your taste buds. Slice into the refreshing, sweet-tart starfruit and savor its unique, tropical flavor. But don't try to use it as a throwing star - it's not quite as aerodynamic as it looks.", 'starfruit', 45000, 'starfruit.jpg', '2024-09-30', 100),
(29, 1, 'Tomato', "Embrace the versatile and juicy goodness of the tomato. Whether you enjoy it in a fresh salad, simmered into a savory sauce, or simply sliced and seasoned, this vibrant fruit (yes, fruit!) is a must-have in any kitchen. Just be mindful of those seeds - they can really get stuck in your teeth!", 'tomato', 35000, 'tomato.jpg', '2024-08-01', 120),
(30, 1, 'Watermelon', "Beat the heat with the refreshing sweetness of a watermelon. This summer staple boasts a juicy red interior that's perfect for quenching your thirst on a hot day. Slice it up, enjoy it in a salad, or blend it into a delicious smoothie - the possibilities are endless!", 'watermelon', 40000, 'watermelon.jpg', '2023-12-05', 150);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pay_id` varchar(50) NOT NULL,
  `sales_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(60) NOT NULL,
  `type` int(1) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `contact_info` varchar(100) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `status` int(1) NOT NULL,
  `activate_code` varchar(15) NOT NULL,
  `reset_code` varchar(15) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `type`, `firstname`, `lastname`, `address`, `contact_info`, `photo`, `status`, `activate_code`, `reset_code`, `created_on`) VALUES
(1, 'admin@admin.com', '$2y$10$8wY63GX/y9Bq780GBMpxCesV9n1H6WyCqcA2hNy2uhC59hEnOpNaS', 1, 'Dat', 'Tien Nguyen', '', '', 'profile youtube1.jpg', 1, '', '', '2018-05-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
