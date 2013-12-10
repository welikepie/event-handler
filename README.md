##Dependencies##
- ruby, obvs. 
- gem install jekyll
- gem install rdiscount (markdown compilation)
- gem install pygments.rb --version "=0.5.0" (pygments for syntax highlighting)
- nodeJS for form submissions
- npm mailchimp version 1.1.0
- npm mysql version 2.0.0-rc1
- npm forever version 0.10.10

##OUTPUT and INPUT folders##
Site is generated from the site folder and put in the RELEASE folder. Plugins reside in _plugins.
- archivegen.rb collates page by specified time value and is a constructor.
- archivepage.rb generates pages based on that data. In this case, year.

Comment; YAML with ruby is really finnicky about spacing. Maintain the spaces in the templates.
Comment; location property is an array which takes two arguments; latitude then longitude.

##Templates##

### Events Template ###

    speakerID: timruffles //same speakerID as the file name of the speaker. Can be an array.
    title: "London JS Night Class: AngularJS" 
    series: 1 , yes, true or 0, no, false are accepted values
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

##Forms, Form Validation and Form Server##

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

### Form Server ###
Form server is a basic NodeJS server rigged to receive POST requests only. Will need supplementing with code dependant on what forms you want to receive. To install, running "npm install" from the same folder as the package.json should suffice to install all dependencies listed above. Content Types expected are either application/x-www-form-urlformencoded for flat data structures, or application/json for more rich, nested data structures.

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