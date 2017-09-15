create table User (
    firstrname varchar(40) ,
    lastname varchar(40),
    password varchar(256), 
    email varchar(40),
    address varchar(100),
    gender varchar(15),
    profile varchar(400),
    primary key (username)
)
Alter table User add column lastname varchar(40), add column address varchar(100), add column gender varchar(15) after name;
alter table User add column photo varchar(255) after gender;

alter table User change column profile description varchar(400);
alter table User change column name firstname varchar(40);

alter table User modify lastname varchar(40) after name;

update Recipe set picture = 'img/slide4.jpg' where rid = 19;

create table Recipe (
    rid int(10) NOT NULL AUTO_INCREMENT,
    username varchar(40) ,
    title varchar(40),
    description varchar(40),
    serving int(10),
    direction varchar(800),
    cooktime varchar(20),
    picture varchar(255),
    posttime datetime,
    primary key (rid),
    foreign key (username) references User(username)
)

create table RecipePicture(
    rid int(10) ,
    picture varchar(200),
    primary key (rid, picture),
    foreign key(rid) references Recipe(rid)
)

create table RecipeIngredient(
    rid int(10),
    iname varchar(40),
    amount varchar(40),
    unit varchar(20),
    primary key (rid,iname),
    foreign key (rid) references Recipe(rid)
)

create table RecipeTag(
    rid int(10) ,
    tname varchar(40),
    primary key (rid, tname),
    foreign key (rid) references Recipe(rid)
)

create table RecipeLink(
    rid int(10) ,
    linkedid int(10),
    primary key (rid, linkedid),
    foreign key (rid) references Recipe(rid),
    foreign key (linkedid) references Recipe(rid)
)

create table Review(
    reviewid int(10) NOT NULL AUTO_INCREMENT,
    username varchar(40), 
    rid int(10),
    rtime datetime,
    rtitle varchar(40),
    reviews varchar(400),
    rating int(10),
    suggestions varchar(400),
    primary key (reviewid),
    foreign key (username) references User(username),
    foreign key (rid) references Recipe(rid)
)

create table ReviewPhoto(
    reviewid int(10),
    photo varchar(200),
    primary key(reviewid, photo),
foreign key(reviewid) references Review(reviewid)
)

Create table CookingGroup(
    gid int(10) not null auto_increment,
    gname varchar(100), 
    description varchar(200), 
    creater varchar(40),
    primary key(gid),
    foreign key (creater) references User(username)
)

Create table GroupMember(
    gid int(10),
    username varchar(40),
    primary key(gid, username),
    foreign key (gid) references CookingGroup(gid),
    foreign key (username) references User(username)
)

Create table GroupMeeting(
    mid int(10) not null auto_increment, 
    mname varchar(40),
    gid int(10), 
    organizer varchar(40),
    starttime datetime, 
    endtime datetime, 
    mdescription varchar(200),
    location varchar(40),
    primary key (mid),
    foreign key (gid) references CookingGroup(gid),
    foreign key (organizer) references User(username),
)

create table MeetingMember(
    mid int(10),
    username varchar(40),
    rating int(10),
    report varchar(800),
    sendRSVP tinyint(1),
    primary key(mid, username),
    foreign key(mid) references GroupMeeting(mid),
     foreign key(username) references User(username)
)

create table MeetingPhoto(
    mid int(10),
    user varchar(40),
    photo varchar(40),
    primary key(mid, user, photo),
    foreign key(mid) references GroupMeeting(mid),
    foreign key(user) references User(username)
)



