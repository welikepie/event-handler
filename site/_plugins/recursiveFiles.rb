#encoding: utf-8
require "pathname"
require "YAML"

$devString = "../"
$substring_from = "_data/";
$pathArr = [];
$fileArr = [];
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
#puts "#{path}";
patharr = "#{path}"["#{path}".index($substring_from)+$substring_from.length,"#{path}".length];
puts patharr;
$pathArr <<  patharr
end

def open_file(path)
patharr = "#{path}"["#{path}".index($substring_from)+$substring_from.length,"#{path}".length].gsub(".yml","").gsub(".yaml","");
$fileArr << patharr;
puts $fileArr
end

def format_things()
auto_hash = Hash.new{ |h,k| h[k] = Hash.new &h.default_proc }

$pathArr.each{ |path|
  sub = auto_hash
  path.split( "/" ).each{ |dir| sub[dir]; sub = sub[dir] }
}
$fileArr.each{ |path|
  sub = auto_hash
  path.split( "/" ).each{ |dir| sub[dir]; sub = sub[dir] }
}
puts auto_hash #At the moment we've got the stuff created here. Now to write the file contents to this here! Woop woop!
end

#dir = "site/_data";
dir = "../_data";
# only directories
# rec_path(Pathname.new(dir), false)
# directories and normal files
rec_path(Pathname.new(dir), true)
format_things