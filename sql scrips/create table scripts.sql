SET DATEFORMAT dmy;


CREATE TABLE Voorwerp (

Voorwerp					NUMERIC (10)	not null,						
Title						VARCHAR (30)	not null,						-- aangepast van char 18 naar 
Beschrijving				VARCHAR (255)	not null,						-- aangepast van char 22
Startprijs					NUMERIC (6,2)	not null,						-- char 5 
Betalingswijzen				VARCHAR (10)	not null,						-- char 9
Betalingsinstructie			VARCHAR (128)			,						-- char 23
Plaatsnaam					VARCHAR (30)	not null,						-- char 12
Land						VARCHAR (50)	not null,						-- char 9
Looptijd /*in dagen */		NUMERIC (1)		not null,
Looptijdbegindag			DATE			not null,						-- datetime format is aangepast naar dd/mm/yyyy
LooptijdbeginTijdstip		DATETIME		not null ,
Verzendkosten				NUMERIC (4,2)	null ,							-- char 5
Verzendinstructies			VARCHAR (128)	null,							-- char 27
Verkoper					VARCHAR (20)	not null,						-- aangepast van char 10 Ook aanpassen gebruiker table
Koper						VARCHAR (20)	null,							-- aangepast van char 10 Ook aanpassen gebruiker table
LooptijdeindeDag			DATE			not null,						-- datetime format is aangepast naar dd/mm/yyyy
LooptijdeindeTijdstip		DATETIME		not null,
Veilinggesloten				BIT				not null						-- aangepast van een char 3.

CONSTRAINT VoorwerpKey PRIMARY KEY (Voorwerp)
);

CREATE TABLE VoorwerpInRubriek (
Voorwerp					NUMERIC (10)	not null,
Rubriek_op_laagste_Niveau	numeric (3)		not null

CONSTRAINT VoorwerpInRubriekKey PRIMARY KEY (Voorwerp,Rubriek_op_laagste_Niveau)
);