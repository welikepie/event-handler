#encoding: utf-8
require "pathname"
require "YAML"

$devString = "../"
$substring_from = "_data/";
$writeObj = {};
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
patharr = "#{path}"["#{path}".index($substring_from)+$substring_from.length,"#{path}".length].split("/");
patharr.each do |i|
	puts i;
	for a in 0..patharr.index(i);
		puts "--"+"#{a}"
	end
end
#puts patharr
#iterate through patharr and create as necessary if not existing. If !exist, create, else not.
end

def open_file(path)
puts YAML.dump_stream(path);

#patharr = "#{path}"["#{path}".index($substring_from)+$substring_from.length,"#{path}".length].split("/");
#puts "--"+"#{path}"
#puts path
#puts YAML.load_file(path).inspect();
end

#dir = "site/_data";
dir = "../_data";
# only directories
# rec_path(Pathname.new(dir), false)
# directories and normal files
rec_path(Pathname.new(dir), true)