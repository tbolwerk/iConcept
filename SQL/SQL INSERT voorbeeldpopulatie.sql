/*
Veilingsite Eenmaal Andermaal
Auteurs: Michael Kalil 590395, Twan Bolwerk 598576, Ivan Miladinovic 599294, Janno Onink 602808, Suzanne Bogaard 603439, Auke Onvlee 604640
Datum: 07-05-2018
*/
use testDB;
--use iConcept;

delete from Rubriek;
delete from Landen;
delete from Voorwerp_In_Rubriek;

delete from Bod;
delete from Bestand;
delete from Voorwerp;
delete from Verkoper;
delete from Gebruikerstelefoon;
delete from Verificatiecode;
delete from Gebruiker;
delete from Vraag;


DBCC CHECKIDENT(Voorwerp, RESEED, 0);
DBCC CHECKIDENT(Gebruikerstelefoon, RESEED, 0);
DBCC CHECKIDENT(Vraag, RESEED, 0);


Insert into Vraag(vraag)
VALUES
		('Wat is je geboortedatum?'),
		('In welke straat ben je geboren?'),
		('Wat is de meisjesnaam je moeder?'),
		('Wat is je lievelingsgerecht?'),
		('Hoe heet je oudste zusje?'),
		('Hoe heet je huisdier?'),
		('In welke stad is je vader geboren?'),
		('In welke stad is je moeder geboren?'),
		('Wat is je moeders geboortedatum?'),
		('Wat is je vaders geboortedatum?')
		;
GO


Insert into Gebruiker(gebruikersnaam, voornaam, achternaam, adresregel1, postcode, plaatsnaam, land, geboortedatum, email, wachtwoord, vraagnummer, antwoordtekst, verkoper, geactiveerd)
Values 
		('janbeenham', 'Ján', 'van Dooren', 'De goudenstraat 93', '3712HT', 'Zeist', 'Nederland', '1970-03-03', 'janbeenham@hotmail.com', 'janbeenham00', 1, '03-03-1970',  1, 1),
		('michkz', 'micháel', 'Kalil', 'De grote beer 5', '6501KL', 'Nijmegen', 'Nederland', '1997-11-08', 'MZ.Kalil@student.han.nl', '590395', 1, 'De grote beer', 1, 1),
		('twankoekepan', 'twan', 'bolwerk', 'Heyéndaalseweg 98', '1010TH', 'Amsterdam', 'Nederland', '1994-11-02', 'TPN.Bolwerk@student.han.nl', '598576', 2, 'meisjenaam', 0, 1),
		('ggwp', 'ivan', 'miladinoviç', 'De achterbergsestraatweg 139', '3913KL', 'Rhenen', 'Nederland', '1995-07-25', 'I.Miladinovic@student.han.nl', '599294', 3, 'pizza', 1, 1),
		('aukeonfleek', 'Auké', 'Onvlee', 'De cuneraweg 17', '5262HP','Rotterdam', 'Nederland', '1998-02-03', 'AM.Onvlee@student.han.nl', '604640', 5, 'suus', 1, 1),
		('klikokotsjongen', 'Youri', 'Maarnen', 'grebbeweg 23',  '3922XJ', 'Wageningen', 'Nederland', '1981-03-09', 'klikokotsjongen@gmail.com', 'klikokotsjongen00', 1, 'grebbeweg', 1, 0),
		('bigben10', 'Ben', 'Hammington', 'londonroad 201', 'E130AA', 'London', 'United Kingdom', '1988-12-30', 'benhammington@gmail.com', 'bigben00', 2, 'benlia', 0, 1),
		('deutschesalade', 'Herman', 'Reinhart', 'neuestrasse 23','10119', 'Berlin', 'Duitsland', '1995-01-03', 'hermanreinhart@hotmail.com', 'herman00', 3, 'kartoffel', 1, 1),
		('letourleeiffel', 'jean', 'Claude', 'la rue rouge 2',  '75011', 'Paris',  'Frankrijk', '1992-02-01', 'jeanclaude@gmail.com', 'jeanclaude00', 4, 'jeanette', 0, 1),
		('jeromeke', 'Jeroen', 'Janssen', 'Cálvijnstraat 23', '2020', 'Antwerpen', 'België', '1964-10-26', 'jeroenjanssen@hotmail.com', 'jeromeke00', 1, '26-10-1964', 0, 1),
		('BeenmaalAndermaal', 'mknc', 'yuino', 'awda', '7812AK', 'thuis', 'hier', '0815-01-01', 'beenmaal@andermaal.com', 'cdxsza', 3, 'dfjkvn', 0, 1) 
		;



