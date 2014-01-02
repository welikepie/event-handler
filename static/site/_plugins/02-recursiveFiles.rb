#encoding: utf-8
require "pathname"
require "YAML"
require "time"

$devString = "../"
$substring_from = "site/_data/";
$path_to_data = "";
$pathArr = [];
$fileArr = [];
$dateSortArr = [];
$speakerArr = {};
$venueArr = {};
$categories = [];
$catLinList = [];

def rec_path(path, file= false)
  path.children.collect do |child|
    if file and child.file?
    	open_file(child);
    elsif child.directory?
    	add_folder(child);
      rec_path(child, file) + [child]
    end
  end.select { |x| x }.flatten(1)
end

def add_folder(path)
puts "-- Folder found at #{path}";
$pathArr << "#{path}"["#{path}".index($substring_from)+$substring_from.length,"#{path}".length];
end

def open_file(path)
if !"#{path}".include? "seriesconf.yaml"
patharr = "#{path}"["#{path}".index($substring_from)+$substring_from.length,"#{path}".length]
	if $path_to_data.length == 0
		$path_to_data = "#{path}"[0,"#{path}".index($substring_from)+$substring_from.length];
	end
$fileArr << patharr;
file = YAML.load_file(path)
file["directory_tags"] = patharr.split("/");
fileName = file["directory_tags"].pop;
file["filename"] = fileName.split(".")[0];
if (file["directory_tags"].include? "venues")
 	$venueArr[fileName.split(".")[0]] = file;
end
if (file["directory_tags"].include? "speakers")
	$speakerArr[fileName.split(".")[0]] = file;
end
if file["date"]
	puts "-- File found at #{path}";
	file["epoch_s_date"] = time_to_epoch(file["date"]);
	if(file["end_date"])
		file["epoch_s_end_date"] = time_to_epoch(file["end_date"]);
	end
	if(!file["time_zone"])
		file["time_zone"] = "GMT";
	end
	if(file["series"])
	paths = $substring_from;
	file["directory_tags"].each{|x|
		paths+= x+"/"}
	file["seriesconfpath"] = paths
	end
	$dateSortArr << file;
end
end
end

def create_dump()
	auto_hash = Hash.new{ |h,k| h[k] = Hash.new &h.default_proc }
	$pathArr.each{ |path|
	  sub = auto_hash
	  path.split( "/" ).each{ 
	  	|dir| 
	  	sub[dir]; 
	  	sub = sub[dir] 
	  }
	}
	$fileArr.each{ |path|
	  sub = auto_hash
	  path.split( "/" ).each{ 
	  	|dir| 
	 # 	puts dir;
	  	if (dir == path.split("/").last)
	  		sub["#{dir}".gsub(".yml","").gsub(".yaml","")]= YAML.load_file($path_to_data+path)
	  	elsif (sub[dir] == path.split("/").last)
	  		sub = sub["#{dir}".gsub(".yml","").gsub(".yaml","")]
	  	else
		  	sub = sub[dir] 
	  	end
	  }
	}
	#puts auto_hash #At the moment we've got the stuff created here. Now to write the file contents to this here! Woop woop!
	puts "-- Writing to file data.yaml"
	File.open($path_to_data+"data.yaml", 'w') { |file| 
		file.write(YAML.dump(auto_hash));
		puts "-- Data directory successfully re-created!"
	}
end

def time_to_epoch(time)
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
end

def sort_events(binary, sorting)
sorting = sorting.sort_by {
	|x|
	 x["epoch_s_date"] 
}
	if(binary == "high")
		sorting.reverse!;
	end
	sorting.each{
		|x| 
		if( x["series"] && (x["series"] == true || x["series"] == "yes" || x["series"] == 1 ))
			x["series"] = x["directory_tags"].last
			file = YAML.load_file(x["seriesconfpath"]+"seriesconf.yaml");
			file.each{|z|
				x["seriesconf"+z[0]] = z[1];
			}
			#puts file

		else
			x.delete("series")
		end
	}

	 subfolders_to_check_for = ["workshops"];
        sorting.each {|x|
        subfolders_to_check_for.each{|y|
        if(x["directory_tags"].include? y )
          if(x.key? "series")
            x["url"] = "/"+y+"/"+x["series"];
          else
            x["url"]="/"+y;
          end
        else
          if(x.key? "series")
            x["url"] = "/events/"+x["series"];
          else
            x["url"]="/events";
          end
        end
      }

      if (x.key? "series")
      	if(!$catLinList.include? x["series"])
      		#YAMLLOAD
#      		file = YAML.load_file("/site/_data"+ x["url"]+"/seriesconf.yaml");
#      		puts file;
      		$categories <<	{"series" => x["series"], "url" => x["url"], "prettyname" => x["seriesconfprettyname"], "description" => x["seriesconfdescription"]};
      		$catLinList << x["series"];
      	end
      end
  }

  	puts "-- Writing Categories to series_list.yaml"
	File.open($path_to_data+"series_list.yaml", 'w') { |file| 
		#puts $categories;
		file.write(YAML.dump($categories));
		puts "-- Series_list have been saved"
	}


	puts "-- Writing Events to file events.yaml"
	File.open($path_to_data+"events.yaml", 'w') { |file| 
		file.write(YAML.dump(sorting));
		puts "-- Events have been saved"
	}
	create_series_list(sorting);
end

def create_series_list(array)
puts "-- Creating Series listing"
arr = {};
array.each{
	|x|
	if(x.key?("series"))
	puts "-- Found Event in Series "
		if(!arr.key?(x["series"]))
			arr[x["series"]]=Array.new;
		end
#		x["index_in_arr"] = arr[x["series"]].length
		arr[x["series"]] << x;
	end
}
puts "-- Writing Series listings"
File.open($path_to_data+"series.yaml", 'w') { |file| 
		file.write(YAML.dump(arr));
		puts "-- Series have been saved"
	}
end

def write_speakers(array)
puts "-- Writing Speakers to flat file structure."
File.open($path_to_data+"speakers.yaml", 'w') { |file| 
		file.write(YAML.dump($speakerArr));
		puts "-- Speakers have been saved"
	}
end

def write_venues(array)
puts "-- Writing Venues to flat file structure."
File.open($path_to_data+"venues.yaml", 'w') { |file| 
		file.write(YAML.dump($venueArr));
		puts "-- Venues have been saved"
	}
end

dir = "site/_data";
#dir = "../_data";
files_to_delete = ["data.yaml","events.yaml", "series.yaml","speakers.yaml", "venues.yaml", "series_list.yaml"];
files_to_delete.each{
	|x| File.delete(dir+"/"+x) if File.exist?(dir+"/"+x)
}

# only directories
# rec_path(Pathname.new(dir), false)
# directories and normal files
puts ""
puts " == Starting the Event Handler data flattener. =="
puts " == -- Denotes everything is going okay."
puts " == ++ Denotes something has gone horribly wrong."
puts "-- re-creating file structure at "+dir
rec_path(Pathname.new(dir), true)
puts "-- Folders scanned."
puts "-- Events Organised in to a Flat File structure";
puts "-- Sorting by lowest date first.";
sort_events("low", $dateSortArr);
write_speakers($speakerArr);
write_venues($venueArr);
puts " == Cave Johnson, we're done here."