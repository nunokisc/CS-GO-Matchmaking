-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 23-Nov-2017 às 22:47
-- Versão do servidor: 5.5.57-0+deb8u1
-- PHP Version: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `matchmaking`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`matchmaking`@`%` PROCEDURE `dispacherQueue`(OUT retorno varchar(256))
BEGIN
	DECLARE done INT DEFAULT 0;
    DECLARE aux1,aux2,aux3,aux4,aux5,aux6,aux7,aux8,aux9,aux10,aux11 INT DEFAULT 0;
    DECLARE lobby1,lobby2,lobby3,lobby4,lobby5,lobby6,lobby7,lobby8,lobby9,lobby10,lobby11 INT DEFAULT 0;
    DECLARE player1,player2,player3,player4,player5,player6,player7,player8,player9,player10 INT DEFAULT 0;
	DECLARE elo_s double DEFAULT 0;
    DECLARE userid_r double DEFAULT 0;
	DECLARE elo_min DOUBLE DEFAULT 0;
    DECLARE elo_max DOUBLE DEFAULT 2000;
	DECLARE cur CURSOR FOR SELECT elo FROM queue;
    DECLARE cur1 CURSOR FOR SELECT userid FROM queue WHERE elo > 0 AND elo < 200 LIMIT 10;
    DECLARE cur2 CURSOR FOR SELECT userid FROM queue WHERE elo >= 200  AND elo < 400 LIMIT 10;
    DECLARE cur3 CURSOR FOR SELECT userid FROM queue WHERE elo >= 400  AND elo < 600 LIMIT 10;
    DECLARE cur4 CURSOR FOR SELECT userid FROM queue WHERE elo >= 600  AND elo < 800 LIMIT 10;
    DECLARE cur5 CURSOR FOR SELECT userid FROM queue WHERE elo >= 800  AND elo < 1000 LIMIT 10;
    DECLARE cur6 CURSOR FOR SELECT userid FROM queue WHERE elo >= 1000  AND elo < 1200 LIMIT 10;
    DECLARE cur7 CURSOR FOR SELECT userid FROM queue WHERE elo >= 1200  AND elo < 1400 LIMIT 10;
    DECLARE cur8 CURSOR FOR SELECT userid FROM queue WHERE elo >= 1400  AND elo < 1600 LIMIT 10;
    DECLARE cur9 CURSOR FOR SELECT userid FROM queue WHERE elo >= 1600  AND elo < 1800 LIMIT 10;
    DECLARE cur10 CURSOR FOR SELECT userid FROM queue WHERE elo >= 1800  AND elo < 2000 LIMIT 10;
    DECLARE cur11 CURSOR FOR SELECT userid FROM queue WHERE elo >= 2000  LIMIT 10;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

			  OPEN cur;
			  
			  REPEAT
				FETCH cur INTO elo_s;
				IF NOT done THEN
				   IF (aux1 <= 10 and aux2 <= 10 and aux3 <= 10 and aux4 <= 10 and aux5 <= 10 and aux6 <= 10 
				   and aux7 <= 10 and aux8 <= 10 and aux9 <= 10 and aux10 <= 10 and aux11 <= 10) THEN
						IF elo_s > 0 AND elo_s < 200 THEN
							SET aux1 = aux1 + 1;
						ELSEIF elo_s >= 200 AND elo_s < 400 THEN
							SET aux2 = aux2 + 1;
						ELSEIF elo_s >= 400 AND elo_s < 600 THEN
							SET aux3 = aux3 + 1;
						ELSEIF elo_s >= 600 AND elo_s < 800 THEN
							SET aux4 = aux4 + 1;
						ELSEIF elo_s >= 800 AND elo_s < 1000 THEN
							SET aux5 = aux5 + 1;
						ELSEIF elo_s >= 1000 AND elo_s < 1200 THEN
							SET aux6 = aux6 + 1;
						ELSEIF elo_s >= 1200 AND elo_s < 1400 THEN
							SET aux7 = aux7 + 1;	
						ELSEIF elo_s >= 1400 AND elo_s < 1600 THEN
							SET aux8 = aux8 + 1;
						ELSEIF elo_s >= 1600 AND elo_s < 1800 THEN
							SET aux9 = aux9 + 1;
						ELSEIF elo_s >= 1800 AND elo_s < 2000 THEN
							SET aux10 = aux10 + 1;
						ELSEIF elo_s >= 2000 THEN
							SET aux11 = aux11 + 1;
						END IF;
                        
                        ELSE
						 SET done=1;
                        
					END IF;
				END IF;
			  UNTIL done END REPEAT;
              CLOSE cur;
              
				 -- SELECT aux1,aux2,aux3,aux4,aux5,aux6,aux7,aux8,aux9,aux10,aux11;
                 
                SET done = 0;
                
                if aux1 = 10 THEN
					OPEN cur1;
			  
						REPEAT
							FETCH cur1 INTO userid_r;
								IF NOT done THEN
									IF aux1 = 10 THEN
										SET player1 = userid_r;    
                                        SET aux1 = aux1 -1;
									ELSEIF aux1 = 9 THEN 
										SET player2 = userid_r;
                                        SET aux1 = aux1 -1;
									ELSEIF aux1 = 8 THEN 
										SET player3 = userid_r;
                                        SET aux1 = aux1 -1;
									ELSEIF aux1 = 7 THEN 
										SET player4 = userid_r;					
                                        SET aux1 = aux1 -1;
									ELSEIF aux1 = 6 THEN 
										SET player5 = userid_r;
                                        SET aux1 = aux1 -1;
									ELSEIF aux1 = 5 THEN 
										SET player6 = userid_r;                                        
                                        SET aux1 = aux1 -1;
									ELSEIF aux1 = 4 THEN 
										SET player7 = userid_r;					
                                        SET aux1 = aux1 -1;
									ELSEIF aux1 = 3 THEN 
										SET player8 = userid_r;                                        
                                        SET aux1 = aux1 -1;
									ELSEIF aux1 = 2 THEN 
										SET player9 = userid_r;                                        
                                        SET aux1 = aux1 -1;
									ELSEIF aux1 = 1 THEN 
										SET player10 = userid_r;
                                    END IF;
								END IF;
							UNTIL done END REPEAT;
                            
					CLOSE cur1;
                    
                    DELETE FROM queue WHERE userid = player1;
                    DELETE FROM queue WHERE userid = player2;
                    DELETE FROM queue WHERE userid = player3;
                    DELETE FROM queue WHERE userid = player4;
                    DELETE FROM queue WHERE userid = player5;
                    DELETE FROM queue WHERE userid = player6;
                    DELETE FROM queue WHERE userid = player7;
                    DELETE FROM queue WHERE userid = player8;
                    DELETE FROM queue WHERE userid = player9;
                    DELETE FROM queue WHERE userid = player10;
                    -- SELECT player1,player2,player3,player4,player5,player6,player7,player8,player9,player10;
						INSERT INTO lobby (owner, name, type, players, p1User,p2User,p3User,p4User,p5User,p6User,p7User,p8User,p9User,p10User, active, createAt) 
							VALUES (1,CONCAT('lobby #',FLOOR(RAND() * 100000)),'5on5',10,player1,player2,player3,player4,player5,player6,player7,player8,player9,player10,'1',NOW());
						SET lobby1 =  LAST_insert_id();
                END IF;
                
					SET done = 0;
                    
				if aux2 = 10 THEN
					OPEN cur2;
			  
						REPEAT
							FETCH cur2 INTO userid_r;
								IF NOT done THEN
									IF aux2 = 10 THEN
										SET player1 = userid_r;
                                        SET aux2 = aux2 -1;
									ELSEIF aux2 = 9 THEN 
										SET player2 = userid_r;
                                        SET aux2 = aux2 -1;
									ELSEIF aux2 = 8 THEN 
										SET player3 = userid_r;
                                        SET aux2 = aux2 -1;
									ELSEIF aux2 = 7 THEN 
										SET player4 = userid_r;
                                        SET aux2 = aux2 -1;
									ELSEIF aux2 = 6 THEN 
										SET player5 = userid_r;
                                        SET aux2 = aux2 -1;
									ELSEIF aux2 = 5 THEN 
										SET player6 = userid_r;
                                        SET aux2 = aux2 -1;
									ELSEIF aux2 = 4 THEN 
										SET player7 = userid_r;
                                        SET aux2 = aux2 -1;
									ELSEIF aux2 = 3 THEN 
										SET player8 = userid_r;
                                        SET aux2 = aux2 -1;
									ELSEIF aux2 = 2 THEN 
										SET player9 = userid_r;
                                        SET aux2 = aux2 -1;
									ELSEIF aux2 = 1 THEN 
										SET player10 = userid_r;
                                    END IF;
								END IF;
							UNTIL done END REPEAT;
                            
					CLOSE cur2;
                    
                    DELETE FROM queue WHERE userid = player1;
                    DELETE FROM queue WHERE userid = player2;
                    DELETE FROM queue WHERE userid = player3;
                    DELETE FROM queue WHERE userid = player4;
                    DELETE FROM queue WHERE userid = player5;
                    DELETE FROM queue WHERE userid = player6;
                    DELETE FROM queue WHERE userid = player7;
                    DELETE FROM queue WHERE userid = player8;
                    DELETE FROM queue WHERE userid = player9;
                    DELETE FROM queue WHERE userid = player10;
                     -- SELECT player1,player2,player3,player4,player5,player6,player7,player8,player9,player10;
						INSERT INTO lobby (owner, name, type, players, p1User,p2User,p3User,p4User,p5User,p6User,p7User,p8User,p9User,p10User, active, createAt) 
							VALUES (1,CONCAT('lobby #',FLOOR(RAND() * 100000)),'5on5',10,player1,player2,player3,player4,player5,player6,player7,player8,player9,player10,'1',NOW());
						SET lobby2 =  LAST_insert_id();
				END IF;
                
					SET done = 0;
                
				if aux3 = 10 THEN
					OPEN cur3;
			  
						REPEAT
							FETCH cur3 INTO userid_r;
								IF NOT done THEN
									IF aux3 = 10 THEN
										SET player1 = userid_r;
                                        SET aux3 = aux3 -1;
									ELSEIF aux3 = 9 THEN 
										SET player2 = userid_r;
                                        SET aux3 = aux3 -1;
									ELSEIF aux3 = 8 THEN 
										SET player3 = userid_r;
                                        SET aux3 = aux3 -1;
									ELSEIF aux3 = 7 THEN 
										SET player4 = userid_r;
                                        SET aux3 = aux3 -1;
									ELSEIF aux3 = 6 THEN 
										SET player5 = userid_r;
                                        SET aux3 = aux3 -1;
									ELSEIF aux3 = 5 THEN 
										SET player6 = userid_r;
                                        SET aux3 = aux3 -1;
									ELSEIF aux3 = 4 THEN 
										SET player7 = userid_r;
                                        SET aux3 = aux3 -1;
									ELSEIF aux3 = 3 THEN 
										SET player8 = userid_r;
                                        SET aux3 = aux3 -1;
									ELSEIF aux3 = 2 THEN 
										SET player9 = userid_r;
                                        SET aux3 = aux3 -1;
									ELSEIF aux3 = 1 THEN 
										SET player10 = userid_r;
                                    END IF;
								END IF;
							UNTIL done END REPEAT;
                            
					CLOSE cur3;
                    
                    DELETE FROM queue WHERE userid = player1;
                    DELETE FROM queue WHERE userid = player2;
                    DELETE FROM queue WHERE userid = player3;
                    DELETE FROM queue WHERE userid = player4;
                    DELETE FROM queue WHERE userid = player5;
                    DELETE FROM queue WHERE userid = player6;
                    DELETE FROM queue WHERE userid = player7;
                    DELETE FROM queue WHERE userid = player8;
                    DELETE FROM queue WHERE userid = player9;
                    DELETE FROM queue WHERE userid = player10;
                    --  SELECT player1,player2,player3,player4,player5,player6,player7,player8,player9,player10;
                     INSERT INTO lobby (owner, name, type, players, p1User,p2User,p3User,p4User,p5User,p6User,p7User,p8User,p9User,p10User, active, createAt) 
							VALUES (1,CONCAT('lobby #',FLOOR(RAND() * 100000)),'5on5',10,player1,player2,player3,player4,player5,player6,player7,player8,player9,player10,'1',NOW());
						SET lobby3 =  LAST_insert_id();
                END IF;
                
					SET done = 0;
                    
                if aux4 = 10 THEN
					OPEN cur4;
			  
						REPEAT
							FETCH cur4 INTO userid_r;
								IF NOT done THEN
									IF aux4 = 10 THEN
										SET player1 = userid_r;
                                        SET aux4 = aux4 -1;
									ELSEIF aux4 = 9 THEN 
										SET player2 = userid_r;
                                        SET aux4 = aux4 -1;
									ELSEIF aux4 = 8 THEN 
										SET player3 = userid_r;
                                        SET aux4 = aux4 -1;
									ELSEIF aux4 = 7 THEN 
										SET player4 = userid_r;
                                        SET aux4 = aux4 -1;
									ELSEIF aux4 = 6 THEN 
										SET player5 = userid_r;
                                        SET aux4 = aux4 -1;
									ELSEIF aux4 = 5 THEN 
										SET player6 = userid_r;
                                        SET aux4 = aux4 -1;
									ELSEIF aux4 = 4 THEN 
										SET player7 = userid_r;
                                        SET aux4 = aux4 -1;
									ELSEIF aux4 = 3 THEN 
										SET player8 = userid_r;
                                        SET aux4 = aux4 -1;
									ELSEIF aux4 = 2 THEN 
										SET player9 = userid_r;
                                        SET aux4 = aux4 -1;
									ELSEIF aux4 = 1 THEN 
										SET player10 = userid_r;
                                    END IF;
								END IF;
							UNTIL done END REPEAT;
                            
					CLOSE cur4;
                    
                    DELETE FROM queue WHERE userid = player1;
                    DELETE FROM queue WHERE userid = player2;
                    DELETE FROM queue WHERE userid = player3;
                    DELETE FROM queue WHERE userid = player4;
                    DELETE FROM queue WHERE userid = player5;
                    DELETE FROM queue WHERE userid = player6;
                    DELETE FROM queue WHERE userid = player7;
                    DELETE FROM queue WHERE userid = player8;
                    DELETE FROM queue WHERE userid = player9;
                    DELETE FROM queue WHERE userid = player10;
                    --  SELECT player1,player2,player3,player4,player5,player6,player7,player8,player9,player10;
                     INSERT INTO lobby (owner, name, type, players, p1User,p2User,p3User,p4User,p5User,p6User,p7User,p8User,p9User,p10User, active, createAt) 
							VALUES (1,CONCAT('lobby #',FLOOR(RAND() * 100000)),'5on5',10,player1,player2,player3,player4,player5,player6,player7,player8,player9,player10,'1',NOW());
						SET lobby4 =  LAST_insert_id();
                END IF;
					
                    SET done = 0;
                    
                if aux5 = 10 THEN
					OPEN cur5;
			  
						REPEAT
							FETCH cur5 INTO userid_r;
								IF NOT done THEN
									IF aux5 = 10 THEN
										SET player1 = userid_r;
                                        SET aux5 = aux5 -1;
									ELSEIF aux5 = 9 THEN 
										SET player2 = userid_r;
                                        SET aux5 = aux5 -1;
									ELSEIF aux5 = 8 THEN 
										SET player3 = userid_r;
                                        SET aux5 = aux5 -1;
									ELSEIF aux5 = 7 THEN 
										SET player4 = userid_r;
                                        SET aux5 = aux5 -1;
									ELSEIF aux5 = 6 THEN 
										SET player5 = userid_r;
                                        SET aux5 = aux5 -1;
									ELSEIF aux5 = 5 THEN 
										SET player6 = userid_r;
                                        SET aux5 = aux5 -1;
									ELSEIF aux5 = 4 THEN 
										SET player7 = userid_r;
                                        SET aux5 = aux5 -1;
									ELSEIF aux5 = 3 THEN 
										SET player8 = userid_r;
                                        SET aux5 = aux5 -1;
									ELSEIF aux5 = 2 THEN 
										SET player9 = userid_r;
                                        SET aux5 = aux5 -1;
									ELSEIF aux5 = 1 THEN 
										SET player10 = userid_r;
                                    END IF;
								END IF;
							UNTIL done END REPEAT;
                            
					CLOSE cur5;
                    
                    DELETE FROM queue WHERE userid = player1;
                    DELETE FROM queue WHERE userid = player2;
                    DELETE FROM queue WHERE userid = player3;
                    DELETE FROM queue WHERE userid = player4;
                    DELETE FROM queue WHERE userid = player5;
                    DELETE FROM queue WHERE userid = player6;
                    DELETE FROM queue WHERE userid = player7;
                    DELETE FROM queue WHERE userid = player8;
                    DELETE FROM queue WHERE userid = player9;
                    DELETE FROM queue WHERE userid = player10;
                    -- SELECT player1,player2,player3,player4,player5,player6,player7,player8,player9,player10;
                     INSERT INTO lobby (owner, name, type, players, p1User,p2User,p3User,p4User,p5User,p6User,p7User,p8User,p9User,p10User, active, createAt) 
							VALUES (1,CONCAT('lobby #',FLOOR(RAND() * 100000)),'5on5',10,player1,player2,player3,player4,player5,player6,player7,player8,player9,player10,'1',NOW());
						SET lobby5 =  LAST_insert_id();
				END IF;
                
					SET done = 0;
                
                if aux6 = 10 THEN
					OPEN cur6;
			  
						REPEAT
							FETCH cur6 INTO userid_r;
								IF NOT done THEN
									IF aux6 = 10 THEN
										SET player1 = userid_r;
                                        SET aux6 = aux6 -1;
									ELSEIF aux6 = 9 THEN 
										SET player2 = userid_r;
                                        SET aux6 = aux6 -1;
									ELSEIF aux6 = 8 THEN 
										SET player3 = userid_r;
                                        SET aux6 = aux6 -1;
									ELSEIF aux6 = 7 THEN 
										SET player4 = userid_r;
                                        SET aux6 = aux6 -1;
									ELSEIF aux6 = 6 THEN 
										SET player5 = userid_r;
                                        SET aux6 = aux6 -1;
									ELSEIF aux6 = 5 THEN 
										SET player6 = userid_r;
                                        SET aux6 = aux6 -1;
									ELSEIF aux6 = 4 THEN 
										SET player7 = userid_r;
                                        SET aux6 = aux6 -1;
									ELSEIF aux6 = 3 THEN 
										SET player8 = userid_r;
                                        SET aux6 = aux6 -1;
									ELSEIF aux6 = 2 THEN 
										SET player9 = userid_r;
                                        SET aux6 = aux6 -1;
									ELSEIF aux6 = 1 THEN 
										SET player10 = userid_r;
                                    END IF;
								END IF;
							UNTIL done END REPEAT;
                            
					CLOSE cur6;
                    
                    DELETE FROM queue WHERE userid = player1;
                    DELETE FROM queue WHERE userid = player2;
                    DELETE FROM queue WHERE userid = player3;
                    DELETE FROM queue WHERE userid = player4;
                    DELETE FROM queue WHERE userid = player5;
                    DELETE FROM queue WHERE userid = player6;
                    DELETE FROM queue WHERE userid = player7;
                    DELETE FROM queue WHERE userid = player8;
                    DELETE FROM queue WHERE userid = player9;
                    DELETE FROM queue WHERE userid = player10;
                    -- SELECT player1,player2,player3,player4,player5,player6,player7,player8,player9,player10;
                     INSERT INTO lobby (owner, name, type, players, p1User,p2User,p3User,p4User,p5User,p6User,p7User,p8User,p9User,p10User, active, createAt) 
							VALUES (1,CONCAT('lobby #',FLOOR(RAND() * 100000)),'5on5',10,player1,player2,player3,player4,player5,player6,player7,player8,player9,player10,'1',NOW());
						SET lobby6 =  LAST_insert_id();
                END IF;
                
					SET done = 0;
                
                if aux7 = 10 THEN
					OPEN cur7;
			  
						REPEAT
							FETCH cur7 INTO userid_r;
								IF NOT done THEN
									IF aux7 = 10 THEN
										SET player1 = userid_r;
                                        SET aux7 = aux7 -1;
									ELSEIF aux7 = 9 THEN 
										SET player2 = userid_r;
                                        SET aux7 = aux7 -1;
									ELSEIF aux7 = 8 THEN 
										SET player3 = userid_r;
                                        SET aux7 = aux7 -1;
									ELSEIF aux7 = 7 THEN 
										SET player4 = userid_r;
                                        SET aux7 = aux7 -1;
									ELSEIF aux7 = 6 THEN 
										SET player5 = userid_r;
                                        SET aux7 = aux7 -1;
									ELSEIF aux7 = 5 THEN 
										SET player6 = userid_r;
                                        SET aux7 = aux7 -1;
									ELSEIF aux7 = 4 THEN 
										SET player7 = userid_r;
                                        SET aux7 = aux7 -1;
									ELSEIF aux7 = 3 THEN 
										SET player8 = userid_r;
                                        SET aux7 = aux7 -1;
									ELSEIF aux7 = 2 THEN 
										SET player9 = userid_r;
                                        SET aux7 = aux7 -1;
									ELSEIF aux7 = 1 THEN 
										SET player10 = userid_r;
                                    END IF;
								END IF;
							UNTIL done END REPEAT;
                            
					CLOSE cur7;
                    
                    DELETE FROM queue WHERE userid = player1;
                    DELETE FROM queue WHERE userid = player2;
                    DELETE FROM queue WHERE userid = player3;
                    DELETE FROM queue WHERE userid = player4;
                    DELETE FROM queue WHERE userid = player5;
                    DELETE FROM queue WHERE userid = player6;
                    DELETE FROM queue WHERE userid = player7;
                    DELETE FROM queue WHERE userid = player8;
                    DELETE FROM queue WHERE userid = player9;
                    DELETE FROM queue WHERE userid = player10;
                    -- SELECT player1,player2,player3,player4,player5,player6,player7,player8,player9,player10;
                     INSERT INTO lobby (owner, name, type, players, p1User,p2User,p3User,p4User,p5User,p6User,p7User,p8User,p9User,p10User, active, createAt) 
							VALUES (1,CONCAT('lobby #',FLOOR(RAND() * 100000)),'5on5',10,player1,player2,player3,player4,player5,player6,player7,player8,player9,player10,'1',NOW());
						SET lobby7 =  LAST_insert_id();
                END IF;
                
					SET done = 0;
                
                if aux8 = 10 THEN
					OPEN cur8;
			  
						REPEAT
							FETCH cur8 INTO userid_r;
								IF NOT done THEN
									IF aux8 = 10 THEN
										SET player1 = userid_r;
                                        SET aux8 = aux8 -1;
									ELSEIF aux8 = 9 THEN 
										SET player2 = userid_r;
                                        SET aux8 = aux8 -1;
									ELSEIF aux8 = 8 THEN 
										SET player3 = userid_r;
                                        SET aux8 = aux8 -1;
									ELSEIF aux8 = 7 THEN 
										SET player4 = userid_r;
                                        SET aux8 = aux8 -1;
									ELSEIF aux8 = 6 THEN 
										SET player5 = userid_r;
                                        SET aux8 = aux8 -1;
									ELSEIF aux8 = 5 THEN 
										SET player6 = userid_r;
                                        SET aux8 = aux8 -1;
									ELSEIF aux8 = 4 THEN 
										SET player7 = userid_r;
                                        SET aux8 = aux8 -1;
									ELSEIF aux8 = 3 THEN 
										SET player8 = userid_r;
                                        SET aux8 = aux8 -1;
									ELSEIF aux8 = 2 THEN 
										SET player9 = userid_r;
                                        SET aux8 = aux8 -1;
									ELSEIF aux8 = 1 THEN 
										SET player10 = userid_r;
                                    END IF;
								END IF;
							UNTIL done END REPEAT;
                            
					CLOSE cur8;
                    
                    DELETE FROM queue WHERE userid = player1;
                    DELETE FROM queue WHERE userid = player2;
                    DELETE FROM queue WHERE userid = player3;
                    DELETE FROM queue WHERE userid = player4;
                    DELETE FROM queue WHERE userid = player5;
                    DELETE FROM queue WHERE userid = player6;
                    DELETE FROM queue WHERE userid = player7;
                    DELETE FROM queue WHERE userid = player8;
                    DELETE FROM queue WHERE userid = player9;
                    DELETE FROM queue WHERE userid = player10;
                    -- SELECT player1,player2,player3,player4,player5,player6,player7,player8,player9,player10;
                     INSERT INTO lobby (owner, name, type, players, p1User,p2User,p3User,p4User,p5User,p6User,p7User,p8User,p9User,p10User, active, createAt) 
							VALUES (1,CONCAT('lobby #',FLOOR(RAND() * 100000)),'5on5',10,player1,player2,player3,player4,player5,player6,player7,player8,player9,player10,'1',NOW());
						SET lobby8 =  LAST_insert_id();
                END IF;
                
					SET done = 0;
                
				if aux9 = 10 THEN
					OPEN cur9;
			  
						REPEAT
							FETCH cur9 INTO userid_r;
								IF NOT done THEN
									IF aux9 = 10 THEN
										SET player1 = userid_r;
                                        SET aux9 = aux9 -1;
									ELSEIF aux9 = 9 THEN 
										SET player2 = userid_r;
                                        SET aux9 = aux9 -1;
									ELSEIF aux9 = 8 THEN 
										SET player3 = userid_r;
                                        SET aux9 = aux9 -1;
									ELSEIF aux9 = 7 THEN 
										SET player4 = userid_r;
                                        SET aux9 = aux9 -1;
									ELSEIF aux9 = 6 THEN 
										SET player5 = userid_r;
                                        SET aux9 = aux9 -1;
									ELSEIF aux9 = 5 THEN 
										SET player6 = userid_r;
                                        SET aux9 = aux9 -1;
									ELSEIF aux9 = 4 THEN 
										SET player7 = userid_r;
                                        SET aux9 = aux9 -1;
									ELSEIF aux9 = 3 THEN 
										SET player8 = userid_r;
                                        SET aux9 = aux9 -1;
									ELSEIF aux9 = 2 THEN 
										SET player9 = userid_r;
                                        SET aux9 = aux9 -1;
									ELSEIF aux9 = 1 THEN 
										SET player10 = userid_r;
                                    END IF;
								END IF;
							UNTIL done END REPEAT;
                            
					CLOSE cur9;
                    
                    DELETE FROM queue WHERE userid = player1;
                    DELETE FROM queue WHERE userid = player2;
                    DELETE FROM queue WHERE userid = player3;
                    DELETE FROM queue WHERE userid = player4;
                    DELETE FROM queue WHERE userid = player5;
                    DELETE FROM queue WHERE userid = player6;
                    DELETE FROM queue WHERE userid = player7;
                    DELETE FROM queue WHERE userid = player8;
                    DELETE FROM queue WHERE userid = player9;
                    DELETE FROM queue WHERE userid = player10;
                    -- SELECT player1,player2,player3,player4,player5,player6,player7,player8,player9,player10;
                     INSERT INTO lobby (owner, name, type, players, p1User,p2User,p3User,p4User,p5User,p6User,p7User,p8User,p9User,p10User, active, createAt) 
							VALUES (1,CONCAT('lobby #',FLOOR(RAND() * 100000)),'5on5',10,player1,player2,player3,player4,player5,player6,player7,player8,player9,player10,'1',NOW());
						SET lobby9 =  LAST_insert_id();
                END IF;
                
					SET done = 0;
                
				if aux10 = 10 THEN
					OPEN cur10;
			  
						REPEAT
							FETCH cur10 INTO userid_r;
								IF NOT done THEN
									IF aux10 = 10 THEN
										SET player1 = userid_r;
                                        SET aux10 = aux10 -1;
									ELSEIF aux10 = 9 THEN 
										SET player2 = userid_r;
                                        SET aux10 = aux10 -1;
									ELSEIF aux10 = 8 THEN 
										SET player3 = userid_r;
                                        SET aux10 = aux10 -1;
									ELSEIF aux10 = 7 THEN 
										SET player4 = userid_r;
                                        SET aux10 = aux10 -1;
									ELSEIF aux10 = 6 THEN 
										SET player5 = userid_r;
                                        SET aux10 = aux10 -1;
									ELSEIF aux10 = 5 THEN 
										SET player6 = userid_r;
                                        SET aux10 = aux10 -1;
									ELSEIF aux10 = 4 THEN 
										SET player7 = userid_r;
                                        SET aux10 = aux10 -1;
									ELSEIF aux10 = 3 THEN 
										SET player8 = userid_r;
                                        SET aux10 = aux10 -1;
									ELSEIF aux10 = 2 THEN 
										SET player9 = userid_r;
                                        SET aux10 = aux10 -1;
									ELSEIF aux10 = 1 THEN 
										SET player10 = userid_r;
                                    END IF;
								END IF;
							UNTIL done END REPEAT;
                            
					CLOSE cur10;
                    
                    DELETE FROM queue WHERE userid = player1;
                    DELETE FROM queue WHERE userid = player2;
                    DELETE FROM queue WHERE userid = player3;
                    DELETE FROM queue WHERE userid = player4;
                    DELETE FROM queue WHERE userid = player5;
                    DELETE FROM queue WHERE userid = player6;
                    DELETE FROM queue WHERE userid = player7;
                    DELETE FROM queue WHERE userid = player8;
                    DELETE FROM queue WHERE userid = player9;
                    DELETE FROM queue WHERE userid = player10;
                    INSERT INTO lobby (owner, name, type, players, p1User,p2User,p3User,p4User,p5User,p6User,p7User,p8User,p9User,p10User, active, createAt) 
							VALUES (1,CONCAT('lobby #',FLOOR(RAND() * 100000)),'5on5',10,player1,player2,player3,player4,player5,player6,player7,player8,player9,player10,'1',NOW());
						SET lobby10 =  LAST_insert_id();
                END IF;
                
					SET done = 0;
                
                if aux11 = 10 THEN
					OPEN cur11;
			  
						REPEAT
							FETCH cur11 INTO userid_r;
								IF NOT done THEN
									IF aux11 = 10 THEN
										SET player1 = userid_r;
                                        SET aux11 = aux11 -1;
									ELSEIF aux11 = 9 THEN 
										SET player2 = userid_r;
                                        SET aux11 = aux11 -1;
									ELSEIF aux11 = 8 THEN 
										SET player3 = userid_r;
                                        SET aux11 = aux11 -1;
									ELSEIF aux11 = 7 THEN 
										SET player4 = userid_r;
                                        SET aux11 = aux11 -1;
									ELSEIF aux11 = 6 THEN 
										SET player5 = userid_r;
                                        SET aux11 = aux11 -1;
									ELSEIF aux11 = 5 THEN 
										SET player6 = userid_r;
                                        SET aux11 = aux11 -1;
									ELSEIF aux11 = 4 THEN 
										SET player7 = userid_r;
                                        SET aux11 = aux11 -1;
									ELSEIF aux11 = 3 THEN 
										SET player8 = userid_r;
                                        SET aux11 = aux11 -1;
									ELSEIF aux11 = 2 THEN 
										SET player9 = userid_r;
                                        SET aux11 = aux11 -1;
									ELSEIF aux11 = 1 THEN 
										SET player10 = userid_r;
                                    END IF;
								END IF;
							UNTIL done END REPEAT;
                            
					CLOSE cur11;
                    
                    DELETE FROM queue WHERE userid = player1;
                    DELETE FROM queue WHERE userid = player2;
                    DELETE FROM queue WHERE userid = player3;
                    DELETE FROM queue WHERE userid = player4;
                    DELETE FROM queue WHERE userid = player5;
                    DELETE FROM queue WHERE userid = player6;
                    DELETE FROM queue WHERE userid = player7;
                    DELETE FROM queue WHERE userid = player8;
                    DELETE FROM queue WHERE userid = player9;
                    DELETE FROM queue WHERE userid = player10;
                    -- SELECT player1,player2,player3,player4,player5,player6,player7,player8,player9,player10;
                     INSERT INTO lobby (owner, name, type, players, p1User,p2User,p3User,p4User,p5User,p6User,p7User,p8User,p9User,p10User, active, createAt) 
							VALUES (1, CONCAT('lobby #',FLOOR(RAND() * 100000)),'5on5',10,player1,player2,player3,player4,player5,player6,player7,player8,player9,player10,'1',NOW());
						SET lobby11 =  LAST_insert_id();
				END IF;
                
				SET retorno = CONCAT('{ "lobbys": [ { "lobby": "',lobby1,'"}, {"lobby": "',lobby2,'"}, {"lobby": "',lobby3,'"}, {"lobby": "',lobby4,'"}, {"lobby": "',lobby5,'"}, {"lobby": "',lobby6,'"}, {"lobby": "',lobby7,'"}, {"lobby": "',lobby8,'"}, {"lobby": "',lobby9,'"}, {"lobby": "',lobby10,'"}, {"lobby": "',lobby11,'"}]}');
			  
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `get5_stats_maps`
--