insert into User values ('Mr.Cool', '234567',   'mc@gmail.com','Jason', 'I live in New York, I love curry food, I am studying computer science, My daddy is a chef! By the way, teach me make curry chicken.');
insert into User values ('akb48','abcd$$',  'sushiLover@gmail.com', 'Suel', 'Sushi is the most delicious, do you know that? I like sushi, I love sushi, sushi is the best, man!' );
insert into User values ('sweetyHeart','justing',   'jb@gmail.com', 'Bear',' I heard Chinese eat everything?! How brave and strange it is!! But just lets eat everything!');
insert into User values ('RockTheEarth', 'LEOMING123',  'lmmm@gmail.com','Ming',  'Hi everyone, I am from California. I love cooking. I am good at cooking Indian food and Chinese food. Chicken is my favorate. I am 30 years old now. Welcome to my place and cook together!');
insert into User values ('EatMonster', 'nxyc2z','ppptty@gmail.com', 'Pitty', 'Hi guys, do you like pizzaaaa, ahahaaa!');
insert into User values ('peace' ,'marypenny0',   'mp@gmail.com', 'Penny',' No matter what happens, food will always with you and bring you happiness and warm. Thanks god, thanks everyone. Let us pray for our food!');
insert into User values ('basketball_lord', '987654321',   'mj@gmail.com','Jordan',' Eat healthy, live healthy!');
insert into User values ('SingleMom','67891011', 'mk@gmail.com' ,'Kelly',  'The most important thing is preparing a good meal for my son.');
insert into User values ('HeyMan',  'microsoft',  'bg@gmail.com','Wndow', 'Hey, this is Bill. Hope I can learn cooking skills here.');

