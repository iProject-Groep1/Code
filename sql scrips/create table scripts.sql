
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
Create table Betaalwijze	 (
betaalwijze varchar (25) not null,

constraint PK_Betaalwijze  Primary key (betaalwijze)
)
go


create table Looptijd(
dagen tinyint not null,

Constraint PK_dagen Primary Key (dagen)
)
go


CREATE TABLE Rubriek (
	Rubrieknummer			numeric(8)		NOT NULL,				-- aangepast van integer(3)
	Rubrieknaam				varchar(50)		NOT NULL,				-- aangepast van char(24)
	Parent					numeric(8)		,						-- aangepast van integer(3)
	Volgnr					numeric(8)		NOT NULL,				-- aangepast van integer(2)	

CONSTRAINT RubriekKey PRIMARY KEY(rubrieknummer),
Constraint FK_Parent_Rubrieknummer FOREIGN KEY (parent) REFERENCES Rubriek(rubrieknummer)
)


go
CREATE TABLE Voorwerp (
	Voorwerpnummer			int												not null,						-- een voorwerp word automatisch een nummer toegewezen door de database app C
	Titel					varchar (50)									not null,						-- Dit doen we om het overzicht op de site te houden 
	Beschrijving			varchar (2000)									not null,						-- Dit doen we om men voldoende ruimte te geven om een duidelijke omschrijving te kunnen geven 
	Startprijs				numeric (9,2)	default 1.00					not null,						-- wij willen geen bedragen over de 10.000.000,00
	Betalingswijze			varchar (25)	default 'Bank/Giro'				not null,						
	Betalingsinstructie		varchar (128)									null	,						-- char 23 --> langste plaatsnaam Nederland 28 karakters (Westerhaar-Vriezenveensewijk)
	Plaatsnaam				varchar (30)									not null,						-- char 12
	Land					varchar (50)	default 'Nederland'				not null,						-- char 9
	Looptijd /*in dagen */	TINYINT 		default 1						not null,
	looptijdbeginmoment		datetime		default Current_timestamp		not null,						-- dit zorgt er voor dat de tijd start wanneer het record is ge insert
	LooptijdEindmoment		as  dateadd (day,looptijd,looptijdbeginmoment)			,
	Verzendkosten			numeric (6,2)									null	,						-- char 5
	Verzendinstructies		varchar (128)									null	,						-- char 27
	Verkoper				varchar (20)									not null,						-- 
	Koper					varchar (20)	default 'Onbekent'				null	,						-- aangepast van char 10 Ook aanpassen gebruiker table
	Veilinggesloten			bit												not null,						-- aangepast van een char 3.

CONSTRAINT voorwerpKey PRIMARY KEY (Voorwerpnummer),
Constraint CK_Titel Check ( (len(rtrim(ltrim(titel)))) >1),
Constraint CK_startprijs Check (startprijs >= 1), -- app B page 6 
Constraint FK_looptijd  Foreign Key (looptijd) References Looptijd(dagen),
Constraint FK_Betalingswijze Foreign Key (Betalingswijze) References Betaalwijze (betaalwijze),
Constraint CK_Plaatsnaam Check ( (len(rtrim(ltrim(Plaatsnaam)))) >1),
Constraint CK_Beschrijving Check ( (len(rtrim(ltrim(Plaatsnaam)))) >1) 
);



CREATE TABLE VoorwerpInRubriek (
Voorwerp					int				not null,
Rubriek_op_laagste_Niveau	numeric (8)		not null						-- aangepast van int naar numeric 

CONSTRAINT VoorwerpInRubriekKey PRIMARY KEY (Voorwerp,Rubriek_op_laagste_Niveau),
Constraint FK_VoorwerpInRubriek FOREIGN KEY (voorwerp) REFERENCES Voorwerp(Voorwerpnummer),
Constraint FK_RubriekOpLaagsteNiveu_RubriekNummer FOREIGN KEY (Rubriek_op_laagste_Niveau) REFERENCES Rubriek (Rubrieknummer),
CONSTRAINT CK_Maximaal_2_Gratis_Rubrieken_per_Voorwerp CHECK (fnCHK_Maximaal_2_Gratis_Rubrieken_per_Voorwerp(Voorwerp) = 1), 
Constraint CK_Geen_Subrubrieken CHECK (Rubriek_op_laagste_Niveau not in (SELECT Parent FROM Rubriek)
);
go

GO
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




CREATE TABLE Bod (
	Voorwerp			int					NOT NULL, 
	Bodbedrag			NUMERIC(8, 2)		NOT NULL,				--veranderd van char(5)
	Gebruiker			VARCHAR(20)			NOT NULL,				--overal veranderd van char(10)
	Bodtijd				DATEtime	default Current_timestamp		NOT NULL,				--veranderd van char(10)


CONSTRAINT BodKey PRIMARY KEY(Voorwerp,Bodbedrag),
Constraint FK_Voorwerp_VoorwerpNummer FOREIGN KEY (voorwerp) REFERENCES Voorwerp(Voorwerpnummer)
);
go


CREATE TABLE Bestand (
	Filenaam				varchar(50)			NOT NULL,						-- aangepast van char(13)
	Voorwerp				int					NOT NULL,

CONSTRAINT BestandKey PRIMARY KEY(filenaam),
Constraint FK_Bestant_VoorwerpnummerKey FOREIGN KEY (voorwerp) REFERENCES voorwerp(voorwerpnummer)
)



