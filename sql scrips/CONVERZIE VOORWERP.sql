
/* DIT RECORD HEEFT EEN VALSE PRIJS*/
UPDATE Items SET Prijs = '100.00' WHERE ID = 271480537133
  
    
SET IDENTITY_INSERT Voorwerp ON
 
	insert into [dbo].[Voorwerp] ([voorwerpnummer], [titel], [beschrijving], [startprijs],[verzendkosten] , [betalingsinstructie], [land], [looptijd], [looptijdbeginmoment], [verzendinstructies], [verkoper],plaatsnaam)
select distinct id							as [voorwerpnummer]					,
				left  (Titel,50)			as [titel]							,
				left ([Beschrijving],2000)	as [beschrijving]					,
				CAST ([Prijs] AS NUMERIC(9,2) )	as [startprijs]					,
				(FLOOR (ID%10+1)	)						AS [verzendkosten]	,
				 ('Overschrijveing een dag na afloop' ) as [betalingsinstructie],
				left ([Locatie],50)			as land								,
				(1)	as looptijd										,
dateadd(month,id % 2 +1, dateadd(day,id % 31 +1,dateadd(HOUR,id % 24 +1,dateadd(minute,id % 60 +1,CURRENT_TIMESTAMP)))) as [looptijdbeginmoment],
				('product wordt verstuurd nadat de prijs (' + prijs + ') en verzend kosten  zijn overgemaakt') as [verzendinstructies],
				left ([Verkoper],20)			as [verkoper]					,
				('onbekent') as plaatnaam						
								
	from [dbo].[Items]
	
SET IDENTITY_INSERT Voorwerp OFF


