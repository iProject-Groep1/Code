

go
drop table if exists VoorwerpInRubriek
go
drop table if exists Bestand
go
drop table if exists Bod 
go
drop table if exists Voorwerp
go
drop table if exists Rubriek
go
drop table if exists Betaalwijze
go 
drop table if exists Looptijd
go
drop table if exists Vraag
go
drop table if exists Verkoper
go
drop table if exists Gebruiker
go
drop table if exists Gebruikerstelefoon
go
drop table if exists Verificatie
go
drop table if exists Land
go

go 
Create table Betaalwijze	 (
betaalwijze varchar (25) not null,

constraint PK_Betaalwijze  Primary key (betaalwijze)
)
go

CREATE TABLE Verificatie
(
	email				VARCHAR(320)		NOT NULL, -- 64 characters for the "local part" (username), 1 character for the @ symbol & 255 characters for the domain name.
	hash				VARCHAR(32)			NOT NULL, -- 32 tekens omdat de functie in php dit genereert.
	isGeactiveerd		BIT					NOT NULL  

	CONSTRAINT PK_Verificatie PRIMARY KEY (email),

)

create table Looptijd(
dagen tinyint not null,

Constraint PK_dagen Primary Key (dagen)
)
go


CREATE TABLE Rubriek (
	rubrieknummer			numeric(8)		NOT NULL,				-- aangepast van integer(3)
	rubrieknaam				varchar(50)		NOT NULL,				-- aangepast van char(24)
	parent					numeric(8)		,						-- aangepast van integer(3)
	volgnr					numeric(8)		NOT NULL,				-- aangepast van integer(2)	

CONSTRAINT RubriekKey PRIMARY KEY(rubrieknummer),
Constraint FK_Parent_Rubrieknummer FOREIGN KEY (parent) REFERENCES Rubriek(rubrieknummer)
)


go
CREATE TABLE Voorwerp (
	voorwerpnummer			int												not null,						-- een voorwerp word automatisch een nummer toegewezen door de database app C
	titel					varchar (50)									not null,						-- Dit doen we om het overzicht op de site te houden 
	beschrijving			varchar (2000)									not null,						-- Dit doen we om men voldoende ruimte te geven om een duidelijke omschrijving te kunnen geven 
	startprijs				numeric (9,2)	default 1.00					not null,						-- wij willen geen bedragen over de 10.000.000,00
	betalingswijze			varchar (25)	default 'Bank/Giro'				not null,						
	betalingsinstructie		varchar (128)	default 'Geen'					null	,						-- char 23 --> langste plaatsnaam Nederland 28 karakters (Westerhaar-Vriezenveensewijk)
	plaatsnaam				varchar (30)									not null,						-- char 12
	land					varchar (50)	default 'Nederland'				not null,						-- char 9
	looptijd /*in dagen */	TINYINT 		default 7						not null,
	looptijdbeginmoment		datetime		default Current_timestamp		not null,						-- dit zorgt er voor dat de tijd start wanneer het record is ge insert
	looptijdEindmoment		as  dateadd (day,looptijd,looptijdbeginmoment)			,
	verzendkosten			numeric (6,2)									null	,						-- char 5
	verzendinstructies		varchar (128)									null	,						-- char 27
	verkoper				varchar (20)									not null,						-- 
	koper					varchar (20)	default 'Onbekend'				null	,						-- aangepast van char 10 Ook aanpassen gebruiker table
	veilinggesloten			bit												not null,						-- aangepast van een char 3.

CONSTRAINT voorwerpKey PRIMARY KEY (Voorwerpnummer),
Constraint CK_Titel Check ( (len(rtrim(ltrim(titel)))) >1),
Constraint CK_startprijs Check (startprijs >= 1), -- app B page 6 
Constraint FK_looptijd  Foreign Key (looptijd) References Looptijd(dagen),
Constraint FK_Betalingswijze Foreign Key (Betalingswijze) References Betaalwijze (betaalwijze),
Constraint CK_Plaatsnaam Check ( (len(rtrim(ltrim(Plaatsnaam)))) >1),
Constraint CK_Beschrijving Check ( (len(rtrim(ltrim(Plaatsnaam)))) >1) 
);


DROP FUNCTION IF EXISTS fnCHK_Maximaal_2_Gratis_Rubrieken_per_Voorwerp
go
CREATE FUNCTION fnCHK_Maximaal_2_Gratis_Rubrieken_per_Voorwerp(@Voorwerp int)
RETURNS bit 
AS
BEGIN
IF ((SELECT count(*) FROM VoorwerpInRubriek WHERE Voorwerp = @Voorwerp ) <= 2) 
	RETURN 1
ELSE 
	RETURN 0

RETURN 0
END
GO

DROP FUNCTION IF EXISTS dbo.fnCHK_Geen_Subrubrieken
go
CREATE FUNCTION dbo.fnCHK_Geen_Subrubrieken(@rubriek int)
RETURNS BIT
AS
BEGIN
IF (@rubriek in (SELECT Parent FROM Rubriek))
	RETURN 1
ELSE
	RETURN 0
RETURN 0
END
GO

