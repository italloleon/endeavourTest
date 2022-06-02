# 🍺 Import API plugin test 🍺

## Plugin Instructions

1. Download and install the plugin.
2. A new Custom Post Type Brewery will be added to the admin page.
3. Go to the ***Brewery Import*** option.
4. Click the "Import Breweries" button.
5. Wait until the Breweries list is filled.
6. In this list, for each imported brewery you will see two buttons:
   - **Check Brewery** that send you to the brewery view
   - **Edit Brewery** that send you to the brewery edit page

### Assignment 

1. Create a new fork of this repository to commit your changes.
   - Done ✅
2. Write a Wordpress plugin to connect with the [Open Brewery DB API](https://www.openbrewerydb.org/) and import 75 breweries. The items have to be saved in a Custom Post Type with at least the parameters below saved and separately reproducable for the frontend.
   - Done ✅
   - Import Api Plugin Created
3. The brewery item has to be organizable by category, categories are based on `brewery_type`.
   - Done ✅
   - Each item category was imported and saved in a Wp Category
4. Create at least 1 function that shows part of the imported data in a template.
   - Done ✅
   - A single template was created to visualize the imported data. This can be checked immediately after import, which allows viewing of each created item.
5. Add jorn.baas@endeavour.nl to the repository to review your work.
   - Done ✅
   - Here we are 🚀

**Parameters to import:**

* name
* city
* country
* phone
* website_url

**Review:**

Aspects of the assignment we will review your work on:

* clean coding practices
* properly organised functions 
* reusability of code
* effectiveness of code

**Below is the same assignment, only in Dutch:**

--------------------------

### Opdracht:

1. Maak een aparte fork van de repository voor de te schrijven plugin.
2. Schrijf een Wordpress plugin die connect met de Open Brewery DB API en importeer daar uit 75 brouwerijen. De items moeten in een Custom Post Type terecht komen waarbij in ieder geval de onderstaande parameters los weer op te roepen zijn.
3. Het brouwerij item dient te worden gekoppeld aan een categorie die uitsluitend voor de Custom Post Type beschikbaar is en voortkomt uit de "brewery_type".
4. Maak tenminste 1 functie waarmee een gedeelte van de geimporteerde data ook weer binnen een template is op te roepen.
5. Voeg jorn.baas@endeavour.nl toe aan de repository om het werk te controleren.

Gebruik de index.php als opzet om de plugin mee op te zetten.

**Parameters:**

*  name
*  city
*  country
*  phone
*  website_url

**Beoordeling:**

We zullen de plugin beoordelen op:

* of de code "clean" is
* nette gescheiden functies
* herbruikbaarheid van code
* functionaliteit

**API:**

https://rapidapi.com/brianiswu/api/open-brewery-db
