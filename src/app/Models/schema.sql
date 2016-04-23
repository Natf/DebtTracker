DROP TABLE Users;
CREATE TABLE Users (uid int primary key, email varchar(50), password varchar(20), salt varchar(20));
DROP TABLE Debts;
CREATE TABLE Debts (did int primary key, uid int, owedId int, amount int, description varchar(150));