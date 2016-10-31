ValencePM Tests - Adam Velma
===

Barcode Test
===

### Goal: As a user, I can:
* View a list of barcode data from previously uploaded pdf files.
* Can upload pdf files and have the data on the screen.

### Live Test
http://www.xeipstudios.com/valencepm/bar-code-test

### Relevant Files
* Controller: https://github.com/ValencePM/valence-exercise-adam-v/blob/master/src/AppBundle/Controller/AppController.php
* Service (used by the controller): https://github.com/ValencePM/valence-exercise-adam-v/blob/master/src/AppBundle/Service/PDFService.php
* View: https://github.com/ValencePM/valence-exercise-adam-v/blob/master/src/AppBundle/Resources/views/ValencePM/barcode.html.twig
* JS Controller (Angular): https://github.com/ValencePM/valence-exercise-adam-v/blob/master/src/AppBundle/Resources/public/js/barcode.js

Sort Test
====

This is a test completed by Adam Vellma for the Full Stack/Mobile remote developer role at ValencePM.

###Requirements

EXERCISE FOR DEVELOPER CANDIDATES: Unit Number Sorting Exercise

We often deal with unit number / resident name data. These two pieces of information are used by our users to identify a lease. Many of our screens and reports show a list of leases.

The task is to sort lease data read from a file and to print the sorted data to STDOUT. The data looks as follows (sample also attached):
 
* "#50 - Smith"
* "#8 - Johnson"
* "#100 - Sanders"
* "#1B - Adams"
* "#1A - Kessenich"
 
Each line contains a unit number and a resident name. The data should be sorted by unit number.
 
Develop a solution in PHP and one other language of your choice that reads the data from a file and prints the data (sorted by unit number) to STDOUT. The printed strings should not be modified from how they appear in the input file.

Solution
------

##### View The Test Live
http://xeipstudios.com/valencepm/test

#####Stack and Technology
* PHP / Symfony Framework
* Angular
* Bootstrap Components
* Twig
* Linux / Apache

#####How it works
* Symfony returns the page via twig.
* Angular in twig loads the data, data read from "input.txt" and sorted naturally via PHP.
* Twig displays the Angular variables, data.
* Buttons added to allow the data to be sorted a second time, dynamically, via Javascript / Angular.

##### Relevant Files
* Controller: https://github.com/Dubletar/valencepm/blob/master/src/AppBundle/Controller/AppController.php
* Twig Template: https://github.com/Dubletar/valencepm/blob/master/src/AppBundle/Resources/views/ValencePM/test.html.twig
* Angular Object: https://github.com/Dubletar/valencepm/blob/master/src/AppBundle/Resources/public/js/valencepm.js
* Input Text File: https://github.com/Dubletar/valencepm/blob/master/web/valencepm/input.txt
# valence-exercise-adam-v
