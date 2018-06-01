IF OBJECT_ID('CHK_CheckIsHogerStart') IS NOT NULL BEGIN ALTER TABLE Bod
DROP CONSTRAINT CHK_CheckIsHogerStart END
GO

IF OBJECT_ID('dbo.CheckIsHogerStart') IS NOT NULL BEGIN DROP FUNCTION dbo.CheckIsHogerStart END
GO

IF OBJECT_ID('dbo.IsHoogsteBod') IS NOT NULL BEGIN DROP FUNCTION dbo.IsHoogsteBod END
GO

IF OBJECT_ID('dbo.tr_IsHoogsteBod') IS NOT NULL BEGIN DROP TRIGGER dbo.tr_IsHoogsteBod END
GO

CREATE FUNCTION dbo.CheckIsHogerStart (@voorwerpnummer INT ,@bodbedrag NUMERIC(9, 2))
RETURNS BIT
AS
BEGIN
	DECLARE @startprijs NUMERIC(9, 2);

	SET @startprijs = (	SELECT Startprijs
	FROM Voorwerp
	WHERE Voorwerpnummer = @voorwerpnummer)

	IF (@bodbedrag >= @startprijs)
	BEGIN
		RETURN 1
	END

	RETURN 0
END;
GO

CREATE FUNCTION dbo.IsHoogsteBod (@voorwerpnummer INT ,@bodbedrag NUMERIC(9, 2))
RETURNS BIT
AS
BEGIN
	DECLARE @hoogstebod NUMERIC(9, 2);

	SET @hoogstebod = (
				SELECT ISNULL(MAX(bodbedrag), 0) AS hoogstebod FROM bod
				WHERE voorwerpnummer = @voorwerpnummer
			)

	IF (@bodbedrag > @hoogstebod)
	BEGIN
		RETURN 1
	END

	RETURN 0
END;
GO



ALTER TABLE Bod
ADD CONSTRAINT CHK_CheckIsHogerStart
CHECK (dbo.CheckIsHogerStart(voorwerpnummer, bodbedrag) = 1)
GO



CREATE TRIGGER tr_IsHoogsteBod ON bod
INSTEAD OF INSERT
AS
BEGIN

DECLARE @voorwerpnummer INT,
        @bodbedrag NUMERIC(9,2)

SELECT  @voorwerpnummer = voorwerpnummer,
        @bodbedrag = bodbedrag
FROM inserted

IF (dbo.IsHoogsteBod(@voorwerpnummer, @bodbedrag) = 1)
	INSERT INTO bod SELECT * from inserted
ELSE
	THROW 50000, 'Niet het hoogste bod', 1
END
GO
