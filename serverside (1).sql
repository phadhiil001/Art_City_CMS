-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2024 at 11:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `serverside`
--

-- --------------------------------------------------------

--
-- Table structure for table `artcitycategories`
--

CREATE TABLE `artcitycategories` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(25) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artcitycategories`
--

INSERT INTO `artcitycategories` (`id`, `title`, `description`) VALUES
(13, 'Events', ' Explore our diverse range of events that cater to every interest and passion. From music concerts and art exhibitions to theater performances and cultural festivals, our events offer immersive experiences and unforgettable moments for everyone to enjoy.'),
(14, 'Workshops', 'Immerse yourself in learning and creativity with our curated workshops designed to inspire and educate. From photography and painting to digital marketing and web development, our workshops provide hands-on training, expert guidance, and valuable skills t'),
(15, 'Artists', 'Discover the world of artistry and expression through the works of talented artists from diverse backgrounds and disciplines. From painters and sculptors to photographers and performers, our artists showcase their unique perspectives, creativity, and pass'),
(16, 'Uncategorized', 'This hold the posts without categories');

-- --------------------------------------------------------

--
-- Table structure for table `artcitycomments`
--

CREATE TABLE `artcitycomments` (
  `id` int(11) UNSIGNED NOT NULL,
  `author` varchar(25) NOT NULL,
  `comment` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `post_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artcitycomments`
--

INSERT INTO `artcitycomments` (`id`, `author`, `comment`, `created_date`, `post_id`) VALUES
(6, 'Addi', 'Well done', '2024-04-09 16:21:38', 38),
(11, 'Sam', 'Hi Web Dev 3', '2024-04-12 16:22:44', 37),
(14, 'johndoe', 'yusuf', '2024-04-16 14:38:39', 31),
(15, 'johndoe', 'Nice job', '2024-04-16 14:39:13', 31),
(16, 'johndoe', 'Nice job', '2024-04-16 14:41:28', 31);

-- --------------------------------------------------------

--
-- Table structure for table `artcitycontact`
--

CREATE TABLE `artcitycontact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artcitycontact`
--

INSERT INTO `artcitycontact` (`id`, `name`, `email`, `content`) VALUES
(7, 'Fadlullah Jamiu-Imam', 'phadhiil001@gmail.com', 'Well Done Amatu');

-- --------------------------------------------------------

--
-- Table structure for table `artcityposts`
--

CREATE TABLE `artcityposts` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) UNSIGNED DEFAULT NULL,
  `author_id` int(11) UNSIGNED NOT NULL,
  `is_featured` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artcityposts`
--

