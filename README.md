# [Shinka] Thread Log
View a user's active threads, closed threads, and threads in need of reply on their profile page.

## Installation
* Download the [latest stable release](https://github.com/kalynrobinson/xf2_threadlog/releases)
* Extract the zip
* Copy the contents of the `upload` folder to the root of your Xenforo installation
* Install and activate the add-on in your Admin CP

## Settings & Permissions
* Designate forums to be included in the thread log. This defaults to false.
* Permissions for whether a user group has a thread log, can view their own thread log, and can view other thread logs.

## Features
* AJAX

## Development
* Clone or fork the repository
* Create a symbolic link for the ThreadLog folder in your XF2 installation to the one in the repository directory, e.g.
```
> mklink /D "C:/Fake User/My Site/src/addons/Shinka/ThreadLog" "C:/Fake User/Dev/xf2_threadlog/upload/src/addons/Shinka/ThreadLog"
```
* Import development output by executing 
```
> php cmd.php xf-dev:import --addon Shinka/ThreadLog
```

# Credits
* amwells' original [Threadlog plugin for MyBB](https://github.com/amwelles/mybb-threadlog)