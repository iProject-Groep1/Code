--testpopulatie
DROP TABLE Rubriek

INSERT RUBRIEK VALUES	(1, 'Auto ''s, boten en caravans', -1, 1),				--hoofdrubrieken
						(2, 'Kleren', -1, 2),
						(3, 'Muziek', -1, 3),
						(4, 'Computers', -1, 4),
						(5, 'Kunst', -1, 5),
						(6, 'Auto-onderdelen', 1, 1),							--subrubrieken niveau 1 auto's etc.
						(7, 'Occasions', 1, 2),
						(8, 'Roeiboten', 1, 3),
						(9, 'Broeken', 2, 1),									--subrubrieken niveau 1 kleren
						(10, 'Shirts', 2, 2),
						(11, 'Instrumenten', 3, 1),								--subrubrieken niveau 1 muziek
						(12, 'CD''s', 3, 2),
						(13, 'Desktops', 4, 1),									--subrubrieken niveau 1 computers
						(14, 'Laptops', 4, 2),
						(15, 'Beeldjes', 5, 1),									--subrubrieken niveau 1 kunst
						(16, 'Schilderijen', 5, 2),
						(17, 'Motor-onderdelen', 6, 1),							--subrubrieken niveau 2 Auto-onderdelen
						(18, 'Versnellingsbak-onderdelen', 6,2),
						(19, 'Gitaren', 11, 1),									--subrubrieken niveau 2 Instrumenten
						(20, 'Cilinderkop', 17, 1),								--subrubrieken niveau 3 motor-onderdelen
						(21, 'Basgitaren', 19,1),								--subrubrieken niveau 3 Instrumenten
						(22, 'Zuigers', 20, 1)									--subrubrieken niveau 4 Cilinderkop
