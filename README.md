##Dependencies##
- ruby, obvs. 
- gem install jekyll
- gem install rdiscount (markdown compilation)
- gem install pygments.rb --version "=0.5.0" (pygments for syntax highlighting)

##OUTPUT and INPUT folders##
Site is generated from the site folder and put in the RELEASE folder. Plugins reside in _plugins.
- archivegen.rb collates page by specified time value and is a constructor.
- archivepage.rb generates pages based on that data. In this case, year.

Comment; YAML with ruby is really finnicky about spacing. Maintain the spaces in the templates.
Comment; location property is an array which takes two arguments; latitude then longitude.

### Events Template ###

---
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
---

### Speaker Template ###

---
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
---

### Venue Template ###

--- 
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
---