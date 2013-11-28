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
#        lists_to_generate = ["events.yaml","speakers.yaml"];
#        filepaths_to_write_to=["/events","/speakers"];
#        template_to_use_arr=["defaulttest.html","defaulttest.html"];
        #subfolders_to_check_for = ["meetups","other","workshops","conferences"];
        dir="site/_data/"
#       //
        hash_of_data =  YAML.load_file(dir+"speakers.yaml");
        end_dir = "/speakers"
        template_to_use = "defaulttest.html"
        hash_of_data.each {|x|
        new_file_name = x[0]+".html"
        site.pages << GenericPage.new(site, site.source, end_dir, new_file_name,template_to_use,x[1])
        }

        subfolders_to_check_for = ["workshops"];
        hash_of_data =  YAML.load_file(dir+"events.yaml");
        template_to_use = "defaulttest.html"
        hash_of_data.each {|x|
  

        subfolders_to_check_for.each{|y|
        if(x["directory_tags"].include? y )
          if(x.has_key? "series")
            end_dir = "/"+y+"/"+x["series"];
              array = [];
              hash_of_data.each{|z| 
                if(z["series"] == x["series"])
                  puts z["series"]
                  array << z;
                end
              }
              site.pages << GenericPage.new(site,site.source,end_dir,"index.html","defaulttest.html",array)
          else
            end_dir="/"+y;
          end
        else
          if(x.has_key? "series")
            end_dir = "/events/"+x["series"];
 array = [];
              hash_of_data.each{|z| 
                if(z["series"] == x["series"])
                  puts z["series"]
                  array << z;
                end
              }
              site.pages << GenericPage.new(site,site.source,end_dir,"index.html","defaulttest.html",array)
          else
            end_dir="/events";
          end
        end
      }

        new_file_name = x["filename"]+".html"
        site.pages << GenericPage.new(site, site.source, end_dir, new_file_name,template_to_use,x)
        }
#        //

    end
  end

end