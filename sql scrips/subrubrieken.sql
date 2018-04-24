SELECT Rubrieknummer, Rubrieknaam  FROM Rubriek r WHERE Volgnr = Rubrieknummer


--recursieve query
--with CTE

SELECT 
Rubrieknaam AS li,
(
  SELECT 
 Rubrieknaam AS li,
  (
  SELECT
 Rubrieknaam AS li,
  (
  SELECT
  Rubrieknaam AS li,
  (
  SELECT
  Rubrieknaam AS li,
  (
  SELECT
  Rubrieknaam AS li,
  (
  SELECT
  Rubrieknaam AS li
  FROM Rubriek s5
  WHERE s5.Rubriek = s4.Rubrieknummer
  FOR XML PATH('ul'), TYPE
  )
  FROM Rubriek s4
  WHERE s4.Rubriek = s3.Rubrieknummer
  FOR XML PATH('ul'), TYPE
  )
  FROM Rubriek s3
  WHERE s3.Rubriek = s2.Rubrieknummer
  FOR XML PATH('ul'), TYPE
  )
  FROM Rubriek s2
  WHERE s2.Rubriek = s1.Rubrieknummer
  FOR XML PATH('ul'),TYPE
  )

  FROM Rubriek s1
  WHERE s1.Rubriek = s.Rubrieknummer
  FOR XML PATH('ul'),TYPE
  )
  FROM Rubriek s
  WHERE s.Rubriek = h.Rubrieknummer
  FOR XML PATH('ul'),TYPE
)
FROM Rubriek h
WHERE h.Rubriek = -1
FOR XML PATH('ul'),TYPE






SELECT
HoofdrubriekNr=h.Rubrieknummer,
HoofdrubriekNaam=h.Rubrieknaam,
SubrubriekNr=s.Rubrieknummer,
SubrubriekNaam=s.Rubrieknaam,
SubrubriekNiveau1Nr=s1.Rubrieknummer,
SubrubriekNiveau1Naam=s1.Rubrieknaam,
SubrubriekNiveau2Nr=s2.Rubrieknummer,
SubrubriekNiveau2Naam=s2.Rubrieknaam,
SubrubriekNiveau3Nr=s3.Rubrieknummer,
SubrubriekNiveau3Naam=s3.Rubrieknaam,
SubrubriekNiveau4Nr=s4.Rubrieknummer,
SubrubriekNiveau4Naam=s4.Rubrieknaam

FROM Rubriek h
LEFT JOIN Rubriek s on h.Rubrieknummer=s.Rubriek 
LEFT JOIN Rubriek s1 on s.Rubrieknummer = s1.Rubriek
LEFT JOIN Rubriek s2 on s1.Rubrieknummer = s2.Rubriek
LEFT JOIN Rubriek s3 on s2.Rubrieknummer = s3.Rubriek
LEFT JOIN Rubriek s4 on s3.Rubrieknummer = s4.Rubriek

WHERE h.Rubriek = -1 AND h.Rubrieknaam LIKE 'a%'
ORDER BY h.Volgnr, h.Rubrieknaam, s.Volgnr, s.Rubrieknaam,  s1.Volgnr, s1.Rubrieknaam, s2.Volgnr, s2.Rubrieknaam, s3.Volgnr, s3.Rubrieknaam, s4.Volgnr, s4.Rubrieknaam


-- bepaal alle hoofdrubrieken
SELECT	HoofdrubriekNr = h.Rubrieknummer,
		HoofdrubriekNaam = h.Rubrieknaam
FROM	Rubriek h
WHERE	h.Rubriek = -1

--bepaal de subrubrieken van hoofdrubriek 1
SELECT	SubrubriekNr=s.Rubrieknummer,
		SubrubriekNaam=s.Rubrieknaam
FROM	Rubriek h
LEFT JOIN Rubriek s on h.Rubrieknummer = s.Rubriek
WHERE s.rubriek = 1

--bepaal de subrubrieken niveau 1 van subrubriek 1 van hoofdrubriek 1
SELECT	SubrubriekNiveau1Nr = s1.Rubrieknummer,
		SubrubriekNiveau1Naam = s1.Rubrieknaam
FROM Rubriek h
LEFT JOIN Rubriek s on h.Rubrieknummer=s.Rubriek 
LEFT JOIN Rubriek s1 on s.Rubrieknummer = s1.Rubriek
WHERE s1.rubriek = 6

--bepaal de subrubrieken niveau 2 van subrubriek niveau 1 van subrubriek 1 hoofdrubriek 1
SELECT	SubrubriekNiveau2Nr = s2.Rubrieknummer,
		SubrubriekNiveau2Naam = s2.Rubrieknaam
FROM Rubriek h
LEFT JOIN Rubriek s on h.Rubrieknummer=s.Rubriek 
LEFT JOIN Rubriek s1 on s.Rubrieknummer = s1.Rubriek
LEFT JOIN Rubriek s2 on s1.Rubrieknummer = s2.Rubriek

WHERE s2.rubriek = 17

--bepaal de subrubrieken niveau 3 van subrubriek niveau 2 van subrubriek niveau 1 van subrubriek 1 hoofdrubriek 1

SELECT	SubrubriekNiveau3Nr = s3.Rubrieknummer,
		SubrubriekNiveau3Naam = s3.Rubrieknaam
FROM Rubriek h
LEFT JOIN Rubriek s on h.Rubrieknummer=s.Rubriek 
LEFT JOIN Rubriek s1 on s.Rubrieknummer = s1.Rubriek
LEFT JOIN Rubriek s2 on s1.Rubrieknummer = s2.Rubriek
LEFT JOIN Rubriek s3 on s2.Rubrieknummer = s3.Rubriek

WHERE s3.rubriek = 20
