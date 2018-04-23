
SET DATEFORMAT dmy;

CREATE TABLE Voorwerp (
	Voorwerpnummer			numeric (10)	not null,
	Title					varchar (30)	not null,						-- aangepast van char 18 naar 
	Beschrijving			varchar (255)	not null,						-- aangepast van char 22
	Startprijs				numeric (6,2)	not null,						-- char 5 
	Betalingswijzen			varchar (10)	not null,						-- char 9
	Betalingsinstructie		varchar (128)	null	,						-- char 23
	Plaatsnaam				varchar (30)	not null,						-- char 12
	Land					varchar (50)	not null,						-- char 9
	Looptijd /*in dagen */	numeric (1)		not null,
	Looptijdbegindag		date			not null,						-- datetime format is aangepast naar dd/mm/yyyy
	LooptijdbeginTijdstip	datetime		not null,
	Verzendkosten			numeric (4,2)	null	,						-- char 5
	Verzendinstructies		varchar (128)	null	,						-- char 27
	Verkoper				varchar (20)	not null,						-- aangepast van char 10 Ook aanpassen gebruiker table
	Koper					varchar (20)	null	,						-- aangepast van char 10 Ook aanpassen gebruiker table
	LooptijdeindeDag		date			not null,						-- datetime format is aangepast naar dd/mm/yyyy
	LooptijdeindeTijdstip	datetime		not null,
	Veilinggesloten			bit				not null						-- aangepast van een char 3.

constraint voorwerpKey primary key (voorwerpnummer)
);

CREATE TABLE Bestand (
	Filenaam				varchar(50)		NOT NULL,						-- aangepast van char(13)
	Voorwerp				numeric(10)		NOT NULL,

CONSTRAINT BestandKey PRIMARY KEY(filenaam)
);

CREATE TABLE Rubriek (
	Rubrieknummer			numeric(3)		NOT NULL,						-- aangepast van integer(3)
	Rubrieknaam				varchar(24)		NOT NULL,						-- aangepast van char(24)
	Rubriek					numeric(3)		NOT NULL,						-- aangepast van integer(3)
	Volgnr					numeric(2)		NOT NULL,						-- aangepast van integer(2)
		
CONSTRAINT RubriekKey PRIMARY KEY(rubrieknummer)
);

CREATE TABLE VoorwerpInRubriek (
Voorwerp					NUMERIC (10)	not null,
Rubriek_op_laagste_Niveau	numeric (3)		not null						-- aangepast van int naar numeric 

CONSTRAINT VoorwerpInRubriekKey PRIMARY KEY (Voorwerp,Rubriek_op_laagste_Niveau)
);