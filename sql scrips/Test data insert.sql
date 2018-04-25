set dateformat dmy

	delete from Bestand
	delete from Bod
	delete from Voorwerp
	delete from VoorwerpInRubriek

insert into Voorwerp
values	(150, 'Dikke Bank','Mooie leren elegante bank',100.00, 'Ideal', 'geef mij je geld', 'elst', 'Nederland', 5, '26-04-2018', '12:00:00',50,'stuur maar op', 'Karel de Groot','' , '29-04-2018', '12:00:00', 0),
		(151, 'Mooie Spiegel','goede spiegel ',50.00,'Creditcard','dag na veiling betalen', 'Nijmegen','Nederland',4,'24-04-2018','16:00:01',5,'Hij gaat met de bood mee','Michil de Haan','','29-04-2018','16:00:01',0 ),
		(152, 'Boot','Boot zonder veel gaten', 500,'Per koffer', 'achterlaten in het park','Johannisburg','Afrika',8,'24-04-2018','12:00:00',5,'Ik maak de knoop los en dan drijft hij naar je toe','sinterklaas', '','30-04-2018','08:00:23',0),
		(153, 'Bedden frame','Modern bedden frame',1500, 'Overschrijving','overschrijven naar een nummer rekening', 'De berg','Zwitserland',6,'18-04-2018', '12:00:00',50,'Het bed wordt verstuurd met de post','De Operatie kamer','','24-04-2018','12:00:00',1),
		(154, 'Laptop','Nieuwe laptop bijna niet gebruikt kei veel ram .ram is gedownload', 600, 'cash betalen', 'Ik kom het geld ophalen', 'het woud','Nederland', 4, '20-04-2018', '18:30:00',50,'Ik kom hem zelf brengen ', 'Da Man','','24-04-2018','08:00:30',1 ),
		(200, 'Nintendo Switch', 'Beleef onderweg dezelfde game-ervaring als thuis, zelfs zonder tv.', 250.00, 'VISA/Mastercard', 'Na betaling wordt het product verzonden.', 'Zwolle', 'Nederland', 7, '23-4-2018', '16:30:00', 4.49, NULL, 'HansvanT98', NULL, '30-4-2018', '16:00', 0), 
		(201, 'Contigo Westloop Thermosbeker', 'De Contigo AUTOSEAL® technologie garandeert een 100% mors- en lekvrije drinkervaring door automatisch te sluiten na elke slok.', 20.00, 'IDEAL', 'Na betaling wordt het product verzonden.', 'Groningen', 'Nederland', 3, '21-4-2018', '06:23:21', 2.99, NULL, 'JanvRaaijs', NULL, '24-4-2018', '6:23:21', 0), 
		(202, 'Philips Viva HR2162/90 - Blender - Zwart', 'Met de Philips Viva HR2162 heb je dankzij de krachtige motor van 600 W geen last meer van stukken banaan in je smoothies.', 45.00, 'IDEAL', 'Na betaling wordt het product verzonden.', 'Zierikzee', 'Nederland', 4, '24-4-2018', '8:13:46', 4.49, NULL, 'IkKanDingenVeilen', NULL, '28-4-2018', '8:13:46', 0),
		(203, 'Harley Benton HBO-850NT Akoestische Gitaar', 'Body vorm: roundback met cutaway met een sparren bovenblad.', 75.00, 'IDEAL', 'Na betaling wordt het product verzonden.', 'Amsterdam', 'Nederland', 6, '25-4-2018', '23:54:03', 6.49, NULL, 'KeesvanBarnel', NULL, '1-5-2018', '23:54:03', 0), 
		(204, 'SteelSeries Rival 310', 'De Steelseries Rival 310 gaming muis is de eerste ware gaming muis met een e-sports waardige sensor.', 45.00, 'IDEAL', 'Na betaling wordt het product verzonden.', 'Amsterdam', 'Nederland', 2, '22-4-2018', '11:34:39', 1.49, NULL, 'EenGebruikersNaam', null, '24-4-2018', '11:34:39', 0),
		(500, 'Blauwe damesfiets', 'Deze stijlvolle damesfiets fietst erg prettig', 299.99, 'Paypal', 'zsm overmaken', 'Doetinchem', 'Nederland', 6, '25-04-2018', '12:24:00', 5.00, 'Plak je postzegels er op', 'henkie123', NULL, '01-05-2018', '12:24:00', 0),
		(501, 'Senseo koffieapparaat', 'Heerlijke koffie, alleen links werkt niet', 50.00, 'Bankoverschrift', 'Ik stuur een betaalverzoek', 'Arnhem', 'Nederland', 9, '30-04-2018', '12:52:00', 0.00, 'Ophalen s.v.p.', 'dennis23', NULL, '09-05-2018', '12:52:00', 0),
		(502, 'Basgitaar', 'Rood, hals van esdoorn', 24.00, 'iDeal', '...', 'Ruurlo', 'Nederland', 2, '04-05-2018', '13:01:00', 10.99, 'Ik verstuur met DHL', 'kattenlover123', NULL, '06-05-2018', '13:01:00', 0),
		(503, 'Vierkante trampoline', '213 x 305 cm, in nieuwstaat', 350.00, 'Bankoverschrift', 'Ik stuur een betaalverzoek', 'Azewijn', 'Nederland', 9, '20-05-2018', '13:16:00', 30.00, 'Ik kom het brengen', 'hallo312', NULL, '29-05-2018', '13:16:00', 0),
		(504, 'Jaguar X-Type', '2.5 V6 Automaat, 2003, Groen, 198k Kilometerstand. Projectauto (distributieriem moet vervangen worden)', 3000.50, 'Contant', 'Graag gepast betalen', 'Willemstad', 'Curaçao', 8, '10-05-2018', '13:27:00', 250, 'Auto moet gesleept worden', 'autogast2', NULL, '18-05-2018', '13:27:00', 0),
		(505, 'Born Lucky Rapido Kinderwagen', 'Zwart, wandelwageninzet inbegrepen', 250.00, 'iDeal', '...', 'Amsterdam',  'Nederland', 2, '05-05-2018', '13:38:00', 0.00, 'Ophalen s.v.p.', 'kinderwagenverkoper5', NULL, '07-05-2018', '13:38:00', 0);

