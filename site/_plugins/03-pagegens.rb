require "YAML"
module Jekyll
  class GenericPage < Page
    def initialize(site, base, dir, name, template, hash)
      @site = site
      @base = base
      @dir = dir
      @name = name
      #self.template = "_layouts/"+template;
      
      self.process(@name);
      self.read_yaml(File.join(base, '_layouts'), template)
      #puts self;
      self.data["data"] = hash;
    end
  end

  class CategoryPageGenerator < Generator
    safe true
    def generate(site)
    	end_dir = "/speakers"
        dir="site/_data/"
        hash_of_data =  YAML.load_file(dir+"speakers.yaml");
        hash_of_data.each {|x|
        new_file_name = x[0]+".html"
        template_to_use = "defaulttest.html"
        site.pages << GenericPage.new(site, site.source, end_dir, new_file_name,template_to_use,x[1])
        }
    end
  end

end