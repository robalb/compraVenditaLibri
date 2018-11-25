/*
    DB quick setup file, 
    you can run this code in 2 different ways, 
    copy and put the code inside a php query or inside the console in your db graphical interface
*/

-- INSTITUTES AND UNIVERSITIES TABLE CREATION
create table Inst(
    InstituteId int(4) not null,
    InstituteName varchar(50) not null,
    CityId int(2) not null,
    CityName varchar(50) not null,
    ProvinceId int(3) not null,
    ProvinceName varchar(50) not null,
    RegionId int(2) not null,
    RegionName varchar(50) not null,
    primary key (InstituteId)
);

-- USERS ACCOUNT TABLE CREATION
create table Accounts (
    AccountId bigint(10) not null,
    Name varchar(140) not null,
    Password varchar(256) not null,
    Email varchar(150) not null,
    EmailValidation int(1) default null,
    PhoneNumber bigint(10) default null,
    PhoneNumberValidation int(1) default null,
    InstId int(4) not null,
    InstCityId int(2) not null,
    InstProvinceId int(3) not null,
    InstRegionId int(2) not null,
    TokenAuthFb varchar(150),
    RegistrationDate timestamp not null,
    primary key (AccountId),
    foreign key (InstId) references Inst (InstituteId)
);

-- SALES TABLE CREATION
create table BooksOnSale (
    AccountId bigint(10) not null,
    IdSale bigint(10) not null,
    BookName varchar(100) not null,
    Isbn bigint(13) not null,
    Description varchar(1000) default 'Non è stata fornita una descrizione del libro in questione',
    PhotoOneUrl varchar(30),
    PhotoTwoUrl varchar(30),
    PhoneNumberVisibility bit not null,
    EmailVisibility bit not null,
    PublicationDate timestamp not null,
    primary key (IdSale),
    foreign key (AccountId) references Accounts (AccountId)
);

-- SEGNALATIONS TABLE CREATION
create table Segnalations(
    SegnalationId int(10) not null,
    SegnalatedAccountId bigint(10) not null,
    SegnalatedPostId bigint(10) not null,
    SegnalatorsAccountId bigint(10) not null,
    SegnalationReasonId int(1) not null,
    SegnalationDate timestamp not null,
    primary key (SegnalationId),
    foreign key (SegnalatedAccountId) references Accounts (AccountId),
    foreign key (SegnalatorsAccountId) references Accounts (AccountId),
    foreign key (SegnalatedPostId) references BooksOnSale (IdSale)
);
create table MailsValidation(
    ConfirmationId varchar(60) not null,
    Mail varchar(150) not null,
    primary key (ConfirmationId)
);

-- CREATING FEW ACCOUNTS 
 insert into Inst (InstituteId,InstituteName,CityId,CityName,ProvinceId,ProvinceName,RegionId,RegionName) 
 values (1,'P.Hensemberger',1,'Monza',1,'Monza e Brianza',1,'Lombardia');



