<?php
DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `generate_brand_id` () RETURNS VARCHAR(7) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
  DECLARE id INT;
  DECLARE new_id VARCHAR(7); -- Adjust the length based on your requirements
  SET id = 0;

  WHILE id < 100000 DO
    SET id = id + 1;
    SET new_id = CONCAT('BR', LPAD(CAST(id AS CHAR(5)), 5, '0'));

    IF NOT EXISTS (SELECT 1 FROM brand WHERE Brand_id = new_id) THEN
      RETURN new_id;
    END IF;
  END WHILE;

  RETURN NULL;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_card_id` () RETURNS VARCHAR(7) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
  DECLARE id INT;
  DECLARE new_id VARCHAR(7); -- Adjust the length based on your requirements
  SET id = 0;

  WHILE id < 100000 DO
    SET id = id + 1;
    SET new_id = CONCAT('CARD', LPAD(CAST(id AS CHAR(5)), 5, '0'));

    IF NOT EXISTS (SELECT 1 FROM card WHERE Card_id = new_id) THEN
      RETURN new_id;
    END IF;
  END WHILE;

  RETURN NULL;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_category_id` () RETURNS VARCHAR(7) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
  DECLARE id INT;
  DECLARE new_id VARCHAR(7); -- Adjust the length based on your requirements
  SET id = 0;

  WHILE id < 100000 DO
    SET id = id + 1;
    SET new_id = CONCAT('CAT', LPAD(CAST(id AS CHAR(5)), 5, '0'));

    IF NOT EXISTS (SELECT 1 FROM category WHERE Category_id = new_id) THEN
      RETURN new_id;
    END IF;
  END WHILE;

  RETURN NULL;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_courierassignment_id` () RETURNS VARCHAR(7) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
  DECLARE id INT;
  DECLARE new_id VARCHAR(7);
  SET id = 0;

  WHILE id < 100000 DO
    SET id = id + 1;
    SET new_id = CONCAT('CA', LPAD(CAST(id AS CHAR(5)), 5, '0'));

    IF NOT EXISTS (SELECT 1 FROM courierassignment WHERE Courierassign_id = new_id) THEN
      RETURN new_id;
    END IF;
  END WHILE;

  RETURN NULL;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_courier_id` () RETURNS VARCHAR(7) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
  DECLARE id INT;
  DECLARE new_id VARCHAR(7); -- Adjust the length based on your requirements
  SET id = 0;

  WHILE id < 100000 DO
    SET id = id + 1;
    SET new_id = CONCAT('CR', LPAD(CAST(id AS CHAR(5)), 5, '0'));

    IF NOT EXISTS (SELECT 1 FROM courier WHERE Courier_id = new_id) THEN
      RETURN new_id;
    END IF;
  END WHILE;

  RETURN NULL;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_customer_id` () RETURNS VARCHAR(7) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
  DECLARE id INT;
  DECLARE new_id VARCHAR(7); -- Adjust the length based on your requirements
  SET id = 0;

  WHILE id < 100000 DO
    SET id = id + 1;
    SET new_id = CONCAT('CU', LPAD(CAST(id AS CHAR(5)), 5, '0'));

    IF NOT EXISTS (SELECT 1 FROM customer WHERE Customer_id = new_id) THEN
      RETURN new_id;
    END IF;
  END WHILE;

  RETURN NULL;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_delivery_id` () RETURNS VARCHAR(7) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
  DECLARE id INT;
  DECLARE new_id VARCHAR(7); -- Adjust the length based on your requirements
  SET id = 0;

  WHILE id < 100000 DO
    SET id = id + 1;
    SET new_id = CONCAT('DEL', LPAD(CAST(id AS CHAR(5)), 5, '0'));

    IF NOT EXISTS (SELECT 1 FROM delivery WHERE Delivery_id = new_id) THEN
      RETURN new_id;
    END IF;
  END WHILE;

  RETURN NULL;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_item_id` () RETURNS VARCHAR(7) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
  DECLARE id INT;
  DECLARE new_id VARCHAR(7); -- Adjust the length based on your requirements
  SET id = 0;

  WHILE id < 1000000 DO
    SET id = id + 1;
    SET new_id = CONCAT('ITEM', LPAD(CAST(id AS CHAR(5)), 5, '0'));

    IF NOT EXISTS (SELECT 1 FROM item WHERE Item_id = new_id) THEN
      RETURN new_id;
    END IF;
  END WHILE;

  RETURN NULL;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_message_id` () RETURNS VARCHAR(7) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
  DECLARE id INT;
  DECLARE new_id VARCHAR(7); -- Adjust the length based on your requirements
  SET id = 0;

  WHILE id < 1000000 DO -- Adjust the upper limit if needed
    SET id = id + 1;
    SET new_id = CONCAT('MSG', LPAD(CAST(id AS CHAR(5)), 5, '0'));

    IF NOT EXISTS (SELECT 1 FROM message WHERE msg_id = new_id) THEN
      RETURN new_id;
    END IF;
  END WHILE;

  RETURN NULL;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_payment_id` () RETURNS VARCHAR(7) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
  DECLARE id INT;
  DECLARE new_id VARCHAR(7); -- Adjust the length based on your requirements
  SET id = 0;

  WHILE id < 100000 DO
    SET id = id + 1;
    SET new_id = CONCAT('PAY', LPAD(CAST(id AS CHAR(5)), 5, '0'));

    IF NOT EXISTS (SELECT 1 FROM payment WHERE Payment_id = new_id) THEN
      RETURN new_id;
    END IF;
  END WHILE;

  RETURN NULL;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_staff_id` () RETURNS VARCHAR(7) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
  DECLARE id INT;
  DECLARE new_id VARCHAR(7); -- Adjust the length based on your requirements
  SET id = 0;

  WHILE id < 100000 DO
    SET id = id + 1;
    SET new_id = CONCAT('ST', LPAD(CAST(id AS CHAR(5)), 5, '0'));

    IF NOT EXISTS (SELECT 1 FROM staff WHERE Staff_id = new_id) THEN
      RETURN new_id;
    END IF;
  END WHILE;

  RETURN NULL;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_subcategory_id` () RETURNS VARCHAR(7) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
  DECLARE id INT;
  DECLARE new_id VARCHAR(7); -- Adjust the length based on your requirements
  SET id = 0;

  WHILE id < 100000 DO
    SET id = id + 1;
    SET new_id = CONCAT('SCAT', LPAD(CAST(id AS CHAR(5)), 5, '0'));

    IF NOT EXISTS (SELECT 1 FROM subcategory WHERE Subcategory_id = new_id) THEN
      RETURN new_id;
    END IF;
  END WHILE;

  RETURN NULL;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_vendor_id` () RETURNS VARCHAR(7) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
  DECLARE id INT;
  DECLARE new_id VARCHAR(7); -- Adjust the length based on your requirements
  SET id = 0;

  WHILE id < 100000 DO
    SET id = id + 1;
    SET new_id = CONCAT('VN', LPAD(CAST(id AS CHAR(5)), 5, '0'));

    IF NOT EXISTS (SELECT 1 FROM vendor WHERE Vendor_id = new_id) THEN
      RETURN new_id;
    END IF;
  END WHILE;

  RETURN NULL;
END$$

DELIMITER ;
?>