DROP USER IF EXISTS 'pi'@'localhost';
DROP USER IF EXISTS 'piremote'@'%';
CREATE USER 'pi'@'localhost' IDENTIFIED BY 'raspberry';
CREATE USER 'piremote'@'%' IDENTIFIED BY 'raspberry';
GRANT ALL PRIVILEGES ON pidb.* to 'pi'@'localhost' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON pidb.* to 'piremote'@'%' WITH GRANT OPTION;

