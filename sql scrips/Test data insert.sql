set dateformat dmy
	delete from VoorwerpInRubriek
	delete from Bestand
	delete from Bod
	delete from Voorwerp
	delete from Betaalwijze
	delete from Looptijd
	set dateformat dmy

	INSERT INTO Betaalwijze VALUES
('IDEAL'),
('PayPal'),
('Bank/Giro'),
('Contant'),
('Creditcard'),
('Maestro'),
('VISA'), 
('Bankoverschrift');

INSERT INTO Looptijd VALUES
(1),
(3),
(7),
(10);

insert into Voorwerp ([Voorwerpnummer] , [Titel], [Beschrijving], [Startprijs], [Betalingswijze], [Betalingsinstructie], [Plaatsnaam], [Land], [Looptijd], [looptijdbeginmoment], [Verzendkosten], [Verzendinstructies], [Verkoper], [Veilinggesloten])values
	(1,'Dikke Bank','Mooie leren elegante bank',100.00, 'IDEAL', 'geef mij je geld', 'elst', 'Nederland', 1, '26-04-2018 12:00:00.0',50,'stuur maar op', 'Karel de Groot', 0);
insert into Voorwerp ([Voorwerpnummer] , [Titel], [Beschrijving], [Startprijs], [Betalingswijze], [Betalingsinstructie], [Plaatsnaam], [Land], [Looptijd], [looptijdbeginmoment], [Verzendkosten], [Verzendinstructies], [Verkoper], [Veilinggesloten])values
	(2,'Mooie Spiegel','goede spiegel ',50.00,'Creditcard','dag na veiling betalen', 'Nijmegen','Nederland',3,'24-04-2018 16:00:01.0',5,'Hij gaat met de bood mee','Michil de Haan',0 )
insert into Voorwerp ([Voorwerpnummer] , [Titel], [Beschrijving], [Startprijs], [Betalingswijze], [Betalingsinstructie], [Plaatsnaam], [Land], [Looptijd], [looptijdbeginmoment], [Verzendkosten], [Verzendinstructies], [Verkoper], [Veilinggesloten])values	
	(3,'Boot','Boot zonder veel gaten', 500,'IDEAL', 'achterlaten in het park','Johannisburg','Afrika',7,'24-04-2018 12:00:00.0',5,'Ik maak de knoop los en dan drijft hij naar je toe','sinterklaas',0)
insert into Voorwerp ([Voorwerpnummer] , [Titel], [Beschrijving], [Startprijs], [Betalingswijze], [Betalingsinstructie], [Plaatsnaam], [Land], [Looptijd], [looptijdbeginmoment], [Verzendkosten], [Verzendinstructies], [Verkoper], [Veilinggesloten])values
	(4,'Bedden frame','Modern bedden frame',1500, 'PayPal','overschrijven naar een nummer rekening', 'De berg','Zwitserland',3,'18-04-2018 12:00:00.0',50,'Het bed wordt verstuurd met de post','De Operatie kamer',1)
insert into Voorwerp ([Voorwerpnummer] , [Titel], [Beschrijving], [Startprijs], [Betalingswijze], [Betalingsinstructie], [Plaatsnaam], [Land], [Looptijd], [looptijdbeginmoment], [Verzendkosten], [Verzendinstructies], [Verkoper], [Veilinggesloten])values
	(6,'Laptop','Nieuwe laptop bijna niet gebruikt kei veel ram .ram is gedownload', 600, 'Contant', 'Ik kom het geld ophalen', 'het woud','Nederland', 1, '20-04-2018 18:30:00.0',50,'Ik kom hem zelf brengen', 'Da Man',1 )
insert into Voorwerp ([Voorwerpnummer] , [Titel], [Beschrijving], [Startprijs], [Betalingswijze], [Betalingsinstructie], [Plaatsnaam], [Land], [Looptijd], [looptijdbeginmoment], [Verzendkosten], [Verzendinstructies], [Verkoper], [Veilinggesloten])values
	(7,'Nintendo Switch', 'Beleef onderweg dezelfde game-ervaring als thuis, zelfs zonder tv.', 250.00, 'Maestro', 'Na betaling wordt het product verzonden.', 'Zwolle', 'Nederland', 10, '23-4-2018 16:30:00.0', 4.49, NULL, 'HansvanT98', 0)
insert into Voorwerp ([Voorwerpnummer] , [Titel], [Beschrijving], [Startprijs], [Betalingswijze], [Betalingsinstructie], [Plaatsnaam], [Land], [Looptijd], [looptijdbeginmoment], [Verzendkosten], [Verzendinstructies], [Verkoper], [Veilinggesloten])values
	(8,'Contigo Westloop Thermosbeker', 'De Contigo AUTOSEAL® technologie garandeert een 100% mors- en lekvrije drinkervaring door automatisch te sluiten na elke slok.', 20.00, 'IDEAL', 'Na betaling wordt het product verzonden.', 'Groningen', 'Nederland', 3, '21-4-2018 06:23:21.0', 2.99, NULL, 'JanvRaaijs', 0)
