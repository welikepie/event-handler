#encoding: utf-8
require "pathname"
require "YAML"
require "time"

$devString = "../"
$substring_from = "_data/";
$path_to_data = "";
$pathArr = [];
$fileArr = [];
$dateSortArr = [];
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
$pathArr << "#{path}"["#{path}".index($substring_from)+$substring_from.length,"#{path}".length];
end

def open_file(path)
patharr = "#{path}"["#{path}".index($substring_from)+$substring_from.length,"#{path}".length]
	if $path_to_data.length == 0
		$path_to_data = "#{path}"[0,"#{path}".index($substring_from)+$substring_from.length];
	end
$fileArr << patharr;
file = YAML.load_file(path)
if file["date"]
	puts path;
	file["directory_tags"] = patharr.split("/");
	file["directory_tags"].pop
	file["epoch_s_date"] = time_to_epoch(file["date"]);
	if(file["end_date"])
		file["epoch_s_end_date"] = time_to_epoch(file["end_date"]);
	end
	$dateSortArr << file;
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
sorting.sort! {
	|x|
	 x["epoch_s_date"] 
}
	if(binary == "low")
		sorting.sort! { |x,y| y <=> x }
	end
	puts "-- Writing Events to file events.yaml"
	File.open($path_to_data+"events.yaml", 'w') { |file| 
		file.write(YAML.dump(sorting));
		puts "-- Events have been saved"
	}
end
#dir = "site/_data";
dir = "../_data";
files_to_delete = ["data.yaml","events.yaml"];
files_to_delete.each{
	|x| File.delete(dir+"/"+x) if File.exist?(dir+"/"+x)
}

# only directories
# rec_path(Pathname.new(dir), false)
# directories and normal files
puts "-- re-creating file structure at "+dir
rec_path(Pathname.new(dir), true)
puts "-- Folders scanned."
create_dump
puts "-- Events Organised in to a Flat File structure";
puts "-- Sorting by highest date first.";
sort_events("high", $dateSortArr)