CREATE TABLE VoorwerpInRubriek (
voorwerp					int				not null,
rubriek_op_laagste_Niveau	numeric (8)		not null						-- aangepast van int naar numeric 

CONSTRAINT VoorwerpInRubriekKey PRIMARY KEY (Voorwerp,Rubriek_op_laagste_Niveau),
Constraint FK_VoorwerpInRubriek FOREIGN KEY (voorwerp) REFERENCES Voorwerp(Voorwerpnummer),
Constraint FK_RubriekOpLaagsteNiveu_RubriekNummer FOREIGN KEY (Rubriek_op_laagste_Niveau) REFERENCES Rubriek (Rubrieknummer),
CONSTRAINT CK_Maximaal_2_Gratis_Rubrieken_per_Voorwerp CHECK (dbo.fnCHK_Maximaal_2_Gratis_Rubrieken_per_Voorwerp(Voorwerp) = 1), 
Constraint CK_Geen_Subrubrieken CHECK (dbo.fnCHK_Geen_Subrubrieken(rubriek_op_laagste_niveau) = 0)
);
go



CREATE TABLE Bod (
	voorwerp			int					NOT NULL, 
	bodbedrag			NUMERIC(8, 2)		NOT NULL,				--veranderd van char(5)
	gebruiker			VARCHAR(20)			NOT NULL,				--overal veranderd van char(10)
	bodtijd				DATEtime	default Current_timestamp		NOT NULL,				--veranderd van char(10)


CONSTRAINT BodKey PRIMARY KEY(Voorwerp,Bodbedrag),
CONSTRAINT bodbedragHogerDanNull Check ( bodbedrag > 0), 
Constraint FK_Voorwerp_VoorwerpNummer FOREIGN KEY (voorwerp) REFERENCES Voorwerp(Voorwerpnummer)
);
go


CREATE TABLE Bestand (
	filenaam				varchar(50)			NOT NULL,						-- aangepast van char(13)
	voorwerp				int					NOT NULL,

CONSTRAINT BestandKey PRIMARY KEY(filenaam),
Constraint FK_Bestand_VoorwerpnummerKey FOREIGN KEY (voorwerp) REFERENCES voorwerp(voorwerpnummer)
)


CREATE TABLE Vraag (
	
	vraagnummer			INTEGER				NOT NULL, 
	vraagtekst			VARCHAR(100)		NOT NULL, --aangepast van char(21)
	
	CONSTRAINT Vraagkey PRIMARY KEY(vraagnummer)

)

CREATE TABLE Land (
	land				VARCHAR(40)			NOT NULL,  --aangepast van char(9)

	CONSTRAINT LandKey PRIMARY KEY(land)
)


CREATE TABLE Gebruiker (

	gebruikersnaam		VARCHAR(20)			NOT NULL, --aangepast van char(10)
	voornaam			VARCHAR(15)			NOT NULL, --van char(5)
	achternaam			VARCHAR(20)			NOT NULL, --van char(8)
	adresregel1			VARCHAR(30)			NOT NULL, --van char(15)
	adresregel2			VARCHAR(30)					, 	
	postcode			VARCHAR(7)			NOT NULL, --van char(7)
	plaatsnaam			VARCHAR(40)			NOT NULL, --van char(12)
	land				VARCHAR(40)			NOT NULL, --van char(9)
	geboortedag			DATE				NOT NULL, --van char(10)
	mail_adres			VARCHAR(320)		NOT NULL, --64 characters for the "local part" (username), 1 character for the @ symbol & 255 characters for the domain name.
	wachtwoord			VARCHAR(256)			NOT NULL, --van char(9)
	vraag				INTEGER				NOT NULL,
	antwoordtekst		VARCHAR(20)			NOT NULL, --van char(6)
	verkoper			BIT		DEFAULT 0	NOT NULL, --van char(3)

	CONSTRAINT Gebruikerkey PRIMARY KEY(gebruikersnaam),
	CONSTRAINT FK_Gebruiker_Vraagnummerkey	FOREIGN KEY (vraag) REFERENCES Vraag(vraagnummer),
	--DEZE HIERONDER WERKEN NIET
	CONSTRAINT CK_Wachtwoord_Lengte CHECK(len(rtrim(ltrim(wachtwoord))) >= 7),
	CONSTRAINT FK_Gebruiker_Land			FOREIGN KEY (land) REFERENCES Land(land) 
)

CREATE TABLE Verkoper (
	gebruikersnaam		VARCHAR(20)		NOT NULL,						--veranderd van char(10)
	bank				VARCHAR(20)		NOT NULL DEFAULT 'Rabobank',	--veranderd van char(8)
	rekeningnummer		VARCHAR(34)				,						--TODO: nog voor regelen dat deze not null is als creditcardnummer null is en andersom... veranderd van int(7)
	controleOptie		VARCHAR(10)		NOT NULL DEFAULT 'Post',		--veranderd van char(10)
	creditcardnummer	numeric(16)				,						--TODO: nog regelen dat deze null is als controleOptie 'Post' is.
	rating				numeric(4, 1)	NOT NULL,						
	CONSTRAINT VerkoperKey PRIMARY KEY(gebruikersnaam),
	CONSTRAINT FK_Verkoper_Gebruikersnaam FOREIGN KEY (gebruikersnaam) REFERENCES Gebruiker(gebruikersnaam),	
	CONSTRAINT CK_controleOptie CHECK(controleOptie in ('Creditcard','Post')),
	CONSTRAINT CK_rating CHECK(rating <= 100)
)

CREATE TABLE Gebruikerstelefoon (

	volgnr				INTEGER				NOT NULL, 
	gebruiker			VARCHAR(20)			NOT NULL,	--aangepast van char(10)
	telefoon			VARCHAR(20)			NOT NULL,	--verplicht veld bij het registreren, aangepast van char(11)
	
	CONSTRAINT Gebruikerstelefoonkey PRIMARY KEY(volgnr, gebruiker),
	CONSTRAINT FK_Gebruikerstelefoon_Gebruikersnaamkey FOREIGN KEY (gebruiker) REFERENCES Gebruiker(gebruikersnaam)

)

