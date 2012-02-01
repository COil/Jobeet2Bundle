Jobeet2
=======

This Jobeet2 tutorial actually works with Symfony2 standard edition: *2.0.9*

All the code was done by me and I didn't cheat on other implementations so the code
may vary with what you will find on other Jobeet2 repositories.

Nevertheless, I tried to produce the cleanest code I could by respecting 100%
of the Symfony2 coding standarts. The code will be cleaned and improved as
I will gain experience with Symfony2.

No tutorial here, just code ! :)

See you. [COil](http://www.strangebuzz.com) :)


Infos
-----

Additional Symfony2 bundles used:

### For the frontend

* DoctrineFixturesBundle (use doctrine-fixtures)
* KnpPaginatorBundle (use knp-components)

### For the backend

* SonatajQueryBundle
* SonataUserBundle
* SonataAdminBundle
* KnpMenuBundle
* KnpMenu
* SonataDoctrineORMAdminBundle

Database
--------

You can find the MySQLWorkbench schema of the database in __/Resources/doc/jobeet2.mwb__


Todo
----

### Chap12
* Apply the Jobeet2 admin theme
* Add a security rule to access /admin/dashboard
* Check the problem with the company field (https://github.com/sonata-project/SonataAdminBundle/issues/524)
* Check the problem with the SonataAdminBundle translations not displayed


Problems
--------

* Inheritance and theming of form blocks does not seem to work well, to try later...
  I'd like to use the for_widget(form) like Jobeet1 but only with modifying the blocks:
  'field_row', 'form_widget' and 'field_widget' ([doc](http://symfony.com/doc/current/cookbook/form/form_customization.html))


To check / Best practices
-------------------------

* Job form: check what is best place to put Job::getTypes() function, in the entity
  or in the repository class like Jobeet1 ?
* Check the way activatedQueries() are built, it does not seem the cleanest DRY method


Rafactoring / Cleanup / Optimisation
------------------------------------

* Use the DoctrineExtension bundle to hanlde timestamble and sluggable behaviors
  --> Is it really necessary as using doctrine lifecycle callback works pretty well ?
* Use the @ParamConverter to retrieve job objects in the Job and Category controllers
