Time Wasted on Destiny
====================

## About
Time Wasted on Destiny is a website that tells you how much time you've poured into the Destiny series. On top of this, it is the only website that tells you just how much time you've spent on deleted characters, which you could consider wasted time.

**NOTE**: This page is only a documentation of the API for https://wastedondestiny.com. If you're looking for information about the website itself, please go to https://wastedondestiny.com/about.

## How to use
The API for Time Wasted on Destiny is really simple and easy to use.

> **/bungie/getMembership?membershipType=[]&membershipId=[]**
> Allows you to lookup all associated accounts for an already known membership.

> **/bungie/fetchAccounts?membershipType=[]&displayName=[]**
> Allows you to lookup all accounts for a given platform and display name.

> **/bungie/fetchCharacters?membershipType=[]&membershipId=[]&gameVersion=[]**
> Get character information and time played on the specified game for an account

> **/api/leaderboard?membershipType=[]&gameVersion=[]&page=[]**
> Get pages of the leaderboard by game and platform

Keep in mind that this API is released free of charge and without subscription. Please do not abuse, or I will have to restrict access to the API.

## FAQ
#### WHAT ACTIVITIES COUNT IN THE TIME PLAYED?
Only the time you spend shooting at stuff (not in orbit, loading or in social spaces) is counted towards your time played (and wasted).
#### WHY IS MY USERNAME NOT WORKING?
Make sure you typed your Playstation Network ID, Xbox Live Gamertag or Battle.net ID correctly. If you still experience problems, please submit an issue here.
#### WHY IS ANOTHER PLAYER SHOWING UP WHEN I'M SEARCHING FOR MY USERNAME?
It is possible that another player uses the same name as you on another platform. If you simply don't see your account there, make sure you typed your username correctly.

## Disclaimer
Time Wasted on Destiny is not affiliated with Bungie. Destiny is a registered trademark of Bungie and Activision.

## Licence
This project is distributed under the GPL v3.0 license. Please give credit if you intend on using it!