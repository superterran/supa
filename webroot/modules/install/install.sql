/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `{{prefix}}eav`
--

DROP TABLE IF EXISTS `{{prefix}}eav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `{{prefix}}eav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eid` int(11) DEFAULT NULL,
  `entity` varchar(45) DEFAULT NULL,
  `meta` varchar(45) DEFAULT NULL,
  `attribute` varchar(45) DEFAULT NULL,
  `value` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `{{prefix}}eav`
--

LOCK TABLES `{{prefix}}eav` WRITE;
/*!40000 ALTER TABLE `{{prefix}}eav` DISABLE KEYS */;
INSERT INTO `{{prefix}}eav` VALUES (1,1,'supa_modules_panels_models_users','false','email','superterran@gmail.com'),(2,1,'supa_modules_panels_models_users','false','password','fbc146a035594005fd11ff70eb688e67'),(3,1,'supa_modules_panels_models_users','false','level','1'),(4,2,'supa_modules_blog_models_posts','false','byline','superterran'),(5,2,'supa_modules_blog_models_posts','false','title','The Future of The Desktop'),(6,2,'supa_modules_blog_models_posts','false','email','superterran@gmail.com'),(7,2,'supa_modules_blog_models_posts','false','body','If PC\'s are trucks, then I\'m the redneck with the mud tires and scuba kit. I love my truck, and with the way things are going in the industry&nbsp;I\'m starting to wonder who will still be left making... screw this metaphor... nice desktop\'y operating systems. As we move in to this so called Post PC Era, a lot of emphasis is being placed on Mobile, Touch and Voice recognition as UX drivers, while the more traditional desktop platforms have either stagnated or weirdly convoluted. As a lowly Desktop user, this isn\'t the greatest news.&nbsp;<br><br>Microsoft\'s all but stated it\'s intent to deprecate the Desktop from Windows altogether. With Mavericks, Tim Cook says he\'s comfortable with where it stands with OS X and intends to release several more iterations before another major release. Linux has too many heads to go through, but the only way any of them will ever go mainstream is out of wide protest against the first two. I don\'t really see that helping the Linux upstream (which is vibrant in a \'lets all rebuild the same foundation we already have\' sort of way)&nbsp;but it would be nice to finally see them win the war.&nbsp;<br><br>One of the most interesting things I see with&nbsp;the current desktop OS landscape is how OS X has managed to become the last vestige of the traditional desktop. OS X innovated a lot in these&nbsp;advanced power user features through the years&nbsp;but they don\'t really flaunt it anymore. It\'s almost like they see how negatively people react to Metro and all the rest of it and thought... you know...<br><br>It\'s all led to an interesting place since there\'s no telling what the next dominate platform is going to be.&nbsp;All signs say Microsoft is being rejected by consumers (which is a good thing, Win32 is a dead platform that deserves to die), Apple\'s probably not going to let people run OS X on their Acer, and out of all the Linux Desktop contenders there\'s nothing that Best Buy would put on a store shelf. Maybe the market is just doomed to fragment, and that will be OK because applications are moving to the web.&nbsp;<br>'),(8,2,'supa_modules_blog_models_posts','false','slug','futureofthedesktop'),(9,3,'supa_modules_pages_models_page','false','name','Home - Centerpeice'),(10,3,'supa_modules_pages_models_page','false','body','Is this thing on?&nbsp;Aliquam dictum lobortis mi, ut egestas tellus placerat quis. Nullam accumsan egestas semper. In hac habitasse platea dictumst. Vivamus scelerisque mauris at est luctus vehicula. Suspendisse purus metus, vulputate ut tincidunt semper, volutpat nec nibh. Vestibulum semper varius leo eget placerat. Proin suscipit vestibulum consectetur.&nbsp;'),(11,3,'supa_modules_pages_models_page','false','slug','home'),(12,4,'supa_modules_pages_models_page','false','name','Right - Details'),(13,4,'supa_modules_pages_models_page','false','body','<br><ul><li>Lives in&nbsp;Charleston, SC</li><li>From&nbsp;Myrtle Beach, SC</li><li>Works at&nbsp;<a rel=\"nofollow\" target=\"_blank\" href=\"http://www.blueacorn.com/\">Blue Acorn</a></li><li>Hangs out on&nbsp;<a rel=\"nofollow\" target=\"_blank\" href=\"https://plus.google.com/107618603073236931621/posts/p/pub\">Google Plus</a>&nbsp;and&nbsp;<a rel=\"nofollow\" target=\"_blank\" href=\"http://www.reddit.com/user/superterran/\">Reddit</a></li></ul>'),(14,4,'supa_modules_pages_models_page','false','slug','deets'),(15,5,'supa_modules_pages_models_page','false','name','Footer - About Blurb'),(16,5,'supa_modules_pages_models_page','false','body','Hellooo, my name is Doug and&nbsp;I\'m from Coastal South Carolina, where I do Magento work for&nbsp;one of the best eCommerce Agencies known to mankind. In my free time, I run the gambit of nerdy hobbies and interests, and we\'re here to see if any of them are interesting enough to float a decent&nbsp;blogroll. If you\'re wondering where all the awesome stuff from 2008&nbsp;went, it\'s all gone. This will be the only mention of how stupid Kim Komando is. Swear.'),(17,5,'supa_modules_pages_models_page','false','slug','whodat'),(18,6,'supa_modules_blog_models_posts','false','byline','superterran'),(19,6,'supa_modules_blog_models_posts','false','title','It\'s crazy to build your own CMS'),(20,6,'supa_modules_blog_models_posts','false','email','superterran@gmail.com'),(21,6,'supa_modules_blog_models_posts','false','body','It\'s intense, you really shouldn\'t do it. If you have a job that requires output, you don\'t have time for it. It\'s very difficult, and if you want it to be a showpiece you have to open source it which makes you all vulnerable to criticism.Â There\'s easier ways to blog, man. Â <br><br>Today, I finally decide to write something out, and I glance through allÂ the tools I have for the job. There\'s my Tumblr Blog, which is as bad as any and only gets a few sentences at a time. There\'s Google+, which despite my lackluster but steady efforts is still dead in the water, and there\'s the rolodex of friends who\'veÂ invited me to write on their blogs. Oh yeah, and there\'s this thing, almost completely done but with nobody to use it because I\'m not a blogger.Â So, consider the dust wiped off. Screw Wordpress, real men write their own. Still, one has to wonder why I built a blog....'),(22,6,'supa_modules_blog_models_posts','false','slug','firstpost'),(23,7,'supa_modules_blog_models_posts','false','byline','superterran'),(24,7,'supa_modules_blog_models_posts','false','title','A little about my favorite toy'),(25,7,'supa_modules_blog_models_posts','false','email','superterran@gmail.com'),(26,7,'supa_modules_blog_models_posts','false','body','I remember my first website, I built in in the late 90\'s and&nbsp;called it \"Doug\'s LCARS Webpage\". If it had a use, it was just to introduce&nbsp;me and my love for all things Star Trek to you and the world. I don\'t remember how old I was when I made it, but I was just a little kid and had no idea what I was doing. I didn\'t need a website or anything, I just wanted to know how the internet worked and the internet was just a bunch of websites. Making a website seemed like a good place to start. <br><br>A few years later, after host hopping between geocities, tripod and angelfire basically&nbsp;remaking the same stupid introduction site over and over, I ended up getting a hostgator&nbsp;account and a domain and basically started running through the platforms just trying to figure out the right way to do it. First it was straight HTML, then counters, then PHP, then&nbsp;PHPNuke, phpBB just because I wanted a forum, phpBB with a portal because why tack on a CMS, Joombla,&nbsp;Geeklog, drupal... it goes on and on and on. I used to go to hotscripts, find the PHP category for whatever i\'m into that week, and work my way down installing everything that fit the bill.<br><br>What\'s this \'bill\', you ask? I mean, what am I even doing this for? The latest incarnation of Doug\'s LCARS Webpage or to show the world my <a rel=\"nofollow\" target=\"_blank\" href=\"http://demo.superterran.com/design/wayback/2003/codename/\" title=\"Link: http://demo.superterran.com/design/wayback/2003/codename/\">mock longhorn desktop</a>? This is hardly even artistic expression, just pure research trying to understand the world.&nbsp;I just wanted to&nbsp;figure it all out. I built a static HTML page, realized people use PHP to trim down the template code in each HTML file. From there, figured out most people don\'t even put their content in the HTML files, they somehow made a database do all that. Pure effin\' magic, who can understand all this stuff?&nbsp;<br><br>Fast forward to today, and nothing\'s really changed. Still basically just a landing page introducing myself. But I have now&nbsp;built this page 80 different ways, and at one point I knew all the ins and outs with all the different ways one might attempt it - still do, mostly. In a real way, I\'m&nbsp;standing on the other side of the learning experience. More than likely, this is me at the top of my web game. In a few years, I\'m going to move on to another stack and (hopefully?) leave web development behind forever. <br><br>Unless this is the last change to the landing page (spoiler: it won\'t be), this little blog won\'t stand the test of time. The posts may find their way to my personal document stash (many have), but will probably end up&nbsp;living in a .sql file inside a zip archive for the rest of eternity.&nbsp;So, it only seems fitting to use this little stretch of time while it\'s live to reflect on this experience. Not writing the current iteration, but what could arguably be called my very favorite&nbsp;toy: superterran.com.<br>'),(27,7,'supa_modules_blog_models_posts','false','slug','myfavoritetoy'),(28,8,'supa_modules_blog_models_posts','false','byline','superterran'),(29,8,'supa_modules_blog_models_posts','false','title','No, I don\'t want SteamOS to fail, but...'),(30,8,'supa_modules_blog_models_posts','false','email','superterran@gmail.com'),(31,8,'supa_modules_blog_models_posts','false','body','<div>Linux is this big harry beast that\'s trying to eat your face off... trying to marry gaming, linux and the living room, while laudable, is a tremendous undertaking that will A) probably not work well, and B) probably fail commercially. I hope I\'m wrong, I hope GabeN fixes Linux and upstreams everything. I\'m just saying, Steam for Linux is still very, very much a Beta (No Big Picture support for this guy), and video card blobs just aren\'t good enough for hardcore gaming. In the next year or so, the community will be switching from Xorg to Wayland/Mir which will fragment graphic support even moreso in the shortterm.&nbsp;<br></div><div><br></div><div>I\'ve got a handful of Steam games on Linux at this point, and only one or two are even fully playable. So the hype claims coming out of Valve that this thing will be streaming Windows games and playing native games on any hardware... feel a little stretchy at this point. One has to wonder where the repos for this thing are, what as most Linux distro gets developed in the open. It\'d be nice to get some technical details on this thing. Maybe Steam would make a fantastic Package Manager down the line (right now it\'s a buggy heap), perhaps Valve will make yet another desktop of inferior Unbuntu-like quality.&nbsp;</div><div><br></div><div>All I know is that they\'re playing a dangerous game. Richard Stallman must be amassing the legions already; this could well be the coming commericalization of Linux. And while it will most likely lead to better quality across the board, there is something to be said about the tenets of FOSS and GNU license. As Windows continues to fall off, the power vacumm will have to be filled with something. Mostly Tablets and Macs? Probably, but desktop linux has a serious chance. As the masses come over to our nerdy little corner, things are bound to change. It\'ll be interesting to see if the first real commerical linux app store tames the beast.</div>'),(32,8,'supa_modules_blog_models_posts','false','slug','onthesteamos'),(33,9,'supa_modules_blog_models_posts','false','byline','Doug Hatcher'),(34,9,'supa_modules_blog_models_posts','false','title','Whatever'),(35,9,'supa_modules_blog_models_posts','false','email','superterran@gmail.com'),(36,9,'supa_modules_blog_models_posts','false','body','<b>Hi guys! This is a tst</b>'),(37,9,'supa_modules_blog_models_posts','false','slug','fuckallyall');
/*!40000 ALTER TABLE `supa_eav` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-10  5:44:57