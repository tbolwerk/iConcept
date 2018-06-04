SET NOCOUNT ON 

use iConcept;
--use testDB;

--delete from Rubriek;
--DBCC CHECKIDENT(Rubriek, RESEED, 0);
--delete from Bestand;
--delete from Bod;
--delete from Voorwerp_In_Rubriek;
--delete from Voorwerp;
--delete from Verkoper;
--delete from Gebruikerstelefoon;
--delete from Verificatiecode;
--delete from Gebruiker;
--delete from Vraag;
--delete from Landen;





IF OBJECT_ID('dbo.udf_StripHTML') IS NOT NULL BEGIN DROP FUNCTION dbo.udf_StripHTML END
GO
--simpele functie voor html strippen
CREATE FUNCTION [dbo].[udf_StripHTML] (@HTMLText VARCHAR(MAX))
RETURNS VARCHAR(MAX)
AS
BEGIN
DECLARE @Start INT
DECLARE @End INT
DECLARE @Length INT
DECLARE @StartIndex int, @EndIndex int;

SET @Start = CHARINDEX('<',@HTMLText) 
SET @End = CHARINDEX('>',@HTMLText,CHARINDEX('<',@HTMLText)) 
SET @Length = (@End - @Start) + 1 WHILE @Start > 0
AND @End > 0
AND @Length > 0
BEGIN
SET @HTMLText = LTRIM(RTRIM(STUFF(@HTMLText,@Start,@Length,'')))
SET @Start = CHARINDEX('<',@HTMLText) 
SET @End = CHARINDEX('>',@HTMLText,CHARINDEX('<',@HTMLText))
SET @Length = (@End - @Start) + 1

select @HTMLText = replace(REPLACE(REPLACE(@HTMLText,  '&nbsp;', ' '), '{document.write('');}', ' '), 'document.writeln('');', '')
--SET @HTMLText = RIGHT(@HTMLText+'{document.write('');}', CHARINDEX('{document.write('');}',@HTMLText+'{document.write('');}')-1)
--SET @HTMLText = LEFT(@HTMLText+'<!--  var', CHARINDEX('<!--  var',@HTMLText+'<!--  var')-1)
--SET @HTMLText = LEFT(@HTMLText+'0)     {', CHARINDEX('0)     {',@HTMLText+'0)     {')-1)
--SELECT @StartIndex = CHARINDEX('//-->', @HTMLText, 0), @EndIndex = CHARINDEX('0)', @HTMLText, 0);
--SELECT @HTMLText = SUBSTRING(@HTMLText, 0, @StartIndex) + SUBSTRING(@HTMLText, @EndIndex + 1, LEN(@HTMLText) - @EndIndex)
--SET  @HTMLText = LEFT(@HTMLText, CHARINDEX('ret += ",";', @HTMLText) - 1)
END	
RETURN LTRIM(RTRIM(@HTMLText))
END
GO

select dbo.udf_StripHTML(Beschrijving) 
from GrootDBBedrijf.dbo.Items

select dbo.RemoveBracketedText(dbo.udf_StripHTML(Beschrijving))
from GrootDBBedrijf.dbo.Items

select RIGHT(dbo.udf_StripHTML(Beschrijving),len(dbo.udf_StripHTML(Beschrijving)) - patindex('%//-->%',dbo.udf_StripHTML(Beschrijving) ))
from GrootDBBedrijf.dbo.Items

SELECT LEFT(dbo.udf_StripHTML(Beschrijving), CHARINDEX('0)', dbo.udf_StripHTML(Beschrijving)) - 1)
FROM GrootDBBedrijf.dbo.Items
 
DECLARE @StartIndex int, @EndIndex int;
DECLARE @Str nvarchar(max);
select @Str = dbo.udf_StripHTML(Beschrijving) 
from GrootDBBedrijf.dbo.Items

SELECT @StartIndex = CHARINDEX('{', @Str, 0), @EndIndex = CHARINDEX('}', @Str, 0);

SELECT SUBSTRING(@Str, 0, @StartIndex) + SUBSTRING(@Str, @EndIndex + 1, LEN(@Str) - @EndIndex) AS [Method1]

//LEFT(@Str, @StartIndex - 1) + RIGHT(@Str, LEN(@Str) - @EndIndex) AS [Method2];

 //-->    0) 0)     {  {       ret
IF OBJECT_ID('dbo.RemoveBracketedText') IS NOT NULL BEGIN DROP FUNCTION dbo.RemoveBracketedText END
GO
CREATE FUNCTION RemoveBracketedText(@sourceString varchar(max))
RETURNS varchar(max)
AS
BEGIN

DECLARE @pStart Int
DECLARE @pEnd Int
DECLARE @pTarget varchar(max)
DECLARE @pResult varchar(max)

SET @pStart = CHARINDEX('{', @sourceString)
SET @pEnd = CHARINDEX('}', @sourceString, @pStart) /** start looking from pos of opening bracket */

IF @pEnd > @pStart AND @pEnd > 0  /** basic error avoidance */
BEGIN
  SET @pTarget = SUBSTRING(@sourceString, @pStart, @pEnd - @pStart + 1)
  SET @pResult = Replace(@sourceString, @pTarget, '')

  /** recursion to get rid of more than one set of brackets per string */
  IF CHARINDEX('{', @pResult) > 0 AND CHARINDEX('}', @pResult) > CHARINDEX('{', @pResult)
  BEGIN
    SET @pResult = dbo.RemoveBracketedText(@pResult)  
  END
END
ELSE
BEGIN
  SET @pResult = @sourceString  /** no matching set of brackets found */
END

RETURN @pResult
END