insert into Voorwerp ([Voorwerpnummer] , [Titel], [Beschrijving], [Startprijs], [Betalingswijze], [Betalingsinstructie], [Plaatsnaam], [Land], [Looptijd], [looptijdbeginmoment], [Verzendkosten], [Verzendinstructies], [Verkoper], [Veilinggesloten])values		
	(9,'Philips Viva HR2162/90 - Blender - Zwart', 'Met de Philips Viva HR2162 heb je dankzij de krachtige motor van 600 W geen last meer van stukken banaan in je smoothies.', 45.00, 'IDEAL', 'Na betaling wordt het product verzonden.', 'Zierikzee', 'Nederland', 3, '24-4-2018 8:13:46.0', 4.49, NULL, 'IkKanDingenVeilen', 0)
insert into Voorwerp ([Voorwerpnummer] , [Titel], [Beschrijving], [Startprijs], [Betalingswijze], [Betalingsinstructie], [Plaatsnaam], [Land], [Looptijd], [looptijdbeginmoment], [Verzendkosten], [Verzendinstructies], [Verkoper], [Veilinggesloten])values
	(10,'Harley Benton HBO-850NT Akoestische Gitaar', 'Body vorm: roundback met cutaway met een sparren bovenblad.', 75.00, 'IDEAL', 'Na betaling wordt het product verzonden.', 'Amsterdam', 'Nederland', 3, '25-4-2018 23:54:03.0', 6.49, NULL, 'KeesvanBarnel', 0)
insert into Voorwerp ([Voorwerpnummer] , [Titel], [Beschrijving], [Startprijs], [Betalingswijze], [Betalingsinstructie], [Plaatsnaam], [Land], [Looptijd], [looptijdbeginmoment], [Verzendkosten], [Verzendinstructies], [Verkoper], [Veilinggesloten])values	
	(11,'SteelSeries Rival 310', 'De Steelseries Rival 310 gaming muis is de eerste ware gaming muis met een e-sports waardige sensor.', 45.00, 'IDEAL', 'Na betaling wordt het product verzonden.', 'Amsterdam', 'Nederland', 1, '22-4-2018 11:34:39.0', 1.49, NULL, 'EenGebruikersNaam', 0)
insert into Voorwerp ([Voorwerpnummer] , [Titel], [Beschrijving], [Startprijs], [Betalingswijze], [Betalingsinstructie], [Plaatsnaam], [Land], [Looptijd], [looptijdbeginmoment], [Verzendkosten], [Verzendinstructies], [Verkoper], [Veilinggesloten])values	
	(12,'Blauwe damesfiets', 'Deze stijlvolle damesfiets fietst erg prettig', 299.99, 'PayPal', 'zsm overmaken', 'Doetinchem', 'Nederland', 7, '25-04-2018 12:24:00.0', 5.00, 'Plak je postzegels er op', 'henkie123', 0)
insert into Voorwerp ([Voorwerpnummer] , [Titel], [Beschrijving], [Startprijs], [Betalingswijze], [Betalingsinstructie], [Plaatsnaam], [Land], [Looptijd], [looptijdbeginmoment], [Verzendkosten], [Verzendinstructies], [Verkoper], [Veilinggesloten])values
	(13,'Senseo koffieapparaat', 'Heerlijke koffie, alleen links werkt niet', 50.00, 'Bankoverschrift', 'Ik stuur een betaalverzoek', 'Arnhem', 'Nederland', 10, '30-04-2018 12:52:00.0', 0.00, 'Ophalen s.v.p.', 'dennis23', 0)
insert into Voorwerp ([Voorwerpnummer] , [Titel], [Beschrijving], [Startprijs], [Betalingswijze], [Betalingsinstructie], [Plaatsnaam], [Land], [Looptijd], [looptijdbeginmoment], [Verzendkosten], [Verzendinstructies], [Verkoper], [Veilinggesloten])values	
	(14,'Basgitaar', 'Rood, hals van esdoorn', 24.00, 'VISA', '...', 'Ruurlo', 'Nederland', 1, '04-05-2018 13:01:00.0', 10.99, 'Ik verstuur met DHL', 'kattenlover123', 0)
insert into Voorwerp ([Voorwerpnummer] , [Titel], [Beschrijving], [Startprijs], [Betalingswijze], [Betalingsinstructie], [Plaatsnaam], [Land], [Looptijd], [looptijdbeginmoment], [Verzendkosten], [Verzendinstructies], [Verkoper], [Veilinggesloten])values	
	(15,'Vierkante trampoline', '213 x 305 cm, in nieuwstaat', 350.00, 'Bankoverschrift', 'Ik stuur een betaalverzoek', 'PayPal', 'Nederland', 7, '20-05-2018 13:16:00.0', 30.00, 'Ik kom het brengen', 'hallo312', 0)
