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
SET @HTMLText = STUFF(@HTMLText,@Start,@Length,'')
SET @Start = CHARINDEX('<',@HTMLText) 
SET @End = CHARINDEX('>',@HTMLText,CHARINDEX('<',@HTMLText))
SET @Length = (@End - @Start) + 1
select @HTMLText = REPLACE(@HTMLText,  '&nbsp;', ' ')
--SET @HTMLText = RIGHT(@HTMLText+'{document.write('');}', CHARINDEX('{document.write('');}',@HTMLText+'{document.write('');}')-1)
--SET @HTMLText = LEFT(@HTMLText+'<!--  var', CHARINDEX('<!--  var',@HTMLText+'<!--  var')-1)
--SET @HTMLText = LEFT(@HTMLText+'0)     {', CHARINDEX('0)     {',@HTMLText+'0)     {')-1)
--SELECT @StartIndex = CHARINDEX('//-->', @HTMLText, 0), @EndIndex = CHARINDEX('0)', @HTMLText, 0);
--SELECT @HTMLText = SUBSTRING(@HTMLText, 0, @StartIndex) + SUBSTRING(@HTMLText, @EndIndex + 1, LEN(@HTMLText) - @EndIndex)
SET  @HTMLText = LEFT(@HTMLText, CHARINDEX('ret += ",";', @HTMLText) - 1)
END	
RETURN LTRIM(RTRIM(@HTMLText))
END
GO

select dbo.udf_StripHTML(Beschrijving) 
from GrootDBBedrijf.dbo.Items

SELECT LEFT(dbo.udf_StripHTML(Beschrijving), CHARINDEX('0)', dbo.udf_StripHTML(Beschrijving)) - 1)
FROM GrootDBBedrijf.dbo.Items
 
 //-->    0) 0)     {  {       ret

select replace(replace(replace(replace(dbo.udf_StripHTML(Beschrijving), '&nbsp;', ' '), 'var itemNumber ', ' '), 'document.writeln('');', ' '), '&amp;', '&')
from GrootDBBedrijf.dbo.Items




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



insert into testDB.dbo.Voorwerp
select DISTINCT d.ID as voorwerpnummer,
				d.Titel as titel,
				d.Beschrijving as beschrijving,
				d.Prijs as startprijs,


insert into iConcept.dbo.Bestand

