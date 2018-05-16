-- Portable script for creating the pizza database
-- on your dev system:
-- mysql -u root -p < dev_setup.sql    
-- mysql -D pizzadb -u root -p < createdb.sql 
--  or, on topcat:
-- mysql -D <user>db -u <user> -p < createdb.sql 
create table menu_sizes(
id integer auto_increment,
size varchar(30) not null,
unique (size),
primary key(id)
);

create table menu_toppings(
id integer auto_increment,
topping varchar(30) not null,
unique (topping),
primary key(id)
);

create table status_values (
status_value varchar(10) primary key
);

-- With fix: effective FK to status_values (table constraint)
-- Mysql does not honor a FK that's part of a column definition!
create table pizza_orders(
id integer auto_increment,
room_number integer not null,
size varchar(30) not null,
day integer not null,
status varchar(10) references status_values(status_value),
primary key(id)
);

-- toppings for a pizza order
-- Note: we can't use a foreign key to menu_toppings here because the topping
-- might be deleted while the order is still in the system
-- Same with size in pizza_orders and menu_sizes
create table order_topping (
order_id integer not null,
topping varchar(30) not null,
primary key (order_id, topping),
foreign key (order_id) references pizza_orders(id));

-- one-row table doesn't need a primary key
create table pizza_sys_tab (
current_day integer not null
);

create table undelivered_orders (
    orderid integer not null, 
    flour_qty integer, 
    cheese_qty integer,
    primary key(orderid)
);

create table inventory (
    flour_qty integer, 
    cheese_qty integer
);

insert into pizza_sys_tab values (1);
-- minimal toppings and sizes on the menu: one each
insert into menu_toppings values (1,'Pepperoni');
insert into menu_sizes values (1,'small');
insert into status_values values ('Preparing');
insert into status_values values ('Baked');
insert into status_values values ('Finished');
insert into inventory values (100,100);


