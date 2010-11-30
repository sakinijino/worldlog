set foreign_key_checks=0;
drop table if exists worldlog_users;
create table worldlog_users (
  id int not null auto_increment,
  name varchar(255) not null,
  nickname varchar(255) not null,
  password varchar(255) not null,
  email varchar(255) not null,
  img_url varchar(255),
  default_profile_id int,
  constraint fk_user_default_profile foreign key (default_profile_id) references worldlog_profiles(id) on delete set null,
  primary key (id)
);

drop table if exists worldlog_items;
create table worldlog_items (
  id int(11) not null auto_increment,
  user_id int(11) not null default '0',
  latitude double not null default '0',
  longitude double not null default '0',
  tags varchar(255) not null default '',
  icon varchar(255) not null default '',
  link varchar(255) default null,
  title varchar(255) not null default '',
  content mediumtext not null,
  type varchar(64) default null,
  valid enum('true','false') not null default 'true',
  createtime datetime not null default '0000-00-00 00:00:00',
  enable enum('true','false') not null default 'true',
  updatetime datetime not null default '0000-00-00 00:00:00',
  primary key  (id)
);

drop table if exists worldlog_resources;
create table worldlog_resources (
  resource_id int(11) not null auto_increment,
  item_id int(11) not null default '0',
  resource_uri varchar(255) default null,
  resource_type varchar(64) default '',
  resource_valid enum('true','false') not null default 'true',
  resource_createtime datetime not null default '0000-00-00 00:00:00',
  resource_enable enum('true','false') not null default 'true',
  resource_updatetime datetime not null default '0000-00-00 00:00:00',
  primary key  (resource_id)
);

drop table if exists worldlog_tags;
create table worldlog_tags (
  id int not null auto_increment,
  name varchar(255) not null,
  num int not null default '0',
  primary key (id)
);

drop table if exists worldlog_profiles;
create table worldlog_profiles (
  id int not null auto_increment,
  name varchar(255) not null,
  user_id int not null,
  longitude double not null,
  latitude double not null,
  zoom_level int not null,
  primary key (id)
);

drop table if exists worldlog_flickr_cache;
create table worldlog_flickr_cache (
  request varchar(35) not null default '',
  response text not null,
  expiration datetime not null default '0000-00-00 00:00:00',
  key request (request)
);

drop table if exists worldlog_item_ratings;
create table worldlog_item_ratings (
  rating_id int(11) not null auto_increment,
  item_id int(11) not null default '0',
  visits int(11) not null default '0',
  goodrating int(11) not null default '0',
  badrating int(11) not null default '0',
  primary key  (rating_id),
  unique key item_id (item_id)
);

drop table if exists worldlog_item_tag;
create table worldlog_item_tag (
  item_id int(11) not null default '0',
  tag_id int(11) not null default '0',
  primary key  (item_id,tag_id)
);

drop table if exists worldlog_profile_item;
create table worldlog_profile_item (
  p_id int not null,
  item_id int not null,
  primary key(p_id, item_id)
);
set foreign_key_checks=1;