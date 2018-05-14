/*
Veilingsite Eenmaal Andermaal
Auteurs: Michael Kalil 590395, Twan Bolwerk 598576, Ivan Miladinovic 599294, Janno Onink 602808, Suzanne Bogaard 603439, Auke Onvlee 604640
Datum: 24-04-2018
*/

/* B1 */
ALTER TABLE Verkoper 
DROP CONSTRAINT CHK_IsVerkoper;
GO

DROP FUNCTION dbo.IsVerkoper;
GO

/* B2 */
ALTER TABLE Verkoper
DROP CONSTRAINT CHK_CreditcardGevuld;
GO



/* B3 */
ALTER TABLE Verkoper 
DROP CONSTRAINT CHK_CreditOfBankNull;
GO


/* B4 */ 
ALTER TABLE Bestand
DROP CONSTRAINT CHK_NietMeerDanVierAfbeeldingen;
GO

DROP FUNCTION dbo.NietMeerDanVierAfbeelding;

/* B5 */ 
ALTER TABLE Bod 
DROP CONSTRAINT CHK_CheckIsHogerBod;


DROP FUNCTION dbo.CheckHoogsteBod;
GO


/* B6 */
ALTER TABLE Bod 
DROP CONSTRAINT CHK_IsGeenEigenBod;
GO


DROP FUNCTION dbo.GeenEigenBod;
GO


/* B1 Tabellen Verkoper en Gebruiker:
Kolom Verkoper(Gebruiker) moet uitsluitend alle gebruikers bevatten, die in kolom Gebruiker(Verkoper?) de waarde ‘wel’ hebben. */

CREATE FUNCTION dbo.IsVerkoper (@gebruikersnaam VARCHAR(25))
RETURNS BIT
AS
BEGIN
	DECLARE @return BIT;
	SET @return = (SELECT verkoper
	FROM Gebruiker
	WHERE gebruikersnaam = @gebruikersnaam)

	RETURN @return
END;
GO

ALTER TABLE Verkoper 
ADD CONSTRAINT CHK_IsVerkoper 
CHECK (dbo.IsVerkoper(gebruikersnaam) = 1)
GO




/* B2 Tabel Verkoper:
Als kolom Controle-optie de waarde ‘Creditcard’ heeft, dan moet kolom Creditcard een waarde bevatten,
 en anders moet kolom Creditcard een NULL-waarde bevatten. */
ALTER TABLE Verkoper 
ADD CONSTRAINT CHK_CreditcardGevuld
CHECK (controleoptienaam = 'creditcard' AND creditcardnummer IS NOT NULL AND rekeningnummer is null OR controleoptienaam = 'post' AND creditcardnummer is NULL AND rekeningnummer is not null);
GO


/* B 3	Tabel Verkoper:
In één tupel mogen kolommen Bankrekening en Creditcard niet allebei een NULL-waarde bevatten 
(voor elke verkoper moet ofwel een bankrekening ofwel een creditcard bekend zijn (allebei mag ook)). */

ALTER TABLE Verkoper 
ADD CONSTRAINT CHK_CreditOfBankNull 
CHECK (rekeningnummer = NULL AND creditcardnummer = NULL);
GO


/* B 4	Tabel Bestand:
Per voorwerp kunnen maximaal 4 afbeeldingen opgeslagen worden. */
CREATE FUNCTION dbo.NietMeerDanVierAfbeelding (@voorwerpnummer INT)
RETURNS INT
AS
BEGIN
	DECLARE @MinderDanVier BIT = 'False';
	DECLARE @number INT
	SET @number = (SELECT COUNT(filenaam)
	FROM dbo.Bestand
	WHERE filenaam = @voorwerpnummer)
	

	IF (@number < 5)
		SET @MinderDanVier = 'True'

	RETURN @MinderDanVier;
END;
GO

ALTER TABLE Bestand
ADD CONSTRAINT CHK_NietMeerDanVierAfbeeldingen
CHECK (dbo.NietMeerDanVierAfbeelding(voorwerpnummer) = 1);

GO