insert into VoorwerpInRubriek
values	(150,7491),
		(151,19825),
		(152,81636),
		(153,32254),
		(154,28837),
		(200, 8241), 
		(201, 8516), 
		(202, 12165), 
		(203, 46638), 
		(204, 23154),
		(500, 30752),
		(501, 32901),
		(502, 87485),
		(503, 85346),
		(503, 25960),
		(504, 18185),
		(505, 23610);


Insert into Bestand
values	('LerenBank.jpg',150),
		('LerenBank1.jpg',150),
		('kussen.jpg',150),
		('350194099.jpg',151),
		('rubberboot.jpg',152),
		('bed',153),
		('laptop',154),
		('15138796091767.jpg', 200), 
		('9200000052699679.jpg', 201), 
		('2385908236.jpg', 201), 
		('347587236483425.jpg', 202), 
		('9200000010997932.jpg', 202),
		('196793.jpg', 203), 
		('10167916.jpg', 204),
		('16738913455.jpg', 204),
		('1535624582635.jpg', 204),
		('565724760476.jpg', 204),
		('9200000088252680.jpg',500),
		('9200000088252680_10.jpg', 500),
		('HD7865_80-A1P-global-001.jpg', 501),
		('HD7865_80-RTP-global-001.jpg', 501),
		('87287127812.jpg', 502),
		('73272871881.jpg', 502),
		('1010831.png', 503),
		('1010834.png', 503),
		('123897921398732198.JPG',504),
		('12873872178312.JPG', 504),
		('988998897879.JPG', 504),
		('img_0024_medium__1.jpg', 505),
		('img_0003_medium__1.jpg', 505);


INSERT INTO Bod VALUES
	(200, 255.00, 'ZwibberZwabber', '25-4-2018', '21:57:13'), 
	(200, 280.00, 'IkBiedMeerDanJij', '26-4-2018', '15:26:21'), 
	(200, 300.50, 'RandomUser123', '27-4-2018', '09:32:26'), 
	(201, 20.70, 'IkWilKoffieNu', '22-4-2018', '16:21:13'), 
	(203, 80.00, 'Slash2point0', '26-4-2018', '09:13:22'), 
	(203, 82.50, 'ArnoldDeVeiler', '28-4-2018', '14:20:18'), 
	(203, 90.00, 'Slash2point0', '30-4-2018', '17:54:09'), 
	(203, 95.00, 'ArnoldDeVeiler', '30-4-2018', '18:43:11'), 
	(203, 100.00, 'Slash2point0', '1-5-2018', '10:18:14'), 
	(203, 101.00, 'ThisIsMineNow', '1-5-2018', '23:30:53'), 
	(204, 50.00, 'xxUltraGamerxx', '23-4-2018', '10:02:55'),
	(500, 310.00, 'denneh5', '25-04-2018', '13:01:42'),
	(500, 333.00, 'woetroe',  '26-04-2018', '06:33:21'), 
	(501, 51.00, 'valliebeer', '01-05-2018', '12:42:13'),
	(502, 26.00, 'ibuystuff23', '05-05-2018', '14:32:21'),
	(503, 360.00, 'ibuystuff23', '21-05-2018', '16:48:21'),
	(503, 380.00, 'ibuymorestuff23', '22-05-2018', '22:01:44'),
	(504, 4000.00, 'ikhouvanauto''s2', '06-05-2018', '23:59:33');