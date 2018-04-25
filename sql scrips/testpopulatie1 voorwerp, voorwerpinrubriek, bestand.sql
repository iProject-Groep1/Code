INSERT Voorwerp VALUES
									(500, 'Blauwe damesfiets', 'Deze stijlvolle damesfiets fietst erg prettig', 299.99, 'Paypal', 'zsm overmaken', 'Doetinchem', 'Nederland', 6, '25-04-2018', '12:24:00', 5.00, 'Plak je postzegels er op', 'henkie123', NULL, '01-05-2018', '12:24:00', 0),
									(501, 'Senseo koffieapparaat', 'Heerlijke koffie, alleen links werkt niet', 50.00, 'Bankoverschrift', 'Ik stuur een betaalverzoek', 'Arnhem', 'Nederland', 9, '30-04-2018', '12:52:00', 0.00, 'Ophalen s.v.p.', 'dennis23', NULL, '09-05-2018', '12:52:00', 0),
									(502, 'Basgitaar', 'Rood, hals van esdoorn', 24.00, 'iDeal', '...', 'Ruurlo', 'Nederland', 2, '04-05-2018', '13:01:00', 10.99, 'Ik verstuur met DHL', 'kattenlover123', NULL, '06-05-2018', '13:01:00', 0),
									(503, 'Vierkante trampoline', '213 x 305 cm, in nieuwstaat', 350.00, 'Bankoverschrift', 'Ik stuur een betaalverzoek', 'Azewijn', 'Nederland', 9, '20-05-2018', '13:16:00', 30.00, 'Ik kom het brengen', 'hallo312', NULL, '29-05-2018', '13:16:00', 0),
									(504, 'Jaguar X-Type', '2.5 V6 Automaat, 2003, Groen, 198k Kilometerstand. Projectauto (distributieriem moet vervangen worden)', 3000.50, 'Contant', 'Graag gepast betalen', 'Willemstad', 'Curaçao', 8, '10-05-2018', '13:27:00', 250, 'Auto moet gesleept worden', 'autogast2', NULL, '18-05-2018', '13:27:00', 0),
									(505, 'Born Lucky Rapido Kinderwagen', 'Zwart, wandelwageninzet inbegrepen', 250.00, 'iDeal', '...', 'Amsterdam',  'Nederland', 2, '05-05-2018', '13:38:00', 0.00, 'Ophalen s.v.p.', 'kinderwagenverkoper5', NULL, '07-05-2018', '13:38:00', 0)

INSERT  Bestand VALUES
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
									('img_0003_medium__1.jpg', 505)


INSERT VoorwerpInRubriek VAlUES
									(500, 30752),
									(501, 32901),
									(502, 87485),
									(503, 85346),
									(503, 25960),
									(504, 18185),
									(505, 23610)


--boddag moet tussen begindag en einddag liggen, bodtijd ook tussen begintijd en eindetijd
--bodbedrag moet hoger 
INSERT Bod VALUES
									(500, 310.00, 'denneh5', '25-04-2018', '13:01:42'),
									(500, 333.00, 'woetroe',  '26-04-2018', '06:33:21'), 
									(501, 51.00, 'valliebeer', '01-05-2018', '12:42:13'),
									(502, 26.00, 'ibuystuff23', '05-05-2018', '14:32:21'),
									(503, 360.00, 'ibuystuff23', '21-05-2018', '16:48:21'),
									(503, 380.00, 'ibuymorestuff23', '22-05-2018', '22:01:44'),
									(504, 4000.00, 'ikhouvanauto''s2', '06-05-2018', '23:59:33')
