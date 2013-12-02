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
def generate_with_end(site,site_source,x_url, array)
       hashtopush = {"iterable"=>array,"extras"=>{"seriesinfo"=>{} } } ;
      $toparseout = "seriesconf";
    if(array.length > 0)
      if array[0].key? "series"
          array[0].each{|c|
          if c[0].include? $toparseout
            #puts "#{c[0]}".gsub($toparseout,"")
            hashtopush["extras"]["seriesinfo"]["#{c[0]}".gsub($toparseout,"")] = c[1]
          end
        }
             site.pages << GenericPage.new(site,site_source,x_url,"index.html","catpage.html",hashtopush)

      else
     site.pages << GenericPage.new(site,site_source,x_url,"index.html","catpage.html",hashtopush)
      end
    end
end

    def generate(site)
#        lists_to_generate = ["events.yaml","speakers.yaml"];
#        filepaths_to_write_to=["/events","/speakers"];
#        template_to_use_arr=["defaulttest.html","defaulttest.html"];
        #subfolders_to_check_for = ["meetups","other","workshops","conferences"];
        dir="site/_data/"
#       //
=begin
        hash_of_data =  YAML.load_file(dir+"speakers.yaml");
        end_dir = "/speakers"
        template_to_use = "defaulttest.html"
        hash_of_data.each {|x|
        new_file_name = x[0]+".html"
        site.pages << GenericPage.new(site, site.source, end_dir, new_file_name,template_to_use,x[1])
        }
=end
        foldersToTemplate = ["meetups","other","workshops"];
        subfolders_to_check_for = ["workshops"];
        hash_of_data =  YAML.load_file(dir+"events.yaml");
        hash_of_data.each {|x|
  

        subfolders_to_check_for.each{|y|
        if(x["directory_tags"].include? y )
          if(x.has_key? "series")
              array = [];
              hash_of_data.each{|z| 
                if(z["series"] == x["series"])
                 # puts z["series"]
                  array << z;
                end
              }
              generate_with_end(site,site.source,x["url"],array)
          else
            end_dir="/"+y;
          end
        else
          if(x.has_key? "series")
            end_dir = "/events/"+x["series"];
              array = [];
              hash_of_data.each{|z| 
                if(z["series"] == x["series"])
                  #puts z["series"]
                  array << z;
                end
              }
              generate_with_end(site,site.source,x["url"],array)
          else
            end_dir="/events";
          end
        end
      }
        template_to_use = "event.html"
        if foldersToTemplate & x["directory_tags"]
          template_to_use = "#{(foldersToTemplate & x["directory_tags"])[0]}" +"event.html"
        end
        new_file_name = x["filename"]+".html"
        site.pages << GenericPage.new(site, site.source, x["url"], new_file_name,template_to_use,x)
        }
#        //

    end
  end
end