CREATE DATABASE IF NOT EXISTS anychart_db;
USE anychart_db;
DROP PROCEDURE IF EXISTS init;
DELIMITER //
CREATE PROCEDURE init ()
LANGUAGE SQL
  BEGIN
    DECLARE user_exist, data_present INT;
    SET user_exist = (SELECT EXISTS (SELECT DISTINCT user FROM mysql.user WHERE user = "anychart_user"));
    IF user_exist = 0 THEN
      CREATE USER 'anychart_user'@'localhost' IDENTIFIED BY 'anychart_pass';
      GRANT ALL PRIVILEGES ON anychart_db.* TO 'anychart_user'@'localhost';
      FLUSH PRIVILEGES;
    END IF;
    CREATE TABLE IF NOT EXISTS place (
      id VARCHAR(64),
      selected INT
    );
    SET data_present = (SELECT COUNT(*) FROM place);
    IF data_present = 0 THEN
      INSERT INTO place (id, selected) VALUES
        ('1-A', false),
        ('1-B', false),
        ('1-E', false),
        ('1-F', false),

        ('3-A', false),
        ('3-B', false),
        ('3-E', false),
        ('3-F', false),

        ('7-A', false),
        ('7-B', false),
        ('7-C', false),
        ('7-D', false),
        ('7-E', false),
        ('7-F', false),

        ('8-A', false),
        ('8-B', false),
        ('8-C', false),
        ('8-D', false),
        ('8-E', false),
        ('8-F', false),

        ('10-A', false),
        ('10-B', false),
        ('10-C', false),
        ('10-D', false),
        ('10-E', false),
        ('10-F', false),

        ('11-A', false),
        ('11-B', false),
        ('11-C', false),
        ('11-D', false),
        ('11-E', false),
        ('11-F', false),

        ('12-A', false),
        ('12-B', false),
        ('12-C', false),
        ('12-D', false),
        ('12-E', false),
        ('12-F', false),

        ('20-B', false),
        ('20-C', false),
        ('20-D', false),
        ('20-E', false),

        ('21-A', false),
        ('21-B', false),
        ('21-C', false),
        ('21-D', false),
        ('21-E', false),
        ('21-F', false),

        ('22-A', false),
        ('22-B', false),
        ('22-C', false),
        ('22-D', false),
        ('22-E', false),
        ('22-F', false),

        ('23-A', false),
        ('23-B', false),
        ('23-C', false),
        ('23-D', false),
        ('23-E', false),
        ('23-F', false),

        ('24-A', false),
        ('24-B', false),
        ('24-C', false),
        ('24-D', false),
        ('24-E', false),
        ('24-F', false),

        ('25-A', false),
        ('25-B', false),
        ('25-C', false),
        ('25-D', false),
        ('25-E', false),
        ('25-F', false),

        ('26-A', false),
        ('26-B', false),
        ('26-C', false),
        ('26-D', false),
        ('26-E', false),
        ('26-F', false),

        ('27-A', false),
        ('27-B', false),
        ('27-C', false),
        ('27-D', false),
        ('27-E', false),
        ('27-F', false),

        ('28-A', false),
        ('28-B', false),
        ('28-C', false),
        ('28-D', false),
        ('28-E', false),
        ('28-F', false),

        ('29-A', false),
        ('29-B', false),
        ('29-C', false),
        ('29-D', false),
        ('29-E', false),
        ('29-F', false),

        ('30-A', false),
        ('30-B', false),
        ('30-C', false),
        ('30-D', false),
        ('30-E', false),
        ('30-F', false),

        ('31-A', false),
        ('31-B', false),
        ('31-C', false),
        ('31-D', false),
        ('31-E', false),
        ('31-F', false),

        ('32-A', false),
        ('32-B', false),
        ('32-C', false),
        ('32-D', false),
        ('32-E', false),
        ('32-F', false);
    END IF;
  END;//
DELIMITER ;
CALL init();