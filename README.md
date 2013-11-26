##Dependencies##
- ruby, obvs. 
- gem install jekyll
- gem install rdiscount (markdown compilation)
- gem install pygments.rb --version "=0.5.0" (pygments for syntax highlighting)

##OUTPUT and INPUT folders##
Site is generated from the site folder and put in the RELEASE folder. Plugins reside in _plugins.
- archivegen.rb collates page by specified time value and is a constructor.
- archivepage.rb generates pages based on that data. In this case, year.