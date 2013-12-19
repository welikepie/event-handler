##Dependencies##
- **ruby** (1.9.3 used in development) 
- gem install jekyll
- gem install rdiscount (markdown compilation)
- run "jekyll build" from the command line in the same folder as _config.yml to build the site.
- run "jekyll serve" from the command line in the same folder as _config.yml to build&serve the site. Note; this does not have PHP support and will not run production version of the workshoplist page.
- **nodeJS** (0.10.13 used in development)
- run "npm install" in the server folder.
- run "npm start" to start the server.
- **php** (5.3.27 used in development, only in workshoplist for twitter authent.)
- **mysql** (used for databases)
- mysql create file is to be found in server/database/neweventhandler.sql

NOTE: Might be best to just run it all through a XAMP/MAMP stack for development.
##Config files##
There are two config files. One resides in server/config.js and is a configuration file for the nodeJS server. It contains stubs for;
- Eventbrite API and User keys
- Mailchimp API and User keys
- MYSQL connection information
- verification function. Should return true on an even number.

The other configuration file is in static/site/assets/php/twitteroauth/config.php. It contains stubs for;
- Twitter Consumer Key for application
- Twitter Consumer Secret Key for application
- Callback URL (This should be a URL to return to after Authentication is successful; should be /workshoplist)
- allowed users (This is an array with twitter usernames, case insensitive.)

##OUTPUT and INPUT folders##
Site is generated from the site folder and put in the RELEASE folder. Plugins reside in _plugins.
- archivepage.rb generates pages based on that data. In this case, year.
- recrsiveFiles.rb runs through the data folder and compresses the tree mapping to a flat file structure recursively.
- liquidfilters expand the functionality of liquid somewhat to include some additional maths and timing operations.
- pagegens.rb is responsible for creating the custom pages.

Comment; YAML with ruby is really finnicky about spacing. Maintain the spaces in the templates.
Comment; location property is an array which takes two arguments; latitude then longitude.

##Page Building and Compiling process##

Jekyll has a slightly funny way of doing things to build pages. 

Firstly, you define the rigid site structure in folders in the root of the static/site/ folder. Folders without an underscore (_) before their names will be included and as such will have their contents created as pages. Each folder has its' own index.html file, which can contain the following; 
- **Headmatter** A bit of yaml at the top of the document denoting which layout from the _layouts folder to use and title of page.
- **content** HTML content of the page. Note, this isn't a necessity of each index.html file and can also be in the layout relevant to the file.

Now we have the layouts in the _layouts folder. These are what the pages reference to build themselves. Each layout has a name, which is referenced in the respective index.html folder. Can contain liquid templating language, also just normal HTML. Also has the feature of Includes, which mean you can "include" snippets of html (header / footer etc.) in to your document to be added to the page during compile.

During compilation, the base pages are compiled, and all of the ruby in the _plugins folder is ran. What this does in this case is iterates through allof the data files in the data folder, and creates pages for each series of events as well as individual pages for each series.

These created files are copied in to the static/RELEASE/ folder, where the new version of the site lives.

NOTE: For everything to reference properly and css / JS includes to function properly, the root directory of the server needs to be static/RELEASE/.

##Templates##

These templates are used to create new Events, Speakers and Venues. They live in the _data folder in a tree structure, with the files that jekyll can use living in the root folder. To add new events, just add a filled out template to the relevant place in the folder structure, and it will automatically be included on the next build and merged in with the files, with pages automatically generated.

### Events Template ###

    speakerID: timruffles //same speakerID as the file name of the speaker. Can be an array.
    title: "London JS Night Class: AngularJS" 
    series: 1 , yes, true or 0, no, false are accepted values
    eventbriteid: String
    text: |
      So this is a decently interesting example introduction using
      the high and venerable art of markdown.
    blurb: An evening workshop dedicated to learning AngularJS 
    date: 2013-11-05 19:00
    end_Date: 2013-11-05 22:00
    where: hubwestminster
    cost: £60
    map: 80 Haymarket, London, SW1Y 4TE
    booking_link: http://ldnjsnightclass-angular2.eventbrite.com/
    lanyrd: http://lanyrd.com/2013/ldnjsnightclass-angular2

### Speaker Template ###

    picture: string for path inside the assets folder
    name: AMRoche
    title: Full Stack Developer at We Like Pie
    description: |
      This is another
      multiline biography
      which is handy, as you can
      write in here in markdown too.
    lanyrd: alexHacked
    twitter: alexHacked
    webpage: http://dev.welikepie.com

