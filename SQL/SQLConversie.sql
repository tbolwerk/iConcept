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

drop function dbo.udf_StripHTML;
--simpele functie voor html strippen
CREATE FUNCTION [dbo].[udf_StripHTML] (@HTMLText VARCHAR(MAX))
RETURNS VARCHAR(MAX)
AS
BEGIN
DECLARE @Start INT
DECLARE @End INT
DECLARE @Length INT
DECLARE @StartIndex int, @EndIndex int;
SET @Start = CHARINDEX('<',@HTMLText) SET @End = 
CHARINDEX('>',@HTMLText,CHARINDEX('<',@HTMLText)) 
SET @Length = (@End - @Start) + 1 WHILE @Start > 0
AND @End > 0
AND @Length > 0
BEGIN
SET @HTMLText = STUFF(@HTMLText,@Start,@Length,'')
SET @Start = CHARINDEX('<',@HTMLText) SET @End = CHARINDEX('>',@HTMLText,CHARINDEX('<',@HTMLText))
SET @Length = (@End - @Start) + 1
--SET @HTMLText = REPLACE(@HTMLText, '&nbsp;', ' ')
select @HTMLText = REPLACE(@HTMLText,  '&nbsp;', ' ')
--SELECT @StartIndex = CHARINDEX('{', @HTMLText, 0), @EndIndex = CHARINDEX('}', @HTMLText, 0);
--SELECT @HTMLText = SUBSTRING(@HTMLText, 0, @StartIndex) + SUBSTRING(@HTMLText, @EndIndex + 1, LEN(@HTMLText) - @EndIndex)
END
RETURN LTRIM(RTRIM(@HTMLText))
END
GO

select dbo.udf_StripHTML(Beschrijving) 
from GrootDBBedrijf.dbo.Items


select replace(replace(replace(replace(dbo.udf_StripHTML(Beschrijving), '&nbsp;', ' '), 'var itemNumber ', ' '), 'document.writeln('');', ' '), '&amp;', '&')
from GrootDBBedrijf.dbo.Items




DECLARE @StartIndex int, @EndIndex int;
DECLARE @Str varchar(max);
select @Str = replace(replace(replace(replace(dbo.udf_StripHTML(Beschrijving), '&nbsp;', ' '), 'var itemNumber ', ' '), 'document.writeln('');', ' '), '&amp;', '&')
from GrootDBBedrijf.dbo.Items;

SELECT @StartIndex = CHARINDEX('(', @Str, 0), @EndIndex = CHARINDEX(')', @Str, 0);

SELECT SUBSTRING(@Str, 0, @StartIndex) + SUBSTRING(@Str, @EndIndex + 1, LEN(@Str) - @EndIndex) AS [Method1],
    LEFT(@Str, @StartIndex - 1) + RIGHT(@Str, LEN(@Str) - @EndIndex) AS [Method2];



--functie werkt niet maar zou beter moeten werken
drop function dbo.fn_RemoveHTMLFromText;

CREATE FUNCTION dbo.fn_RemoveHTMLFromText (@inputString nvarchar(max))
RETURNS nvarchar(MAX)

AS
BEGIN

  /*Variables to store source fielde temporarily and to remove tags one by one*/
  DECLARE @replaceHTML nvarchar(max), @counter int, @outputString nvarchar(max)
  set @counter = 0
  SET @outputString = @inputString

  /*This was extra case which I've added later to remove no-break space*/
  SET @outputString = REPLACE(@outputString, '&nbsp;', '')

  /*This loop searches for tags beginning with "<" and ending with ">" */
  WHILE (CHARINDEX('<', @outputString,1)>0 AND CHARINDEX('>', @outputString,1)>0)
  BEGIN
    SET @counter = @counter + 1

    /*
    Some math here... looking for tags and taking substring storing result into temporarily variable, for example "</span>" 
   */
   SELECT @replaceHTML = SUBSTRING(@outputString, CHARINDEX('<', @outputString,1), CHARINDEX('>',   @outputString,1)-CHARINDEX('<', @outputString,1)+1)

   /* Replace the tag that we stored in previous step */
   SET @outputString = REPLACE(@outputString, @replaceHTML, '') 

   /* Let's clear our variable just in case... */
   SET @replaceHTML = ''

   /* Let's set up maximum number of tags just for fun breaking the loop after 15 tags */
  if @counter >15
      RETURN(@outputString);

  END

  RETURN(@outputString);

