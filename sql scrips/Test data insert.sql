set dateformat dmy
insert into Voorwerp
values	(150,'Dikke Bank','Mooie leren elegante bank',100.00, 'Ideal', 'geef mij je geld', 'elst', 'Nederland', 5, '26-04-2018', '12:00:00',50,'stuur maar op', 'Karel de Groot','' , '29-04-2018', '12:00:00', 0),
		(151,'Mooie Spiegel','goeie spiegel ',50.00,'Creditcard','dag na veiling betalen', 'Nijmegen','Nederland',4,'24-04-2018','16:00:01',5,'Hij gaat met de bood mee','Michil de Haan','','29-04-2018','16:00:01',0 ),
		(152,'Boot','Boot zonder veel gaten', 500,'per koffer', 'achterlaten in het park','Johannisburg','Afrika',8,'24-04-2018','12:00:00',5,'Ik maak de knoop los en dan drijft hij naar je toe','sinterklaas', '','30-04-2018','08:00:23',0),
		(153,'bedden fraim','Modern bedden fraim',1500, 'overschrijving','overschrijven naar een nummer rekening', 'De berg','Zwitserland',6,'18-04-2018', '12:00:00',50,'Het bed wordt verstuurd met de post','De Operatie kamer','','24-04-2018','12:00:00',1),
		(154,'Laptop','Nieuwe laptop bijna niet gebruikt kei veel ram .ram is gedownload', 600, 'cach betalen', 'Ik kom het geld ophalen', 'het woud','Nederland', 4, '20-04-2018', '18:30:00',50,'Ik kom hem zelf brengen ', 'Da Man','','24-04-2018','08:00:30',1 );

insert into VoorwerpInRubriek
values	(150,7491),
		(151,19825),
		(152,81636),
		(153,32254),
		(154,28837);

Insert into Bestand
values	('images\productImages\LerenBank.jpg',150),
		('images\productImages\LerenBank1.jpg',150),
		('images\productImages\kussen.jpg',150),
		('images\productImages\350194099.jpg',151),
		('images\productImages\rubberboot.jpg',152),
		('images\productImages\bed',153),
		('images\productImages\laptop',154);

		select * from Voorwerp