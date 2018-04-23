SET DATEFORMAT dmy;


CREATE TABLE Voorwerp (
	Voorwerpnummer			numeric (10)	not null,
	Title					varchar (30)	not null,						-- aangepast van char 18 naar 
	beschrijving			varchar (255)	not null,						-- aangepast van char 22
	startprijs				numeric (6,2)	not null,						-- char 5 
	betalingswijzen			varchar (10)	not null,						-- char 9
	betalingsinstructie		varchar (128)			,						-- char 23
	plaatsnaam				varchar (30)	not null,						-- char 12
	land					varchar (50)	not null,						-- char 9
	looptijd /*in dagen */	numeric (1)		not null,
	looptijdbegindag		date			not null,						-- datetime format is aangepast naar dd/mm/yyyy
	looptijdbeginTijdstip	datetime		not null ,
	verzendkosten			numeric (4,2)	null ,							-- char 5
	verzendinstructies		varchar (128)	null,							-- char 27
	verkoper				varchar (20)	not null,						-- aangepast van char 10 Ook aanpassen gebruiker table
	koper					varchar (20)	null,							-- aangepast van char 10 Ook aanpassen gebruiker table
	looptijdeindeDag		date			not null,						-- datetime format is aangepast naar dd/mm/yyyy
	looptijdeindeTijdstip	datetime		not null,
	veilinggesloten			bit				not null						-- aangepast van een char 3.

constraint voorwerpKey primary key (voorwerpnummer)
);

CREATE TABLE Bestand (
	filenaam				varchar(50)		NOT NULL,						-- aangepast van char(13)
	Voorwerp				numeric(10)		NOT NULL,

CONSTRAINT BestandKey PRIMARY KEY(filenaam)
);

CREATE TABLE Rubriek (
	rubrieknummer			numeric(3)		NOT NULL,						-- aangepast van integer(3)
	rubrieknaam				varchar(24)		NOT NULL,						-- aangepast van char(24)
	Rubriek					numeric(3)		NOT NULL,						-- aangepast van integer(3)
	volgnr					numeric(2)		NOT NULL,						-- aangepast van integer(2)
		
CONSTRAINT RubriekKey PRIMARY KEY(rubrieknummer)
);

CREATE TABLE VoorwerpInRubriek (
Voorwerp					NUMERIC (10)	not null,
Rubriek_op_laagste_Niveau	numeric (3)		not null

CONSTRAINT VoorwerpInRubriekKey PRIMARY KEY (Voorwerp,Rubriek_op_laagste_Niveau)
);