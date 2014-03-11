##Dependencies##
- **ruby** (1.9.3 used in development, use RVM to install it if necessary)
- Make sure rubygems and ruby are up to date.
- gem install jekyll
- [Mac] If this fails with "gcc-4.2: No such file or directory" or similar, run brew install apple-gcc42
- [Mac] If it still fails, run xcode-select --install to install xcode command line tools (Needed in Mavericks)
- gem install rdiscount (markdown compilation)
- run "jekyll build" from the command line in the same folder as _config.yml to build the site.
- run "jekyll serve" from the command line in the same folder as _config.yml to build&serve the site. Note; this does not have PHP support and will not run production version of the workshoplist page.
- **nodeJS** (0.10.13 used in development)
- run "npm install" in the server folder; it's a bit of a wait, and ignore all the warnings about being on the wrong version of nodeJS.
- run "npm start" to start the server.
- **php** (5.3.27 used in development, only in workshoplist for twitter authent.)
- **mysql** (used for databases)
- mysql create file is to be found in server/database/neweventhandler.sql

NOTE: Might be best to just run it all through a XAMP/MAMP stack for development.

##Starting up the site##
- Open up two command line terminals

- With one, navigate to the /server folder of the repository and run "node server.js"
- If, at this point, an error with "EADDRINUSE" is displayed, run "ps aux | grep node" and get the process ID of server.js
- Now run "kill -9 PID", with PID being the process ID from the previous step.
- Now run "node server.js" again. It should work this time.

- With the other, navigate to the /static folder of the repository and run "jekyll serve" to start a server and compile the site.
- Open up localhost:4000 in your browser. This should display the new build of the site.

- NOTE: That any changes made to the source code need to either be saved in the /static/RELEASE folder and copied across to the /static/site , or made in the /static/site folder, at which point the site will need re-compiling.
- NOTE: config.js and config.php contain API keys. These should not be committed to the repo; there are already dummy files there.

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

During compilation, the base pages are compiled, and all of the ruby in the _plugins folder is ran. What this does in this case is iterates through all of the data files in the data folder, and creates pages for each series of events as well as individual pages for each series.

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

###On Form Validation###

Form validation is handled by a javascript file in the assets/scripts/formJS folder.

To validate a form, it is a case of attaching a function to the on click event of the submit button, creating a form validation object and calling the submit method of that object.

The object creation takes up to five parameters with a minimum of three in the form of a JSON object;

    {
    "array_of_elements" : [],
    "array_of_types" : [],
    "success_function" : function(){},
    /*optional parameters*/
    "validation_text" : [],
    "fail_function" : function(){}
    }

At current state (20/12/13), the validation fails by logging to console and not completing the submission function (detailed in the "success_function"), in addition to firing off the failure function (detailed in the "fail_function") if it has been provided.

To create an instance of the form tester, pass in an array of elements to test, pass in an array of types and a function to complete upon successful validation. To create a validator correctly, set the "array_of_elements" property to an array filled with the elements in question (retrieved by the document.getElementById method or similar). To set the "array_of_types" property correctly, an array filled with the types that the validator is to test for which is case insensitive. These are as follows;

- percent
- percent2
- phone
- string
- integer
- float
- email

NOTE: percent accepts values between 0 and 100, whereas percent2 attempts to accept all of the following as valid percentages;

- 69%
- 69
- 0.69

To specify the "success_function" parameter correctly, all that is necessary is to define a function which can be executed once the form is shown to have verified correctly.

To specify the optional parameter "validation_text" correctly, it is necessary to provide an array of JSON objects which have text for each error code possible returned by the validation. By including this property, the additional inline error reporting is enabled. This inline error reporting assumes both that the input being checked has an id property, and that the error field to be populated has the same ID property as the input, with "Error" appended. In the event the field cannot be found, nothing happens.

In the event that the field is found, then the class "formerror" and "failure" are ascribed to the element for styling purposes. They are also displayed using CSS properties applied through javascript. On a successful submission, these elements receive the classes "formerror" and "success" and are automatically hidden.

**Validation codes are as follows;**

    "0":"Wrong for some reason",
    "1":"Passed!",
    "2":"Wrong Type for Value",
    "3":"Value Unexpected",
    "4":"Empty Value"

These codes can be used to determine which error messages to display for each value by using the key attribute (0-4) in a JSON object for the "validation_text" property, (where HTML is valid and will be parsed in to the dom,) as follows;

    "validation_text":[
      {
        "0":"Error corresponding to Validation Code 0.",
        "2":"Error corresponding to Validation Code 2.",
        "3":"Error corresponding to Validation Code 3.",
        "4":"Error corresponding to Validation Code 4."
      }]

This array can take as many objects as desired by the end user, with some stipulations, which are as follows;

- If only one object is supplied or the validation text array and "array_of_elements" array have different lengths, the error messages in the first object will be used for all errors.
- Error objects must be in the same order as the position of the respective element in the "array_of_elements" array.

The final optional property is the "fail_function" property, which requires a function to run in the case of the form failing to validate properly.

## NodeJS Server ##

To install, running "npm install" from the same folder as the package.json should suffice to install all dependencies listed above. Content Types expected are either application/x-www-form-urlformencoded for flat data structures, or application/json for more rich, nested data structures.

Is programmed to react to both POST and GET requests. In some cases, the X-WLPAPI header might be necessary in order to retrieve confidential information such as retrieve from the database, update and retrieve speakers, and fetch EventBrite information.

The server is used for the following at present;
- Retrieving EventBrite information for workshops
- Retrieving Speaker Submissions
- Editing Speaker Submissions
- Recieving any form submissions from the site and forwarding these on to end destinations

The server being inactive does mean that content will not be provided, and therefore pages will not render correctly, as they are reliant on Javascript communicating with the Node Server to render correctly.