/* B 5	Tabel Bod:
Een nieuw bod moet hoger zijn dan al bestaande bedragen die geboden zijn voor hetzelfde voorwerp, 
en tenminste zoveel hoger als de minimumverhoging voorschrijft (zie appendix B, proces 3.1). */
CREATE FUNCTION dbo.CheckHoogsteBod (@voorwerpnummer INT ,@bodbedrag NUMERIC(10, 2))
RETURNS BIT
AS
BEGIN
	DECLARE @hoogstebod NUMERIC(10, 2);
	DECLARE @startprijs NUMERIC(10, 2);

	SET @startprijs = (	SELECT Startprijs
	FROM Voorwerp
	WHERE Voorwerpnummer = @voorwerpnummer)


	SET @hoogstebod = (
			SELECT TOP (1) bodbedrag
			FROM Bod
			WHERE voorwerpnummer = @voorwerpnummer
				AND NOT  bodbedrag = @startprijs
			ORDER BY bodbedrag DESC
			)

	IF (@hoogstebod < @startprijs)
	BEGIN
		RETURN 1
	END

	RETURN 0
END;
GO


ALTER TABLE Bod 
ADD CONSTRAINT CHK_CheckIsHogerBod
CHECK (dbo.CheckHoogsteBod(voorwerpnummer, bodbedrag) = 1)
GO


/* B 6	Tabellen Bod en Voorwerp:
Een gebruiker mag geen bod op één van zijn/haar eigen voorwerpen uitbrengen. */
CREATE FUNCTION dbo.GeenEigenBod(@voorwerpnummer INT ,@gebruikersnaam VARCHAR(25))
RETURNS BIT
AS
BEGIN
	DECLARE @OfferNietVanverkoper BIT = 1
	DECLARE @verkoper VARCHAR(25)

	SET @verkoper = (SELECT Verkoper
	FROM Voorwerp
	WHERE Voorwerpnummer = @voorwerpnummer)

	IF (@verkoper = @gebruikersnaam)
		SET @OfferNietVanverkoper = 0;

	RETURN @OfferNietVanverkoper
END;
GO



ALTER TABLE Bod 
ADD CONSTRAINT CHK_IsGeenEigenBod
CHECK (dbo.GeenEigenBod(voorwerpnummer, gebruikersnaam) = 1)
GO



/* AF 1	Tabel Voorwerp, kolom LooptijdeindeDag:
Kolom LooptijdeindeDag heeft de datum van LooptijdbeginDag + het aantal dagen dat Looptijd aangeeft. 
 */
--declare @looptijdeind;
--set @looptijdeind = SELECT DATEADD(DAY, looptijd, LooptijdbeginDag);

--PHP? met de insert?

/* AF 2	Tabel Voorwerp, kolom LooptijdeindeTijdstip:
Kolom LooptijdeindeTijdstip heeft dezelfde waarde als kolom LooptijdbeginTijdstip. 

Dit is opgelost met de productowner, we verwijderen kolom Eindetijdstip en maken van Looptijdbegintijdstip naar looptijdtijdstip */




/* AF 3	Tabel Voorwerp, kolom VeilingGesloten?:
Kolom VeilingGesloten? heeft de waarde ‘niet’ als de systeemdatum en –tijd vroeger zijn dan wat kolommen LooptijdeindeDag en LooptijdeindeTijdstip aangeven,
 en de waarde ‘wel’ als de systeemdatum en –tijd later zijn dan dat. */



/* AF 4	Tabel Voorwerp, kolom Koper:
Kolom Koper heeft een NULL-waarde, tenzij de veiling is gesloten en er op het voorwerp een bod is uitgebracht. 
Dan heeft kolom Koper de waarde uit kolom Bod(Gebruiker) die bij het hoogste bod op hetzelfde voorwerp hoort. */



/* AF 5	Tabel Voorwerp, kolom Verkoopprijs:
Kolom Verkoopprijs heeft een NULL-waarde, tenzij de veiling is gesloten en er op het voorwerp een bod is uitgebracht. 
Dan heeft kolom Verkoopprijs de waarde uit kolom Bod(Bodbedrag) die bij het hoogste bod op hetzelfde voorwerp hoort. */


