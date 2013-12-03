# Modulo filter for Jekyll
#
# Adds modulo functionality to Jekyll. It's already in the Liquid core, but that
# version doesn't appear to be in Jekyll.
#
# That's about it.
 
 require "Date"
module Jekyll
  module ModuloFilter
    # Returns the modulo of the input based on the supplied modulus
    # Called 'mod' to avoid conflict with newer Liquid's 'modulo' filter
    def mod(input, modulus)
    	puts input.to_i
    	puts modulus.to_i
    	puts       input.to_i % modulus.to_i    	
      input.to_i % modulus.to_i    	
    end
  end
end
Liquid::Template.register_filter(Jekyll::ModuloFilter)

module Jekyll 
  module Month_listing
  	def day_of_week (starting,ending)
    	Date.civil( (date(starting,"%Y").to_i) , date(starting,"%m").to_i , date(starting,"%-d").to_i ).strftime("%u");
  	end

  	def add_days_return_unix (starting,ending)
    	Date.civil( (date(starting,"%Y").to_i) , date(starting,"%m").to_i , ending.to_i ).strftime("%s");
  	end
  	def add_months_return_unix (starting,ending)
		x = Date.strptime(starting.to_s, '%s') >> ending
    	Date.civil((date(x,"%Y").to_i),date(x,"%m").to_i, -1).strftime("%s");
  	end
  	def current_year(starting, ending)
  		x = Date.strptime(starting.to_s, '%s')>> ending
    	Date.civil((date(x,"%Y").to_i),date(x,"%m").to_i, -1).strftime("%Y");
  	end
  	def current_month_name(starting, ending)
  		x = Date.strptime(starting.to_s, '%s')>> ending
    	Date.civil((date(x,"%Y").to_i),date(x,"%m").to_i, -1).strftime("%B");
  	end
    def days_in_month(starting, ending)
    	x = Date.strptime(starting.to_s, '%s')>> ending
    	Date.civil((date(x,"%Y").to_i),date(x,"%m").to_i, -1).strftime("%d");
    end
  end
end 
Liquid::Template.register_filter(Jekyll::Month_listing)