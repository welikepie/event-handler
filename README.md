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
### Speaker Template ###

---
picture: string for path
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