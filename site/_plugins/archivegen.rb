module Jekyll
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