--Code om van oude database over te zetten na nieuwe.
insert into testDB.dbo.Rubriek
select DISTINCT (d.ID) as rubrieknummer,
		d.Name as rubrieknaam,
		(d.Parent) as rubrieknummerOuder
		from GrootDBBedrijf.dbo.Categorieen d 


insert into iConcept.dbo.Landen
select DISTINCT d.GBA_CODE as landcode,
				d.NAAM_LAND as landnaam,
				d.BEGINDATUM as begindatum,
				d.EINDDATUM as einddatum,
				d.EER_Lid as eer_lid
				from GrootDBBedrijf.dbo.tblIMAOLand d

				
insert into testDB.dbo.Gebruiker(gebruikersnaam, voornaam, achternaam, adresregel1, postcode, plaatsnaam, land, geboortedatum, email, wachtwoord, vraagnummer, antwoordtekst, verkoper, geactiveerd)
select DISTINCT d.Username as gebruikersnaam,
				'Voornaam' as voornaam,
				'Achternaam' as achternaam,
				'Niet ingevoerd' as adresregel1,
				d.Postalcode as postcode,
				'niet ingevoerd' as plaatsnaam,
				d.Location as land,
				'1990-01-01' as geboortedatum,
				'twanbolwerk'+ '+' + SUBSTRING(D.Username,0,75) + '@gmail.com' as email,
				cast((Abs(Checksum(NewId()))%10) as varchar(1)) + 
				char(ascii('a')+(Abs(Checksum(NewId()))%25)) +
				char(ascii('A')+(Abs(Checksum(NewId()))%25)) +
				left(newid(),5) as wachtwoord,
				1 as vraagnummer,
				'1990-01-01' as antwoordtekst,
				1 as verkoper,
				1 as geactiveerd
				from GrootDBBedrijf.dbo.Users d
				order by d.Username
GO


insert into testDB.dbo.Verkoper(gebruikersnaam, controleoptienaam, creditcardnummer)
select DISTINCT d.Username as gebruikersnaam,
				'Creditcard' as controleoptienaam,
				'123432' as creditcardnummer
				from GrootDBBedrijf.dbo.Users d
				order by d.Username
GO
/*
insert into testDB.dbo.Voorwerp
select DISTINCT TOP 20 d.ID as voorwerpnummer,
				d.Titel as titel,
				d.Beschrijving as beschrijving,
				d.Prijs as startprijs,
*/




insert into testDB.dbo.Voorwerp(voorwerpnummer, titel, beschrijving, startprijs, betalingswijze, plaatsnaam, land, looptijd, looptijdbegindag, looptijdtijdstip, verkoper, veilinggesloten)
SELECT
	ID as voorwerpnummer,
	SUBSTRING(Titel,0,50) AS titel,
	Beschrijving as beschrijving,
	Prijs AS startprijs,
	'Bank' AS betalingswijze,
	'unset' AS plaatsnaam,	
	Locatie AS land,
	10 AS looptijd,
	convert(date,getdate()) AS looptijdbegindag,
	convert(time,getdate()) AS looptijdtijdstip,
	Verkoper AS verkoper,
	0 AS veilinggesloten
from GrootDBBedrijf.dbo.Items
order by Titel
go

Insert into testDB.dbo.Voorwerp_in_Rubriek(voorwerpnummer, rubrieknummer)
SELECT
	ID as voorwerpnummer,
	Categorie as rubrieknummer
	FROM GrootDBBedrijf.dbo.Items
	ORDER BY Titel
GO


Insert into testDB.dbo.Bestand(voorwerpnummer, filenaam)
SELECT
		ID as voorwerpnummer,
		'http://iproject39.icasites.nl/thumbnails/' + Thumbnail
		FROM GrootDBBedrijf.dbo.Items
		ORDER BY Titel
GO

Insert into testDB.dbo.Bestand(voorwerpnummer, filenaam)
SELECT
		ItemID as voorwerpnummer,
		'http://iproject39.icasites.nl/pics/' + IllustratieFile as filenaam
		FROM GrootDBBedrijf.dbo.Illustraties
GO

/*

Select * from testDB.dbo.Gebruiker
Select * from iConcept.dbo.Gebruiker

Select * from iConcept.dbo.Voorwerp_in_Rubriek

Select * from testDB.dbo.Voorwerp
select * from GrootDBBedrijf.dbo.Items

select * from GrootDBBedrijf.dbo.Illustraties

select * from GrootDBBedrijf.dbo.Users order by Username


*/

/* SQL QUERY OM TE KIJKEN VOOR DUPLICATE RECORDS 
select *
from (
  select *, rn=row_number() over (partition by Username order by Username)
  from GrootDBBedrijf.dbo.Users
) x
where rn > 1;
*/

/* SQL QUERY OM DUPLICATE RECORDS TE VERWIJDEREN 
delete x from (
  select *, rn=row_number() over (partition by Username order by Username)
  from GrootDBBedrijf.dbo.Users
) x
where rn > 1;
*/

select voorwerpnummer, COUNT(filenaam)
FROM Bestand
GROUP BY voorwerpnummer

select voorwerpnummer, filenaam
FROM Bestand
ORDER BY voorwerpnummer




insert into iConcept.dbo.Bestand

select * from GrootDBBedrijf.dbo.Users

select * from testDB.dbo.Gebruiker

with randowvalues
    as(
       select 1 id, CONVERT(varchar(20), CRYPT_GEN_RANDOM(10)) as mypassword
        union  all
        select id + 1,  CONVERT(varchar(20), CRYPT_GEN_RANDOM(10)) as mypassword
        from randowvalues
        where 
          id < 100
      )
 
 
    select *
    from randowvalues
    OPTION(MAXRECURSION 0)