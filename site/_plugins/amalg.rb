# encoding: utf-8
=begin
require 'yaml'
	puts "ololol";
	devBuild = '../';
	folders = ["events","promoted","speakers"];
	rootnames = ["events","promoted","speakers"];
	writeto = "data";
	filepath = devBuild+'_data/'+folders[0]+'/';
	arr = [];
	Dir.foreach(filepath) do |item|
		next if item == '.' or item == '..'
	  	# do work on real items
	  	#  puts YAML.load_file(filePath+item).inspect();
	  	data = YAML.load_file(filepath+item);
	  	arr << data;
		#  print item;
	end
	puts arr.to_yaml;
	File.open(rootnames[0]+".yml", "w") do |file|
	file.write(YAML.dump(arr));
end
#YAML.dump("file.yaml",YAML.dump(arr));
=end