INSERT INTO `artcityposts` (`id`, `title`, `content`, `thumbnail`, `created_date`, `category_id`, `author_id`, `is_featured`) VALUES
(40, 'Unlocking Creativity: A Workshop for Aspiring Artists', 'Are you ready to unleash your creativity and take your artistic endeavors to the next level? Look no further! We&#039;re thrilled to announce our upcoming workshop, &quot;Unlocking Creativity,&quot; designed especially for aspiring artists like you.\r\n\r\nIn today&#039;s fast-paced world, it&#039;s easy to feel stuck or uninspired in your creative pursuits. Whether you&#039;re a painter, writer, musician, or any other type of artist, we understand the challenges you face in tapping into your creative potential. That&#039;s why we&#039;ve curated this transformative workshop to help you break through barriers and ignite your imagination.\r\n\r\nDuring this immersive event, you&#039;ll have the opportunity to:\r\n\r\nExplore Different Creative Techniques: Through a series of hands-on exercises and interactive sessions, you&#039;ll discover various techniques for generating ideas, overcoming creative blocks, and pushing the boundaries of your artistic expression.\r\nGain Insights from Industry Experts: Learn from seasoned artists and creative professionals who will share their insights, experiences, and tips for navigating the creative process. Whether you&#039;re seeking guidance on refining your craft or navigating the business side of the art world, our expert speakers have you covered.\r\nConnect with Like-Minded Peers: Surround yourself with a community of fellow artists who share your passion and enthusiasm for creativity. Exchange ideas, collaborate on projects, and forge meaningful connections that will inspire and support you on your artistic journey.\r\nReceive Personalized Feedback: Receive constructive feedback and guidance from instructors and peers alike, helping you identify your strengths, address areas for improvement, and refine your artistic vision.\r\nLeave Inspired and Empowered: Walk away from this workshop feeling reinvigorated, inspired, and equipped with the tools and confidence to continue pursuing your artistic goals with renewed vigor.\r\nWhether you&#039;re a novice looking to explore your creative potential or a seasoned artist seeking fresh inspiration, &quot;Unlocking Creativity&quot; is the perfect opportunity to reignite your passion for art and take your creativity to new heights.\r\n\r\nDon&#039;t miss out on this transformative experience! Reserve your spot today and embark on a journey of self-discovery and artistic exploration like never before. Join us as we unlock the limitless possibilities of your imagination and unleash the artist within.\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 'artworkshop1.jpg', '2024-04-18 17:45:03', 14, 1, 0),
(41, 'A Journey through Winnipeg&rsquo;s Vibrant Art Scene', 'Winnipeg, often referred to as the cultural heart of Canada&rsquo;s prairies, is home to a rich tapestry of artistic expression. From the captivating brushstrokes of local painters to the intricate melodies of musicians, the city pulsates with creative energy. At [Art Company Name], we are thrilled to be a part of this dynamic community, offering a diverse array of events that celebrate the boundless talent flourishing within our city.\r\n\r\nOur event calendar is a canvas painted with a spectrum of colors, each representing a unique experience waiting to be discovered. Whether you&rsquo;re a seasoned artist or a curious beginner, there&rsquo;s something for everyone to explore. From immersive exhibitions showcasing the works of local talents to interactive workshops designed to ignite your creativity, we invite you to embark on a journey of self-discovery through the world of art.\r\n\r\nOne of the highlights of our event lineup is our series of curated exhibitions, where we showcase the works of both emerging and established artists. These exhibitions serve as a platform for artists to share their stories, inspirations, and visions with the world. Step into our gallery space and immerse yourself in a visual feast of paintings, sculptures, and mixed media creations that reflect the diverse tapestry of Winnipeg&rsquo;s artistic landscape.\r\n\r\nBut our commitment to fostering creativity extends beyond the walls of our gallery. We believe in the power of art to transform lives and communities, which is why we offer a range of workshops and classes designed to inspire and educate. Whether you&rsquo;re interested in learning the fundamentals of painting, exploring the art of pottery, or honing your skills in digital design, our experienced instructors are here to guide you on your artistic journey.\r\n\r\nAt [Art Company Name], we understand that art is not just about aesthetics; it&rsquo;s about connection and expression. That&rsquo;s why we also host a variety of community events that bring people together to celebrate the arts. From artist talks and panel discussions to live performances and poetry readings, our events serve as gathering spaces where ideas are exchanged, friendships are forged, and creativity thrives.\r\n\r\nAs we navigate the ever-changing landscape of the art world, we remain committed to providing a platform for artists to share their voices and visions with the world. Whether you&rsquo;re a seasoned art enthusiast or someone who&rsquo;s just beginning to dip their toes into the world of creativity, we invite you to join us on this journey of exploration and discovery.\r\n\r\nStay tuned to our event calendar for updates on upcoming exhibitions, workshops, and community events. We can&rsquo;t wait to welcome you into our vibrant artistic community here in Winnipeg. Together, let&rsquo;s unleash the power of creativity and make magic happen, one brushstroke at a time.', 'artworkshop2.jpg', '2024-04-18 18:10:23', 15, 1, 0),
(42, 'Illuminate Winnipeg&#039;s Night Sky', 'As the sun dips below the horizon, Winnipeg&#039;s skyline transforms into a canvas of twinkling stars, inviting us to marvel at the beauty of the cosmos. At Concert Hall, we are thrilled to announce our upcoming event that promises to ignite your sense of wonder and awe: &quot;Celestial Dreams: A Night of Astronomy and Art.&quot;\r\n\r\nOn May 29th, join us for an unforgettable evening under the stars as we explore the intersection of art and astronomy. Our gallery will be transformed into a celestial oasis, where you can embark on a journey through the cosmos without ever leaving the city limits.\r\n\r\nThe centerpiece of the evening will be a captivating exhibition featuring the stunning celestial photography of local artists. From mesmerizing images of distant galaxies to breathtaking views of our own Milky Way, these works of art will transport you to the far reaches of the universe and beyond.\r\n\r\nBut the magic doesn&#039;t stop there. Step outside into our outdoor space, where telescopes will be set up for stargazing sessions guided by knowledgeable astronomers. Peer through the lenses and witness the beauty of Saturn&#039;s rings, the craters of the moon, and other celestial wonders that adorn our night sky.\r\n\r\nThroughout the evening, guests will have the opportunity to engage with both the artists and astronomers, learning about the techniques behind capturing these celestial masterpieces and gaining insights into the mysteries of the cosmos.\r\n\r\nAs you wander through the gallery and gaze up at the stars, let yourself be inspired by the infinite beauty and wonder that surrounds us. Whether you&#039;re a seasoned astronomer or someone who&#039;s simply fascinated by the night sky, &quot;Celestial Dreams&quot; promises to be an evening you won&#039;t soon forget.\r\n\r\nJoin us as we illuminate Winnipeg&#039;s night sky and celebrate the profound connection between art and the cosmos. Tickets are limited, so be sure to reserve your spot early for this celestial spectacle at [Art Company Name]. We can&#039;t wait to share this magical experience with you.', 'artworkshop3.jpg', '2024-04-18 18:12:48', 13, 1, 1),
(43, 'Unleash Your Inner Artist: A Creative Exploration', 'Calling all aspiring artists and creative souls! Get ready to unleash your imagination and dive into a world of artistic expression at [Art Company Name]&#039;s upcoming event: &quot;Artistic Odyssey: A Journey of Creativity.&quot;\r\n\r\nOn [Event Date], join us for a day filled with inspiration, discovery, and hands-on artistic exploration. Whether you&#039;re a seasoned artist looking to refine your skills or a beginner eager to dip your toes into the world of art, there&#039;s something for everyone at &quot;Artistic Odyssey.&quot;\r\n\r\nThe event kicks off with a series of interactive workshops led by talented local artists. From painting and drawing to sculpture and mixed media, these workshops will provide you with the tools and techniques you need to bring your creative visions to life. Whether you&#039;re experimenting with new mediums or honing your existing skills, our instructors will be there to guide you every step of the way.\r\n\r\nBut the fun doesn&#039;t stop there! Throughout the day, our gallery space will come alive with live art demonstrations, where you can watch artists at work and gain insights into their creative process. Get up close and personal with the art-making process as you witness masterpieces come to life before your eyes.\r\n\r\nFeeling inspired? Grab a brush, pencil, or sculpting tool and join in on the fun! Our communal art stations will be set up throughout the gallery, inviting you to unleash your inner artist and create your own masterpiece. Whether you&#039;re painting a canvas, molding clay, or sketching in a notebook, let your creativity flow freely and see where it takes you.\r\n\r\nAs you explore the gallery and immerse yourself in the world of art, take time to connect with fellow art enthusiasts and exchange ideas and inspiration. Art has a unique ability to bring people together, and &quot;Artistic Odyssey&quot; is the perfect opportunity to build connections and forge friendships with like-minded individuals who share your passion for creativity.\r\n\r\nSo mark your calendars and get ready for an unforgettable day of artistic exploration at [Art Company Name]. Tickets are limited, so be sure to reserve your spot early and secure your place at this one-of-a-kind event. We can&#039;t wait to embark on this creative journey with you!', 'artgallery.jpg', '2024-04-18 18:14:39', 13, 1, 0),
(44, ' A Journey of Discovery', 'Are you ready to tap into your innate creativity and explore new artistic horizons? Join us at [Art Company Name] for an immersive workshop experience designed to ignite your passion for art and unleash your creative potential. Introducing &quot;Creative Catalyst: A Workshop Series for Aspiring Artists.&quot;\r\n\r\nOn [Workshop Date], immerse yourself in a day of hands-on learning and artistic discovery as we delve into a variety of mediums and techniques to help you unlock your inner artist. Whether you&#039;re a beginner taking your first steps into the world of art or a seasoned creator looking to expand your skills, &quot;Creative Catalyst&quot; offers something for artists of all levels.\r\n\r\nLed by experienced instructors who are passionate about sharing their knowledge and expertise, each workshop in the series will focus on a different aspect of artistic expression. From exploring the fundamentals of drawing and painting to experimenting with mixed media and collage, you&#039;ll have the opportunity to explore a range of techniques and mediums to find what resonates with you.\r\n\r\nBut &quot;Creative Catalyst&quot; is more than just a series of workshops&mdash;it&#039;s a journey of self-discovery and personal growth. Through guided exercises and creative prompts, you&#039;ll learn to trust your instincts, embrace experimentation, and cultivate your unique artistic voice. Whether you&#039;re creating abstract compositions or realistic portraits, the focus is on fostering creativity and self-expression in a supportive and encouraging environment.\r\n\r\nAs you immerse yourself in the creative process, you&#039;ll also have the opportunity to connect with fellow participants who share your passion for art. Exchange ideas, share insights, and draw inspiration from one another as you embark on this artistic journey together.\r\n\r\nWhether you&#039;re looking to reignite your passion for art, expand your artistic skills, or simply spend a day immersed in creativity, &quot;Creative Catalyst&quot; is the perfect opportunity to nurture your artistic spirit and unleash your creative potential. Spaces are limited, so be sure to reserve your spot early and embark on this transformative journey with us at [Art Company Name]. We can&#039;t wait to see where your creativity takes you!', 'artgallery1.jpg', '2024-04-18 18:19:34', 13, 1, 0),
(45, '&quot;Sculpting Serenity: A Zen Garden Experience', 'As the hustle and bustle of city life fades into the background, [Art Company Name] invites you to embark on a journey of tranquility and creativity with our latest event: &quot;Zen Garden Retreat.&quot; Set to take place on [Event Date], this immersive experience promises to transport you to a world of peace and serenity inspired by the beauty of Japanese gardens.Picture yourself stepping into our transformed gallery space, where the soothing sound of trickling water and the gentle rustle of bamboo leaves set the stage for a moment of quiet contemplation. Here, amidst a carefully curated landscape of sand, rocks, and lush greenery, you&#039;ll have the opportunity to create your own miniature Zen garden&mdash;a personal sanctuary where you can cultivate mindfulness and reconnect with nature.Guided by experienced instructors, participants will learn the art of Zen garden design, from the meticulous placement of rocks to the rhythmic patterns of raking sand. As you immerse yourself in the meditative process of garden creation, you&#039;ll discover a sense of calm and balance that transcends the ordinary.But &quot;Zen Garden Retreat&quot; is more than just a creative workshop&mdash;it&#039;s an opportunity to experience the profound beauty and simplicity of Zen philosophy. Drawing inspiration from the principles of harmony, balance, and impermanence, participants will learn to let go of stress and distraction, embracing the present moment with open hearts and clear minds.Throughout the event, guests will have the chance to engage with fellow participants and share their insights and experiences. Whether you&#039;re a seasoned practitioner of meditation or someone who&#039;s simply curious about the art of Zen, &quot;Zen Garden Retreat&quot; offers a welcoming space for exploration and connection.So mark your calendars and join us for an unforgettable journey of serenity and creativity at [Art Company Name]. Tickets are limited, so be sure to reserve your spot early and experience the transformative power of the Zen garden for yourself.', 'artgallery2.jpg', '2024-04-18 18:23:35', 13, 1, 0),
(46, 'The Art of Tea: A Cultural Celebration', 'Prepare to embark on a sensory journey into the world of tea culture and artistry with [Art Company Name]&#039;s upcoming event: &quot;Tea Ceremony Extravaganza.&quot; Scheduled for [Event Date], this enchanting celebration invites guests to immerse themselves in the rich traditions and rituals of tea from around the world.Step into our gallery space and be transported to the serene surroundings of a traditional tea house as you witness a mesmerizing tea ceremony performed by a master tea artist. Through graceful movements and precise gestures, you&#039;ll experience the beauty and grace of this ancient practice, steeped in centuries of tradition and culture.But the artistry of tea extends far beyond the ceremony itself. Throughout the event, guests will have the opportunity to explore a curated selection of tea-inspired artworks created by local artists. From delicate porcelain teapots to intricate paintings of tea plantations, these pieces offer a visual feast that celebrates the beauty and diversity of tea culture.In addition to visual art, guests will also have the chance to indulge their taste buds with a selection of premium teas sourced from around the world. From delicate green teas to robust black teas, each cup offers a unique sensory experience that reflects the terroir and craftsmanship of its origin.But perhaps the most enchanting aspect of &quot;Tea Ceremony Extravaganza&quot; is the sense of community and connection that it fosters. Whether you&#039;re a tea aficionado or someone who&#039;s simply curious about this ancient beverage, this event offers a welcoming space for exploration, conversation, and camaraderie.So join us on [Event Date] as we raise our teacups in celebration of the art, culture, and tradition of tea. Tickets are limited, so be sure to reserve your spot early and experience the magic of the tea ceremony for yourself.', 'artworkshop5.jpg', '2024-04-18 18:24:14', 13, 1, 0),
(47, ' A Street Art Showcase ', 'Prepare to be dazzled by the vibrant energy and creativity of Winnipeg&#039;s street art scene with [Art Company Name]&#039;s latest event: &quot;Urban Canvas.&quot; Taking place on [Event Date], this dynamic showcase invites guests to explore the colorful world of urban artistry and graffiti culture.Step into our transformed gallery space and be greeted by a riot of color, texture, and expression as you immerse yourself in a curated selection of street art-inspired works. From larger-than-life murals to intricate stencil art, each piece offers a unique glimpse into the diverse and eclectic styles that define Winnipeg&#039;s urban landscape.But &quot;Urban Canvas&quot; is more than just an art exhibition&mdash;it&#039;s a celebration of creativity, community, and self-expression. Throughout the event, guests will have the opportunity to meet the artists behind the works and gain insight into their creative process and inspiration.From established graffiti artists to up-and-coming street art talent, the lineup features a diverse array of voices and perspectives that reflect the vibrancy and dynamism of Winnipeg&#039;s artistic community.But perhaps the most exciting aspect of &quot;Urban Canvas&quot; is its interactive elements, which invite guests to become active participants in the creative process. From live mural painting sessions to hands-on graffiti workshops, there&#039;s plenty of opportunity to roll up your sleeves and get involved.So mark your calendars and join us for a day of urban exploration and artistic discovery at [Art Company Name]. Whether you&#039;re a longtime fan of street art or someone who&#039;s simply curious about this dynamic and evolving art form, &quot;Urban Canvas&quot; offers something for everyone. Tickets are limited, so be sure to reserve your spot early and experience the magic of street art for yourself.', 'artgallery5.jpg', '2024-04-18 18:24:42', 13, 1, 0),
(48, 'A Nature-Inspired Art Retreat', 'Embark on a journey of creative discovery and reconnect with the natural world at [Art Company Name]&#039;s upcoming event: &quot;Elements of Nature Retreat.&quot; Scheduled for [Event Date], this immersive experience invites participants to immerse themselves in the beauty and diversity of the great outdoors.Picture yourself surrounded by the sights, sounds, and textures of the natural world as you explore a variety of artistic techniques and mediums inspired by nature. From plein air painting and sketching to botanical illustration and eco-dyeing, this retreat offers a unique opportunity to find inspiration in the landscapes, flora, and fauna that surround us.Led by experienced instructors and artists, participants will have the opportunity to hone their skills, experiment with new techniques, and create their own works of art in a supportive and encouraging environment. Whether you&#039;re a seasoned artist or someone who&#039;s simply curious about the intersection of art and nature, &quot;Elements of Nature Retreat&quot; offers something for everyone.But perhaps the most rewarding aspect of this retreat is the sense of connection and community that it fosters. Surrounded by like-minded individuals who share your passion for art and nature, you&#039;ll have the opportunity to exchange ideas, share insights, and forge friendships that will last a lifetime.So pack your art supplies and join us for a day of creativity, inspiration, and exploration at [Art Company Name]. Whether you&#039;re capturing the beauty of a sun-dappled forest or sketching the intricate patterns of a leaf, &quot;Elements of Nature Retreat&quot; promises to be an unforgettable experience. Tickets are limited, so be sure to reserve your spot early and immerse yourself in the harmony of the elements.', 'artworkshop5.jpg', '2024-04-18 18:25:18', 13, 1, 0),
(49, 'Masterclass in Oil Painting', 'Unlock the secrets of oil painting and unleash your creativity with [Art Company Name]&#039;s latest workshop: &quot;Mastering Oil Painting.&quot; Scheduled for [Workshop Date], this immersive masterclass offers participants the opportunity to refine their skills and elevate their artistry to new heights.Led by acclaimed artist [Instructor&#039;s Name], this workshop covers a range of techniques and principles essential to the practice of oil painting. From color mixing and brushwork to composition and perspective, participants will gain valuable insights and hands-on experience that will help them bring their artistic visions to life with confidence and flair.But perhaps the most exciting aspect of &quot;Mastering Oil Painting&quot; is its focus on individualized instruction and feedback. Whether you&#039;re a beginner looking to learn the basics or an experienced painter seeking to refine your technique, our experienced instructor will provide personalized guidance and support every step of the way.Throughout the workshop, participants will have the opportunity to work on their own oil painting projects, putting into practice the techniques and principles they&#039;ve learned. Whether you&#039;re painting a still life, a landscape, or a portrait, the emphasis is on experimentation, exploration, and self-expression.So dust off your brushes and join us for a day of creativity, inspiration, and artistic growth at [Art Company Name]. Whether you&#039;re a longtime admirer of oil painting or someone who&#039;s curious to learn more about this versatile medium, &quot;Mastering Oil Painting&quot; offers something for artists of all levels. Tickets are limited, so be sure to reserve your spot early and take your painting skills to the next level.', NULL, '2024-04-18 18:26:13', 14, 1, 0),
(50, 'Photography Workshop ', 'Unlock the secrets of photography and learn to capture the beauty of light with [Art Company Name]&#039;s upcoming workshop: &quot;Mastering Light and Shadow.&quot; Scheduled for [Workshop Date], this immersive learning experience offers participants the opportunity to hone their skills and expand their creative horizons.Led by acclaimed photographer [Instructor&#039;s Name], this workshop covers a range of techniques and principles essential to the practice of photography. From understanding exposure and composition to harnessing the creative potential of natural and artificial light, participants will gain valuable insights and hands-on experience that will help them take their photography to the next level.But perhaps the most exciting aspect of &quot;Mastering Light and Shadow&quot; is its focus on practical application and experimentation. Whether you&#039;re shooting in a studio setting or exploring the great outdoors, participants will have the opportunity to put their newfound knowledge into practice and capture stunning images that tell a story.Throughout the workshop, participants will receive personalized feedback and guidance from the instructor, helping them refine their technique and develop their own unique style. Whether you&#039;re a beginner or an experienced photographer, the emphasis is on creativity, exploration, and self-expression.So grab your camera and join us for a day of inspiration, discovery, and artistic growth at [Art Company Name]. Whether you&#039;re passionate about landscape photography, portrait photography, or street photography, &quot;Mastering Light and Shadow&quot; offers something for photographers of all levels. Tickets are limited, so be sure to reserve your spot early and take your photography skills to the next level.', 'artgallery2.jpg', '2024-04-18 18:27:02', 14, 1, 0),
(51, 'A Ceramic Art Workshop', 'Get ready to roll up your sleeves and get your hands dirty with [Art Company Name]&#039;s upcoming workshop: &quot;Exploring Ceramic Sculpture.&quot; Scheduled for [Workshop Date], this hands-on experience invites participants to dive into the world of ceramics and explore the art of sculptural expression.Led by experienced sculptor [Instructor&#039;s Name], this workshop covers a range of techniques and principles essential to the practice of ceramic sculpture. From hand-building and wheel-throwing to glazing and firing, participants will gain valuable insights and hands-on experience that will help them create their own unique works of art.But perhaps the most exciting aspect of &quot;Exploring Ceramic Sculpture&quot; is its emphasis on experimentation and exploration. Whether you&#039;re a novice or an experienced ceramicist, participants will have the opportunity to push the boundaries of their creativity and discover new possibilities in clay.Throughout the workshop, participants will receive personalized guidance and feedback from the instructor, helping them refine their technique and develop their own unique style. Whether you&#039;re sculpting figurative forms, abstract shapes, or functional objects, the emphasis is on creativity, expression, and self-discovery.So join us for a day of creativity, inspiration, and artistic growth at [Art Company Name]. Whether you&#039;re passionate about ceramics or simply curious to learn more about this versatile medium, &quot;Exploring Ceramic Sculpture&quot; offers something for artists of all levels. Tickets are limited, so be sure to reserve your spot early and discover the joy of sculpting with clay.', 'artgallery3.jpg', '2024-04-18 18:27:32', 14, 1, 0),
(52, 'Calligraphy Workshop', 'Discover the art of beautiful writing with [Art Company Name]&#039;s upcoming workshop: &quot;Introduction to Calligraphy.&quot; Scheduled for [Workshop Date], this immersive learning experience offers participants the opportunity to explore the timeless art of calligraphy and unleash their creativity with ink and paper.Led by expert calligrapher [Instructor&#039;s Name], this workshop covers a range of techniques and styles essential to the practice of calligraphy. From mastering the basic strokes of traditional scripts to experimenting with modern lettering styles, participants will gain valuable insights and hands-on experience that will help them develop their own unique calligraphic style.But perhaps the most exciting aspect of &quot;Introduction to Calligraphy&quot; is its focus on experimentation and self-expression. Whether you&#039;re writing with a traditional dip pen or exploring digital calligraphy tools, participants will have the opportunity to push the boundaries of their creativity and discover new possibilities in lettering.Throughout the workshop, participants will receive personalized guidance and feedback from the instructor, helping them refine their technique and develop their own unique style. Whether you&#039;re a beginner or an experienced calligrapher, the emphasis is on creativity, exploration, and self-discovery.So grab your favorite pen and join us for a day of inspiration, discovery, and artistic growth at [Art Company Name]. Whether you&#039;re passionate about traditional calligraphy, modern lettering, or experimental typography, &quot;Introduction to Calligraphy&quot; offers something for artists of all levels. Tickets are limited, so be sure to reserve your spot early and discover the joy of beautiful writing', 'artworkshop4.jpg', '2024-04-18 18:28:06', 14, 1, 0),
(53, 'Digital Canvas', 'Explore the exciting world of digital art with [Art Company Name]&#039;s upcoming workshop: &quot;Digital Painting Essentials.&quot; Scheduled for [Workshop Date], this immersive learning experience offers participants the opportunity to unleash their creativity and explore the endless possibilities of digital painting.Led by acclaimed digital artist [Instructor&#039;s Name], this workshop covers a range of techniques and tools essential to the practice of digital painting. From mastering digital brushes and layers to understanding color theory and composition, participants will gain valuable insights and hands-on experience that will help them create stunning digital artworks with confidence and flair.But perhaps the most exciting aspect of &quot;Digital Painting Essentials&quot; is its focus on experimentation and exploration. Whether you&#039;re painting with a graphics tablet, a touchscreen device, or a traditional mouse and keyboard, participants will have the opportunity to push the boundaries of their creativity and discover new possibilities in digital art.Throughout the workshop, participants will receive personalized guidance and feedback from the instructor, helping them refine their technique and develop their own unique style. Whether you&#039;re a beginner or an experienced digital artist, the emphasis is on creativity, exploration, and self-expression.So fire up your favorite drawing software and join us for a day of inspiration, discovery, and artistic growth at [Art Company Name]. Whether you&#039;re passionate about digital painting, illustration, or concept art, &quot;Digital Painting Essentials&quot; offers something for artists of all levels. Tickets are limited, so be sure to reserve your spot early and take your digital art skills to the next level.', 'artgallery4.jpg', '2024-04-18 18:28:36', 14, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `artcityusers`
--

CREATE TABLE `artcityusers` (
  `id` int(11) UNSIGNED NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artcityusers`
--

INSERT INTO `artcityusers` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `is_admin`) VALUES
(1, 'john', 'doe', 'johndoe', 'johndoe@john.com', '$2y$10$AXOQyrFEPFMaS.nyFsK0..OQtIE4NOiSVcsD.046A2WOkfu92Y4EK', 1),
(7, 'Sam', 'Hoffman', 'sam', 'sam@hoffman.com', '$2y$10$tVaTO.jxit7476xckJo0BeZcObJk7lD.m8NBDL6dG6JxXij/zMenK', 0),
(8, 'Jane', 'Doe', 'janedoe', 'jane@doe.com', '$2y$10$3Rx9sdNBBIRFc7vXgCP9xO..hSlSWs28HZGwwBNs117lWLDQ9FTq6', 0),
(9, 'Iris', 'West', 'iriswest', 'iris@west.com', '$2y$10$yQ.1yHozO5B47HYLVOPBmusUB77cHtIfAyc9k93YI5l9YiKaQZC8e', 0);

-- --------------------------------------------------------

--
-- Table structure for table `blog_post`
--

CREATE TABLE `blog_post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artcitycategories`
--
ALTER TABLE `artcitycategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artcitycomments`
--
ALTER TABLE `artcitycomments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artcitycontact`
--
ALTER TABLE `artcitycontact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artcityposts`
--
ALTER TABLE `artcityposts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_category_id` (`category_id`),
  ADD KEY `FK_author_id` (`author_id`);

--
-- Indexes for table `artcityusers`
--
ALTER TABLE `artcityusers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_post`
--
ALTER TABLE `blog_post`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artcitycategories`
--
ALTER TABLE `artcitycategories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `artcitycomments`
--
ALTER TABLE `artcitycomments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `artcitycontact`
--
ALTER TABLE `artcitycontact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `artcityposts`
--
ALTER TABLE `artcityposts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `artcityusers`
--
ALTER TABLE `artcityusers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `blog_post`
--
ALTER TABLE `blog_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artcityposts`
--
ALTER TABLE `artcityposts`
  ADD CONSTRAINT `FK_author_id` FOREIGN KEY (`author_id`) REFERENCES `artcityusers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_category_id` FOREIGN KEY (`category_id`) REFERENCES `artcitycategories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