### Venue Template ###

    name: String
    address: |
        This is multiline markdown.
        The two spaces at the beginning are mandatory.
        Otherwise Jekyll breaks. It's sad.
    location: 
      - 32
      - 50
    closest_stations:
      - name: test name
        location: 
          - 32
          - 50
        lines: 
          - piccadily
          - northern
          - etc.
        type: 
          - rail
          - tube
          - overground
      - name: test name
        location: 
          - 32
          - 50
        lines: 
          - piccadily
          - northern
          - etc.
        type: 
          - rail
          - tube
          - overground
        description: |
            This is multiline markdown.
            The two spaces at the beginning are mandatory.
            Otherwise Jekyll breaks. It's sad.

###On creating Series###
Series are to reside in their own folder with a seriesconf.yaml file. This file should contain the following;

    prettyname : "London JS Night AngularJS Night Classes"
    description : |
      LondonJS night classes are classes designed to teach you stuff.

"prettyname" is the name which is used as the title for the series page while "description" is the description used for the series page.

##Forms and Form Validation##

### On sending Form information ###
Forms are to be send to a NodeJS server, which in turn handles these and depending on the end point writes them to a database or subscribes to Mailchimp.

Each endpoint should be created in the server.js file for the respective form. Setting an endpoint is a simple case of including an additional;

```
if(path=="/NEW_PATH"){}
```

block of code and specifying commands inside the block.

The structure of forms that are sent to the server are as follows;
Single inputs are to have their values encoded with the "name" property of the input.

**Example;**

    <select name="bobbytables">
      <option> Robert'); DROP TABLE Students --; </option>
      <option> Robert </option>
      <option> Bobby </option>
    </select>

**Assuming the first option field is selected, the data should be sent thusly;**

    {
      "bobbytables" : "Robert'); DROP TABLE Students --;"
    }

Integer or Floating Point responses are to be sent as Integer or Floating Point values.

Multiple inputs that are used as responses to the same question should be concatenated and comma seperated in to one string.

**Example;**

    <ul>
      <li class="speaker-topic">
        <input type="checkbox" name="interests.checkbox.group" value="Zombies">
        <label>Zombies</label>
      </li>
      <li class="speaker-topic">
        <input type="checkbox" name="interests.checkbox.group" value="Javascript">
        <label> Javascript</label>
      </li>
    </ul>

**assuming both are checked, the data should be serialised thusly;**

    {
      "interests" : "Zombies, Javascript"
    }

Naming conventions for each input are loose, as long as data is correctly serialised. 

**Suggested naming is as follows;**
  
    name_for_value.type_of_input.group

with .group symbolising the fact of more than one input.

####Relevant XKCD####
![Why you should sanitise Database Inputs; Little Bobby Tables](http://imgs.xkcd.com/comics/exploits_of_a_mom.png "Her daughter is named Help I'm trapped in a driver's license factory.")

###On Form Validation###

Form validation is handled by a javascript file in the assets/scripts/formJS folder.

To validate a form, it is a case of attaching a function to the on click event of the submit button.

The object creation takes three parameters; an array of dom elements which have values to test, an array of their intended values, and a callback for if the form passes all validation. At current state (10/12/13), the validation fails by logging to console. These errors can be used differently if the code is supplemented. Also available is an array of codes for each value being tested. 

**These codes are as follows;**

    "0":"Wrong for some reason",
    "1":"Passed!",
    "2":"Wrong Type for Value",
    "3":"Value Unexpected",
    "4":"Empty Value"

These codes can be used to determine which error messages to display for each value.


## NodeJS Server ##

To install, running "npm install" from the same folder as the package.json should suffice to install all dependencies listed above. Content Types expected are either application/x-www-form-urlformencoded for flat data structures, or application/json for more rich, nested data structures.

Is programmed to react to both POST and GET requests. In some cases, the X-WLPAPI header might be necessary in order to retrieve confidential information such as retrieve from the database, update and retrieve speakers, and fetch EventBrite information.

The server is used for the following at present;
- Retrieving EventBrite information for workshops
- Retrieving Speaker Submissions
- Editing Speaker Submissions
- Recieving any form submissions from the site and forwarding these on to end destinations

The server being inactive does mean that content will not be provided, and therefore pages will not render correctly, as they are reliant on Javascript communicating with the Node Server to render correctly.
