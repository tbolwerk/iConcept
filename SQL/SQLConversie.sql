SET NOCOUNT ON 

use iConcept

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

drop function dbo.udf_StripHTML

CREATE FUNCTION [dbo].[udf_StripHTML] (@HTMLText VARCHAR(MAX))
RETURNS VARCHAR(MAX)
AS
BEGIN
DECLARE @Start INT
DECLARE @End INT
DECLARE @Length INT
SET @Start = CHARINDEX('<',@HTMLText) SET @End = 
CHARINDEX('>',@HTMLText,CHARINDEX('<',@HTMLText)) 
SET @Length = (@End - @Start) + 1 WHILE @Start > 0
AND @End > 0
AND @Length > 0
BEGIN
SET @HTMLText = STUFF(@HTMLText,@Start,@Length,'')
SET @Start = CHARINDEX('<',@HTMLText) SET @End = CHARINDEX('>',@HTMLText,CHARINDEX('<',@HTMLText))
SET @Length = (@End - @Start) + 1
END
RETURN LTRIM(RTRIM(@HTMLText))
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

insert into iConcept.dbo.Bestand