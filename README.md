Catalog
========================

Introduction
========================

Displaying tree and catalog files.

The program can synchronize the database via console command on the basis of
directory in the file system.

The program stores the directory structure and file information.

The tree directory is on the left part of the screen.  When you click on any folder in this directory,
located on right side of the screen, you will see the list of current files from directory.

At the bottom displays information about the number of files in the current directory,
the total count of files in the database, and the total file size.


Installing
--------------

1.Clone the repository

2.Rename 'app/config/parameters.yml.dist' to 'app/config/parameters.yml'

3.Run 'php composer.phar update' to install all the required vendors

4.Install the assets with 'php app/console assets:install web'

5.Create the database with 'php app/console doctrine:database:create'

6.Update schema with 'php app/console doctrine:schema:create'

  * [**gedmo/doctrine-extensions**][1] - Gedmo Doctrine2 extensions

  * [stof/doctrine-extensions-bundle][2] - Provides integration for DoctrineExtensions for your Symfony2 Project.

    
Add catalog path
--------------

1. Add your directory to the path: "src/load_files"

OR

2. Edit file UpdateCommand.php: "$basePath"

Update database
--------------

Use console command: "catalog:update"



GNU GENERAL PUBLIC LICENSE.


[1]:  https://github.com/Atlantic18/DoctrineExtensions/blob/master/doc/symfony2.md
[2]:  https://github.com/stof/StofDoctrineExtensionsBundle/blob/master/Resources/doc/index.rst

