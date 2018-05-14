/*
Veilingsite Eenmaal Andermaal
Auteurs: Michael Kalil 590395, Twan Bolwerk 598576, Ivan Miladinovic 599294, Janno Onink 602808, Suzanne Bogaard 603439, Auke Onvlee 604640
Datum: 07-05-2018
*/
delete from Rubriek;
delete from Bestand;
delete from Voorwerp;
delete from Verkoper;
delete from Gebruikerstelefoon;
delete from Verificatiecode;
delete from Gebruiker;
delete from Vraag;
delete from Landen;

DBCC CHECKIDENT(Voorwerp, RESEED, 0);
DBCC CHECKIDENT(Gebruikerstelefoon, RESEED, 0);
DBCC CHECKIDENT(Vraag, RESEED, 0);

/*
insert into Rubriek
values	(1, 'Auto''s, boten en motoren', null),
		(2, 'Auto''s', 1),
		(3, 'Aanhangers', 1),
		(4, 'Zeilboten', 1),
		(5, 'Scooters', 1),
		(6, 'Boeken', null),
		(7, 'Fictie', 6),
		(8, 'Actie', 7),
		(9, 'Literatuur', 7),
		(10, 'Science fiction', 7),
		(11, 'School', 6),
		(12, 'Eten en Koken', 6),
		(13, 'Gezondheid en Voeding', 12),
		(14, 'Kookboeken', 12),
		(15, 'Stripboeken', 6);
		niet nodig met conversie script

*/

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
		('janbeenham', 'Jan', 'van Dooren', 'De goudenstraat 93', '3712HT', 'Zeist', 'Nederland', '1970-03-03', 'janbeenham@hotmail.com', 'janbeenham00', 1, '03-03-1970',  1, 1),
		('michkz', 'michael', 'Kalil', 'De grote beer 5', '6501KL', 'Nijmegen', 'Nederland', '1997-11-08', 'MZ.Kalil@student.han.nl', '590395', 1, 'De grote beer', 1, 1),
		('twankoekepan', 'twan', 'bolwerk', 'Heyendaalseweg 98', '1010TH', 'Amsterdam', 'Nederland', '1994-11-02', 'TPN.Bolwerk@student.han.nl', '598576', 2, 'meisjenaam', 0, 1),
		('ggwp', 'ivan', 'miladinovic', 'De achterbergsestraatweg 139', '3913KL', 'Rhenen', 'Nederland', '1995-07-25', 'I.Miladinovic@student.han.nl', '599294', 3, 'pizza', 1, 1),
		('aukeonfleek', 'Auke', 'Onvlee', 'De cuneraweg 17', '5262HP','Rotterdam', 'Nederland', '1998-02-03', 'AM.Onvlee@student.han.nl', '604640', 5, 'suus', 1, 1),
		('klikokotsjongen', 'Youri', 'Maarnen', 'grebbeweg 23',  '3922XJ', 'Wageningen', 'Nederland', '1981-03-09', 'klikokotsjongen@gmail.com', 'klikokotsjongen00', 1, 'grebbeweg', 1, 0),
		('bigben10', 'Ben', 'Hammington', 'londonroad 201', 'E130AA', 'London', 'United Kingdom', '1988-12-30', 'benhammington@gmail.com', 'bigben00', 2, 'benlia', 0, 1),
		('deutschesalade', 'Herman', 'Reinhart', 'neuestrasse 23','10119', 'Berlin', 'Duitsland', '1995-01-03', 'hermanreinhart@hotmail.com', 'herman00', 3, 'kartoffel', 1, 1),
		('letourleeiffel', 'jean', 'Claude', 'la rue rouge 2',  '75011', 'Paris',  'Frankrijk', '1992-02-01', 'jeanclaude@gmail.com', 'jeanclaude00', 4, 'jeanette', 0, 1),
		('jeromeke', 'Jeroen', 'Janssen', 'calvijnstraat 23', '2020', 'Antwerpen', 'België', '1964-10-26', 'jeroenjanssen@hotmail.com', 'jeromeke00', 1, '26-10-1964', 0, 1),
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
		('aukeonfleek', null,null, 'creditcard', 4324)
		;
GO



