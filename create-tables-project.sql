CREATE DATABASE project;
USE project;

CREATE TABLE CAR (
ReferenceID			int				not null			primary key			auto_increment,
Reference			varchar(200)	not null,
Year				int				not null,
Transmission	    varchar(50)	    not null,
Brand				varchar(50)		not null,
Type				varchar(25)		not null	
);

CREATE TABLE RENT (
RentID			int				not null			primary key			auto_increment,
ReferenceID		int				not null,
RentFee			dec(8,2)		not null,
constraint		ReferenceID_fk	foreign key(ReferenceID)
								references CAR(ReferenceID)
								on update cascade
                                on delete no action
);

CREATE TABLE CUSTOMER (
CustomerID			int				not null			primary key			auto_increment,
userid				varchar(50)		not null,
FirstName			varchar(100)	not null,
LastName			varchar(100)    not null,
Email				varchar(1000)	not null,
password 			varchar(1024) 	not null
);

CREATE TABLE QUOTE (
QuoteID		int					not null			primary key			auto_increment,
CustomerID	int					not null,
RentID		int					not null,
Date		varchar(100)		not null,
constraint	CustomerID_fk		foreign key(CustomerID)
								references CUSTOMER(CustomerID)
								on update cascade
                                on delete no action,	
constraint	RentID_fk			foreign key(RentID)
								references RENT(RentID)
								on update cascade
                                on delete no action			
);

#DROP DATABASE project;