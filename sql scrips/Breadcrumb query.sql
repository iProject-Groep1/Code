--voorwerp
SELECT	titel,
		P4.rubrieknaam AS Parent4Rubrieknaam,
		P4.rubrieknummer AS Parent4Rubrieknummer,
		P3.rubrieknaam AS Parent3Rubrieknaam,
		P3.rubrieknummer AS Parent3Rubrieknummer,
		P2.rubrieknaam AS Parent2Rubrieknaam,
		P2.rubrieknummer AS Parent2Rubrieknummer,
		P1.rubrieknaam AS Parent1Rubrieknaam,
		P1.rubrieknummer AS Parent1Rubrieknummer,
		S.rubrieknaam AS HuidigRubrieknaam, 
		S.rubrieknummer AS HuidigRubrieknummer		
FROM	Voorwerp v 
		JOIN	VoorwerpInRubriek vir ON v.voorwerpnummer = vir.voorwerp 
		LEFT JOIN rubriek S ON rubriek_op_laagste_niveau = rubrieknummer 
		LEFT JOIN rubriek P1 ON P1.rubrieknummer = S.parent
		LEFT JOIN rubriek P2 ON P2.rubrieknummer = P1.parent
		LEFT JOIN rubriek P3 ON P3.rubrieknummer = P2.parent
		LEFT JOIN rubriek P4 ON P4.rubrieknummer = P3.parent
WHERE voorwerpnummer = 6

--rubrieknummer
SELECT	P4.rubrieknaam AS Parent4Rubrieknaam,
		P4.rubrieknummer AS Parent4Rubrieknummer,
		P3.rubrieknaam AS Parent3Rubrieknaam,
		P3.rubrieknummer AS Parent3Rubrieknummer,
		P2.rubrieknaam AS Parent2Rubrieknaam,
		P2.rubrieknummer AS Parent2Rubrieknummer,
		P1.rubrieknaam AS Parent1Rubrieknaam,
		P1.rubrieknummer AS Parent1Rubrieknummer,
		S.rubrieknaam AS HuidigRubrieknaam, 
		S.rubrieknummer AS HuidigRubrieknummer		
FROM	rubriek S
		LEFT JOIN rubriek P1 ON P1.rubrieknummer = S.parent
		LEFT JOIN rubriek P2 ON P2.rubrieknummer = P1.parent
		LEFT JOIN rubriek P3 ON P3.rubrieknummer = P2.parent
		LEFT JOIN rubriek P4 ON P4.rubrieknummer = P3.parent
WHERE	S.rubrieknummer = 8733


--voorwerpen in onderliggende rubrieken








--subrubrieken van een rubriek.
SELECT	S1.rubrieknummer AS Sub1Rubrieknummer,
		S2.rubrieknummer AS Sub2Rubrieknummer,
		S3.rubrieknummer AS Sub3Rubrieknummer,
		S4.rubrieknummer AS Sub4Rubrieknummer			
FROM	rubriek P
		LEFT JOIN rubriek S1 ON S1.Parent = P.Rubrieknummer
		LEFT JOIN rubriek S2 ON S2.Parent = S1.Rubrieknummer
		LEFT JOIN rubriek S3 ON S3.Parent = S2.Rubrieknummer
		LEFT JOIN rubriek S4 ON S4.Parent = S3.Rubrieknummer
WHERE	P.rubrieknummer = 9800