Insert into Voorwerp(titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam, land, looptijd, Looptijdbegindag, Looptijdtijdstip, verzendkosten, verzendinstructies, verkoper, koper, looptijdeindedag, veilinggesloten, verkoopprijs)
VALUES
		('Product', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 1, 'Creditcard', 'Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.', 'Nijmegen', 'Nederland', 60, GETDATE(), CURRENT_TIMESTAMP, 5, 'Gaat via postnl', 'janbeenham', null ,GETDATE(), 0, 100),
		('Product', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 10, 'Creditcard', 'Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. ', 'Nijmegen', 'Nederland', 365, 2018-05-05, CURRENT_TIMESTAMP, 5, 'Gaat via postnl', 'janbeenham', null , 2019-05-05, 0, 100),
		('Product', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. ', 50, 'Bank', 'Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.', 'Nijmegen', 'Nederland', 30, 2018-05-05, CURRENT_TIMESTAMP, 5, 'Gaat via postnl', 'janbeenham', null , 2018-06-05, 0, 100),
		('Product', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. ', 30, 'Bank', 'Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.', 'Nijmegen', 'Nederland', 30, 2018-05-05, CURRENT_TIMESTAMP, 5, 'Gaat via postnl', 'janbeenham', null , 2018-06-05, 0, 100),
		('Product', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. ', 10, 'Bank', 'Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.', 'Nijmegen', 'Nederland', 30, 2018-05-05, CURRENT_TIMESTAMP, 5, 'Gaat via postnl', 'janbeenham', null , 2018-06-05, 0, 100),
		('Product', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. ', 20, 'Bank', 'Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.', 'Nijmegen', 'Nederland', 30, 2018-05-05, CURRENT_TIMESTAMP, 5, 'Gaat via postnl', 'janbeenham', null , 2018-06-05, 0, 100)
		;




/* bleek onnodig te zijn omdat de land tabel van de andere database meer gegevens bevat en bijna dezelfde waardes heeft 
SET NOCOUNT ON /* zodat de console niet gespammed wordt, voeg deze bovenaan toe zodra voorbeeldpopulatie/insert script compleet is */
INSERT [dbo].[Landen] (landnaam) VALUES ('Afghanistan')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Albania')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Algeria')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('American Samoa')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Andorra')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Angola')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Anguilla')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Antarctica')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Antigua And Barbuda')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Argentina')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Armenia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Aruba')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Australia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Austria')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Azerbaijan')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Bahamas')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Bahrain')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Bangladesh')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Barbados')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Belarus')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Belgium')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Belize')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Benin')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Bermuda')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Bhutan')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Bolivia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Bosnia And Herzegowina')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Botswana')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Bouvet Island')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Brazil')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('British Indian Ocean Territory')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Brunei Darussalam')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Bulgaria')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Burkina Faso')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Burundi')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Cambodia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Cameroon')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Canada')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Cape Verde')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Cayman Islands')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Central African Republic')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Chad')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Chile')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('China')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Christmas Island')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Cocos (Keeling) Islands')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Colombia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Comoros')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Congo')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Cook Islands')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Costa Rica')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Cote D''Ivoire')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Croatia (Local Name: Hrvatska)')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Cuba')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Cyprus')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Czech Republic')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Denmark')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Djibouti')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Dominica')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Dominican Republic')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('East Timor')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Ecuador')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Egypt')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('El Salvador')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Equatorial Guinea')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Eritrea')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Estonia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Ethiopia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Falkland Islands (Malvinas)')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Faroe Islands')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Fiji')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Finland')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('France')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('French Guiana')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('French Polynesia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('French Southern Territories')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Gabon')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Gambia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Georgia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Germany')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Ghana')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Gibraltar')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Greece')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Greenland')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Grenada')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Guadeloupe')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Guam')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Guatemala')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Guinea')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Guinea-Bissau')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Guyana')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Haiti')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Heard And Mc Donald Islands')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Holy See (Vatican City State)')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Honduras')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Hong Kong')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Hungary')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Iceland')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('India')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Indonesia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Iran (Islamic Republic Of)')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Iraq')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Ireland')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Israel')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Italy')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Jamaica')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Japan')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Jordan')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Kazakhstan')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Kenya')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Kiribati')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Korea, Dem People''S Republic')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Korea, Republic Of')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Kuwait')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Kyrgyzstan')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Lao People''S Dem Republic')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Latvia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Lebanon')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Lesotho')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Liberia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Libyan Arab Jamahiriya')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Liechtenstein')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Lithuania')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Luxembourg')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Macau')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Macedonia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Madagascar')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Malawi')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Malaysia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Maldives')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Mali')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Malta')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Marshall Islands')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Martinique')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Mauritania')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Mauritius')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Mayotte')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Mexico')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Micronesia, Federated States')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Moldova, Republic Of')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Monaco')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Mongolia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Montserrat')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Morocco')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Mozambique')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Myanmar')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Namibia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Nauru')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Nepal')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Netherlands')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Netherlands Ant Illes')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('New Caledonia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('New Zealand')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Nicaragua')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Niger')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Nigeria')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Niue')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Norfolk Island')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Northern Mariana Islands')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Norway')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Oman')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Pakistan')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Palau')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Panama')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Papua New Guinea')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Paraguay')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Peru')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Philippines')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Pitcairn')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Poland')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Portugal')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Puerto Rico')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Qatar')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Reunion')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Romania')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Russian Federation')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Rwanda')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Saint K Itts And Nevis')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Saint Lucia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Saint Vincent, The Grenadines')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Samoa')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('San Marino')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Sao Tome And Principe')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Saudi Arabia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Senegal')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Seychelles')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Sierra Leone')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Singapore')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Slovakia (Slovak Republic)')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Slovenia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Solomon Islands')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Somalia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('South Africa')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('South Georgia , S Sandwich Is.')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Spain')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Sri Lanka')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('St. Helena')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('St. Pierre And Miquelon')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Sudan')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Suriname')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Svalbard, Jan Mayen Islands')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Sw Aziland')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Sweden')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Switzerland')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Syrian Arab Republic')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Taiwan')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Tajikistan')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Tanzania, United Republic Of')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Thailand')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Togo')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Tokelau')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Tonga')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Trinidad And Tobago')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Tunisia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Turkey')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Turkmenistan')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Turks And Caicos Islands')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Tuvalu')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Uganda')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Ukraine')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('United Arab Emirates')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('United Kingdom')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('United States')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('United States Minor Is.')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Uruguay')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Uzbekistan')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Vanuatu')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Venezuela')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Viet Nam')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Virgin Islands (British)')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Virgin Islands (U.S.)')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Wallis And Futuna Islands')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Western Sahara')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Yemen')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Yugoslavia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Zaire')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Zambia')
GO
INSERT [dbo].[Landen] (landnaam) VALUES ('Zimbabwe')
GO

SET NOCOUNT OFF; 

*/