CREATE TABLE IF NOT EXISTS `get5_stats_maps` (
  `matchid` int(10) unsigned NOT NULL,
  `mapnumber` smallint(5) unsigned NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `winner` varchar(16) NOT NULL DEFAULT '',
  `mapname` varchar(64) NOT NULL DEFAULT '',
  `team1_score` smallint(5) unsigned NOT NULL DEFAULT '0',
  `team2_score` smallint(5) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `get5_stats_maps`
--

INSERT INTO `get5_stats_maps` (`matchid`, `mapnumber`, `start_time`, `end_time`, `winner`, `mapname`, `team1_score`, `team2_score`) VALUES
(2, 0, '2017-05-10 21:59:38', '2017-05-10 22:45:41', 'team2', 'de_inferno', 3, 16);

-- --------------------------------------------------------

--
-- Estrutura da tabela `get5_stats_matches`
--

CREATE TABLE IF NOT EXISTS `get5_stats_matches` (
`matchid` int(10) unsigned NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `winner` varchar(16) NOT NULL DEFAULT '',
  `series_type` varchar(64) NOT NULL DEFAULT '',
  `team1_name` varchar(64) NOT NULL DEFAULT '',
  `team1_score` smallint(5) unsigned NOT NULL DEFAULT '0',
  `team2_name` varchar(64) NOT NULL DEFAULT '',
  `team2_score` smallint(5) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `get5_stats_matches`
--

INSERT INTO `get5_stats_matches` (`matchid`, `start_time`, `end_time`, `winner`, `series_type`, `team1_name`, `team1_score`, `team2_name`, `team2_score`) VALUES
(2, '2017-05-10 21:53:53', '2017-05-10 22:47:35', 'team2', 'bo1', 'Equipa A', 0, 'Equipa B', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `get5_stats_players`
--

CREATE TABLE IF NOT EXISTS `get5_stats_players` (
  `matchid` int(10) unsigned NOT NULL,
  `mapnumber` smallint(5) unsigned NOT NULL,
  `steamid64` varchar(32) NOT NULL,
  `team` varchar(16) NOT NULL DEFAULT '',
  `rounds_played` smallint(5) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `kills` smallint(5) unsigned NOT NULL,
  `deaths` smallint(5) unsigned NOT NULL,
  `assists` smallint(5) unsigned NOT NULL,
  `flashbang_assists` smallint(5) unsigned NOT NULL,
  `teamkills` smallint(5) unsigned NOT NULL,
  `headshot_kills` smallint(5) unsigned NOT NULL,
  `damage` int(10) unsigned NOT NULL,
  `bomb_plants` smallint(5) unsigned NOT NULL,
  `bomb_defuses` smallint(5) unsigned NOT NULL,
  `v1` smallint(5) unsigned NOT NULL,
  `v2` smallint(5) unsigned NOT NULL,
  `v3` smallint(5) unsigned NOT NULL,
  `v4` smallint(5) unsigned NOT NULL,
  `v5` smallint(5) unsigned NOT NULL,
  `2k` smallint(5) unsigned NOT NULL,
  `3k` smallint(5) unsigned NOT NULL,
  `4k` smallint(5) unsigned NOT NULL,
  `5k` smallint(5) unsigned NOT NULL,
  `firstkill_t` smallint(5) unsigned NOT NULL,
  `firstkill_ct` smallint(5) unsigned NOT NULL,
  `firstdeath_t` smallint(5) unsigned NOT NULL,
  `firstdeath_ct` smallint(5) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `get5_stats_players`
--

INSERT INTO `get5_stats_players` (`matchid`, `mapnumber`, `steamid64`, `team`, `rounds_played`, `name`, `kills`, `deaths`, `assists`, `flashbang_assists`, `teamkills`, `headshot_kills`, `damage`, `bomb_plants`, `bomb_defuses`, `v1`, `v2`, `v3`, `v4`, `v5`, `2k`, `3k`, `4k`, `5k`, `firstkill_t`, `firstkill_ct`, `firstdeath_t`, `firstdeath_ct`) VALUES
(2, 0, '76561197989403375', 'team1', 19, 'diversity[*', 8, 17, 3, 0, 0, 5, 1492, 2, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 2, 0, 4, 0),
(2, 0, '76561198009888969', 'team1', 19, 'ex1ster', 14, 17, 2, 0, 1, 9, 1739, 1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 2, 2, 4, 1),
(2, 0, '76561198025463780', 'team2', 19, 'Shunoo', 14, 10, 4, 0, 0, 3, 1711, 0, 1, 0, 0, 0, 0, 0, 3, 0, 0, 0, 3, 2, 0, 5),
(2, 0, '76561198046285511', 'team2', 19, 'ＤＥＳＩ', 20, 8, 2, 0, 0, 12, 2009, 1, 1, 1, 0, 0, 0, 0, 4, 1, 1, 0, 1, 5, 1, 0),
(2, 0, '76561198067507705', 'team2', 19, 'Á G U A S - A E S T H E T I C', 18, 9, 5, 0, 0, 7, 2181, 0, 1, 0, 1, 0, 0, 0, 4, 2, 0, 0, 0, 1, 1, 2),
(2, 0, '76561198079754928', 'team1', 19, 'DEMON*', 9, 18, 0, 0, 0, 5, 728, 2, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 1, 2, 0, 0),
(2, 0, '76561198097636254', 'team1', 18, 'w i s h []', 6, 18, 3, 1, 0, 2, 905, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 3, 0, 3, 2),
(2, 0, '76561198108473798', 'team2', 19, 'RADEP RattPack301!', 19, 10, 2, 0, 0, 4, 1751, 1, 1, 1, 0, 0, 0, 0, 3, 2, 0, 0, 0, 7, 0, 3),
(2, 0, '76561198134185002', 'team2', 19, '✪ BernasG', 15, 8, 0, 0, 0, 7, 1339, 0, 1, 0, 0, 0, 0, 0, 4, 0, 0, 0, 0, 0, 2, 2),
(2, 0, '76561198168303658', 'team1', 19, 'BiaPa', 8, 17, 2, 0, 0, 3, 991, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 4, 0, 4, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `lobby`
--

CREATE TABLE IF NOT EXISTS `lobby` (
`id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `type` varchar(128) NOT NULL,
  `teamA` varchar(128) NOT NULL DEFAULT 'Equipa A',
  `teamB` varchar(128) NOT NULL DEFAULT 'Equipa B',
  `players` int(11) NOT NULL,
  `p1User` int(128) NOT NULL,
  `p2User` int(128) DEFAULT NULL,
  `p3User` int(128) DEFAULT NULL,
  `p4User` int(128) DEFAULT NULL,
  `p5User` int(128) DEFAULT NULL,
  `p6User` int(128) DEFAULT NULL,
  `p7User` int(128) DEFAULT NULL,
  `p8User` int(128) DEFAULT NULL,
  `p9User` int(128) DEFAULT NULL,
  `p10User` int(128) DEFAULT NULL,
  `server` bigint(20) NOT NULL DEFAULT '2',
  `active` int(1) NOT NULL,
  `createAt` datetime NOT NULL,
  `updateAt` datetime NOT NULL,
  `de_cbble` int(11) NOT NULL DEFAULT '1',
  `de_train` int(11) NOT NULL DEFAULT '1',
  `de_overpass` int(11) NOT NULL DEFAULT '1',
  `de_nuke` int(11) NOT NULL DEFAULT '1',
  `de_inferno` int(11) NOT NULL DEFAULT '1',
  `de_cache` int(11) NOT NULL DEFAULT '1',
  `de_dust2` int(11) NOT NULL DEFAULT '1',
  `de_mirage` int(11) NOT NULL DEFAULT '1',
  `who` int(11) NOT NULL DEFAULT '1',
  `teamBalanced` int(11) NOT NULL DEFAULT '0',
  `archived` int(11) NOT NULL DEFAULT '0',
  `matchId` int(11) NOT NULL,
  `connect` varchar(64) NOT NULL,
  `enable` int(11) NOT NULL DEFAULT '0',
  `timer` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `lobby`
--

INSERT INTO `lobby` (`id`, `owner`, `name`, `type`, `teamA`, `teamB`, `players`, `p1User`, `p2User`, `p3User`, `p4User`, `p5User`, `p6User`, `p7User`, `p8User`, `p9User`, `p10User`, `server`, `active`, `createAt`, `updateAt`, `de_cbble`, `de_train`, `de_overpass`, `de_nuke`, `de_inferno`, `de_cache`, `de_dust2`, `de_mirage`, `who`, `teamBalanced`, `archived`, `matchId`, `connect`, `enable`, `timer`) VALUES
(81, 2, 'test1', '5on5', 'Equipa A', 'Equipa B', 10, 12, 2, 13, 17, 9, 11, 5, 19, 18, 16, 2, 0, '2017-05-10 21:34:15', '2017-05-10 22:49:48', 0, 0, 0, 0, 1, 0, 0, 0, 8, 1, 1, 2, 'connect 185.113.141.5:27113;password pracc', -1, 0),
(82, 1, '084b6fbb10729ed4da8c3d3f5a3ae7c9', '5on5', 'Equipa A', 'Equipa B', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2017-10-11 05:49:02', '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, '', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `lobby_expected_elo`
--

CREATE TABLE IF NOT EXISTS `lobby_expected_elo` (
`id` int(11) NOT NULL,
  `lobbyId` int(11) NOT NULL,
  `p1expected` double NOT NULL,
  `p2expected` double NOT NULL,
  `p3expected` double NOT NULL,
  `p4expected` double NOT NULL,
  `p5expected` double NOT NULL,
  `p6expected` double NOT NULL,
  `p7expected` double NOT NULL,
  `p8expected` double NOT NULL,
  `p9expected` double NOT NULL,
  `p10expected` double NOT NULL,
  `p1elo` double NOT NULL,
  `p2elo` double NOT NULL,
  `p3elo` double NOT NULL,
  `p4elo` double NOT NULL,
  `p5elo` double NOT NULL,
  `p6elo` double NOT NULL,
  `p7elo` double NOT NULL,
  `p8elo` double NOT NULL,
  `p9elo` double NOT NULL,
  `p10elo` double NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `lobby_expected_elo`
--

INSERT INTO `lobby_expected_elo` (`id`, `lobbyId`, `p1expected`, `p2expected`, `p3expected`, `p4expected`, `p5expected`, `p6expected`, `p7expected`, `p8expected`, `p9expected`, `p10expected`, `p1elo`, `p2elo`, `p3elo`, `p4elo`, `p5elo`, `p6elo`, `p7elo`, `p8elo`, `p9elo`, `p10elo`) VALUES
(8, 81, 0.61, 0.61, 0.53, 0.44, 0.32, 0.61, 0.61, 0.44, 0.44, 0.43, 1057.28, 1057.28, 1032.64, 1000, 945.6, 1057.28, 1057.28, 1000, 1000, 996.48);

-- --------------------------------------------------------

--
-- Estrutura da tabela `queue`
--

CREATE TABLE IF NOT EXISTS `queue` (
`id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `elo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servers`
--

CREATE TABLE IF NOT EXISTS `servers` (
`id` bigint(20) NOT NULL,
  `ipPort` varchar(50) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `port` varchar(50) NOT NULL,
  `rcon` varchar(50) NOT NULL,
  `hostname` varchar(100) NOT NULL,
  `tv_ip` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `inUse` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `servers`
--

INSERT INTO `servers` (`id`, `ipPort`, `ip`, `port`, `rcon`, `hostname`, `tv_ip`, `created_at`, `updated_at`, `inUse`) VALUES
(2, '91.121.84.50:27015', '91.121.84.50', '27015', 'dixon', 'Backstabd Server', '', '2017-04-22 15:14:00', '2017-04-22 15:14:00', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `steamid` varchar(128) NOT NULL,
  `elo` double NOT NULL DEFAULT '1000',
  `steamid64` varchar(128) NOT NULL,
  `inQueue` int(11) NOT NULL DEFAULT '0',
  `team` varchar(64) NOT NULL,
  `image` longblob NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `salt`, `password`, `steamid`, `elo`, `steamid64`, `inQueue`, `team`, `image`) VALUES
(1, 'admin', '', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', '0521e128cb583ea876043fabbfa4207c', 'STEAM_1:0:89536082', 969.6, '', 0, 'GATO GALATICO', ''),
(2, 'ex1ster', '', '58e29f8d303dc9bfdddb0c5e3ca805b204eb7433', '6a02bdcd3fa1da617c718969d6630a90', 'STEAM_1:1:24811620', 1037.76, '76561198009888969', 0, '', ''),
(3, 'kisc', '', '9196269bdf120e7fe6631e66efb58762adf0542a', '4f74c285fac266d4375113327c8d934b', 'STEAM_1:0:19834223', 945.6, '76561197999934174', 0, '', ''),
(5, 'rafa121', '', '91bf00e1c5a4f04db076bf99c220145cb78daff5', '77ab9a6b42e25924f39853befb20e348', 'STEAM_1:1:53620988', 1069.76, '76561198067507705', 0, '', ''),
(6, 'plaka', '', '23924227511bf3441899f79ea30878ee4239701c', '4ba33bd529f2e0e86bb401b0ce49e967', 'STEAM_1:0:35431341', 1000, '76561198031128410', 0, '', ''),
(7, 'xande', '', 'd1358cf518442864144d3b0a69d8a202a9608bc5', '88a8b12b4bae2f6a7c2c113c03b3807a', 'STEAM_1:0:68852224', 969.6, '76561198097970176', 0, '', ''),
(9, 'wish', '', '0a914fbffcaf680ab0475f71ad91fad9f6bc65f2', '13c57836c987a304805943bca6b4af0e', 'STEAM_1:0:68685263', 935.36, '76561198097636254', 0, '', ''),
(10, 'BlackJesus', '', '8e921776e51e67ed046953f79b042216a58046ce', '57c88fcb472dd0d878c411ec295cf44b', 'STEAM_1:1:29860610', 969.6, '76561198019986949', 0, '', ''),
(11, 'desire', '', '41a436fc08f2760c2b24a2b294326d62b821975b', 'a08ab2043b3bca86d073b0f5bdca502c', 'STEAM_1:1:43009891', 1069.76, '76561198046285511', 0, '', ''),
(12, 'biapa', '', '74815175eb245d3492c0069ff44a134141bdc5d7', '6b1a790702b088879db254e3bbac1ea7', 'STEAM_1:0:104018965', 1037.76, '76561198168303658', 0, '', ''),
(13, 'diversity', '', '531dc595239866c0347b8770e1f1fb43e995b202', '58f012a75f4dbab36f7781c6fd3aa7e2', 'STEAM_1:1:14568823', 1015.68, '76561197989403375', 0, '', ''),
(14, 'kiazy', '', '72a3b1cfb5a9c873fdf75add60a9bec92fcd200d', '9076376f9d8c1f11bc04bbb99c5ad2c9', 'STEAM_1:1:26795602', 971.2, '76561198013856933', 0, '', ''),
(15, 'migueis', '', 'ebb1a87f50e58cb2855f19da007c36bf02a9a6d0', '56073f12cd165ffab60c447df838299e', 'STEAM_1:0:52733439', 971.2, '76561198065732606', 0, '', ''),
(16, 'shunoo', '', '302956199563efdeb8fc488b5b2d20ba44c3928c', '3d8b863e473ab1ed986964cfd8b74769', 'STEAM_1:0:32599026', 1014.72, '76561198025463780', 0, '', ''),
(17, 'demonpc', '', '31d6929fe5a7424ff436fcf0436c8a7514989fb4', '5482a64b488c1fb670bed460f5bbcd17', 'STEAM_0:0:59744600', 985.92, '76561198079754928', 0, '', ''),
(18, 'radep', '', '69544c97e8c7cd257c31ee457c55a18c6e13cb64', '89f09996bbccf4e3ae98d7efe3b166fa', 'STEAM_0:0:74104035', 1017.92, '76561198108473798', 0, '', ''),
(19, 'bernardoribeiro14', '', '4ceec63a5705d5be2b6c391688745f6970ebbcf8', '9ebb5c59af52d15d50288894b9553677', 'STEAM_0:0:86959637', 1017.92, '76561198134185002', 0, '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `get5_stats_maps`
--
ALTER TABLE `get5_stats_maps`
 ADD PRIMARY KEY (`matchid`,`mapnumber`);

--
-- Indexes for table `get5_stats_matches`
--
ALTER TABLE `get5_stats_matches`
 ADD PRIMARY KEY (`matchid`);

--
-- Indexes for table `get5_stats_players`
--
ALTER TABLE `get5_stats_players`
 ADD PRIMARY KEY (`matchid`,`mapnumber`,`steamid64`);

--
-- Indexes for table `lobby`
--
ALTER TABLE `lobby`
 ADD PRIMARY KEY (`id`), ADD KEY `p2User` (`p2User`), ADD KEY `p3User` (`p3User`), ADD KEY `p4User` (`p4User`), ADD KEY `p5User` (`p5User`), ADD KEY `p6User` (`p6User`), ADD KEY `p7User` (`p7User`), ADD KEY `p8User` (`p8User`), ADD KEY `p9User` (`p9User`), ADD KEY `p10User` (`p10User`), ADD KEY `owner` (`owner`), ADD KEY `server` (`server`), ADD KEY `pUsers` (`p1User`,`p2User`,`p3User`,`p4User`,`p5User`,`p6User`,`p7User`,`p8User`,`p9User`,`p10User`);

--
-- Indexes for table `lobby_expected_elo`
--
ALTER TABLE `lobby_expected_elo`
 ADD PRIMARY KEY (`id`), ADD KEY `lobbyId` (`lobbyId`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servers`
--
ALTER TABLE `servers`
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
-- AUTO_INCREMENT for table `get5_stats_matches`
--
ALTER TABLE `get5_stats_matches`
MODIFY `matchid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `lobby`
--
ALTER TABLE `lobby`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT for table `lobby_expected_elo`
--
ALTER TABLE `lobby_expected_elo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `servers`
--
ALTER TABLE `servers`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `lobby`
--
ALTER TABLE `lobby`
ADD CONSTRAINT `lobby_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `lobby_ibfk_10` FOREIGN KEY (`p9User`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `lobby_ibfk_11` FOREIGN KEY (`p10User`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `lobby_ibfk_12` FOREIGN KEY (`server`) REFERENCES `servers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `lobby_ibfk_2` FOREIGN KEY (`p1User`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `lobby_ibfk_3` FOREIGN KEY (`p2User`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `lobby_ibfk_4` FOREIGN KEY (`p3User`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `lobby_ibfk_5` FOREIGN KEY (`p4User`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `lobby_ibfk_6` FOREIGN KEY (`p5User`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `lobby_ibfk_7` FOREIGN KEY (`p6User`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `lobby_ibfk_8` FOREIGN KEY (`p7User`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `lobby_ibfk_9` FOREIGN KEY (`p8User`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `lobby_expected_elo`
--
ALTER TABLE `lobby_expected_elo`
ADD CONSTRAINT `lobby_expected_elo_ibfk_1` FOREIGN KEY (`lobbyId`) REFERENCES `lobby` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