insert into Recipe values(1, 'EatMonster', 'Veggie Pizza', 3, '1.Preheat oven to 350 degrees F (175 degrees C). Spray a jellyroll pan with non-stick cooking spray.  
2.Pat crescent roll dough into a jellyroll pan. Let stand 5 minutes. Pierce with fork. 
3.Bake for 10 minutes, let cool.   
4.In a medium-sized mixing bowl, combine sour cream, cream cheese, dill weed, garlic salt and ranch dip mix. Spread this mixture on top of the cooled crust. Arrange the onion, carrot, celery, broccoli, radish, bell pepper and broccoli on top of the creamed mixture. Cover and let chill. Once chilled, cut it into squares and serve.','20 minutes', '2016-01-01 20:50:59');
insert into RecipeIngredient values (1, 'sour cream', 1, 'cup');
insert into RecipeIngredient values (1, 'cream chease', 1, 'package');
insert into RecipeIngredient values (1, 'salt', 1/4, 'teaspoon');
insert into RecipeIngredient values (1, 'crescent rolls', 2, 'packages');
insert into RecipeIngredient values (1, 'onion', 1, '');
insert into RecipeIngredient values (1, 'red bell pepper', 1, '');
insert into RecipeIngredient values (1, 'broccoli', 1, '');
insert into RecipeTag values (1, 'Italian'), (1, 'pizza'), (1, 'veggie');

insert into Recipe values(2, 'akb48', 'tuna sushi', 6, 'Soak rice for 4 hours. Drain rice and cook in a rice cooker with 2 cups of water. Rice must be slightly dry as vinegar will be added later.     2.Immediately after rice is cooked, mix in 6 tablespoons rice vinegar to the hot rice. Spread rice on a plate until completely cool.   3.Place 1 sheet of seaweed on bamboo mat, press a thin layer of cool rice on the seaweed. Leave at least 1/2 inch top and bottom edge of the seaweed uncovered.  4.Arrange cucumber, avocado and tuna to the rice.' ,  '30 minutes','2016-03-08 16:50:39');
insert into RecipeIngredient values (2, 'Japanese sushi rice', 2, 'cup');
insert into RecipeIngredient values (2, 'rice wine vinegar', 6, 'tablespoons');
insert into RecipeIngredient values (2, 'nori (dry seaweed)', 6, 'sheets');
insert into RecipeIngredient values (2, 'tuna', 8, 'ounces');
insert into RecipeIngredient values (2, 'cucumber', 1, '');
insert into RecipeIngredient values (2, 'wasabi paste', 2, 'tablespoons');
insert into RecipeTag values (2, 'Japanese'), (2, 'Sushi'), (2, 'Tuna'), (2, 'fish');

insert into Recipe values(3, 'Mr.Cool', 'curried chicken', 5, '1.Arrange the chicken pieces in a single layer in a 9x13-inch baking dish. Season the chicken liberally with salt, pepper, and the paprika; set aside.   2.Melt the butter in a skillet over medium heat. Add the apple and onion to the melted butter, season with the curry powder, and cook and stir until the apple and onion are tender, 7 to 10 minutes. Stir the mushroom soup and half-and-half into the mixture until completely combined; spoon over the chicken pieces.' ,  '35 minutes','2016-02-18 03:50:39');
insert into RecipeIngredient values (3, 'chicken', 1, 'pound');
insert into RecipeIngredient values (3, 'salt', 1, 'teaspoon');
insert into RecipeIngredient values (3, 'pepper', 1, 'teaspoon');
insert into RecipeIngredient values (3, 'butter', 1, 'tablespoon');
insert into RecipeIngredient values (3, 'onion', 1, '');
insert into RecipeIngredient values (3, 'curry powder,', 2, 'tablespoons');
insert into RecipeTag values (3, 'Indian'), (3, 'curry'), (3, 'chicken');

insert into Recipe values(4, 'sweetyHeart','Grandma’s Fettuccini Alfredo',8, ' 1.Heat vegetable oil over medium heat in a large soup pot, and brown the pork and beef, stirring often, about 10 minutes. 2.Mix the soy sauce and cornstarch in a bowl until smooth, and pour it into the soup. Stir until the soup thickens, about 1 minute; cover the chili, and reduce heat to a simmer.','40 minutes','2016-10-18 10:50:39');
insert into RecipeIngredient values (4, 'green bell peppers', 1, '');
insert into RecipeIngredient values (4, 'black pepper', 1, 'teaspoon');
insert into RecipeIngredient values (4, ' soy sauce', 1/2, 'tablespoons');
insert into RecipeIngredient values (4, 'cornstarch', 3, 'tablespoons');
insert into RecipeIngredient values (4, 'chili powder,', 2, 'tablespoons');
insert into RecipeTag values (4, 'Chinese'), (4, 'Chili'), (4, 'Spicy');

insert into Recipe values(5, 'HeyMan', 'Spaghetti with tuna Sauce', 4, '1.Cook spaghetti in the boiling water, stirring occasionally, until cooked through but firm to the bite, about 12 minutes. Drain.  2.ombine cream, tuna with juice, garlic, and anchovies in a large pot over medium heat; bring to a simmer and remove from heat. 3.Add cooked spaghetti to the cream mixture; stir to coat the pasta, cover the pot, and let sit until flavors combine and pasta soaks up some of the sauce, about 5 minutes. Sprinkle Parmesan cheese over the top and season with salt. Put some broccoli is better.', '15 minutes','2016-10-18 10:50:39');
insert into RecipeIngredient values (5, 'spaghetti', 1, 'pound');
insert into RecipeIngredient values (5, 'heavy whipping cream', 1, 'pint');
insert into RecipeIngredient values (5, 'tuna fillets', 0.5, 'pound');
insert into RecipeIngredient values (5, 'red pepper flakes', 1/2, 'teaspoon');
insert into RecipeIngredient values (5, 'garlic', 3, 'cloves');
insert into RecipeIngredient values (5, 'salt', 1, 'teaspoon');
insert into RecipeIngredient values (5, 'broccoli', 1,'');
insert into RecipeTag values (5, 'italian'), (5, 'tuna'), (5, 'spaghetti');

insert into Recipe values(6, 'Mr.Cool', 'Hamburgers', 5, '1.Gently divide ground beef into 8 small piles of around 4 ounces each, and even more gently gather them together into orbs that are about 2 inches in height.  2Put half the orbs into the skillet with plenty of distance between them and, using a stiff metal spatula, press down on each one to form a burger that is around 4 inches in diameter and about 1/2 inch thick. Season with salt and pepper. 3. Use the spatula to scrape free and carefully turn burgers over. If using cheese, lay slices on meat.', '18 minutes','2016-07-18 15:50:39');
insert into RecipeIngredient values (6, 'ground chuck', 2, 'pound');
insert into RecipeIngredient values (6, 'cheese', 8, 'slices');
insert into RecipeIngredient values (6, ' soft hamburger buns', 8, '');
insert into RecipeIngredient values (6, 'Lettuce', 1, '');
insert into RecipeIngredient values (6, 'sliced tomatoes', 8, 'slices');
insert into RecipeIngredient values (6, 'salt', 1, 'teaspoon');
insert into RecipeTag values (6, 'Burger'), (6, 'American');

insert into Recipe values(7, 'SingleMom', 'curried chicken', 5, '1.Arrange the chicken pieces in a single layer in a 9x13-inch baking dish. Season the chicken liberally with salt, pepper, and the paprika; set aside.   2.Melt the butter in a skillet over medium heat. Add the apple and onion to the melted butter, season with the curry powder, and cook and stir until the apple and onion are tender, 7 to 10 minutes. Stir the mushroom soup and half-and-half into the mixture until completely combined; spoon over the chicken pieces.' ,'45 minutes' , '2016-06-29 13:50:39');
insert into RecipeIngredient values (7, 'chicken', 1, 'pound');
insert into RecipeIngredient values (7, 'salt', 1, 'teaspoon');
insert into RecipeIngredient values (7, 'pepper', 1, 'teaspoon');
insert into RecipeIngredient values (7, 'butter', 1, 'tablespoon');
insert into RecipeIngredient values (7, 'curry powder,', 2, 'tablespoons');
insert into RecipeTag values (7, 'curry'), (7, 'Indian'), (7, 'chicken');

insert into Recipe values(8, 'Mr.Cool', 'Roasted Tuna', 3, '1.Heat oven to 400 degrees. 2. Drizzle tuna with olive oil, sprinkle with salt and pepper and place on a rimmed baking sheet, skin side down if you have left the skin on. 3.Roast fish for 10 minutes per inch of thickness.Serve with lemon wedges, drizzled with more good olive oil.' ,'25 minutes', '2016-05-29 13:21:39');
insert into RecipeIngredient values (8, 'tuna fillets', 4, 'pieces');
insert into RecipeIngredient values (8, 'olive oil', 2, 'teaspoons');
insert into RecipeIngredient values (8, 'sea salt', 1, 'teaspoon');
insert into RecipeIngredient values (8, 'Black pepper', '', '');
insert into RecipeTag values (8, 'tuna'), (8, 'roast'),(8, 'seafood');

insert into Recipe values(9, 'peace', 'Christina Tosi’s Crockpot Cake', 3, '1.Put all but 1 tablespoon of the butter and the sugars in the bowl of a stand mixer and cream with the paddle attachment.Mix in the eggs and vanilla,Add the buttermilk and oil and mix briefly to combine.  2.Set the mixer to a very low speed and add the cake flour, baking powder and salt, mixing for a minute.   3.Use the remaining tablespoon of butter to grease the interior of a 4- to 6-quart slow cooker, then pour the batter into the pot. Cover and cook on low for somewhere in the neighborhood of 4 to 6 hours.' ,'90 minutes', '2016-11-1 18:01:39');
insert into RecipeIngredient values (9, 'unsalted butter', 1/2, 'pound');
insert into RecipeIngredient values (9, 'sugar', 1, 'cup');
insert into RecipeIngredient values (9, 'large eggs', 3, '');
insert into RecipeIngredient values (9, 'vanilla extractr', 1, 'teaspoon');
insert into RecipeIngredient values (9, 'buttermilk', 1, 'cup');
insert into RecipeIngredient values (9, 'neutral oil', 1, 'cup');
insert into RecipeIngredient values (9, 'cake flour', 1.5, 'cup');
insert into RecipeTag values (9, 'cake'), (9, 'dessert'),(9, 'sweet'), (9, 'butter');

insert into Review values (1, 'basketball_lord', 4, '2016-10-19 18:00:00', 'Yummy!', 'Really, really, tasty!', 5, '');
insert into Review values (2, 'basketball_lord', 2, '2016-11-11 21:00:00', 'Wonderful!', 'This is amazing! Perfect food.his is amazing! Perfect food.his is amazing! Perfect food.his is amazing! Perfect food.his is amazing! Perfect food.his is amazing! Perfect food.', 5, '');
insert into Review values (3, 'basketball_lord', 1, '2016-10-31 10:03:14', 'Jesus!', 'I love it. I love pizza. Love broccoli', 4, 'Try it with tomato sauce！');
insert into Review values (4, 'HeyMan', 2, '2016-10-28 18:00:00', 'Oh my god!', 'Really, really, tasty! Why it is so good! I will try it! Let us try it', 5, 'Upload some photos please, thank you bro!');
insert into Review values (5, 'RockTheEarth', 8, '2016-10-29 18:00:00', 'Tuna!1!', 'Really good experience. Thanks for sharing. Tuna is my favorite! Go go tuna!', 4, '');
insert into Review values (6, 'akb48', 3, '2016-3-19 18:00:00', 'Good!', 'My guest like this curried chicken. It is spicy and tasty! I will try more times and improve my skill!', 5, '');

Insert into CookingGroup values (1, 'Park Slope Cake Club', 'Love cakes, make cakes!', 'peace');
Insert into GroupMember values (1, 'peace'), (1, 'basketball_lord'), (1, 'HeyMan'), (1, 'SingleMom'), (1, 'RockTheEarth'),(1, 'akb48');
Insert into GroupMember values(1, 'sweetyHeart');

Insert into GroupMeeting values (1, 'Cheese Cake', 1, 'peace', '2016-09-01 15:00:00', '2016-09-01 18:00:00', 'please join on time.', '460 Ocean Park');
Insert into GroupMeeting values (2, 'Egg Cake', 1, 'peace', '2016-09-15 15:00:00', '2016-09-15 18:00:00', 'please join on time.', '460 Ocean Park');
Insert into GroupMeeting values (3, 'Fruit Cake', 1, 'akb48', '2016-10-01 15:00:00', '2016-10-01 18:00:00', 'please take some fruits.', '54 Avalon');
Insert into GroupMeeting values (4, 'Coffee Cake', 1, 'akb48', '2016-10-15 15:00:00', '2016-10-15 18:00:00', 'please take your bowl', '453 Brooklyn Avenue');

Insert into MeetingMember values (1, 'peace', 5, '', 1);
Insert into MeetingMember values (1, 'HeyMan', 5, '', 1);
Insert into MeetingMember values (1, 'SingleMom', 5, '', 1);
Insert into MeetingMember values (1, 'akb48', 5, '', 1);

Insert into MeetingMember values (2, 'peace', 4, '', 1);
Insert into MeetingMember values (2, 'HeyMan', 4, '', 1);
Insert into MeetingMember values (2, 'SingleMom', 4, '', 1);

Insert into MeetingMember values (3, 'akb48', 5, '', 1);
Insert into MeetingMember values (3, 'HeyMan', 4, '', 1);

Insert into MeetingMember values (4, 'akb48', 5, '', 1);
Insert into MeetingMember values (4, 'HeyMan', 4, '', 1);
Insert into MeetingMember values (4, 'SingleMom', 5, '', 1);

Insert into CookingGroup values (2, 'Brooklyn Burgers', 'burgers!', 'Heyman');
Insert into GroupMember values (2, 'Heyman'), (2, 'basketball_lord'), (2, 'Mr.Cool');
Insert into GroupMember values(2, 'sweetyHeart');

insert into RecipeLink values (2, 5), (2, 8);
insert into RecipeLink values (5, 2), (5, 8);
insert into RecipeLink values (8, 2), (8, 5);






