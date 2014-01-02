module Jekyll
  class ArchivePage < Page
    include Convertible
 
    attr_accessor :site, :pager, :name, :ext, :basename, :dir, :data, :content, :output
 
    # Initialize new ArchivePage
    # +site+ is the Site
    # +month+ is the month
    # +posts+ is the list of posts for the month
    #
    # Returns <ArchivePage>
    def initialize(site, month, posts)
      puts "Creating page instance for the time period: "+month;

      @site = site
      @month = month
#      @year = year
      self.ext = '.html'
      self.basename = 'index'
      self.content = <<-EOS
<ul>
{% for post in page.posts %}
<li><a href="{{ post.url }}">{{ post.title }}</a></li>
{% endfor %}
</ul>
EOS
      self.data = {
        'layout' => 'blogoverview',
        'type' => 'archive',
        'title' => "Archive for #{month}",
        'posts' => posts,
        'time' => @month
      }
    end
 
    # Add any necessary layouts
    # +layouts+ is a Hash of {"name" => "layout"}
    # +site_payload+ is the site payload hash
    #
    # Returns nothing
    def render(layouts, site_payload)
      payload = {
        "page" => self.to_liquid,
        "paginator" => pager.to_liquid
      }.deep_merge(site_payload)
      do_layout(payload, layouts)
    end
 
    def url
      File.join("/blog/", @month, "index.html")
    end
    
    def to_liquid
      self.data.deep_merge({
                             "url" => self.url,
                             "content" => self.content
                           })
    end
 
    # Write the generated page file to the destination directory.
    # +dest_prefix+ is the String path to the destination dir
    # +dest_suffix+ is a suffix path to the destination dir
    #
    # Returns nothing
    def write(dest_prefix, dest_suffix = nil)
      dest = dest_prefix
      dest = File.join(dest, dest_suffix) if dest_suffix
      FileUtils.mkdir_p(dest)
      # The url needs to be unescaped in order to preserve the
      # correct filename
      path = File.join(dest, CGI.unescape(self.url))
      FileUtils.mkdir_p(File.dirname(path))
      File.open(path, 'w') do |f|
        f.write(self.output)
      end
    end
 
    def html?
      true
    end
  end

 class ArchiveGenerator < Generator
    safe true

    def generate(site) #year is the value being passed in to collate_by_time, hence collating by years.
      collate_by_time(site.posts).each do |year, posts|
        page = ArchivePage.new(site, year, posts)
        site.pages << page
      end
    end
 
    private
 
    def collate_by_time(posts)
      collated = {}
      posts.each do |post|
        key = "#{post.date.year}"
        if collated.has_key? key
          collated[key] << post
        else
          collated[key] = [post]
        end
      end
      collated
    end
  end

end