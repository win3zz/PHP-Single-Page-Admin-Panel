# PHP-Single-Page-Admin-Panel
This is PHP based very small size Admin Panel which may use to update website information like news, and navigation. 

### Usage
- You can use this widget for websites that require minimum dynamic content with frequent update.
- This is more secure and admin login field is hidden in “page not found” page ;)

create following table in database
```sql
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) 
```
Now, you just need to change database credentials in configuration file (config.php)

Enjoy. 

### Designed and Developed by 
Bipin Jitiya, M.Sc. (IT).
