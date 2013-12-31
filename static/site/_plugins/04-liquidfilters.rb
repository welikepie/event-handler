module Jekyll 
  module Calendar_functions
  	def day_of_week (starting)
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
    def monthcount(starting)
      x = starting/60/60/24/30.5;
      if((x - x.floor) > 0.5)
        x.ceiling;
      else
        x.floor;
      end
    end
  end
  module Frontpaging
  	def within_x_days(starting, ending)
  		starting.each{|x|
  			if ((x["epoch_s_date"].to_i - Time.now().to_i) > 0 && (x["epoch_s_date"].to_i - Time.now().to_i) <(86400 * ending))
  				#puts x["title"]
  				return true;
  			end
  		}
  		return false;
  	end
  	def sort_priorities(starting,ending)
  		ending = ending.to_i;
  		priorities = {"high"=>[],"medium"=>[],"low"=>[]}
  		compiletime = Time.now().to_i;
  		renderarr = []
  		starting.each{ |x|
  			x["seconds_difference_compile"] = difference(compiletime,time_since_epoch(x["date"]))
  			if x.has_key?("priority")
  				priorities[x["priority"].downcase] << x
  			else
  				priorities["medium"] << x
  			end
  			if !x.has_key?("size")
  			x["size"]="medium"
  			else
  				x["size"] = x["size"].downcase
  			end
  		}
  			priorities.each{ |x|
	  				x[1].sort!{|y,z|
	  					y["seconds_difference_compile"] <=> z["seconds_difference_compile"]
	  				}
  			}

  			priorities.each{|x|
  				x[1].each{ |y|
  					renderarr << y
  					if ending > 0
  						if renderarr.length >= ending
  							break
  						end
  					end
  				}
  			}
  		starting = renderarr
  	end
  	def is_current(starting)
  		arr = []
  		starting.each{|x|
  			if (x["epoch_s_date"].to_i - Time.now().to_i) > 0
  				arr << x
  			end
  		}
  		starting = arr
  		return starting
  	end

  	def push(starting,ending)
  		starting << ending
  	end
  	def merge(starting, ending)
  		starting.concat(ending)
  	end
  end
end 

def time_since_epoch(time)
	begin
		time=time.gsub("\s","T");
		timeSplit=time.split("T");
		if(timeSplit[0].split("-").length != 3)
			puts "++ Something wrong with the YYYY-MM-DD portion of this date."
			return 0;
		end
		if(timeSplit[1].split(":").length == 2 || timeSplit[1].split(":").length ==3)
			if(timeSplit[1].split(":").length == 2)
				time+=":00"
			end
		else
			puts "++ Something wrong with the time portion of this date. Expected HH:MM or HH:MM:SS"
			return 0;
		end
		return Time.iso8601(time).to_i;
	rescue
		return time.to_i
	end
end

def difference(one, two)
	if one > two
		return one - two
	end
	if two > one
		return two - one
	end
	if two == one
		return 0
	end
end

Liquid::Template.register_filter(Jekyll::Calendar_functions)
Liquid::Template.register_filter(Jekyll::Frontpaging)