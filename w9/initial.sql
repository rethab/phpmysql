CREATE TABLE IF NOT EXISTS `tbl_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(200) NOT NULL,
  `content` varchar(8000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;


INSERT INTO `tbl_person` (`id`, `created`, `title`, `content`) VALUES
(1, '2013-10-27 11:47:19', 'Bacon Ipsum 1', 'Bacon ipsum dolor sit amet meatball sausage hamburger tail boudin jerky. Capicola tongue rump drumstick pork loin kielbasa prosciutto brisket bacon. Ham hock corned beef jerky meatloaf, pancetta kevin jowl filet mignon doner tail t-bone. Shoulder pork chop ham, chicken tri-tip sirloin bresaola. Meatball andouille venison ribeye, bacon spare ribs boudin. Jerky prosciutto andouille tail corned beef meatball.'),
(2, '2013-10-27 11:47:40', 'Bacon Ipsum 2', 'Bresaola capicola andouille brisket venison kielbasa ball tip beef. Kielbasa capicola bresaola venison rump turkey. Frankfurter ribeye venison biltong pig fatback swine cow ham. Short ribs drumstick pork loin cow sirloin. Tenderloin sirloin corned beef filet mignon bacon. Tenderloin shankle pig, cow capicola kevin shank short ribs jerky tongue brisket. Doner venison andouille, prosciutto bacon tongue tenderloin ribeye pork belly chicken fatback pork chop.');
