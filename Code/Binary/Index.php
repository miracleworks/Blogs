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

    <link href="{{ assets('css/style.css') }}" rel="stylesheet" />

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
	
	
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/styles/github-gist.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/highlight.min.js"></script>
	<script>
	  $(document).ready(function () {
		$('blockquote').each(function () {
			$(this).replaceWith(function () {
				var result = '';
				$(this).find('> div').each(function () {
					result += $(this).text() + '\n';
				});

				if (result.trim() === '') {
					return '';
				}
				return '<pre><code>' + result + '</code></pre>';
			});
		});

		$('pre code').each(function(i, block) {
			hljs.highlightBlock(block);
		});
	});
	</script>
	<style>
	pre {
		background: #f8f8f8;
		margin: 0;
	}
	.hljs {
		font-size: 12pt;
		background: none;
	}
	</style>

	
  </head>
  <body>

    {% if is_login %}

      {{ login_form }}

    {% else %}

    <div class="container">
      <div class="row">
        <div class="twelve columns">
          <div class="site-header">
            <div class="header-top">
              <h1 class="site-title">
                <a href="/">{{ site.name }}</a>
              </h1>
            </div>
            <nav class="site-nav">
              <ul class="nav-menu">
                <li><a href="/">Home</a></li>
                {% if pages %}
                {% for page in pages %}
                <li><a href="{{ page.permalink }}" class="{{ set_active(page.permalink) }}">{{ page.title }}</a></li>
                {% endfor %}
                {% endif %}
              </ul>
            </nav>
          </div>
          <div class="site-content">
          {% if is_home or is_tag %}
            {% if is_tag %}
            <h2 class="tag-header">Showing all posts tagged {{ tag }}:</h2>
            {% endif %}

            {% if posts %}
            <section itemscope itemtype="http://schema.org/Blog" class="blog-feed">
            {% for post in posts %}
              <article itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting" class="blog-post feed-item">
                <header class="post-header">
                  <h2 class="post-title">
                    <a href="{{ post.permalink }}">{{ post.title }}</a>
                  </h2>
                  <div class="post-metadata">
                    <div class="left">
                      
                      <p><time datetime="{{ post.created_at }}" class="post-date">{{ post.created_at|date_format }}</time></p>
                    </div>
                    <div class="right">
                      <p class="post-comment-count">
                        <a href="{{ post.permalink }}{% if site.disqus %}{% endif %}" class='dsq-comment-count comment-link commentslink'></a>
                      </p>
                      <p><a href="{{ post.permalink }}" class="post-permalink">Permalink</a></p>
                    </div>
                  </div>
                </header>
                <div class="post-body">
                  <div class="post-content">
                    <div data-type-cleanup="true">
                      {{ post.content }}
                    </div>
                    {% if post.type == 'link' or post.type == 'webclip' %}
                    <span class="post-link-url"><i class="icon-share"></i> <a href="{{ post.url }}" target="_blank">{{ post.url }}</a></span>
                    {% endif %}
                  </div>
                  {% if post.tags %}
                  <div class="post-tags">
                    {{- post.tags|format_tags(humanize=False) -}}
                  </div>
                  {% endif %}
                </div>
              </article>
            {% endfor %}
            </section>
            {% if site.disqus %}
            <script type="text/javascript">
            var disqus_shortname = '{{ site.disqus }}';
            (function() {
              var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
              dsq.src = '//' + disqus_shortname + '.disqus.com/count.js';
              (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
            </script>
            {% endif %}
            {% else %}
            <div class="blog-feed">
              <h2 class="title"><em>No posts yet :(</em></h2>
            </div>
            {% endif %}

            {% if not is_tag and posts %}
            {% if pagination.prev or pagination.next %}
            <div class="blog-pagination">
              {% if pagination.prev %}<a href="{{ pagination.prev }}" title="Newer Posts" class="pagination-newer">&larr; Newer Posts</a>{% endif %}
              {% if pagination.next %}<a href="{{ pagination.next }}" title="Previous Posts" class="pagination-older">Previous Posts &rarr;</a>{% endif %}
            </div>
            {% endif %}
            {% endif %}

          {% elif post %}

            <article itemscope itemtype="http://schema.org/BlogPosting" class="blog-post post-single">
              <section class="post-body">
                <header class="post-header">
                  <div class="header-top">
                    <h1 class="post-title">{{ post.title }}</h1>
                  </div>
                  <div class="post-metadata">
                    
                    <p class="right"><time datetime="{{ post.created_at }}" class="post-date">{{ post.created_at|date_format }}</time></p>
                  </div>
                </header>
                <div class="post-content">
                  <div data-type-cleanup="true">
                    {{ post.content }}
                  </div>
                  {% if post.type == 'link' or post.type == 'webclip' %}
                  <span class="post-link-url"><i class="icon-share"></i> <a href="{{ post.url }}" target="_blank">{{ post.url }}</a></span>
                  {% endif %}
                </div>

                {{ theme.social.bar }}

                {% if post.tags %}
                <div class="post-tags">
                  {{- post.tags|format_tags(humanize=True) -}}
                </div>
                {% endif %}
              </section>
              {% if site.disqus %}
              <section class="comments">
                <hr class="large" />
                <div id="disqus_thread"></div>
                <script type="text/javascript">
                var disqus_shortname = '{{ site.disqus }}';
                var disqus_url = '{{site.base_url}}{{ post.permalink }}';
                (function() {
                  var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                  dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                  (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                })();
                </script>
                <noscript>
                  Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a>
                </noscript>
                <a href="https://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
              </section>
              {% endif %}
            </article>

          {% elif post.type == 'page' %}

            <div class="blog-page">
              <h1 class="page-title">{{ page.title }}</h1>
              <div class="page-content" data-type-cleanup="true">
                {{ page.content }}
              </div>
            </div>

          {% endif %}
          </div>
          <div class="site-footer">
            <p>All rights Reserved &copy; <a href="/">{{ site.name }}</a>.</p>
            <br />
            <p>Theme inspired by <a href="http://www.fabthemes.com/binary/" target="_blank">Fabthemes</a> | Powered by <a href="http://postach.io/">Postach.io</a></p>
          </div>
        </div>
        <div class="four columns">
          <div class="sidebar">
            <div class="widget widget-about">
              <h2 class="widget-title"><a href="/">{{ site.author }}</a></h2>
              <div class="widget-content">
                <div class="avatar">
                  <img src="{{ site.avatar }}" alt="{{ site.author }}" />
                </div>
                <p>{{ site.bio }}</p>
                <ul class="social-links">
                  {% if site.twitter %}
                  <li>
                    <a href="{{ site.twitter }}" title="Twitter" target="_blank">
                      <i class="icon-twitter"></i>
                    </a>
                  </li>
                  {% endif %}
                  {% if site.facebook %}
                  <li>
                    <a href="{{ site.facebook }}" title="Facebook" target="_blank">
                      <i class="icon-facebook"></i>
                    </a>
                  </li>
                  {% endif %}
                  {% if site.googleplus %}
                  <li>
                    <a href="{{ site.googleplus }}?rel=author" title="Google+" target="_blank">
                      <i class="icon-google-plus"></i>
                    </a>
                  </li>
                  {% endif %}
                  {% if site.linkedin %}
                  <li>
                    <a href="{{ site.linkedin }}" title="LinkedIn" target="_blank">
                      <i class="icon-linkedin"></i>
                    </a>
                  </li>
                  {% endif %}
                  <li>
                    <a href="{{ site.atom_url }}" title="RSS" target="_blank">
                      <i class="icon-rss"></i>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="widget widget-latestposts">
              <h2 class="widget-title">Latest Posts</h2>
              <div class="widget-content popular-posts">
                {% if posts_recent %}
                <ul>
                {% for post in posts_recent %}
                {% if loop.index <= 5 and loop.index > 0 %}
                  <li><a href="{{ post.permalink }}">{{ post.title }}</a></li>
                {% endif %}
                {% endfor %}
                </ul>
                {% endif %}
              </div>
            </div>
            <div class="widget widget-tagcloud">
              <h2 class="widget-title">Tag Cloud</h2>
              <div class="widget-content tag-cloud">
                {% if site.tags %}
                <ul>
                  {% for tag in site.tags %}
                  <li><a href="/tag/{{ tag.name }}">{{ tag.name }}</a></li>
                  {% endfor %}
                </ul>
                {% endif %}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {% endif %}

    {{ footer_meta }}
  </body>
</html>