insert into Voorwerp ([Voorwerpnummer] , [Titel], [Beschrijving], [Startprijs], [Betalingswijze], [Betalingsinstructie], [Plaatsnaam], [Land], [Looptijd], [looptijdbeginmoment], [Verzendkosten], [Verzendinstructies], [Verkoper], [Veilinggesloten])values
	(16,'Jaguar X-Type', '2.5 V6 Automaat, 2003, Groen, 198k Kilometerstand. Projectauto (distributieriem moet vervangen worden)', 3000.50, 'Contant', 'Graag gepast betalen', 'Willemstad', 'Curaçao', 10, '10-05-2018 13:27:00.0', 250, 'Auto moet gesleept worden', 'autogast2', 0)
insert into Voorwerp ([Voorwerpnummer] , [Titel], [Beschrijving], [Startprijs], [Betalingswijze], [Betalingsinstructie], [Plaatsnaam], [Land], [Looptijd], [looptijdbeginmoment], [Verzendkosten], [Verzendinstructies], [Verkoper], [Veilinggesloten])values
	(17,'Born Lucky Rapido Kinderwagen', 'Zwart, wandelwageninzet inbegrepen', 250.00, 'IDEAL', '...', 'Amsterdam',  'Nederland', 3, '05-05-2018 13:38:00.0', 0.00, 'Ophalen s.v.p.', 'kinderwagenverkoper5', 0)

	delete from VoorwerpInRubriek
	insert into VoorwerpInRubriek values	(1,7491);
	insert into VoorwerpInRubriek values	(2,19825);
	insert into VoorwerpInRubriek values	(3,81636);
	insert into VoorwerpInRubriek values	(4,32254);
	insert into VoorwerpInRubriek values	(6,28837);
	insert into VoorwerpInRubriek values	(7,8241);
	insert into VoorwerpInRubriek values	(8,8516);
	insert into VoorwerpInRubriek values	(9,12165);
	insert into VoorwerpInRubriek values	(10,46638);
	insert into VoorwerpInRubriek values	(11,23154);
	insert into VoorwerpInRubriek values	(12,30752);
	insert into VoorwerpInRubriek values	(13,32901);
	insert into VoorwerpInRubriek values	(14,87485);
	insert into VoorwerpInRubriek values	(15,85346);
	insert into VoorwerpInRubriek values	(16,25960);
	insert into VoorwerpInRubriek values	(17,18185);
	insert into VoorwerpInRubriek values	(17,23610);


Insert into Bestand
values	('LerenBank.jpg',1),
		('LerenBank1.jpg',1),
		('kussen.jpg',1),
		('350194099.jpg',2),
		('rubberboot.jpg',3),
		('bed',4),
		('laptop',6),
		('15138796091767.jpg', 7), 
		('9200000052699679.jpg', 8), 
		('2385908236.jpg', 8), 
		('347587236483425.jpg', 9), 
		('9200000010997932.jpg', 9),
		('196793.jpg', 10), 
		('10167916.jpg', 11),
		('16738913455.jpg', 12),
		('1535624582635.jpg', 13),
		('565724760476.jpg', 14),
		('9200000088252680.jpg',15),
		('9200000088252680_10.jpg', 15),
		('HD7865_80-A1P-global-001.jpg', 16),
		('HD7865_80-RTP-global-001.jpg', 16),
		('87287127812.jpg', 17),
		('73272871881.jpg', 17),
		('1010831.png', 17),
		('1010834.png', 17),
		('123897921398732198.JPG',16),
		('12873872178312.JPG', 11),
		('988998897879.JPG', 12),
		('img_0024_medium__1.jpg', 12),
		('img_0003_medium__1.jpg', 13);


INSERT INTO Bod VALUES
	(1, 255.00, 'ZwibberZwabber', '25-4-2018 21:57:13'), 
	(1, 280.00, 'IkBiedMeerDanJij', '26-4-2018 15:26:21'), 
	(1, 300.50, 'RandomUser123', '27-4-2018 09:32:26'), 
	(2, 20.70, 'IkWilKoffieNu', '22-4-2018 16:21:13'), 
	(2, 80.00, 'Slash2point0', '26-4-2018 09:13:22'), 
	(2, 84.50, 'ArnoldDeVeiler', '28-4-2018 14:20:18'), 
	(3, 90.00, 'Slash2point0', '30-4-2018 17:54:09'), 
	(3, 95.00, 'ArnoldDeVeiler', '30-4-2018 18:43:11'), 
	(3, 100.00, 'Slash2point0', '1-5-2018 10:18:14'), 
	(3, 110.00, 'ThisIsMineNow', '1-5-2018 23:30:53'), 
	(4, 50.00, 'xxUltraGamerxx', '23-4-2018 10:02:55'),
	(5, 310.00, 'denneh5', '25-04-2018 13:01:42'),
	(5, 333.00, 'woetroe',  '26-04-2018 06:33:21'), 
	(7, 51.00, 'valliebeer', '01-05-2018 12:42:13'),
	(8, 26.00, 'ibuystuff23', '05-05-2018 14:32:21'),
	(9, 360.00, 'ibuystuff23', '21-05-2018 16:48:21'),
	(9, 380.00, 'ibuymorestuff23', '22-05-2018 22:01:44'),
	(10, 4000.00, 'ikhouvanauto''s2', '06-05-2018 23:59:33');