<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" xmlns:og="http://ogp.me/ns#">
  <head>
    <meta charset="utf-8">
    <title>
      {% if is_login %}Login
      {% elif is_home %}{{ site.author }}
      {% elif is_tag %}{{ tag }}
      {% elif post %}{{ post.title }}
      {% endif %}
      | {{ site.name }}
    </title>

    {{ header_meta }}

    <link href="{{ static('themes/gulio/css/gulio.css') }}" rel="stylesheet" />

    <script>
    (function(doc, script) {
      var js,fjs=doc.getElementsByTagName(script)[0],frag=doc.createDocumentFragment(),add=function(url,id){if(doc.getElementById(id)){return;}js=doc.createElement(script);js.src=url;id&&(js.id=id);frag.appendChild(js);};

      // Google+ button
      // add('http://apis.google.com/js/plusone.js');
      // Facebook SDK
      // add('//connect.facebook.net/en_US/all.js#xfbml=1&appId=200103733347528', 'facebook-jssdk');
      // Twitter SDK
      add('//platform.twitter.com/widgets.js');
      // Pinterest SDK
      // add('//assets.pinterest.com/js/pinit.js');

      fjs.parentNode.insertBefore(frag, fjs);
    }(document, 'script'));
    </script>

    {% if site.analytics %}
    <script>
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', '{{ site.analytics }}']);
    _gaq.push(['_trackPageview']);
    (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
    </script>
    {% endif %}
  </head>
  <body>

    {% if is_login %}

      {{ login_form }}

    {% else %}
    <div class="container">
      <div class="row">
        <div class="span3 offset1">
          <div class="span3" data-spy="affix" data-offset-top="30">
            <div class="header">
              <div class="avatar">
                <a href="/">
                  <img src="{{ site.avatar }}" alt="{{ site.author }}" width="100%" height="100%" />
                </a>
              </div>
              <h1>{{ site.author }}</h1>
              <div class="site-description">
                {{ site.bio }}

                {% if pages %}
                <ul class="inline main-nav">
                  <li><a href="/">Blog</a></li>
                  {% for page in pages %}
                  <li><a href="{{ page.permalink }}" class="{{ set_active(page.permalink) }}">{{ page.title }}</a></li>
                  {% endfor %}
                </ul>
                {% endif %}

              </div>
              <ul class="social">
                {% if site.facebook %}
                <li>
                  <a href="{{ site.facebook }}" title="Facebook" target="_blank">
                    <img src="{{ static('themes/gulio/img/facebook.png') }}" alt="Facebook" />
                  </a>
                </li>
                {% endif %}
                {% if site.twitter %}
                <li>
                  <a href="{{ site.twitter }}" title="Twitter" target="_blank">
                    <img src="{{ static('themes/gulio/img/twitter.png') }}" alt="Twitter" />
                  </a>
                </li>
                {% endif %}
                {% if site.googleplus %}
                <li>
                  <a href="{{ site.googleplus }}?rel=author" title="Google+" target="_blank">
                    <img src="{{ static('themes/gulio/img/googleplus.png') }}" alt="Google+" />
                  </a>
                </li>
                {% endif %}
                {% if site.linkedin %}
                <li>
                  <a href="{{ site.linkedin }}" title="LinkedIn" target="_blank">
                    <img src="{{ static('themes/gulio/img/linkedin.png') }}" alt="Linkedin" />
                  </a>
                </li>
                {% endif %}
                <li>
                  <a href="{{ site.atom_url }}" title="RSS" target="_blank">
                    <img src="{{ static('themes/gulio/img/rss.png') }}" alt="RSS" />
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="span7 offset1">
          {% if is_home or is_tag %}

          <section itemscope itemtype="http://schema.org/Blog" class="posts">
            {% if is_tag %}
            <h2 class="tag-head">Showing all posts tagged {{ tag }}:</h2>
            {% endif %}

            {% if posts %}
            {% for post in posts %}
            <article itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting" class="blog-post">
              <div class="post-head">
                {% if post.photos or post.content|striptags|wordcount > 0 %}
                {% for photo in post.photos %}
                {% if photo and loop.index == 1 %}
                <div class="image">
                  <a href="{{ post.permalink }}">
                    <img src="{{ photo.square_75 }}" alt="Featured Photo" />
                  </a>
                </div>
                {% endif %}
                {% endfor %}
                {% endif %}
                <h2><a href="{{ post.permalink }}">{{ post.title }}</a></h2>
              </div>
              <div class="post-body" data-type-cleanup="true">
                {{ post.content }}
              </div>
              <div class="post-info">
                <div class="info-left">
                  <p class="date">Published on <time datetime="{{ post.created_at }}">{{ post.created_at|date_format }}</time> by {{ site.author }}</p>
                  {% if post.tags %}
                  <p class="tags">Tags: {{ post.tags|format_tags(humanize=True) }}</p>
                  {% endif %}
                </div>
              </div>
            </article>
            {% endfor %}
            {% endif %}
          </section>
          {% if not is_tag %}
          <div class="pagination">
            {% if pagination.prev %}<a href="{{ pagination.prev }}" class="post-prev">&larr; View Previous Posts</a>{% endif %}
            {% if pagination.next %}<a href="{{ pagination.next }}" class="post-next">View More Posts &rarr;</a>{% endif %}
          </div>
          {% endif %}

          {% elif post.type == 'post' %}

          <article itemscope itemtype="http://schema.org/BlogPosting" class="blog-post">
            <section class="post-content">
              <div class="post-head">
                <h2>{{ post.title }}</h2>
              </div>
              <div class="post-body" data-type-cleanup="true">
                {{ post.content }}

                <br />

                {{ theme.social.bar }}

                {% if post.tags %}
                <p class="tags"><strong>Tags</strong>: {{ post.tags|format_tags(humanize=True) }}</p>
                {% endif %}
              </div>
              <div class="post-info">
                <div class="info-left">
                  <p class="date">Published on {{ post.created_at|format_date }} by {{ site.author }}</p>
                </div>
                <div class="info-right">
                  <p class="comments">
                    <a href="#" id="comment-url"></a>
                  </p>
                </div>
              </div>
            </section>
            {% if site.disqus %}
            <hr />
            <section class="post-comments">
              <div id="disqus_thread"></div>
              <script type="text/javascript">
                var disqus_shortname = '{{ site.disqus }}';
                var disqus_url = '{{site.base_url}}{{ post.permalink }}';
                (function() {
                  var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                  dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
                  (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                })();
              </script>
            </section>
            {% endif %}
          </article>

          {% elif post.type == 'link' %}

          <article itemscope itemtype="http://schema.org/BlogPosting" class="blog-post">
            <section class="post-content">
              <div class="post-head">
                <h2>{{ link.title }}</h2>
              </div>
              <div class="post-info">
                <div class="info-left">
                  <p class="date">Published on {{ link.created_at|format_date }} by {{ site.author }}</p>
                </div>
                <div class="info-right">
                  <p class="comments">
                    <a href="#"><i class="icon-comment"></i> 0</a>
                  </p>
                </div>
              </div>
              <div class="post-body">
                {{ link.content }}
                <br />
                {{ theme.social.bar }}

                <span><i class="icon-share"></i> <a href="{{ link.url }}">{{ link.url }}</a></span>
                {% if link.tags %}
                <p class="tags"><strong>Tags</strong>: {{ link.tags|format_tags(humanize=True) }}</p>
                {% endif %}
              </div>
            </section>
            {% if site.disqus %}
            <hr />
            <section class="post-comments">
              <div id="disqus_thread"></div>
              <script type="text/javascript">
                var disqus_shortname = '{{ site.disqus }}';
                var disqus_url = '{{site.base_url}}{{ post.permalink }}';
                (function() {
                  var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                  dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
                  (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                })();
              </script>
            </section>
            {% endif %}
          </article>

          {% elif post.type == 'page' %}

          <div class="blog-post">
            <div class="post-head">
              <h1>{{ page.title }}</h1>
            </div>
            <div class="post-body" data-type-cleanup="true">
              {{ page.content }}
            </div>
          </div>

          {% endif %}
        </div>
      </div>
      <div class="row">
        <div class="span12">
          <footer class="footer">
            <div class="copyright">
              <p class="pull-left">All rights Reserved &copy; <a href="/">{{ site.name }}</a>.</p>
              <p class="pull-right">Powered by <a href="http://postach.io" target="_blank">Postach.io</a> | Design based on <a href="http://blog.cerny.me/">Michal Cern�</a></p>
            </div>
          </footer>
        </div>
      </div>
    </div>

    {% if post %}
    {% if post.type == 'post' or post.type == 'link' and site.disqus %}
    <script>
      $(document).ready(function(){
        var loc = $(location).attr('href');
        $("#comment-url").attr("href",loc+"#disqus_thread");
        (function () {
        var s = document.createElement('script'); s.async = true;
        s.type = 'text/javascript';
        s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
        }());
      })
    </script>
    {% endif %}
    {% endif %}

    {% endif %}

    {{ footer_meta }}

    <script src="{{ static('themes/gulio/js/main.min.js') }}"></script>

  </body>
</html>