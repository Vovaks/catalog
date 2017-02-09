Catalog
========================

Introduction
========================

Display tree and catalog files.

The program can synchronize the database via console command on the basis of
directory in the file system.

The program stores the directory structure and file information.

In the left part of the screen in a tree directory. When you click on any directory 
folder in the right-hand side of the screen a list of the current directory files.
At the bottom displays information about the number of files in the current directory,
the total count of files in the database, and the total file size.


Installing
--------------

1.Clone the repository

/*2.Rename 'app/config/parameters.ini.dist' to 'app/config/parameters.ini'*/

3.Run 'php bin/vendors install' to install all the required vendors

/*4.Install the assets with 'php app/console assets:install web'*/

5.Create the database with 'php app/console doctrine:database:create'

6.Update schema with 'php app/console doctrine:schema:create'

  * [**gedmo/doctrine-extensions**][1] - Gedmo Doctrine2 extensions

  * [stof/doctrine-extensions-bundle][2] - Provides integration for DoctrineExtensions for your Symfony2 Project.

    
Add catalog path
--------------

1. Add you directory in the path: "src/load_files"

OR

2. Edit file UpdateCommand.php: "$basePath"

Update database
--------------

Use console command: "catalog:update"



GNU GENERAL PUBLIC LICENSE.


[1]:  https://github.com/Atlantic18/DoctrineExtensions/blob/master/doc/symfony2.md
[2]:  https://github.com/stof/StofDoctrineExtensionsBundle/blob/master/Resources/doc/index.rst

