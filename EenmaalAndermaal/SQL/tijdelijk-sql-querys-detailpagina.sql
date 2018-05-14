select titel, beschrijving, betalingswijze, betalingsinstructie, plaatsnaam, land, verzendkosten, verzendinstructies, verkoper
from dbo.Voorwerp
where voorwerpnummer = 1 --variable

select bodbedrag, gebruiker
from dbo.Bod
where voorwerp = 1 --variable
order by bodbedrag desc

