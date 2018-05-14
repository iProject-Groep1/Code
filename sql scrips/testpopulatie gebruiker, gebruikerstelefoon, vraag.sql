SET DATEFORMAT dmy; -- ZONDER DIT WERKT HET NIET!!!
drop table vraag

insert into vraag values(1, 'Wat is de naam van je eerste huisdier?')

insert into gebruiker values('synologix', 'Sander', 'Bussink', 'De Vlierbes 49', NULL, '7006 SB', 'Doetinchem', 'Nederland', '30-08-1999', 'sanderrdtc@gmail.com', '$2y$10$jNiEjZHIwMtEXVIc.Py5QelGxsxAgf9gqdGSxu500VZHOG7iAf11W', 1, 'geen', 1)

insert into gebruikerstelefoon values(1, 'synologix', '0621327018')




select * from gebruiker