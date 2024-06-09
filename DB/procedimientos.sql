DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ACTUALIZA_LIKES`(IN `id_vivienda_p` INT, IN `id_user_p` VARCHAR(50))
BEGIN
    DECLARE EXISTE INT;
    SET EXISTE=(SELECT COUNT(*) FROM LIKES WHERE ID_USERNAME=id_user_p AND ID_VIVIENDA=id_vivienda_p);
    IF EXISTE > 0 THEN
        DELETE FROM LIKES WHERE ID_USERNAME=id_user_p AND ID_VIVIENDA=id_vivienda_p;
    ELSE
        INSERT INTO LIKES (ID_USERNAME, ID_VIVIENDA) VALUES (id_user_p, id_vivienda_p);
    END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CIERRA_CARRITO`(IN `p_username` VARCHAR(255), IN `p_id_vivienda` INT, IN `p_cantidad` INT)
BEGIN

    -- Obtenemos el stock actual de la vivienda
    DECLARE v_stock INT;
    DECLARE p_contador INT;
    SELECT v.stock INTO v_stock
    FROM viviendas v
    WHERE v.id_vivienda = p_id_vivienda;

	SELECT MAX(CONTADOR) INTO p_contador
	FROM PURCHASE
	WHERE OPERATION_TYPE='VF';
    -- Comprobamos si la cantidad del carrito es menor o igual al stock de la vivienda
    IF p_cantidad <= v_stock THEN
        -- Actualizamos el campo operation_type en la tabla purchase para pasarlo a factura
        UPDATE purchase p
        SET p.operation_type = 'VF', p.vivienda_price=p_cantidad*p.vivienda_price, p.quantity=p_cantidad, p.contador=p_contador+1
        WHERE p.username = p_username
        AND p.id_vivienda = p_id_vivienda
        AND p.operation_type = 'VP';

        -- Descontamos la cantidad del stock en la tabla viviendas
        UPDATE viviendas v
        SET v.stock = v.stock - p_cantidad
        WHERE v.id_vivienda = p_id_vivienda;
    END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ACTUALIZA_CARRITO`(IN `p_id_vivienda` INT, IN `p_username` VARCHAR(255))
BEGIN
    IF NOT EXISTS (SELECT 1 FROM purchase WHERE id_vivienda = p_id_vivienda AND username = p_username and operation_type <>'VF') THEN
        INSERT INTO `purchase`(`id_vivienda`, `vivienda_name`, `id_user`, `username`, `quantity`, `vivienda_price`, `operation_type`) 
        SELECT v.id_vivienda, v.vivienda_name, u.id_user, u.username, 1, v.vivienda_price, 'VP' 
        FROM viviendas v, users u 
        WHERE v.id_vivienda = p_id_vivienda AND u.username = p_username;
    ELSE
        UPDATE purchase
        SET quantity = quantity + 1
        WHERE id_vivienda = p_id_vivienda AND username = p_username AND operation_type='VP';
    END IF;
END$$
DELIMITER ;