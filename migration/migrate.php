<?php
include "dbconfig.php"; // make sure this has your $pdo or $conn PDO connection

try {
    // Disable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

    // Drop tables if they exist
    $tables = ['admin','books','borrowed','borrowing','messages','penalty','students'];
    foreach ($tables as $table) {
        $pdo->exec("DROP TABLE IF EXISTS `$table`");
    }

    // Re-enable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

    // CREATE TABLES
    $pdo->exec("
    CREATE TABLE `admin` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `username` VARCHAR(50) DEFAULT NULL,
      `admin_name` VARCHAR(50) DEFAULT NULL,
      `password` TEXT DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

    CREATE TABLE `books` (
      `book_id` INT(11) NOT NULL AUTO_INCREMENT,
      `title` VARCHAR(100) DEFAULT NULL,
      `author` VARCHAR(50) DEFAULT NULL,
      `genre` VARCHAR(30) DEFAULT NULL,
      `ISBN` VARCHAR(16) DEFAULT NULL,
      `summary` TEXT DEFAULT NULL,
      `copies` INT(5) DEFAULT NULL,
      `file_name` VARCHAR(255) DEFAULT NULL,
      PRIMARY KEY (`book_id`)
    ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

    CREATE TABLE `borrowed` (
      `issued_id` INT(11) NOT NULL AUTO_INCREMENT,
      `book_id` INT(11) DEFAULT NULL,
      `id` INT(11) DEFAULT NULL,
      `book_title` VARCHAR(50) DEFAULT NULL,
      `student_number` VARCHAR(50) DEFAULT NULL,
      `due_date` DATE DEFAULT NULL,
      `issue_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
      `full_name` VARCHAR(100) DEFAULT NULL,
      PRIMARY KEY (`issued_id`)
    ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

    CREATE TABLE `borrowing` (
      `borrow_id` INT(11) NOT NULL AUTO_INCREMENT,
      `book_id` INT(11) DEFAULT NULL,
      `full_name` VARCHAR(100) DEFAULT NULL,
      `student_number` VARCHAR(50) DEFAULT NULL,
      `book_title` VARCHAR(100) DEFAULT NULL,
      `id` INT(11) DEFAULT NULL,
      PRIMARY KEY (`borrow_id`)
    ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

    CREATE TABLE `messages` (
      `message_id` INT(11) NOT NULL AUTO_INCREMENT,
      `id` INT(11) DEFAULT NULL,
      `student_number` VARCHAR(50) DEFAULT NULL,
      `message` TEXT DEFAULT NULL,
      `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`message_id`)
    ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

    CREATE TABLE `penalty` (
      `penalty_id` INT(11) NOT NULL AUTO_INCREMENT,
      `id` INT(11) DEFAULT NULL,
      `student_number` VARCHAR(50) DEFAULT NULL,
      `count` INT(11) DEFAULT NULL,
      `suspension` DATE DEFAULT NULL,
      `penalty_deadline` DATE DEFAULT NULL,
      PRIMARY KEY (`penalty_id`)
    ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

    CREATE TABLE `students` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `full_name` VARCHAR(100) DEFAULT NULL,
      `student_number` VARCHAR(30) DEFAULT NULL,
      `course` VARCHAR(10) DEFAULT NULL,
      `email` VARCHAR(50) DEFAULT NULL,
      `password` TEXT DEFAULT NULL,
      `status` VARCHAR(15) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");

    $data_books = "INSERT INTO `books` (`book_id`, `title`, `author`, `genre`, `ISBN`, `summary`, `copies`, `file_name`) VALUES
                    (1, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Novel', '1234-5678-91011', 'A story of decadence, idealism, and the American Dream.', 5, 'great_gatsby.jpg'),
                    (2, 'The Secret Garden', 'William Shakespear', 'Fiction', '1234566778910', 'Abracadbra!', 1, 'secret_garden.jpg'),
                    (3, '1984', 'George Orwell', 'Genre', '132435678908', 'All about 1984', 2, '1984.jpg'),
                    (5, 'Pride and Prejudice', 'Jane Austen', 'Novel', '9780141439518', 'The novel follows the character development of Elizabeth Bennet, the protagonist of the book, who learns about the repercussions of hasty judgments and comes to appreciate the difference between superficial goodness and actual goodness.\r\n\r\nMr Bennet, owner of the Longbourn estate in Hertfordshire, has five daughters, but his property is entailed and can only be passed to a male heir. His wife also lacks an inheritance, so his family faces becoming poor upon his death. Thus, it is imperative that at least one of the daughters marry well to support the others, which is a motivation that drives the plot.', 2, 'pride_prejudice.jpg'),
                    (6, 'The Prince', 'Niccolo Machiavelli', 'Non-fiction', '9780023042705', 'The book advises new rulers on best maintaining their power or even expanding their power. Machiavelli argues that a focus on warfare is important and that rulers should sometimes bend conventional morality or even be cruel to accomplish their goal of defending their state and their own power over it.', 5, 'the_prince.jpg'),
                    (7, 'Into Thin Air', 'Jon Krakauer', 'Non-fiction', '0385494785 ', 'Krakauer describes the events leading up to his eventual decision to participate in an Everest expedition in May 1996, despite having mostly given up mountain climbing years before. The 1996 expedition season recorded eight deaths, including that of Krakauer\'s guide Rob Hall. This was the third-highest recorded number of deaths on the mountain in a single day; the April 2015 Nepal earthquake caused the most at 21.', 0, 'into_thin_air.jpg'),
                    (8, 'The Couple Next Door', 'Shari Lapena', 'Thriller', '0735221103', 't all started at a dinner party. . .\r\n\r\nA domestic suspense debut about a young couple and their apparently friendly neighbors--a twisty, rollercoaster ride of lies, betrayal, and the secrets between husbands and wives. . .\r\n\r\nAnne and Marco Conti seem to have it all--a loving relationship, a wonderful home, and their beautiful baby, Cora. But one night when they are at a dinner party next door, a terrible crime is committed. Suspicion immediately focuses on the parents. But the truth is a much more complicated story.\r\n\r\nInside the curtained house, an unsettling account of what actually happened unfolds. Detective Rasbach knows that the panicked couple is hiding something. Both Anne and Marco soon discover that the other is keeping secrets, secrets they\'ve kept for years.', 0, 'couple_next.jpg'),
                    (9, 'The Curious Case of Benjamin Button', 'F. Scott Fitzgerald', 'Romance', '1416556052', 'Born under unusual circumstances, Benjamin Button springs into being as an elderly man in a New Orleans nursing home and ages in reverse. Twelve years after his birth, he meets Daisy, a child who flickers in and out of his life as she grows up to be a dancer. Though he has all sorts of unusual adventures over the course of his life, it is his relationship with Daisy, and the hope that they will come together at the right time, that drives Benjamin forward.', 1, 'curious_case.jpg'),
                    (10, ' Atomic Habits: An Easy & Proven Way to Build Good Habits & Break Bad Ones', ' James Clear', 'Self-help book', '9780735211292 ', 'A comprehensive, practical guide on how to change your habits and get 1% better every day. Using a framework called the Four Laws of Behavior Change, Atomic Habits teaches readers a simple set of rules for creating good habits and breaking bad ones.', 9, 'atomic_habits.jpg'),
                    (11, 'Gone Girl', 'Gillian Flynn', 'Thriller', '9780753827666 ', 'On their fifth wedding anniversary, writing teacher Nick Dunne returns home to find his wife Amy missing. Amy\'s fame as the inspiration for her parents\' successful Amazing Amy children\'s books ensures widespread press coverage. The media find Nick\'s apathy towards the disappearance suspicious.', 3, 'gone_girl.jpg'),
                    (12, 'A Short History of Nearly Everything', 'Bill Bryson', 'Non-Fiction', '0385408188 ', 'A Short History Of Nearly Everything explains everything we\'ve learned about our world and the universe so far, including how they formed, how we learned to make sense of time, space and gravity, why it\'s such a miracle that we\'re alive and how much of our planet is still a complete mystery to us.', 4, 'nearly_everything.jpg'),
                    (13, 'Big Little Lies', 'Liane Moriarty', 'Thriller', '0425274861', 'Jane, a single mother, is on her way to Pirriwee Public School in Sydney\'s Northern Beaches, where her son Ziggy is starting kindergarten. On the way, she meets Madeline, another mother with a daughter of the same age. Madeline\'s friend Celeste is also sending her twin sons, Max and Josh, to school. The two strike up a friendship with Jane. All three of them have their own problems: Madeline is resentful that her daughter from her previous marriage is growing close to her ex-husband\'s new wife, Bonnie; Celeste is physically abused by her rich banker husband, Perry; and Jane was raped and left to raise her son Ziggy on her own. To make matters worse for her, Ziggy is accused of bullying Amabella, his future classmate, during orientation.\r\n\r\nAs months pass, the three become close and Jane shares her experience with the other women. Jane tells the two other women that Ziggy is the result of a rape by a man named Saxon Banks when Jane was 19. Celeste and Madeline realize that the father is Perry\'s cousin, but decide to keep it from Jane for the time being. Meanwhile, Celeste\'s marriage becomes even more violent and she starts meeting with a counselor and rents an apartment for herself and her sons without Perry\'s knowledge. Ziggy is once again accused of bullying Amabella, and again denies it. Jane finds out that Ziggy is keeping a secret about who is hurting Amabella and persuades him to write down the name of the child, which turns out to be Max, one of Celeste\'s twins, but she is not sure how to broach the subject with Celeste.', 4, 'big_ittle.jpg'),
                    (14, 'The Right Stuff', 'Tom Wolfe', 'Non-fiction', '0553381350 ', 'About the pilots engaged in U.S. postwar research with experimental rocket-powered, high-speed aircraft as well as documenting the stories of the first Project Mercury astronauts selected for the NASA space program.', 1, 'right_stuff.jpg'),
                    (16, 'The Da Vinci Code', 'Dan Brown', 'Mystery', '0307474275 ', 'While in Paris on business, Harvard symbologist Robert Langdon receives an urgent late-night phone call: the elderly curator of the Louvre has been murdered inside the museum. Near the body, police have found a baffling cipher. Solving the enigmatic riddle, Langdon is stunned to discover it leads to a trail of clues hidden in the works of da Vinci…clues visible for all to see…and yet ingeniously disguised by the painter.\r\n\r\nLangdon joins forces with a gifted French cryptologist, Sophie Neveu, and learns the late curator was involved in the Priory of Sion—an actual secret society whose members included Sir Isaac Newton, Botticelli, Victor Hugo, and da Vinci, among others. The Louvre curator has sacrificed his life to protect the Priory’s most sacred trust: the location of a vastly important religious relic, hidden for centuries.\r\n\r\nIn a breathless race through Paris, London, and beyond, Langdon and Neveu match wits with a faceless powerbroker who appears to work for Opus Dei—a clandestine, Vatican-sanctioned Catholic sect believed to have long plotted to seize the Priory’s secret. Unless Langdon and Neveu can decipher the labyrinthine puzzle in time, the Priory’s secret—and a stunning historical truth—will be lost forever.', 3, 'davinci_code.jpg'),
                    (17, 'Call Me by Your Name', 'André Aciman', 'Romance', '0274884755', 'In the summer of 1983, Elio Perlman, a 17-year-old Jewish Italian-French boy, lives with his parents in rural Northern Italy. Elio\'s father, a professor of archaeology, invites a 24-year-old Jewish-American graduate student, Oliver, to live with the family over the summer and help with his academic paperwork. Elio, an introspective bookworm and a musician, initially thinks he has little in common with Oliver, who appears confident and carefree. Elio spends much of the summer reading, playing piano, and hanging out with his childhood friends, Chiara and Marzia. During a volleyball match, Oliver touches Elio\'s back but Elio brushes it off. However, Elio later finds himself jealous upon seeing Oliver pursue Chiara.\r\n\r\nElio and Oliver spend more time together, going for long walks into town, and accompanying Elio\'s father on an archaeological trip. Elio is increasingly drawn to Oliver, even sneaking to Oliver\'s room to smell his clothing. Elio eventually confesses his feelings to Oliver, who tells him they cannot discuss such things. Later, in a secluded spot, the two kiss for the first time. Oliver is reluctant to take things further, and they do not speak for several days.', 4, 'call_me.jpg'),
                    (18, 'The Daughter of Time', 'Josephine Tey', 'Mystery', '009953682X', 'he Daughter of Time explores the historical facts surrounding one of Shakespeare\'s most enduring villains, King Richard III, and interrogates how stories are preserved, who gets to tell them, and what can be discovered when we reexamine history from a new perspective.', 3, 'daughter_of_time.jpg'),
                    (19, 'Red, White & Royal Blue', 'Casey McQuiston', 'Romance', '1250905702', 'First Son Alex Claremont-Diaz is the closest thing to a prince this side of the Atlantic. With his intrepid sister and the Veep’s genius granddaughter, they’re the White House Trio, a beautiful millennial marketing strategy for his mother, President Ellen Claremont. International socialite duties do have downsides—namely, when photos of a confrontation with his longtime nemesis Prince Henry at a royal wedding leak to the tabloids and threaten American/British relations. The plan for damage control: staging a fake friendship between the First Son and the Prince.\r\n\r\nAs President Claremont kicks off her reelection bid, Alex finds himself hurtling into a secret relationship with Henry that could derail the campaign and upend two nations. What is worth the sacrifice? How do you do all the good you can do? And, most importantly, how will history remember you?', 4, 'red_white.jpg'),
                    (20, 'All the Birds in the Sky', 'Charlie Jane Anders', 'Fantasy', '9780765379955', 'Book about feats of magic and genius level engineering skills that focuses on human emotion and communication. We first meet Patricia and Laurence when they are children and although they have to face the difficulties of parents that do not understand them they could be worse off.', 6, 'birds_in_the_sky.jpg'),
                    (21, 'A Game of Thrones', 'George R. R. Martin', 'Fantasy Fiction', '9780553593716 ', 'The series follows several simultaneous plot lines. The first story arc follows a war of succession among competing claimants for control of the Iron Throne of the Seven Kingdoms, with other noble families fighting for independence from the throne, Nine noble families fight for control over the lands of Westeros, while an ancient enemy returns after being dormant for a millennia.', 7, 'game_of_thrones.jpg'),
                    (22, 'Circe', 'Madeline Miller', 'Fantasy', '9780316556347', 'In the house of Helios, god of the sun and mightiest of the Titans, a daughter is born. But Circe is a strange child--neither powerful like her father nor viciously alluring like her mother. Turning to the world of mortals for companionship, she discovers that she does possess power: the power of witchcraft, which can transform rivals into monsters and menace the gods themselves.\r\n\r\nThreatened, Zeus banishes her to a deserted island, where she hones her occult craft, tames wild beasts, and crosses paths with many of the most famous figures in all of mythology, including the Minotaur, Daedalus and his doomed son Icarus, the murderous Medea, and, of course, wily Odysseus.\r\n\r\nBut there is danger, too, for a woman who stands alone, and Circe unwittingly draws the wrath of both men and gods, ultimately finding herself pitted against one of the most terrifying and vengeful of the Olympians. To protect what she loves most, Circe must summon all her strength and choose, once and for all, whether she belongs with the gods she is born from or with the mortals she has come to love.', 5, 'circe.jpg'),
                    (23, 'To Kill A Mockingbird', 'Harper Lee', 'Fiction', '123443214567', 'Once upon a time', 5, 'kill_a_mockingbird.jpg'),
                    (24, 'Ikaw lang ang iibigin', 'John Marvin Nuque', 'Romace', '0898-10292-12912', 'Once upon a time', 5, ''),
                    (25, 'IU', 'IU', 'Romance', '2222222222', 'Once upon a time there\'s an IU', 1000, 'iu.jpg'),
                    (29, 'Book of shance', 'Di ko alam', 'Romance', '12345678910', 'Kahit ano', 50, '356604878_101457033028891_4083138123489597083_n.jpg'),
                    (30, 'Hindi ko to kilala', '20210591', 'Fiction', '2222222222', '123123', 10, '657ae9.jpg'),
                    (31, 'Hindi ko to kilala', '20210591', 'Fiction', '2222222222', '123123', 10, '657aea.jpg'),
                    (32, 'Negga', 'Kishibutaka', 'Fiction', '1234567810', 'There\'s is...', 10, '657aeb.jpg'),
                    (33, 'Week 7', 'Justin Marucut', 'Fiction', '1234567890', 'asdadasd', 10, '657b00.jpg'),
                    (34, 'Props', 'props', 'Fiction', '12312312', 'asdasdas', 10, '657b00.jpeg');";
    // INSERT BOOKS DATA
    $pdo->exec($data_books);

    
    $name = "admin";
    $admin_name = "admin@gmail.com";
    $plainPassword = "admin";
    $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO admin (id, username, admin_name, password) VALUES (?, ?, ?, ?)");
    $stmt->execute([1, $name, $admin_name, $hashedPassword]);

    echo "Migration executed successfully!";

} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage();
}
?>