INSERT into Gebruikerstelefoon(gebruikersnaam, telefoonnummer)
VALUES 
	('janbeenham', '06-90876543'),
	('michkz', '06-29934411'),
	('twankoekepan', '06-11293822'),
	('klikokotsjongen', '06-39669313'),
	('deutschesalade', '06-40626503'),
	('ggwp', '06-59731441'),
	('aukeonfleek', '06-36298475'),
	('letourleeiffel', '06-24645617'),
	('BeenmaalAndermaal', '06-18602640'), 
    ('BeenmaalAndermaal', '06-98372942'), 
    ('BeenmaalAndermaal', '06-12312640') 
	;

GO


Insert into Verkoper(gebruikersnaam, banknaam, rekeningnummer, controleoptienaam, creditcardnummer)
VALUES
		('janbeenham', null,null, 'creditcard', 54321),
		('aukeonfleek', null,null, 'creditcard', 4324),
		('ggwp', null, null, 'creditcard', 3213),
		('michkz', null, null, 'creditcard', 41343)
		;
GO


--CONVERSIE
insert into dbo.Rubriek
select DISTINCT (d.ID) as rubrieknummer,
		d.Name as rubrieknaam,
		(d.Parent) as rubrieknummerOuder
		from GrootDBBedrijf.dbo.Categorieen d 

GO

insert into dbo.Landen
select DISTINCT d.GBA_CODE as landcode,
				d.NAAM_LAND as landnaam,
				d.BEGINDATUM as begindatum,
				d.EINDDATUM as einddatum,
				d.EER_Lid as eer_lid
				from GrootDBBedrijf.dbo.tblIMAOLand d
GO
--CONVERSIE


Insert into Voorwerp(voorwerpnummer,titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam, land, looptijd, Looptijdbegindag, Looptijdtijdstip, verzendkosten, verzendinstructies, verkoper, koper, veilinggesloten, verkoopprijs)
VALUES
		(1,'Product nr 1', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 1, 'Creditcard', 'Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.', 'Nijmegen', 'Nederland', 60, GETDATE(), CURRENT_TIMESTAMP, 5, 'Gaat via postnl', 'janbeenham', null , 0, NULL),
		(2, 'Product nr 2', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 10, 'Creditcard', 'Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. ', 'Nijmegen', 'Nederland', 365, '2018-05-05', CURRENT_TIMESTAMP, 5, 'Gaat via postnl', 'janbeenham',null , 0, NULL),
		(3,'Product nr 3', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. ', 50, 'Bank', 'Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.', 'Nijmegen', 'Nederland', 60, '2018-05-05', CURRENT_TIMESTAMP, 5, 'Gaat via postnl', 'janbeenham',null ,  0, NULL),
		(4,'Product nr 4', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. ', 30, 'Bank', 'Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.', 'Nijmegen', 'Nederland', 425, '2017-05-05', CURRENT_TIMESTAMP, 5, 'Gaat via postnl', 'janbeenham',null,  0, NULL),
		(5,'Product nr 5', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. ', 10, 'Bank', 'Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.', 'Nijmegen', 'Nederland', 30, '2018-05-05', CURRENT_TIMESTAMP, 5, 'Gaat via postnl', 'janbeenham',null,  0, NULL),
		(6,'Product nr 6', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. ', 20, 'Bank', 'Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.', 'Nijmegen', 'Nederland', 30, '2018-05-05', CURRENT_TIMESTAMP, 5, 'Gaat via postnl', 'janbeenham',null, 0, NULL)
		;

GO



Insert into Bod(voorwerpnummer, bodbedrag, gebruikersnaam, boddag, bodtijdstip)
VALUES
		(1, 5, 'aukeonfleek',GETDATE(), CURRENT_TIMESTAMP),
		(2, 20, 'deutschesalade','2018-05-06', CURRENT_TIMESTAMP),
		(2, 25, 'ggwp', '2018-05-07', CURRENT_TIMESTAMP)
		;

GO


Insert into Bestand(voorwerpnummer)
VALUES
		(1),
		(2),
		(3),
		(4),
		(5),
		(6)
		;

GO


		
Insert into Voorwerp_in_Rubriek
VALUES
		(1, 1), --verzamelen
		(2, 30), --overige klassiek speelgoed
		(3, 63), --stripboeken
		(4, 80), --verzamelstrips
		(5, 57), -- filmobjecten
		(6, 120) --creatief speelgoed
		;  

GO