CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT, brand varchar(100) NOT NULL, name varchar(75) NOT NULL, ptype varchar(125) NOT NULL);
INSERT INTO product (brand, name, ptype) VALUES ('Starbucks', 'Pumpkin Latte','kawa smakowa');
INSERT INTO product (brand, name, ptype) VALUES ('Costa', 'Sweet Sugarcane', 'kawa smakowa');
INSERT INTO product (brand, name, ptype) VALUES ('After Eight', 'Turtle','kawa smakowa');
INSERT INTO product (brand, name, ptype) VALUES ('Kawalerka', 'Cynobrowa Czarna','kawa smakowa');
INSERT INTO product (brand, name, ptype) VALUES ('Kawalerka', 'Latte Affogato','kawa smakowa');

CREATE TABLE menu (id INTEGER PRIMARY KEY AUTOINCREMENT, category varchar(75) NOT NULL, name varchar(75) NOT NULL, price varchar(8) NOT NULL);
INSERT INTO menu (category, name, price) VALUES ('cake', 'Blueberry Tart','$7');
INSERT INTO menu (category, name, price) VALUES ('cocktail', 'Banana-Spinach', '$5');

CREATE TABLE home (id INTEGER PRIMARY KEY AUTOINCREMENT, about varchar(500) NOT NULL, open varchar(500) NOT NULL);
INSERT INTO home (about, open) VALUES ('Klubokawiarnia położona na rogu ulicy Miodowej.','Godziny otwarcia: pon-pt: 9:00-21:00');