

drop table if exists VoorwerpInRubriek
drop table if exists Bestand
drop table if exists Bod 
drop table if exists Voorwerp
drop table if exists Rubriek


go 

CREATE TABLE Voorwerp (
	Voorwerpnummer			numeric (10)	not null,
	Title					varchar (50)	not null,						-- aangepast van char 18 naar 
	Beschrijving			varchar (512)	not null,						-- aangepast van char 22
	Startprijs				numeric (8,2)	not null,						-- char 5 
	Betalingswijzen			varchar (20)	not null,						-- char 9
	Betalingsinstructie		varchar (128)	null	,						-- char 23
	Plaatsnaam				varchar (30)	not null,						-- char 12
	Land					varchar (50)	not null,						-- char 9
	Looptijd /*in dagen */	numeric (1)		not null,
	Looptijdbegindag		date			not null,						-- date format is aangepast naar dd/mm/yyyy
	LooptijdbeginTijdstip	time			not null,						-- VERANDERING: time format ipv datetime (datetime is dubbelop i.v.m. looptijdbegindag
	Verzendkosten			numeric (6,2)	null	,						-- char 5
	Verzendinstructies		varchar (128)	null	,						-- char 27
	Verkoper				varchar (20)	not null,						-- aangepast van char 10 Ook aanpassen gebruiker table
	Koper					varchar (20)	null	,						-- aangepast van char 10 Ook aanpassen gebruiker table
	LooptijdeindeDag		date			not null,						-- datetime format is aangepast naar dd/mm/yyyy
	LooptijdeindeTijdstip	time			not null,						-- time format ipv datetime
	Veilinggesloten			bit				not null,						-- aangepast van een char 3.

CONSTRAINT voorwerpKey PRIMARY KEY (Voorwerpnummer)
);

CREATE TABLE Bestand (
	Filenaam				varchar(50)		NOT NULL,						-- aangepast van char(13)
	Voorwerp				numeric(10)		NOT NULL,

CONSTRAINT BestandKey PRIMARY KEY(filenaam)
);

CREATE TABLE Rubriek (
	Rubrieknummer			numeric(8)		NOT NULL,						-- aangepast van integer(3)
	Rubrieknaam				varchar(50)		NOT NULL,						-- aangepast van char(24)
	Parent					numeric(8)		,						-- aangepast van integer(3)
	Volgnr					numeric(8)		NOT NULL,						-- aangepast van integer(2)	

CONSTRAINT RubriekKey PRIMARY KEY(rubrieknummer)
);

CREATE TABLE VoorwerpInRubriek (
Voorwerp					NUMERIC (10)	not null,
Rubriek_op_laagste_Niveau	numeric (8)		not null						-- aangepast van int naar numeric 

CONSTRAINT VoorwerpInRubriekKey PRIMARY KEY (Voorwerp,Rubriek_op_laagste_Niveau)
);

CREATE TABLE Bod (
	Voorwerp			NUMERIC(10)			NOT NULL, 
	Bodbedrag			NUMERIC(8, 2)		NOT NULL,				--veranderd van char(5)
	Gebruiker			VARCHAR(20)			NOT NULL,				--overal veranderd van char(10)
	BodDag				DATE				NOT NULL,				--veranderd van char(10)
	BodTijdstip			TIME				NOT NULL,				--veranderd van char(8)

CONSTRAINT BodKey PRIMARY KEY(Voorwerp,Bodbedrag)
);



go
Alter table Bestand 
ADD Constraint FK_Bestant_VoorwerpnummerKey FOREIGN KEY (voorwerp) REFERENCES voorwerp(voorwerpnummer);

go
Alter table Rubriek
ADD Constraint FK_Parent_Rubrieknummer FOREIGN KEY (parent) REFERENCES Rubriek(rubrieknummer);

go
Alter table VoorwerpInRubriek
ADD Constraint FK_VoorwerpInRubriek FOREIGN KEY (voorwerp) REFERENCES Voorwerp(Voorwerpnummer),
	Constraint FK_RubriekOpLaagsteNiveu_RubriekNummer FOREIGN KEY (Rubriek_op_laagste_Niveau) REFERENCES Rubriek (Rubrieknummer);
go
Alter table Bod
ADD Constraint FK_Voorwerp_VoorwerpNummer FOREIGN KEY (voorwerp) REFERENCES Voorwerp(Voorwerpnummer);





/*

go
Alter table   Bestand 
drop		Constraint FK_Bestant_VoorwerpnummerKey 
go

Alter table  Rubriek
drop		Constraint FK_Parent_Rubrieknummer 
go

Alter table  VoorwerpInRubriek
drop		Constraint FK_VoorwerpInRubriek ,
			Constraint FK_RubriekOpLaagsteNiveu_RubriekNummer ;
go

Alter table   Bod
drop		Constraint FK_Voorwerp_VoorwerpNummer ;
go */