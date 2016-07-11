use ad_e6d8eb1c641e824;

show tables;

create table error_tracker(error_id int auto_increment primary key, 
			uname varchar(100) not null,
			message varchar(500) not null,
            time_stamp datetime);
            
desc error_tracker;
desc stockvalue;
desc user;
desc utransaction;	
desc message;

select * from message;
select * from stockvalue;

insert into stockvalue values('IBM', 125, '2016-06-20 12 	:34:09 AM');

select stime, price from stockvalue where company ='IBM' order by stime desc;

select * from utransaction;

insert into utransaction values('priyanjitcareer@gmail.com', 'testadmin@gmail.com', '2016-07-08 17:41:07', 'Facebook', 1,
	5, 220);

insert into utransaction values('priyanjitcareer@gmail.com', 'testadmin@gmail.com', '2016-07-08 17:41:07', 'IBM', 1,
	5, 220);

insert into utransaction values('priyanjitcareer@gmail.com', 'testadmin@gmail.com', '2016-07-08 17:41:07', 'Google', 1,
	5, 260);

select t.company, s.stime, s.price price from stockvalue s 
	inner join utransaction t where s.company = t.company
    and uemail = 'priyanjitcareer@gmail.com';
    
select * from error_tracker;