END 


GO



IF OBJECT_ID('dbo.MyHTMLDecode') IS NOT NULL BEGIN DROP FUNCTION dbo.MyHTMLDecode END

GO
CREATE FUNCTION dbo.MyHTMLDecode (@vcWhat VARCHAR(MAX))
RETURNS VARCHAR(MAX)
AS
BEGIN
    DECLARE @vcResult VARCHAR(MAX)
    DECLARE @siPos INT
        ,@vcEncoded VARCHAR(7)
        ,@siChar INT

    SET @vcResult = RTRIM(LTRIM(CAST(REPLACE(@vcWhat COLLATE Latin1_General_BIN, CHAR(0), '') AS VARCHAR(MAX))))

    SELECT @vcResult = REPLACE(REPLACE(@vcResult, '&#160;', ' '), '&nbsp;', ' ')

    IF @vcResult = ''
        RETURN @vcResult

    SELECT @siPos = PATINDEX('%&#[0-9][0-9][0-9];%', @vcResult)

    WHILE @siPos > 0
    BEGIN
        SELECT @vcEncoded = SUBSTRING(@vcResult, @siPos, 6)
            ,@siChar = CAST(SUBSTRING(@vcEncoded, 3, 3) AS INT)
            ,@vcResult = REPLACE(@vcResult, @vcEncoded, NCHAR(@siChar))
            ,@siPos = PATINDEX('%&#[0-9][0-9][0-9];%', @vcResult)
    END

    SELECT @siPos = PATINDEX('%&#[0-9][0-9][0-9][0-9];%', @vcResult)

    WHILE @siPos > 0
    BEGIN
        SELECT @vcEncoded = SUBSTRING(@vcResult, @siPos, 7)
            ,@siChar = CAST(SUBSTRING(@vcEncoded, 3, 4) AS INT)
            ,@vcResult = REPLACE(@vcResult, @vcEncoded, NCHAR(@siChar))
            ,@siPos = PATINDEX('%&#[0-9][0-9][0-9][0-9];%', @vcResult)
    END

    SELECT @siPos = PATINDEX('%#[0-9][0-9][0-9][0-9]%', @vcResult)

    WHILE @siPos > 0
    BEGIN
        SELECT @vcEncoded = SUBSTRING(@vcResult, @siPos, 5)
            ,@vcResult = REPLACE(@vcResult, @vcEncoded, '')
            ,@siPos = PATINDEX('%#[0-9][0-9][0-9][0-9]%', @vcResult)
    END

    SELECT @vcResult = REPLACE(REPLACE(@vcResult, NCHAR(160), ' '), CHAR(160), ' ')

    SELECT @vcResult = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(@vcResult, '&amp;', '&'), '&quot;', '"'), '&lt;', '<'), '&gt;', '>'), '&amp;amp;', '&'), 'var itemNumber', '')

    RETURN @vcResult
END

GO


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



insert into testDB.dbo.Voorwerp
select DISTINCT d.ID as voorwerpnummer,
				d.Titel as titel,
				d.Beschrijving as beschrijving,
				d.Prijs as startprijs,


insert into iConcept.dbo.Bestand


select Beschrijving from GrootDBBedrijf.dbo.Items

select dbo.udf_StripHTML(beschrijving) from GrootDBBedrijf.dbo.Items

select top 50 dbo.fn_RemoveHTMLFromText(beschrijving) from GrootDBBedrijf.dbo.Items

SELECT REPLACE('8 190','char(160)','')

UPDATE GrootDBBedrijf.dbo.Items
SET Beschrijving = REPLACE(Beschrijving, NCHAR(0x00A0), '')
WHERE Beschrijving = x

SELECT REPLACE(Beschrijving,'cde','xxx');  
GO  

/* strip html met replace zodat &nbsp; weghaalt */
select replace(replace(dbo.udf_StripHTML(Beschrijving), '&nbsp;', ' '), 'var itemNumber', ' ')
from GrootDBBedrijf.dbo.Items


	SELECT (dbo.udf_StripHTML(dbo.MyHTMLDecode(Beschrijving)))
	from GrootDBBedrijf.dbo.Items

	select Beschrijving from GrootDBBedrijf.dbo.Items

	select * from GrootDBBedrijf.dbo.Users