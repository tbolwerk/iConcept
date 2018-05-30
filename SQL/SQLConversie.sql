SET NOCOUNT ON 

use testDB

delete from Rubriek;
DBCC CHECKIDENT(Rubriek, RESEED, 0);
delete from Bestand;
delete from Voorwerp;
delete from Verkoper;
delete from Gebruikerstelefoon;
delete from Verificatiecode;
delete from Gebruiker;
delete from Vraag;
delete from Landen;



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
insert into iConcept.dbo.Rubriek
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

				
insert into testDB.dbo.Gebruiker
select DISTINCT d.Username as gebruikersnaam,
				d.Postalcode as postcode,
				d.Location as land,
				cast((Abs(Checksum(NewId()))%10) as varchar(1)) + 
				char(ascii('a')+(Abs(Checksum(NewId()))%25)) +
				char(ascii('A')+(Abs(Checksum(NewId()))%25)) +
				left(newid(),5) as wachtwoord,
				CAST(RAND(CHECKSUM(NEWID())) * 10 as INT) + 1 as vraagnummer
				from GrootDBBedrijf.dbo.Users d
/*
insert into testDB.dbo.Voorwerp
select DISTINCT TOP 20 d.ID as voorwerpnummer,
				d.Titel as titel,
				d.Beschrijving as beschrijving,
				d.Prijs as startprijs,
*/

SET IDENTITY_INSERT Voorwerp ON
insert into testDB.dbo.Voorwerp
SELECT ID as voorwerpnummer,
	SUBSTRING(Titel,0,50) AS titel,
	dbo.udf_StripHTML(Beschrijving) as beschrijving,
	Prijs AS startprijs,
	'Bank/Giro' AS betalingswijze,
	'unset' AS plaatsnaam,
	Locatie AS land,
	10 AS looptijd,
	convert(date,getdate()) AS looptijdbegindag,
	convert(time,getdate()) AS looptijdtijdstip,
	'aukeonfleek' AS verkoper,
	0 AS veilinggesloten
from GrootDBBedrijf.dbo.Items
SET IDENTITY_INSERT Voorwerp OFF











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